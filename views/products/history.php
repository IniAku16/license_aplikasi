<?php
$activePage = 'history'; 
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Riwayat Pembayaran</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-pastel: #5d55cb;
            --primary-light: #8379f7;
            --bg-color: #f3f4f9;
            --card-shadow: 0 10px 30px rgba(162, 155, 254, 0.15);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Poppins', sans-serif;
            color: #2d3436;
            overflow-x: hidden;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        #content {
            flex: 1;
            margin-left: 260px;
            padding: 30px;
            transition: var(--transition);
        }

        #content.expanded {
            margin-left: 85px;
        }

        .card-custom {
            background: #ffffff;
            border-radius: 24px;
            border: none;
            padding: 25px;
            box-shadow: var(--card-shadow);
            margin-bottom: 25px;
        }

        .header-greeting h2 {
            font-weight: 700;
            color: #2d3436;
        }

        .header-greeting span {
            color: var(--primary-pastel);
        }

        .btn-pastel {
            background-color: var(--primary-pastel);
            color: white;
            border: none;
            border-radius: 14px;
            padding: 10px 20px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-pastel:hover {
            background-color: var(--primary-light);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(93, 85, 203, 0.3);
        }

        .stat-card {
            border: none;
            border-radius: 20px;
            padding: 20px;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
            transition: var(--transition);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .table-container {
            border-radius: 18px;
            overflow: hidden;
        }

        .table thead {
            background-color: #f8f9ff;
        }

        .table thead th {
            font-weight: 600;
            color: #7f8c8d;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            border: none;
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f2f6;
        }

        #toggle-btn {
            background: white;
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 10px;
            color: var(--primary-pastel);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            cursor: pointer;
            margin-right: 20px;
        }

        .form-control {
            border-radius: 12px;
            border: 2px solid #edeff2;
            padding: 12px 16px;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary-pastel);
            box-shadow: 0 0 0 4px rgba(93, 85, 203, 0.1);
        }

        .badge-total {
            background: #eaf4ff;
            color: var(--primary-pastel);
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 8px;
        }

        @media (max-width: 992px) {
            #content { margin-left: 0; }
            #content.expanded { margin-left: 0; }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="main-wrapper">
            <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

            <main id="content">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center header-greeting">
                        <button id="toggle-btn">
                            <i class="bi bi-list"></i>
                        </button>
                        <h2 class="m-0">Payment <span>History</span></h2>
                    </div>
                    <div>
                        <a href="/license_aplikasi/public/index.php?action=history-pdf" target="_blank" class="btn btn-danger rounded-pill px-4">
                            <i class="bi bi-file-earmark-pdf me-2"></i> Cetak Semua PDF
                        </a>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-receipt"></i></div>
                            <p class="text-muted small mb-1 fw-bold">TOTAL DATA</p>
                            <h3 class="fw-bold m-0"><?= count($histories) ?></h3>
                        </div>
                    </div>
                </div>

                <div class="card-custom">
                    <div class="row g-3 mb-4 align-items-end">
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted mb-1">Cari Riwayat</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                                <input type="text" id="searchHistory" class="form-control border-start-0" placeholder="Search user, agreement, or dept...">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive table-container">
                        <table class="table table-hover align-middle m-0">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Agreement</th>
                                    <th>User / Dept</th>
                                    <th class="text-center">Total Transaksi</th>
                                    <th>Total Nominal</th>
                                    <th>Last Payment</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="historyTableBody">
                                <?php if (!empty($histories)) : $no = 1;
                                    foreach ($histories as $item) : ?>
                                        <tr>
                                            <td class="text-muted small"><?= $no++ ?></td>
                                            <td><div class="fw-bold text-dark"><?= htmlspecialchars($item['agreement_number']) ?></div></td>
                                            <td>
                                                <div class="fw-semibold"><?= htmlspecialchars($item['username']) ?></div>
                                                <small class="badge bg-secondary bg-opacity-10 text-secondary"><?= htmlspecialchars($item['departemen']) ?></small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge-total"><?= $item['total_transaksi'] ?></span>
                                            </td>
                                            <td class="fw-bold text-dark">Rp <?= number_format($item['total_amount'], 0, ',', '.') ?></td>
                                            <td class="small text-muted">
                                                <?= !empty($item['last_payment_date']) ? htmlspecialchars($item['last_payment_date']) : '-' ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group shadow-sm">
                                                    <button class="btn btn-white btn-sm detail-btn" 
                                                            data-product-id="<?= $item['product_id'] ?>" 
                                                            data-product-name="<?= htmlspecialchars($item['username']) ?>">
                                                        <i class="bi bi-eye-fill text-primary"></i> View
                                                    </button>
                                                    <a href="/license_aplikasi/public/index.php?action=history-pdf&product_id=<?= $item['product_id'] ?>" 
                                                       target="_blank" class="btn btn-white btn-sm">
                                                        <i class="bi bi-file-pdf-fill text-danger"></i> PDF
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                else : ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">Belum ada riwayat pembayaran</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="detailHistoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content card-custom">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Detail Order - <span id="detailProductName" class="text-primary"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive table-container border">
                        <table class="table table-hover m-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody id="detailHistoryBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const toggleBtn = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');
            localStorage.setItem('sidebarStatus', sidebar.classList.contains('collapsed') ? 'collapsed' : 'open');
        });

        window.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('sidebarStatus') === 'collapsed') {
                sidebar.classList.add('collapsed');
                content.classList.add('expanded');
            }
        });

        document.getElementById('searchHistory').addEventListener('input', function() {
            const keyword = this.value.toLowerCase();
            const rows = document.querySelectorAll('#historyTableBody tr');

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(keyword) ? '' : 'none';
            });
        });

        document.querySelectorAll('.detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                document.getElementById('detailProductName').innerText = this.dataset.productName;
                const tbody = document.getElementById('detailHistoryBody');
                tbody.innerHTML = '<tr><td colspan="3" class="text-center">Loading...</td></tr>';

                fetch('/license_aplikasi/public/index.php?action=history-detail&product_id=' + productId)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success' && data.data.length > 0) {
                            tbody.innerHTML = data.data.map((item, i) => `
                                <tr>
                                    <td>${i + 1}</td>
                                    <td>${item.payment_date}</td>
                                    <td class="fw-bold">Rp ${Number(item.amount).toLocaleString('id-ID')}</td>
                                </tr>
                            `).join('');
                        } else {
                            tbody.innerHTML = '<tr><td colspan="3" class="text-center">No details</td></tr>';
                        }
                        new bootstrap.Modal(document.getElementById('detailHistoryModal')).show();
                    });
            });
        });
    </script>
</body>
</html>