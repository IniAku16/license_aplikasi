<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat License Aplikasi</title>
    <style>
        @page { margin: 40px; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #2d3436;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .header {
            border-bottom: 2px solid #f3f4f9;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            color: #2d3436;
            margin: 0;
        }

        .title span {
            color: #5d55cb; 
        }

        .subtitle {
            font-size: 11px;
            color: #7f8c8d;
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .card-info {
            background-color: #f8f9ff;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .info-table {
            width: 100%;
        }

        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .label {
            color: #7f8c8d;
            width: 120px;
            font-weight: 500;
        }

        .value {
            color: #2d3436;
            font-weight: 600;
        }

        .badge-expired {
            background-color: #eaf4ff;
            color: #5d55cb;
            padding: 4px 10px;
            border-radius: 8px;
            font-weight: bold;
            display: inline-block;
        }

        table.main-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        table.main-table th {
            background-color: #f8f9ff;
            color: #7f8c8d;
            text-align: left;
            padding: 12px 15px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #edeff2;
        }

        table.main-table td {
            padding: 15px;
            border-bottom: 1px solid #f1f2f6;
            vertical-align: middle;
        }

        table.main-table tr:nth-child(even) {
            background-color: #fafafa;
        }

        .amount {
            font-weight: 700;
            color: #2d3436;
            text-align: right;
        }

        .no-col {
            width: 30px;
            text-align: center;
            color: #7f8c8d;
        }

        .total-row td {
            background-color: #ffffff !important;
            border-top: 2px solid #5d55cb;
            font-size: 14px;
            padding-top: 20px;
        }

        .total-label {
            text-align: right;
            font-weight: bold;
            color: #7f8c8d;
        }

        .total-value {
            text-align: right;
            font-weight: 800;
            color: #5d55cb;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #bdc3c7;
        }
    </style>
</head>
<body>

    <div class="header">
        <table width="100%">
            <tr>
                <td>
                    <h1 class="title">Payment <span>History</span></h1>
                    <div class="subtitle">E-License Official Document</div>
                </td>
                <td align="right">
                    <div style="font-weight: bold; color: #5d55cb;">#<?= htmlspecialchars($product['agreement_number']) ?></div>
                    <div style="color: #bdc3c7; font-size: 10px;">Dicetak: <?= date('d/m/Y H:i') ?></div>
                </td>
            </tr>
        </table>
    </div>

    <div class="card-info">
        <table class="info-table">
            <tr>
                <td class="label">User / Holder</td>
                <td class="value">: <?= htmlspecialchars($product['username']) ?></td>
                <td class="label">Department</td>
                <td class="value">: <?= htmlspecialchars($product['departemen']) ?></td>
            </tr>
            <tr>
                <td class="label">Agreement No.</td>
                <td class="value">: <?= htmlspecialchars($product['agreement_number']) ?></td>
                <td class="label">Current Status</td>
                <td class="value">: <span class="badge-expired">Valid Until <?= htmlspecialchars($product['order_date']) ?></span></td>
            </tr>
        </table>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th class="no-col">No</th>
                <th>Tanggal Pembayaran</th>
                <th style="text-align: right;">Nominal (IDR)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($details)) : ?>
                <?php 
                $total = 0;
                foreach ($details as $i => $item) : 
                    $total += $item['amount'];
                ?>
                    <tr>
                        <td class="no-col"><?= $i + 1 ?></td>
                        <td><?= date('d F Y', strtotime($item['payment_date'])) ?></td>
                        <td class="amount">Rp <?= number_format($item['amount'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
                
                <tr class="total-row">
                    <td colspan="2" class="total-label">TOTAL PAID</td>
                    <td class="total-value">Rp <?= number_format($total, 0, ',', '.') ?></td>
                </tr>
            <?php else : ?>
                <tr>
                    <td colspan="3" style="text-align: center; padding: 40px; color: #95a5a6;">Belum ada riwayat transaksi.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dihasilkan oleh sistem secara otomatis dan bersifat sah.<br>
        © <?= date('Y') ?> License Management System - <?= htmlspecialchars($product['departemen']) ?></p>
    </div>

</body>
</html>