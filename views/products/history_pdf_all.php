<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat License Keseluruhan</title>
    <style>
        @page {
            margin: 60px 40px;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #2d3436;
            margin: 0;
            padding: 0;
            line-height: 1.5;
            background-color: #ffffff;
        }

        .main-header {
            text-align: center;
            margin-bottom: 35px;
            border-bottom: 3px solid #5d55cb;
            padding-bottom: 20px;
        }

        .main-header h1 {
            font-size: 24px;
            margin: 0;
            color: #2d3436;
            line-height: 1.2;
        }

        .main-header h1 span {
            color: #5d55cb;
        }

        .main-header p {
            margin: 8px 0 0;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 10px;
            font-weight: 500;
        }

        .product-block {
            margin-bottom: 40px;
            page-break-inside: avoid;
        }

        .product-summary {
            background-color: #f8f9ff;
            border-left: 4px solid #5d55cb;
            padding: 15px 20px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 5px;
            border-top: 1px solid #eef0f8;
            border-right: 1px solid #eef0f8;
            border-bottom: 1px solid #eef0f8;
        }

        .product-summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .product-summary td {
            vertical-align: middle;
            padding: 4px 0;
        }

        .product-title {
            font-size: 14px;
            font-weight: bold;
            color: #2d3436;
            margin-bottom: 2px;
        }

        .product-subtitle {
            font-size: 11px;
            color: #7f8c8d;
            font-weight: 500;
        }

        .info-label {
            color: #95a5a6;
            font-size: 9px;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .info-value {
            font-weight: 600;
            color: #2d3436;
        }

        .badge-total {
            background-color: #eaf4ff;
            color: #5d55cb;
            padding: 3px 10px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 10px;
            display: inline-block;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .detail-table th {
            background-color: #ffffff;
            color: #7f8c8d;
            text-align: left;
            padding: 10px 12px;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #edeff2;
        }

        .detail-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #f1f2f6;
            vertical-align: middle;
        }

        .detail-table tr:nth-child(even) {
            background-color: #fafafa;
        }

        .amount {
            font-weight: 700;
            text-align: right;
            color: #2d3436;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #bdc3c7;
            border-top: 1px solid #f1f2f6;
            padding-top: 10px;
        }

        .page-number:after {
            content: counter(page);
        }
    </style>
</head>

<body>

    <div class="main-header">
        <h1>Payment <span>Summary Report</span></h1>
        <p>Seluruh Riwayat Lisensi Aplikasi</p>
    </div>

    <?php if (!empty($histories)) : ?>
        <?php foreach ($histories as $index => $item) : ?>
            <div class="product-block">

                <div class="product-summary">
                    <table>
                        <tr>
                            <td>
                                <div class="product-title">#<?= htmlspecialchars($item['agreement_number'] ?? '-') ?> — <?= htmlspecialchars($item['username'] ?? '-') ?></div>
                                <div class="product-subtitle">
                                    <?= htmlspecialchars($item['application_name'] ?? 'Nama Aplikasi Tidak Terdeteksi') ?>
                                    <?php if (!empty($item['email_name'])) : ?>
                                        <span style="color: #7f8c8d; margin-left: 5px;">(<?= htmlspecialchars($item['email_name']) ?>)</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td width="25%">
                                <div class="info-label">Departemen</div>
                                <div class="info-value" style="margin-bottom: 5px;"><?= htmlspecialchars($item['departemen'] ?? '-') ?></div>
                                <div class="info-value"><span class="badge-total"><?= htmlspecialchars($item['total_transaksi'] ?? 0) ?>x Pembayaran</span></div>
                            </td>
                            <td width="30%" align="right">
                                <div class="info-label">Akumulasi Biaya</div>
                                <div class="info-value" style="color: #5d55cb; font-size: 16px; font-weight: 800; margin-top: 2px;">
                                    Rp <?= number_format($item['total_amount'] ?? 0, 0, ',', '.') ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <table class="detail-table">
                    <thead>
                        <tr>
                            <th width="40" class="text-center">No</th>
                            <th>Tanggal Pembayaran</th>
                            <th style="text-align: right; padding-right: 12px;">Nominal Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($item['details'])) : ?>
                            <?php foreach ($item['details'] as $dIdx => $detail) : ?>
                                <tr>
                                    <td class="text-center" style="color: #bdc3c7; font-weight: 500;"><?= $dIdx + 1 ?></td>
                                    <td><?= isset($detail['payment_date']) ? date('d M Y', strtotime($detail['payment_date'])) : '-' ?></td>
                                    <td class="amount">Rp <?= number_format($detail['amount'] ?? 0, 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3" class="text-center" style="color: #95a5a6; padding: 20px; font-style: italic;">
                                    Tidak ada riwayat detail untuk produk ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div style="text-align: center; padding: 100px 0; color: #bdc3c7;">
            <h3 style="margin: 0 0 5px 0; color: #7f8c8d;">Data tidak ditemukan</h3>
            <p style="margin: 0;">Belum ada riwayat pembayaran yang tercatat dalam sistem.</p>
        </div>
    <?php endif; ?>

    <div class="footer">
        Halaman <span class="page-number"></span> | Dokumen Resmi Sistem Lisensi Aplikasi | Dicetak pada <?= date('d/m/Y') ?>
    </div>

</body>

</html>