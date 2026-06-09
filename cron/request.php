<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
date_default_timezone_set("Asia/Jakarta");

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan");
}

$id = (int) $_GET['id'];
$mysqli = new mysqli("localhost", "root", "", "license_aplikasi");

function renderUI($type, $data = null)
{
    $primary_pastel = "#5d55cb";
    $bg_color = "#f3f4f9";

    $title = ($type === 'success') ? "Hello Request" : "Wait a minute...";
    $icon = ($type === 'success') ? "bi-check-circle-fill" : "bi-exclamation-triangle-fill";
    $icon_color = ($type === 'success') ? "#2ecc71" : "#f39c12";
    $message = ($type === 'success')
        ? "Request Quotation berhasil dikirim ke Procurement."
        : "User <strong>" . htmlspecialchars($data['username']) . "</strong> sebelumnya sudah pernah dimintakan penawaran (Request sudah diproses).";
?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Request Status</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <style>
            body {
                background-color: <?= $bg_color ?>;
                font-family: 'Poppins', sans-serif;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0;
            }

            .card-custom {
                background: #ffffff;
                border-radius: 24px;
                padding: 40px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
                text-align: center;
                max-width: 450px;
                width: 90%;
            }

            .icon-box {
                font-size: 4rem;
                color: <?= $icon_color ?>;
                margin-bottom: 20px;
            }

            h2 {
                font-weight: 700;
                color: #2d3436;
                margin-bottom: 10px;
            }

            p {
                color: #636e72;
                line-height: 1.6;
                margin-bottom: 30px;
            }

            .btn-pastel {
                background-color: <?= $primary_pastel ?>;
                color: white;
                border: none;
                border-radius: 12px;
                padding: 12px 25px;
                font-weight: 600;
                text-decoration: none;
                display: inline-block;
                transition: 0.3s;
            }

            .btn-pastel:hover {
                opacity: 0.9;
                transform: translateY(-2px);
            }
        </style>
    </head>

    <body>
        <div class="card-custom">
            <div class="icon-box"><i class="bi <?= $icon ?>"></i></div>
            <h2><?= $title ?></h2>
            <p><?= $message ?></p>
            <a href="javascript:void(0)" onclick="window.close();" class="btn-pastel">Close Window</a>
        </div>
    </body>

    </html>
<?php
}

if (isset($_GET['status']) && $_GET['status'] === 'sent') {
    renderUI('success');
    exit;
}

$stmt = $mysqli->prepare("SELECT username, agreement_number, departemen, order_date, request_count, foto, application_name, email_name FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Produk tidak ditemukan.");
}

if ($data['request_count'] > 0) {
    renderUI('info', $data);
    exit;
}

$exp = new DateTime($data['order_date'], new DateTimeZone('Asia/Jakarta'));
$orderDate = clone $exp;
$orderDate->modify('-1 year');

$filePath = realpath(__DIR__ . '/../public/uploads/' . $data['foto']);
$has_image = false;
$cid_name = "license_img_" . $id;

if ($filePath && file_exists($filePath) && is_file($filePath)) {
    $has_image = true;
} else {
}
$has_image = false;
$cid_name = "license_img_" . $id;

if (!empty($data['foto']) && file_exists($filePath)) {
    $has_image = true;
}

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

$mail->setFrom("itlicenseaplikasi@hexindo-tbk.co.id", "IT License System");
$mail->addAddress("ara.rhzz16@gmail.com");
$mail->addAddress("denipratama@hexindo-tbk.co.id");

if ($has_image) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($filePath);
    $mail->addEmbeddedImage($filePath, $cid_name, $data['foto'], 'base64', $mime_type);
}

$mail->isHTML(true);
$mail->Subject = "Request Penawaran: " . $data['application_name'] . " - " . $data['username'];
$html_foto_body = "";
if ($has_image) {
    $html_foto_body = "
    <div style='margin-top: 25px; border-top: 1px solid #f1f2f6; padding-top: 20px;'>
        <p style='font-size: 13px; color: #7f8c8d; font-weight: bold; margin-bottom: 10px;'>PREVIEW LISENSI:</p>
        <div style='text-align: center; background: #fafafa; padding: 10px; border-radius: 12px; border: 1px solid #ededed;'>
            <img src='cid:$cid_name' style='max-width: 100%; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);'>
            <p style='font-size: 11px; color: #95a5a6; margin-top: 10px;'>Lihat lampiran email untuk mengunduh file asli.</p>
        </div>
    </div>";
}
$mail->Body = "
<html>
<body style='margin:0; padding:0; background-color: #f3f4f9; font-family: \"Segoe UI\", Helvetica, Arial, sans-serif;'>
    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='padding: 40px 10px;'>
        <tr>
            <td align='center'>
                <table width='100%' border='0' cellspacing='0' cellpadding='0' style='max-width: 600px; background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);'>
                    <tr style='background-color: #5d55cb;'>
                        <td style='padding: 30px; text-align: center;'><h2 style='color: #ffffff; margin: 0; font-size: 20px;'>Request for Quotation</h2></td>
                    </tr>
                    <tr>
                        <td style='padding: 40px;'>
                            <p style='font-size: 15px; color: #2d3436;'>Dear <b>Mas Fauzi / Mbak Nurhesty</b>,</p>
                            <p style='font-size: 14px; color: #636e72; line-height: 1.6;'>Mohon bantuan untuk dikirimkan penawaran lisensi aplikasi dengan detail sebagai berikut:</p>
                            
                            <table width='100%' style='margin-top: 20px; border-collapse: collapse; border: 1px solid #f1f2f6;'>
                                <tr>
                                    <td style='padding: 12px; background: #f8f9ff; color: #7f8c8d; font-size: 11px; width: 35%; border-bottom: 1px solid #f1f2f6;'>APPLICATION</td>
                                    <td style='padding: 12px; color: #2d3436; font-weight: bold; font-size: 14px; border-bottom: 1px solid #f1f2f6;'>" . htmlspecialchars($data['application_name']) . "</td>
                                </tr>
                                <tr>
                                    <td style='padding: 12px; background: #f8f9ff; color: #7f8c8d; font-size: 11px; border-bottom: 1px solid #f1f2f6;'>AGREEMENT NO</td>
                                    <td style='padding: 12px; color: #2d3436; font-weight: bold; font-size: 14px; border-bottom: 1px solid #f1f2f6;'>{$data['agreement_number']}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 12px; background: #f8f9ff; color: #7f8c8d; font-size: 11px; border-bottom: 1px solid #f1f2f6;'>USER / EMAIL</td>
                                    <td style='padding: 12px; color: #2d3436; font-size: 14px; border-bottom: 1px solid #f1f2f6;'>{$data['username']} (" . htmlspecialchars($data['email_name']) . ")</td>
                                </tr>
                                <tr>
                                    <td style='padding: 12px; background: #f8f9ff; color: #7f8c8d; font-size: 11px; border-bottom: 1px solid #f1f2f6;'>DEPARTEMEN</td>
                                    <td style='padding: 12px; color: #2d3436; font-size: 14px; border-bottom: 1px solid #f1f2f6;'>{$data['departemen']}</td>
                                </tr>
                                <!-- Row Order Date baru -->
                                <tr>
                                    <td style='padding: 12px; background: #f8f9ff; color: #7f8c8d; font-size: 11px; border-bottom: 1px solid #f1f2f6;'>ORDER DATE</td>
                                    <td style='padding: 12px; color: #2d3436; font-size: 14px; border-bottom: 1px solid #f1f2f6;'>{$orderDate->format('d M Y')}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 12px; background: #f8f9ff; color: #7f8c8d; font-size: 11px;'>EXPIRED DATE</td>
                                    <td style='padding: 12px; color: #e74c3c; font-weight: bold; font-size: 14px;'>{$exp->format('d M Y')}</td>
                                </tr>
                            </table>

                            $html_foto_body

                            <p style='margin-top: 30px; font-size: 13px; color: #95a5a6;'>Atas perhatiannya diucapkan terima kasih.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding: 0 40px 40px 40px;'>
                            <div style='border-top: 1px solid #f1f2f6; padding-top: 20px;'>
                                <p style='margin: 0; font-size: 15px; color: #5d55cb; font-weight: bold;'>Hexindo IT System</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <p style='font-size: 11px; color: #b2bec3; margin-top: 20px;'>&copy; " . date('Y') . " PT Hexindo Adiperkasa Tbk.</p>
            </td>
        </tr>
    </table>
</body>
</html>";

if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    $mysqli->query("UPDATE products SET request_count = request_count + 1 WHERE id = $id");
    header("Location: request.php?id=$id&status=sent");
    exit;
}
