<?php
require_once __DIR__ . "/../models/Product.php";
require_once __DIR__ . "/../models/Payment.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ProductController
{
    private $model;
    private $paymentModel;
    private $uploadPath;

    public function __construct($koneksi)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        require_once __DIR__ . '/../vendor/autoload.php';
        $this->model = new ProductModel($koneksi);
        $this->paymentModel = new PaymentModel($koneksi);
        $this->uploadPath = realpath(__DIR__ . "/../public/uploads") . "/";
    }

    public function index()
    {
        $productsResult = $this->model->getAllProducts();
        date_default_timezone_set("Asia/Jakarta");
        $today = date("Y-m-d");

        $allProducts      = [];
        $groupedProducts  = [];
        $appStats         = [];
        $milestoneProducts = [];

        $activeCount   = 0;
        $expiringCount = 0;
        $expiredCount  = 0;

        while ($row = mysqli_fetch_assoc($productsResult)) {
            $expiredDate  = $row['order_date'];
            $requestCount = $row['request_count'] ?? 0;
            $appName      = !empty($row['application_name']) ? $row['application_name'] : 'Lainnya';

            if (empty($expiredDate)) {
                $status    = "unknown";
                $color     = "secondary";
                $sisa_hari = null;
            } else {
                $diff      = floor((strtotime($expiredDate) - strtotime($today)) / 86400);
                $sisa_hari = (int)$diff;

                if ($diff < 0) {
                    $status = "expired";
                    $color  = "danger";
                    $expiredCount++;
                } elseif ($diff <= 30) {
                    $status = "segera";
                    $color  = "warning";
                    $expiringCount++;

                    if ($requestCount == 0) {
                        $milestoneProducts[] = $row['id'] . '|' . $diff;
                    }
                } else {
                    $status = "aktif";
                    $color  = "success";
                    $activeCount++;
                }
            }

            $row['status']    = $status;
            $row['color']     = $color;
            $row['sisa_hari'] = $sisa_hari;
            $allProducts[] = $row;
            $groupedProducts[$appName][] = $row;

            if (!isset($appStats[$appName])) {
                $appStats[$appName] = [
                    'total'        => 0,
                    'min_sisa'     => null,
                    'expired_soon' => 0
                ];
            }

            $appStats[$appName]['total']++;
            if ($status !== 'active') {
                $appStats[$appName]['expired_soon']++;
            }

            if ($sisa_hari !== null) {
                if ($appStats[$appName]['min_sisa'] === null || $sisa_hari < $appStats[$appName]['min_sisa']) {
                    $appStats[$appName]['min_sisa'] = $sisa_hari;
                }
            }
        }

        $products      = $allProducts;
        $totalProducts = count($allProducts);

        $skipEmail = $_SESSION['skip_email_after_delete'] ?? false;
        unset($_SESSION['skip_email_after_delete']);

        if (!$skipEmail && !empty($milestoneProducts)) {
            $this->attemptEmailTrigger($milestoneProducts);
        }
        $branchResult = $this->model->getBranches();
        $branches = [];
        while ($b = mysqli_fetch_assoc($branchResult)) {
            $branches[] = $b;
        }

        include __DIR__ . "/../views/products/index.php";
    }

    private function attemptEmailTrigger($milestoneProducts)
    {
        sort($milestoneProducts);
        $currentFingerprint = md5(implode(',', $milestoneProducts));
        $today = date("Y-m-d");

        $reminderLog = $this->loadReminderLog();
        $lastFingerprint = $reminderLog['fingerprint'] ?? '';
        $lastSentDate = $reminderLog['date'] ?? '';

        if ($currentFingerprint === $lastFingerprint && $lastSentDate === $today) {
            return;
        }

        $_SESSION['last_email_fingerprint'] = $currentFingerprint;
        $this->saveReminderLog([
            'fingerprint' => $currentFingerprint,
            'date' => $today,
        ]);

        $dataReminder = $milestoneProducts;

        ob_start();
        include __DIR__ . "/../cron/email_reminder.php";
        ob_end_clean();
    }

    private function getReminderLogPath()
    {
        return __DIR__ . '/../cron/last_email_reminder.json';
    }

    private function loadReminderLog()
    {
        $path = $this->getReminderLogPath();
        if (!file_exists($path)) {
            return [];
        }

        $contents = file_get_contents($path);
        if ($contents === false) {
            return [];
        }

        $data = json_decode($contents, true);
        return is_array($data) ? $data : [];
    }

    private function saveReminderLog(array $data)
    {
        $path = $this->getReminderLogPath();
        file_put_contents($path, json_encode($data));
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');

            $name        = trim($_POST['username'] ?? '');
            $application   = trim($_POST['application_name'] ?? '');
            $agreement   = trim($_POST['agreement_number'] ?? '');
            $expired     = $_POST['order_date'] ?? '';
            $harga       = !empty($_POST['harga_order']) ? $_POST['harga_order'] : 0;
            $departemen  = $_POST['departemen'] ?? '';
            $email   = trim($_POST['email_name'] ?? '');
            $foto        = '';

            $targetDir = __DIR__ . "/../public/uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $foto = "IMG_" . time() . "_" . uniqid() . "." . $ext;

                if (!move_uploaded_file($_FILES['foto']['tmp_name'], $targetDir . $foto)) {
                    $foto = null;
                }
            }

            $success = $this->model->create($name, $application, $agreement, $expired, $harga, $departemen, $email, $foto);

            if ($success) {
                unset($_SESSION['last_email_fingerprint']);
                $this->sendReminderIfNeeded();
            }

            echo json_encode([
                "status"  => $success ? "success" : "error",
                "message" => $success ? "Data berhasil disimpan" : "Gagal menyimpan data"
            ]);
            exit;
        }
    }

    public function update($id)
    {
        $product = $this->model->getById($id);
        if (!$product) {
            header('Content-Type: application/json');
            echo json_encode(["status" => "error", "message" => "Product tidak ditemukan"]);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $payment_status = $_POST['payment_status'] ?? null;

            if ($payment_status === 'done') {
                $payment_date = $_POST['payment_date'] ?? null;
                $amount = $_POST['amount'] ?? 0;

                if (empty($payment_date)) {
                    echo json_encode(["status" => "error", "message" => "Tanggal pembayaran wajib diisi"]);
                    exit;
                }

                if ($this->paymentModel->isPaymentExists($id, $payment_date)) {
                    echo json_encode(["status" => "error", "message" => "Pembayaran sudah ada pada tanggal tersebut"]);
                    exit;
                }

                $success = $this->model->updatePayment($id, $payment_date, $amount);
                echo json_encode([
                    "status"  => $success ? "success" : "error",
                    "message" => $success ? "Payment berhasil disimpan" : "Gagal menyimpan payment"
                ]);
                exit;
            } else {
                $name       = trim($_POST['username'] ?? '');
                $application  = trim($_POST['application_name'] ?? '');
                $agreement  = trim($_POST['agreement_number'] ?? '');
                $expired    = $_POST['order_date'] ?? '';
                $harga      = !empty($_POST['harga_order']) ? $_POST['harga_order'] : 0;
                $departemen = $_POST['departemen'] ?? '';
                $email  = trim($_POST['email_name'] ?? '');
                $foto       = $product['foto'];

                if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                    $targetDir = __DIR__ . "/../public/uploads/";
                    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

                    if ($foto && file_exists($targetDir . $foto)) {
                        unlink($targetDir . $foto);
                    }

                    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                    $foto = "IMG_" . time() . "_" . uniqid() . "." . $ext;
                    move_uploaded_file($_FILES['foto']['tmp_name'], $targetDir . $foto);
                }

                $success = $this->model->update($id, $name, $application, $agreement, $expired, $harga, $departemen, $email, $foto);
                if ($success) {
                    unset($_SESSION['last_email_fingerprint']);
                    $this->sendReminderIfNeeded();
                }

                header('Content-Type: application/json');
                echo json_encode([
                    "status"  => $success ? "success" : "error",
                    "message" => $success ? "Update berhasil" : "Gagal"
                ]);
                exit;
            }
        }
    }

    private function sendReminderIfNeeded()
    {
        $products = $this->model->getAllProducts();
        $milestoneProducts = [];

        date_default_timezone_set("Asia/Jakarta");
        $today = date("Y-m-d");

        while ($row = mysqli_fetch_assoc($products)) {
            $request_count = $row['request_count'] ?? 0;
            $expired = $row['order_date'] ?? '';

            if (empty($expired) || $request_count != 0) {
                continue;
            }

            $diff = floor((strtotime($expired) - strtotime($today)) / 86400);
            if ($diff <= 30) {
                $milestoneProducts[] = $row['id'] . '|' . $diff;
            }
        }

        if (!empty($milestoneProducts)) {
            $this->attemptEmailTrigger($milestoneProducts);
        }
    }

    public function checkAndTriggerReminder($orderDate, $force = false)
    {
        unset($_SESSION['last_email_fingerprint']);
    }

    public function history()
    {
        $result = $this->paymentModel->getGroupedHistory();
        $histories = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $histories[] = $row;
        }
        include __DIR__ . "/../views/products/history.php";
    }

    public function historyDetail()
    {
        header('Content-Type: application/json');
        $product_id = $_GET['product_id'] ?? null;
        if (!$product_id) {
            echo json_encode(["status" => "error", "message" => "ID tidak ditemukan"]);
            exit;
        }
        $result = $this->paymentModel->getPaymentDetailsByProduct($product_id);
        $details = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $details[] = $row;
        }
        echo json_encode(["status" => "success", "data" => $details]);
        exit;
    }

    public function historyPdf()
    {
        require_once __DIR__ . '/../vendor/autoload.php';
        $product_id = $_GET['product_id'] ?? null;
        $dompdf = new \Dompdf\Dompdf();

        if ($product_id) {
            $product = $this->model->getById($product_id);
            if (!$product) die("Product tidak ditemukan");

            $result = $this->paymentModel->getPaymentDetailsByProduct($product_id);
            $details = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $details[] = $row;
            }

            ob_start();
            include __DIR__ . '/../views/products/history_pdf_single.php';
            $html = ob_get_clean();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream("riwayat-" . $product['username'] . ".pdf", ["Attachment" => false]);
            exit;
        } else {
            $histories = $this->paymentModel->getAllGroupedHistoryWithDetails();
            ob_start();
            include __DIR__ . '/../views/products/history_pdf_all.php';
            $html = ob_get_clean();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream("riwayat-semua.pdf", ["Attachment" => false]);
            exit;
        }
    }

    public function exportExcel()
    {
        if (ob_get_contents()) ob_end_clean();
        $startDate = $_GET['start_date'] ?? null;
        $endDate   = $_GET['end_date'] ?? null;
        $result = $this->model->getProductsByFilter($startDate, $endDate);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['No', 'Application Name', 'Agreement Number', 'User', 'Departemen', 'Email', 'Order Date', 'Expired Date', 'Sisa Hari', 'Status'];
        $column = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($column . '1', $h);
            $column++;
        }

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4AA3FF']],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
        ];
        $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);

        $rowNum = 2;
        $no = 1;

        $today = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
        $today->setTime(0, 0, 0);

        while ($row = mysqli_fetch_assoc($result)) {
            $exp = new \DateTime($row['order_date'], new \DateTimeZone('Asia/Jakarta'));
            $orderDate = clone $exp;
            $orderDate->modify('-1 year');

            $interval = $today->diff($exp);
            $selisih_hari = (int)$interval->format("%r%a");

            if ($selisih_hari < 0) {
                $status_label = "Expired";
                $hari_label = abs($selisih_hari) . " Hari Lalu";
            } elseif ($selisih_hari <= 7) {
                $status_label = "Segera";
                $hari_label = $selisih_hari . " Hari Lagi";
            } else {
                $status_label = "Aktif";
                $hari_label = $selisih_hari . " Hari";
            }

            $sheet->setCellValue('A' . $rowNum, $no++);
            $sheet->setCellValue('B' . $rowNum, $row['application_name']);
            $sheet->setCellValueExplicit('C' . $rowNum, $row['agreement_number'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $rowNum, $row['username']);
            $sheet->setCellValue('E' . $rowNum, $row['departemen']);
            $sheet->setCellValue('F' . $rowNum, $row['email_name']);
            $sheet->setCellValue('G' . $rowNum, $orderDate->format("d M Y"));
            $sheet->setCellValue('H' . $rowNum, $exp->format("d M Y"));
            $sheet->setCellValue('I' . $rowNum, $hari_label);
            $sheet->setCellValue('J' . $rowNum, $status_label);
            $sheet->getStyle('A' . $rowNum . ':J' . $rowNum)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $rowNum++;
        }

        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Export_License_' . date('Ymd_His') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function delete($id)
    {
        $product = $this->model->getById($id);
        if ($product && $product['foto']) {
            $targetDir = __DIR__ . "/../public/uploads/";
            if (file_exists($targetDir . $product['foto'])) {
                unlink($targetDir . $product['foto']);
            }
        }
        $this->model->delete($id);
        $_SESSION['skip_email_after_delete'] = true;
        header("Location: index.php");
        exit;
    }

    public function prosesRequest($id)
    {
        if (empty($id) || !is_numeric($id)) {
            echo "ID tidak valid.";
            return;
        }

        $success = $this->model->incrementRequestCount($id);

        if ($success) {
            echo "<script>alert('Request Berhasil Diproses!'); window.location='index.php';</script>";
        } else {
            echo "Gagal memproses data.";
        }
    }
}
