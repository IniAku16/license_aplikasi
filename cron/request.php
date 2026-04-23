<?php
session_start();
date_default_timezone_set("Asia/Jakarta");

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan");
}

$id = (int) $_GET['id'];
$mysqli = new mysqli("localhost", "root", "", "license_aplikasi");

function renderUI($type, $data = null) {
    $primary_pastel = "#5d55cb";
    $bg_color = "#f3f4f9";
    
    $title = ($type === 'success') ? "Hello Request" : "Wait a minute...";
    $icon = ($type === 'success') ? "bi-check-circle-fill" : "bi-exclamation-triangle-fill";
    $icon_color = ($type === 'success') ? "#2ecc71" : "#f39c12";
    $message = ($type === 'success') 
        ? "Request Quotation berhasil dikirim." 
        : "User <strong>".htmlspecialchars($data['username'])."</strong> sebelumnya user ini sudah pernah dimintakan penawaran.";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Request Status</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        body { background-color: <?= $bg_color ?>; font-family: 'Poppins', sans-serif; height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0; }
        .card-custom { background: #ffffff; border-radius: 24px; padding: 40px; box-shadow: 0 10px 30px rgba(162, 155, 254, 0.15); text-align: center; max-width: 450px; width: 90%; }
        .icon-box { font-size: 4rem; color: <?= $icon_color ?>; margin-bottom: 20px; }
        h2 { font-weight: 700; color: #2d3436; margin-bottom: 10px; }
        p { color: #636e72; line-height: 1.6; margin-bottom: 30px; }
        .btn-pastel { background-color: <?= $primary_pastel ?>; color: white; border: none; border-radius: 12px; padding: 12px 25px; font-weight: 600; text-decoration: none; transition: all 0.3s; display: inline-block; margin: 5px; }
        .btn-pastel:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(93, 85, 203, 0.3); color: white; }
        .btn-outline { border: 2px solid #edeff2; color: #636e72; background: transparent; }
    </style>
</head>
<body>
    <div class="card-custom">
        <div class="icon-box"><i class="bi <?= $icon ?>"></i></div>
        <h2><?= $title ?></h2>
        <p><?= $message ?></p>
        <div class="d-flex flex-column gap-2">
            <a href="http://10.87.203.183/license_aplikasi/views/auth/login.php" class="btn-pastel">Back To Login</a>
            <a href="javascript:void(0)" onclick="window.close();" class="btn-pastel btn-outline">Close Window</a>
        </div>
    </div>
</body>
</html>
<?php
}

if (isset($_GET['status']) && $_GET['status'] === 'sent') {
    renderUI('success');
    exit;
}

$stmt = $mysqli->prepare("SELECT username, agreement_number, departemen, order_date, request_count, foto FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) { die("Produk tidak ditemukan"); }
 
if ($data['request_count'] > 0) {
    renderUI('info', $data);
    exit;
}

$exp = new DateTime($data['order_date'], new DateTimeZone('Asia/Jakarta'));
$orderDate = clone $exp; 
$orderDate->modify('-1 year');

require_once __DIR__ . '/../vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../vendor/phpmailer/src/Exception.php';

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->isSMTP();
$mail->Host        = "10.87.200.12";
$mail->SMTPAuth    = false;
$mail->SMTPAutoTLS = false;
$mail->SMTPSecure  = false;
$mail->Port        = 25;
$mail->CharSet     = 'UTF-8';

$mail->setFrom("itlicenseaplikasi@hexindo-tbk.co.id", "IT License");
$mail->addAddress("ara.rhzz16@gmail.com");
$mail->addAddress("denipratama@hexindo-tbk.co.id");

$mail->isHTML(true);
$mail->Subject = "Request Penawaran: " . $data['username'] . " (" . $data['agreement_number'] . ")";
$mail->Body = "
<html>
<body style='margin:0; padding:0; background-color: #f3f4f9; font-family: \"Segoe UI\", Helvetica, Arial, sans-serif;'>
    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='padding: 40px 10px;'>
        <tr>
            <td align='center'>
                <table width='100%' border='0' cellspacing='0' cellpadding='0' style='max-width: 600px; background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);'>
                    <!-- Header -->
                    <tr style='background-color: #5d55cb;'>
                        <td style='padding: 30px; text-align: center;'>
                            <h2 style='color: #ffffff; margin: 0; font-size: 20px;'>Request for Quotation</h2>
                        </td>
                    </tr>
                    <!-- Content -->
                    <tr>
                        <td style='padding: 40px;'>
                            <p style='font-size: 15px; color: #2d3436;'>Dear <b>Mas Fauzi / Mbak Nurhesty</b>,</p>
                            <p style='font-size: 14px; color: #636e72; line-height: 1.6;'>Mohon bantuan untuk dikirimkan penawaran lisensi aplikasi dengan detail sebagai berikut:</p>
                            
                            <table width='100%' style='margin-top: 20px; border-collapse: collapse; border-radius: 12px; overflow: hidden; border: 1px solid #f1f2f6;'>
                                <tr>
                                    <td style='padding: 12px; background: #f8f9ff; color: #7f8c8d; font-size: 12px; width: 40%; text-transform: uppercase;'>Agreement No</td>
                                    <td style='padding: 12px; color: #2d3436; font-weight: bold; font-size: 14px; border-bottom: 1px solid #f1f2f6;'>{$data['agreement_number']}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 12px; background: #f8f9ff; color: #7f8c8d; font-size: 12px; text-transform: uppercase;'>User</td>
                                    <td style='padding: 12px; color: #2d3436; font-size: 14px; border-bottom: 1px solid #f1f2f6;'>{$data['username']}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 12px; background: #f8f9ff; color: #7f8c8d; font-size: 12px; text-transform: uppercase;'>Departemen</td>
                                    <td style='padding: 12px; color: #2d3436; font-size: 14px; border-bottom: 1px solid #f1f2f6;'>{$data['departemen']}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 12px; background: #f8f9ff; color: #7f8c8d; font-size: 12px; text-transform: uppercase;'>Order Date</td>
                                    <td style='padding: 12px; color: #2d3436; font-size: 14px; border-bottom: 1px solid #f1f2f6;'>{$orderDate->format('d M Y')}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 12px; background: #f8f9ff; color: #7f8c8d; font-size: 12px; text-transform: uppercase;'>Expired Date</td>
                                    <td style='padding: 12px; color: #e74c3c; font-weight: bold; font-size: 14px;'>{$exp->format('d M Y')}</td>
                                </tr>
                            </table>

                            <p style='margin-top: 30px; font-size: 14px; color: #636e72;'>Terlampir foto nota(jika ada). Atas perhatiannya diucapkan terima kasih.</p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style='padding: 0 40px 40px 40px;'>
                            <div style='border-top: 1px solid #f1f2f6; padding-top: 20px;'>
                                <p style='margin: 0; font-size: 13px; color: #2d3436;'>Best Regards,</p>
                                <p style='margin: 5px 0 0 0; font-size: 15px; color: #5d55cb; font-weight: bold;'>Hexindo - IT System</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <p style='font-size: 11px; color: #b2bec3; margin-top: 20px;'>&copy; ".date('Y')." PT Hexindo Adiperkasa Tbk. Automated Notification.</p>
            </td>
        </tr>
    </table>
</body>
</html>";

if (!empty($data['foto'])) {
    $filePath = __DIR__ . '/../public/uploads/' . $data['foto'];
    if (file_exists($filePath)) { $mail->addAttachment($filePath); }
}

if (!$mail->send()) {
    echo "Error: " . $mail->ErrorInfo;
} else {
    $updateStmt = $mysqli->prepare("UPDATE products SET request_count = request_count + 1 WHERE id = ?");
    $updateStmt->bind_param("i", $id);
    $updateStmt->execute();

    header("Location: request.php?id=$id&status=sent");
    exit;
}