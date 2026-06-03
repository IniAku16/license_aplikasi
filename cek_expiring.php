<?php
$conn_cek = new mysqli("localhost", "root", "", "license_aplikasi"); 

if ($conn_cek->connect_error) { die("Koneksi gagal"); }

$check = $conn_cek->query("SELECT id FROM products WHERE request_count = 0 AND DATEDIFF(order_date, CURDATE()) <= 30 LIMIT 1");

if ($check->num_rows > 0) {
    include __DIR__ . "/cron/email_reminder.php";
} else {
    echo "Tidak ada data expiring untuk website ini.\n";
}

$conn_cek->close(); 
?>