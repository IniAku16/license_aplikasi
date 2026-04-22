<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat License Keseluruhan</title>
    <style>
        @page { margin: 50px 40px; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #2d3436;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }

        .main-header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #5d55cb;
            padding-bottom: 20px;
        }

        .main-header h1 {
            font-size: 24px;
            margin: 0;
            color: #2d3436;
        }

        .main-header h1 span {
            color: #5d55cb;
        }

        .main-header p {
            margin: 5px 0 0;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 10px;
        }

        .product-block {
            margin-bottom: 40px;
            page-break-inside: avoid; 
        }

        .product-summary {
            background-color: #f8f9ff;
            border-left: 5px solid #5d55cb;
            padding: 15px;
            border-radius: 0 10px 10px 0;
            margin-bottom: 10px;
        }

        .product-summary table {
            width: 100%;
        }

        .product-title {
            font-size: 14px;
            font-weight: bold;
            color: #5d55cb;
            margin-bottom: 5px;
        }

        .info-label {
            color: #7f8c8d;
            font-size: 9px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .info-value {
            font-weight: 600;
            color: #2d3436;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .detail-table th {
            background-color: #ffffff;
            color: #7f8c8d;
            text-align: left;
            padding: 8px 12px;
            font-size: 9px;
            text-transform: uppercase;
            border-bottom: 2px solid #edeff2;
        }

        .detail-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #f1f2f6;
        }

        .detail-table tr:nth-child(even) {
            background-color: #fafafa;
        }

        .amount {
            font-weight: bold;
            text-align: right;
            color: #2d3436;
        }

        .text-center { text-align: center; }

        .badge-total {
            background-color: #eaf4ff;
            color: #5d55cb;
            padding: 2px 8px;
            border-radius: 5px;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #bdc3c7;
        }

        .page-number:after { content: counter(page); }
    </style>
</head>
<body>

    <div class="main-header">
        <h1>Payment <span>Summary Report</span></h1>
        <p>Seluruh Riwayat Lisensi Aplikasi?></p>
    </div>

    <?php if (!empty($histories)) : ?>
        <?php foreach ($histories as $index => $item) : ?>
            <div class="product-block">
                <div class="product-summary">
                    <div class="product-title">#<?= htmlspecialchars($item['agreement_number']) ?> - <?= htmlspecialchars($item['username']) ?></div>
                    <table border="0">
                        <tr>
                            <td width="33%">
                                <div class="info-label">Departemen</div>
                                <div class="info-value"><?= htmlspecialchars($item['departemen']) ?></div>
                            </td>
                            <td width="33%">
                                <div class="info-label">Total Transaksi</div>
                                <div class="info-value"><span class="badge-total"><?= $item['total_transaksi'] ?> Kali Pembayaran</span></div>
                            </td>
                            <td width="33%" align="right">
                                <div class="info-label">Akumulasi Biaya</div>
                                <div class="info-value" style="color: #5d55cb; font-size: 14px;">Rp <?= number_format($item['total_amount'], 0, ',', '.') ?></div>
                            </td>
                        </tr>
                    </table>
                </div>

                <table class="detail-table">
                    <thead>
                        <tr>
                            <th width="40" class="text-center">No</th>
                            <th>Tanggal Pembayaran</th>
                            <th style="text-align: right;">Nominal Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($item['details'])) : ?>
                            <?php foreach ($item['details'] as $dIdx => $detail) : ?>
                                <tr>
                                    <td class="text-center" style="color: #bdc3c7;"><?= $dIdx + 1 ?></td>
                                    <td><?= date('d M Y', strtotime($detail['payment_date'])) ?></td>
                                    <td class="amount">Rp <?= number_format($detail['amount'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3" class="text-center" style="color: #bdc3c7; padding: 20px;">Tidak ada riwayat detail untuk produk ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div style="text-align: center; padding: 100px; color: #bdc3c7;">
            <h3>Data tidak ditemukan</h3>
            <p>Belum ada riwayat pembayaran dalam database.</p>
        </div>
    <?php endif; ?>

    <div class="footer">
        Halaman <span class="page-number"></span> | Dokumen Resmi Sistem Lisensi Aplikasi | Dicetak pada <?= date('d/m/Y H:i') ?>
    </div>

</body>
</html>