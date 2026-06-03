<?php
$activePage = 'products';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lisensi Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
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

        #content {
            flex: 1;
            margin-left: 280px;
            padding: 25px;
            transition: var(--transition);
        }

        #content.expanded {
            margin-left: 85px;
        }

        .card-custom {
            background: #ffffff;
            border-radius: 20px;
            border: none;
            padding: 20px;
            box-shadow: var(--card-shadow);
        }

        .btn-pastel {
            background-color: var(--primary-pastel);
            color: white;
            border-radius: 12px;
            padding: 8px 18px;
            font-weight: 600;
            border: none;
            transition: var(--transition);
        }

        .btn-pastel:hover {
            background-color: var(--primary-light);
            color: white;
            transform: translateY(-2px);
        }

        .stat-card {
            border: none;
            border-radius: 18px;
            padding: 20px;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            height: 100%;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            padding: 10px;
        }

        .table {
            font-size: 0.85rem; 
            vertical-align: middle;
        }

        .table thead th {
            background-color: #f8f9ff;
            color: #636e72;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.5px;
            padding: 12px 8px;
            border: none;
        }

        .badge-status {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        #toggle-btn {
            background: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            color: var(--primary-pastel);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .filter-area {
            background: #ffffff;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            border: 1px solid rgba(0,0,0,0.05);
        }

        @media (max-width: 1200px) {
            #content { margin-left: 0 !important; width: 100% !important; }
            .table-responsive { border: 0; }
        }

        .img-container { overflow: auto; text-align: center; background: #f1f2f6; padding: 20px; }
        #imgPreview { max-width: 100%; border-radius: 10px; cursor: zoom-in; transition: transform 0.3s; }
        #imgPreview.zoomed { transform: scale(1.8); cursor: zoom-out; }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <div class="d-flex">
            <?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

            <main id="content">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center">
                        <button id="toggle-btn" class="me-3">
                            <i class="bi bi-list"></i>
                        </button>
                        <h4 class="fw-bold m-0">Halo, <span class="text-primary"><?= htmlspecialchars($_SESSION['username']) ?></span></h4>
                    </div>
                    <button class="btn btn-pastel" data-bs-toggle="modal" data-bs-target="#createProductModal">
                        <i class="bi bi-plus-lg me-2"></i> Tambah Lisensi
                    </button>
                </div>

                <?php if (!empty($expiringProducts)) : ?>
                    <div class="alert alert-warning border-0 shadow-sm mb-4" style="border-radius: 15px;">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                            <div>
                                <strong class="d-block">Lisensi Mendekati Expired!</strong>
                                <div class="mt-1">
                                    <?php foreach (array_slice($expiringProducts, 0, 5) as $prod) : ?>
                                        <span class="badge bg-dark bg-opacity-10 text-dark me-1"><?= htmlspecialchars($prod['username']) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <small class="text-muted fw-bold">TOTAL</small>
                            <h3 class="fw-bold m-0"><?= $totalProducts ?></h3>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <small class="text-success fw-bold">AKTIF</small>
                            <h3 class="fw-bold m-0 text-success"><?= $activeCount ?></h3>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <small class="text-warning fw-bold">SEGERA BERAKHIR</small>
                            <h3 class="fw-bold m-0 text-warning"><?= $expiringCount ?></h3>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card">
                            <small class="text-danger fw-bold">EXPIRED</small>
                            <h3 class="fw-bold m-0 text-danger"><?= $expiredCount ?></h3>
                        </div>
                    </div>
                </div>

                <div class="filter-area shadow-sm">
                    <div class="row g-2 mb-3">
                        <div class="col-md-3">
                            <input type="text" id="searchProduct" class="form-control" placeholder="Cari aplikasi/user...">
                        </div>
                        <div class="col-md-2">
                            <select id="filterExpired" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="week">Minggu Ini</option>
                                <option value="month">Bulan Ini</option>
                                <?php foreach (array_keys($appStats) as $appName) : ?>
                                    <?php if ($appName !== 'Lainnya') : ?>
                                        <option value="app:<?= htmlspecialchars($appName) ?>"><?= htmlspecialchars($appName) ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="rowsPerPage" class="form-select">
                                <option value="5">Tampilkan 5</option>
                                <option value="10">Tampilkan 10</option>
                                <option value="25">Tampilkan 25</option>
                                <option value="50">Tampilkan 50</option>
                            </select>
                        </div>
                        <div class="col-md-5 text-end">
                            <form action="/license_aplikasi/public/index.php" method="GET" class="d-flex gap-1 justify-content-end">
                                <input type="hidden" name="action" value="exportExcel">
                                <input type="date" name="start_date" class="form-control form-control-sm" style="width: 130px;">
                                <input type="date" name="end_date" class="form-control form-control-sm" style="width: 130px;">
                                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i></button>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive table-container">
                        <table class="table table-hover" id="mainTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Aplikasi</th>
                                    <th>No. Agreement</th>
                                    <th>User & Dept</th>
                                    <th>Expired</th>
                                    <th>Sisa</th>
                                    <th>Harga</th>
                                    <th>Foto</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($products)) : $no = 1; foreach ($products as $product) : 
                                    $statusColor = ($product['status'] == "expired") ? "danger" : (($product['status'] == "segera") ? "warning" : "success");
                                ?>
                                    <tr data-app="<?= htmlspecialchars($product['application_name']) ?>">
                                        <td class="text-muted small"><?= $no++ ?></td>
                                        <td class="fw-bold"><?= htmlspecialchars($product['application_name']) ?></td>
                                        <td class="small"><?= htmlspecialchars($product['agreement_number']) ?></td>
                                        <td>
                                            <div class="fw-semibold"><?= htmlspecialchars($product['username']) ?></div>
                                            <small class="text-muted"><?= htmlspecialchars($product['departemen']) ?></small>
                                        </td>
                                        <td class="small"><?= $product['order_date'] ?></td>
                                        <td class="fw-bold <?= $product['sisa_hari'] < 0 ? 'text-danger' : 'text-primary' ?>">
                                            <?= $product['sisa_hari'] ?> H
                                        </td>
                                        <td class="fw-bold">Rp<?= number_format($product['harga_order'], 0, ',', '.') ?></td>
                                        <td>
                                            <?php if (!empty($product['foto'])): ?>
                                                <button class="btn btn-sm btn-light border view-foto-btn" data-img="/license_aplikasi/public/uploads/<?= $product['foto'] ?>">
                                                    <i class="bi bi-image"></i>
                                                </button>
                                            <?php else: ?>
                                                <span class="text-muted" style="font-size: 10px;">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="badge badge-status bg-<?= $statusColor ?>"><?= ucfirst($product['status']) ?></span></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-update" 
                                                    data-id="<?= $product['id'] ?>"
                                                    data-application="<?= htmlspecialchars($product['application_name']) ?>"
                                                    data-agreement="<?= htmlspecialchars($product['agreement_number']) ?>"
                                                    data-name="<?= htmlspecialchars($product['username']) ?>"
                                                    data-departemen="<?= htmlspecialchars($product['departemen']) ?>"
                                                    data-email="<?= htmlspecialchars($product['email_name']) ?>"
                                                    data-expired="<?= $product['order_date'] ?>"
                                                    data-harga="<?= $product['harga_order'] ?>">
                                                    <i class="bi bi-pencil-square text-warning"></i>
                                                </button>
                                                <button class="btn btn-sm done-btn" data-id="<?= $product['id'] ?>"><i class="bi bi-wallet2 text-success"></i></button>
                                                <a href="/license_aplikasi/public/index.php?action=delete&id=<?= $product['id'] ?>" class="btn btn-sm" onclick="return confirm('Hapus?')"><i class="bi bi-trash text-danger"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; else : ?>
                                    <tr><td colspan="10" class="text-center py-5">Belum ada data</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted small" id="tableInfo"></div>
                        <nav><ul class="pagination pagination-sm mb-0" id="paginationWrapper"></ul></nav>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="createProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card-custom">
                <form id="productForm">
                    <div class="modal-header border-0"><h5 class="fw-bold">Tambah Lisensi Baru</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Application Name</label>
                            <input type="text" class="form-control" name="application_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Agreement Number</label>
                            <input type="text" class="form-control" name="agreement_number" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">User</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Departemen</label>
                            <select class="form-select select-search" name="departemen" id="add_departemen" required>
                                <option value="">Pilih...</option>
                                <?php foreach ($branches as $branch) : ?>
                                    <option value="<?= htmlspecialchars($branch['nama_branch']) ?>"><?= htmlspecialchars($branch['nama_branch']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="text" class="form-control" name="email_name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Expired Date</label>
                            <input type="date" class="form-control" name="order_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Last Quotation (Rp)</label>
                            <input type="number" class="form-control" name="harga_order">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Foto Lisensi</label>
                            <input type="file" class="form-control" name="foto" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card-custom">
                <form id="editProductForm">
                    <input type="hidden" name="id" id="edit_product_id">
                    <div class="modal-header border-0"><h5 class="fw-bold">Perbarui Lisensi</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body row g-3">
                        <div class="col-md-6"><label class="small fw-bold">Application Name</label><input type="text" class="form-control" id="edit_application_name" name="application_name" required></div>
                        <div class="col-md-6"><label class="small fw-bold">Agreement Number</label><input type="text" class="form-control" id="edit_agreement_number" name="agreement_number" required></div>
                        <div class="col-md-6"><label class="small fw-bold">User</label><input type="text" class="form-control" id="edit_username" name="username" required></div>
                        <div class="col-md-6">
                            <label class="small fw-bold">Departemen</label>
                            <select class="form-select select-search" name="departemen" id="edit_departemen" required>
                                <option value="">Pilih...</option>
                                <?php foreach ($branches as $branch) : ?>
                                    <option value="<?= htmlspecialchars($branch['nama_branch']) ?>"><?= htmlspecialchars($branch['nama_branch']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="small fw-bold">Email</label><input type="text" class="form-control" id="edit_email" name="email_name"></div>
                        <div class="col-md-6"><label class="small fw-bold">Expired Date</label><input type="date" class="form-control" id="edit_order_date" name="order_date" required></div>
                        <div class="col-md-6"><label class="small fw-bold">Harga</label><input type="number" class="form-control" id="edit_harga_order" name="harga_order"></div>
                        <div class="col-md-6"><label class="small fw-bold">Update Foto</label><input type="file" class="form-control" name="foto" accept="image/*"></div>
                    </div>
                    <div class="modal-footer border-0"><button type="submit" class="btn btn-primary px-4">Update Data</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content card-custom">
                <form id="paymentForm">
                    <div class="modal-header border-0"><h6 class="fw-bold">Konfirmasi Pembayaran</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <input type="hidden" id="payment_product_id">
                        <div class="mb-2"><label class="small">Tanggal</label><input type="date" class="form-control form-control-sm" id="payment_date" required></div>
                        <div class="mb-2"><label class="small">Nominal</label><input type="number" class="form-control form-control-sm" id="payment_amount" placeholder="Contoh: 1500000" required></div>
                    </div>
                    <div class="modal-footer border-0"><button type="submit" class="btn btn-success btn-sm w-100">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="photoModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-transparent border-0 text-center">
                <div class="img-container rounded shadow-lg bg-white">
                    <img src="" id="imgPreview" alt="Foto Lisensi">
                </div>
                <div class="mt-3">
                    <a href="" id="downloadBtn" download class="btn btn-light btn-sm px-3"><i class="bi bi-download me-2"></i>Download</a>
                    <button type="button" class="btn btn-danger btn-sm px-3 ms-2" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <script>
        const STATE_KEY = 'license_dashboard_state';
        let currentState = JSON.parse(localStorage.getItem(STATE_KEY)) || {
            search: '',
            filter: '',
            rowsPerPage: 25,
            page: 1
        };

        function saveState() { localStorage.setItem(STATE_KEY, JSON.stringify(currentState)); }
        document.getElementById('searchProduct').value = currentState.search;
        document.getElementById('filterExpired').value = currentState.filter;
        document.getElementById('rowsPerPage').value = currentState.rowsPerPage;

        let tsAdd, tsEdit;
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const tableBody = document.querySelector('#mainTable tbody');
        const originalRows = Array.from(tableBody.querySelectorAll('tr'));

        document.addEventListener("DOMContentLoaded", function() {
            tsAdd = new TomSelect('#add_departemen', { placeholder: "Cari dept..." });
            tsEdit = new TomSelect('#edit_departemen', { placeholder: "Cari dept..." });

            if (localStorage.getItem('sidebarStatus') === 'collapsed') {
                sidebar.classList.add('collapsed');
                content.classList.add('expanded');
            }
            updateTable();
        });

        document.getElementById('toggle-btn').addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');
            localStorage.setItem('sidebarStatus', sidebar.classList.contains('collapsed') ? 'collapsed' : 'open');
        });

        document.getElementById('searchProduct').addEventListener('input', (e) => {
            currentState.search = e.target.value.toLowerCase();
            currentState.page = 1;
            saveState();
            updateTable();
        });

        document.getElementById('filterExpired').addEventListener('change', (e) => {
            currentState.filter = e.target.value;
            currentState.page = 1;
            saveState();
            updateTable();
        });

        document.getElementById('rowsPerPage').addEventListener('change', (e) => {
            currentState.rowsPerPage = parseInt(e.target.value);
            currentState.page = 1;
            saveState();
            updateTable();
        });

        function updateTable() {
            const today = new Date();
            today.setHours(0,0,0,0);

            let filteredRows = originalRows.filter(row => {
                const text = row.innerText.toLowerCase();
                const appName = row.getAttribute('data-app');
                const expStr = row.cells[4].innerText;
                const expDate = new Date(expStr);

                let matchSearch = text.includes(currentState.search);
                let matchFilter = true;

                if (currentState.filter !== "") {
                    if (currentState.filter.startsWith('app:')) {
                        matchFilter = (appName === currentState.filter.replace('app:', ''));
                    } else {
                        const diff = Math.ceil((expDate - today) / (1000 * 60 * 60 * 24));
                        if (currentState.filter === 'week') matchFilter = (diff >= 0 && diff <= 7);
                        if (currentState.filter === 'month') matchFilter = (diff >= 0 && diff <= 30);
                    }
                }
                return matchSearch && matchFilter;
            });

            const total = filteredRows.length;
            const pages = Math.ceil(total / currentState.rowsPerPage);
            if (currentState.page > pages) currentState.page = 1;

            const start = (currentState.page - 1) * currentState.rowsPerPage;
            const paginated = filteredRows.slice(start, start + currentState.rowsPerPage);

            // Update statistik berdasarkan filtered rows
            let activeCount = 0, expiringCount = 0, expiredCount = 0;
            filteredRows.forEach(row => {
                const statusCell = row.cells[8];
                const statusText = statusCell.innerText.toLowerCase();
                if (statusText.includes('aktif')) activeCount++;
                else if (statusText.includes('segera')) expiringCount++;
                else if (statusText.includes('expired')) expiredCount++;
            });
            
            // Update statistik di halaman
            document.querySelectorAll('.stat-card')[0].querySelector('h3').innerText = total;
            document.querySelectorAll('.stat-card')[1].querySelector('h3').innerText = activeCount;
            document.querySelectorAll('.stat-card')[2].querySelector('h3').innerText = expiringCount;
            document.querySelectorAll('.stat-card')[3].querySelector('h3').innerText = expiredCount;

            tableBody.innerHTML = '';
            if (paginated.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="10" class="text-center py-4">Data tidak ditemukan</td></tr>';
            } else {
                let no = start + 1;
                paginated.forEach(row => {
                    const rowClone = row.cloneNode(true);
                    rowClone.cells[0].innerText = no++;
                    tableBody.appendChild(rowClone);
                });
            }

            renderPagination(pages);
            document.getElementById('tableInfo').innerText = `Menampilkan ${total === 0 ? 0 : start+1}-${Math.min(start + currentState.rowsPerPage, total)} dari ${total} lisensi`;
        }

        function renderPagination(total) {
            const wrapper = document.getElementById('paginationWrapper');
            wrapper.innerHTML = '';
            if (total <= 1) return;

            for (let i = 1; i <= total; i++) {
                const li = document.createElement('li');
                li.className = `page-item ${i === currentState.page ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.onclick = (e) => { e.preventDefault(); currentState.page = i; saveState(); updateTable(); };
                wrapper.appendChild(li);
            }
        }

        document.getElementById('productForm').addEventListener('submit', function(e) {
            e.preventDefault();
            fetch('/license_aplikasi/public/index.php?action=create', { method: 'POST', body: new FormData(this) })
            .then(res => res.json()).then(data => {
                alert(data.message);
                if(data.status === 'success') location.reload();
            });
        });

        document.querySelectorAll('.btn-update').forEach(btn => {
            btn.addEventListener('click', function() {
                const d = this.dataset;
                document.getElementById('edit_product_id').value = d.id;
                document.getElementById('edit_application_name').value = d.application;
                document.getElementById('edit_agreement_number').value = d.agreement;
                document.getElementById('edit_username').value = d.name;
                tsEdit.setValue(d.departemen);
                document.getElementById('edit_email').value = d.email;
                document.getElementById('edit_order_date').value = d.expired;
                document.getElementById('edit_harga_order').value = d.harga;
                new bootstrap.Modal('#editProductModal').show();
            });
        });

        document.getElementById('editProductForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('edit_product_id').value;
            fetch('/license_aplikasi/public/index.php?action=update&id=' + id, { method: 'POST', body: new FormData(this) })
            .then(res => res.json()).then(data => {
                alert(data.message);
                if(data.status === 'success') location.reload();
            });
        });

        document.querySelectorAll('.done-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('payment_product_id').value = this.dataset.id;
                new bootstrap.Modal('#paymentModal').show();
            });
        });

        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('payment_product_id').value;
            const fd = new FormData();
            fd.append('payment_status', 'done');
            fd.append('payment_date', document.getElementById('payment_date').value);
            fd.append('amount', document.getElementById('payment_amount').value);

            fetch('/license_aplikasi/public/index.php?action=update&id=' + id, { method: 'POST', body: fd })
            .then(res => res.json()).then(data => {
                if(data.status === 'success') location.reload();
                else alert(data.message);
            });
        });

        document.querySelectorAll('.view-foto-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const src = this.getAttribute('data-img');
                const img = document.getElementById('imgPreview');
                img.src = src;
                img.classList.remove('zoomed');
                document.getElementById('downloadBtn').href = src;
                new bootstrap.Modal('#photoModal').show();
            });
        });

        document.getElementById('imgPreview').addEventListener('click', function() {
            this.classList.toggle('zoomed');
        });

    </script>
</body>
</html>