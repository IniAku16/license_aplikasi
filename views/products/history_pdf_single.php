<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat License Aplikasi</title>
    <style>
        @page {
            margin: 50px 40px;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #2d3436;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .header {
            border-bottom: 2px solid #f3f4f9;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            color: #232424;
            margin: 0;
            line-height: 1.2;
        }

        .title span {
            color: #5d55cb;
        }

        .subtitle {
            font-size: 10px;
            color: #7f8c8d;
            margin-top: 6px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .doc-number {
            font-weight: bold;
            color: #5d55cb;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .doc-date {
            color: #bdc3c7;
            font-size: 10px;
        }

        .card-info {
            background-color: #f8f9ff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid #eef0f8;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 6px 4px;
            vertical-align: top;
        }

        .label {
            color: #7f8c8d;
            width: 110px;
            font-weight: 500;
        }

        .value {
            color: #2d3436;
            font-weight: 600;
        }

        .badge-status {
            background-color: #eaf4ff;
            color: #5d55cb;
            padding: 3px 10px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 11px;
            display: inline-block;
        }

        table.main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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
            padding: 14px 15px;
            border-bottom: 1px solid #f1f2f6;
            vertical-align: middle;
        }

        table.main-table tr:nth-child(even) {
            background-color: #fafafa;
        }

        table.main-table tr {
            page-break-inside: avoid;
        }

        .amount {
            font-weight: 700;
            color: #2d3436;
            text-align: right;
        }

        .no-col {
            width: 35px;
            text-align: center;
            color: #7f8c8d;
        }

        .total-row td {
            background-color: #ffffff !important;
            border-top: 2px solid #5d55cb;
            font-size: 13px;
            padding-top: 18px;
        }

        .total-label {
            text-align: right;
            font-weight: bold;
            color: #7f8c8d;
            letter-spacing: 0.5px;
        }

        .total-value {
            text-align: right;
            font-weight: 800;
            color: #5d55cb;
            font-size: 15px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #95a5a6;
            border-top: 1px dashed #f1f2f6;
            padding-top: 15px;
        }
    </style>
</head>

<body>

    <div class="header">
        <table width="100%">
            <tr>
                <td style="vertical-align: bottom;">
                    <h1 class="title">Payment <span>History</span></h1>
                    <div class="subtitle">E-License Official Document</div>
                </td>
                <td align="right" style="vertical-align: bottom;">
                    <div class="doc-number">#<?= htmlspecialchars($product['agreement_number']) ?></div>
                    <div class="doc-date">Dicetak: <?= date('d/m/Y') ?></div>
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
                <td class="label">Application</td>
                <td class="value">: <?= htmlspecialchars($product['application_name']) ?></td>
                <td class="label">Email</td>
                <td class="value">: <?= htmlspecialchars($product['email_name']) ?></td>
            </tr>
            <tr>
                <td class="label">Agreement No.</td>
                <td class="value">: <?= htmlspecialchars($product['agreement_number']) ?></td>
                <td class="label">Current Status</td>
                <td class="value">: <span class="badge-status">Valid Until <?= htmlspecialchars($product['order_date']) ?></span></td>
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
                    <td colspan="3" style="text-align: center; padding: 40px; color: #95a5a6; font-style: italic;">
                        Belum ada riwayat transaksi.
                    </td>
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