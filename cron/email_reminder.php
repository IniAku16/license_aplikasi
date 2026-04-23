<?php
date_default_timezone_set("Asia/Jakarta");

$server   = "localhost";
$username = "root";
$password = "";
$database = "license_aplikasi";

$mysqli = new mysqli($server, $username, $password, $database);
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

$today = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
$today->setTime(0, 0, 0);

$query = $mysqli->query("SELECT id, username, order_date, departemen, agreement_number FROM products WHERE request_count = 0");

$rows = "";
$kirim_email = false;
$no = 1;

$primary_pastel = "#5d55cb";
$bg_color = "#eaebf3"; 

while ($data = $query->fetch_assoc()) {
    $nama = htmlspecialchars($data['username']);
    $agreement = htmlspecialchars($data['agreement_number']);
    $departemen = htmlspecialchars($data['departemen']);
    $exp = new DateTime($data['order_date'], new DateTimeZone('Asia/Jakarta'));

    $orderDate = clone $exp;
    $orderDate->modify('-1 year'); 

    $interval = $today->diff($exp);
    $selisih_hari = (int)$interval->format("%r%a");

    if ($selisih_hari > 30) {
        continue;
    }

    if ($selisih_hari < 0) {
        $status_label = "Expired";
        $badge_bg = "#e02424"; 
        $badge_text = "#ffffff";
        $hari_style = "color: #e02424; font-weight: 700;";
        $hari_label = abs($selisih_hari) . " Hari Lalu";
    } elseif ($selisih_hari <= 7) {
        $status_label = "Expiring";
        $badge_bg = "#f59e0b"; 
        $badge_text = "#ffffff";
        $hari_style = "color: #d97706; font-weight: 700;";
        $hari_label = $selisih_hari . " Hari Lagi";
    } else {
        $status_label = "Active";
        $badge_bg = "#10b981"; 
        $badge_text = "#ffffff";
        $hari_style = "color: #5d55cb; font-weight: 700;";
        $hari_label = $selisih_hari . " Hari";
    }

    $bg_row = ($no % 2 == 0) ? "#ffffff" : "#fbfbfe";

    $rows .= "
    <tr style='border-bottom: 1px solid #e5e7eb; background-color: $bg_row;'>
        <td style='padding: 15px 10px; text-align: center; color: #4b5563; font-size: 13px; font-weight: 600;'>$no</td>
        <td style='padding: 15px 10px;'>
            <div style='font-weight: 700; color: #111827; font-size: 14px;'>$agreement</div>
        </td>
        <td style='padding: 15px 10px;'>
            <div style='color: #111827; font-weight: 600; font-size: 14px;'>$nama</div>
            <div style='font-size: 11px; color: #5d55cb; background: #eeebff; display: inline-block; padding: 2px 10px; border-radius: 6px; font-weight: 600; margin-top: 4px;'>$departemen</div>
        </td>
        <td style='padding: 15px 10px; text-align: center;'>" . $orderDate->format("d M Y") . "</td>
        <td style='padding: 15px 10px; text-align: center;'>" . $exp->format("d M Y") . "</td>
        <td style='padding: 15px 10px; text-align: center; $hari_style font-size: 13px;'>$hari_label</td>
        <td style='padding: 15px 10px; text-align: center;'>
            <span style='background: $badge_bg; color: $badge_text; padding: 6px 14px; border-radius: 10px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);'>
                $status_label
            </span>
        </td>
        <td style='padding: 15px 10px; text-align: center;'>
            <a href='http://10.87.203.183/license_aplikasi/cron/request.php?id={$data['id']}'
               style='background: $primary_pastel; color: #ffffff !important; padding: 10px 18px; border-radius: 12px; text-decoration: none; font-size: 12px; font-weight: 700; display: inline-block; box-shadow: 0 4px 12px rgba(93, 85, 203, 0.25); text-transform: uppercase; letter-spacing: 0.5px;'>
               Request
            </a>
        </td>
    </tr>";

    $kirim_email = true;
    $no++;
}

if ($kirim_email) {

    $isi_email = "
    <html>
    <head>
        <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap' rel='stylesheet'>
    </head>
    <body style='margin:0; padding:0; background-color: $bg_color; font-family: \"Poppins\", \"Segoe UI\", Helvetica, Arial, sans-serif;'>
        <table width='100%' border='0' cellspacing='0' cellpadding='0' style='background-color: $bg_color; padding: 40px 10px;'>
            <tr>
                <td align='center'>
                    <!-- Main Card -->
                    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='max-width: 850px; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);'>
                        
                        <!-- Top Accent Bar -->
                        <tr><td style='height: 8px; background-color: $primary_pastel;'></td></tr>

                        <!-- Header Greeting -->
                        <tr>
                            <td style='padding: 35px 40px 20px 40px;'>
                                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                    <tr>
                                        <td>
                                            <h2 style='color: #111827; margin: 0; font-size: 26px; font-weight: 700;'>Hello Admin, <span style='color: $primary_pastel;'>License Aplikasi!</span></h2>
                                            <p style='color: #4b5563; font-size: 15px; margin-top: 8px; font-weight: 500;'>Sistem mendeteksi lisensi yang memerlukan perhatian (≤ 30 hari).</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <!-- Table Content -->
                        <tr>
                            <td style='padding: 0 40px 20px 40px;'>
                                <div style='border-radius: 16px; overflow: hidden; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);'>
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='border-collapse: collapse;'>
                                        <thead>
                                            <tr style='background-color: $primary_pastel;'>
                                                <th style='padding: 15px 10px; text-align: center; color: #ffffff; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;'>No</th>
                                                <th style='padding: 15px 10px; text-align: left; color: #ffffff; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;'>Agreement</th>
                                                <th style='padding: 15px 10px; text-align: left; color: #ffffff; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;'>User / Dept</th>
                                                <th style='padding: 15px 10px; text-align: center; color: #ffffff; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;'>Order Date</th>
                                                <th style='padding: 15px 10px; text-align: center; color: #ffffff; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;'>Expired Date</th>
                                                <th style='padding: 15px 10px; text-align: center; color: #ffffff; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;'>Sisa Hari</th>
                                                <th style='padding: 15px 10px; text-align: center; color: #ffffff; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;'>Status</th>
                                                <th style='padding: 15px 10px; text-align: center; color: #ffffff; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;'>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            $rows
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>

                        <!-- Footer Note -->
                        <tr>
                            <td style='padding: 10px 40px 40px 40px;'>
                                <table width='100%' border='0' cellspacing='0' cellpadding='0' style='border-top: 2px dashed #e5e7eb; padding-top: 25px;'>
                                    <tr>
                                        <td>
                                            <p style='margin: 0; font-size: 12px; color: #6b7280; line-height: 1.6; font-weight: 500;'>
                                                <strong style='color: #111827;'>Catatan Otomatis:</strong><br>
                                                Pesan ini dihasilkan secara otomatis oleh sistem IT License Dashboard. Harap tidak membalas email ini secara langsung.
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <!-- Sub Footer -->
                        <tr>
                            <td style='background: #111827; padding: 20px; text-align: center; color: #9ca3af; font-size: 11px; font-weight: 500;'>
                                &copy; " . date('Y') . " <span style='color: #ffffff;'>PT Hexindo Adiperkasa Tbk</span>. All Rights Reserved.
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>
    ";

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

    $mail->CharSet = 'UTF-8';

    $mail->From = "ithexindo@hexindo-tbk.co.id";
    $mail->FromName = "Application License Reminder";
    $mail->addAddress("ara.rhzz16@gmail.com");
    $mail->addAddress("denipratama@hexindo-tbk.co.id");

    $mail->isHTML(true);
    $mail->Subject = "License Expiring Soon (≤ 30 Hari)";
    $mail->Body    = $isi_email;
    $mail->AltBody = "Reminder produk akan expired. Silahkan cek lisensi.";

    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Email berhasil dikirim!";
    }
} else {
    echo "Tidak ada produk expiring (≤ 30 hari)";
}