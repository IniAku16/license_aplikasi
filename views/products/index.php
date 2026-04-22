<?php
$activePage = 'products';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>License Dashboard</title>
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

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-shadow);
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

        .form-control,
        .form-select {
            border-radius: 12px;
            border: 2px solid #edeff2;
            padding: 12px 16px;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary-pastel);
            box-shadow: 0 0 0 4px rgba(93, 85, 203, 0.1);
        }

        .alert-custom {
            border-radius: 16px;
            border: none;
            font-weight: 500;
        }

        @media (max-width: 992px) {
            #content {
                margin-left: 0;
            }

            #content.expanded {
                margin-left: 0;
            }
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
                        <h2 class="m-0">Heyow Welcome, <span><?= htmlspecialchars($_SESSION['username']) ?></span></h2>
                    </div>
                    <div>
                        <button class="btn btn-pastel" data-bs-toggle="modal" data-bs-target="#createProductModal">
                            <i class="bi bi-plus-lg me-2"></i> Add License
                        </button>
                    </div>
                </div>

                <?php if (!empty($expiringProducts)) : ?>
                    <div class="alert alert-warning alert-custom shadow-sm mb-4 border-0" style="background: #fff9eb; border-left: 5px solid #f39c12 !important; border-radius: 15px;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-exclamation-triangle-fill me-2" style="color: #f39c12; font-size: 1.2rem;"></i>
                            <strong style="color: #856404;">Perhatian: Ada Lisensi Mendekati Expired!</strong>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <?php
                            $limit = 5;
                            $count = 0;
                            foreach ($expiringProducts as $product) :
                                if ($count < $limit) :
                            ?>
                                    <span class="badge rounded-pill bg-warning text-dark px-3 py-2" style="font-weight: 500; font-size: 0.75rem; border: 1px solid #e1ad01;">
                                        <i class="bi bi-app-indicator me-1"></i>
                                        <?= htmlspecialchars($product['username']) ?>
                                        <small class='ms-1 opacity-75'>(<?= htmlspecialchars($product['agreement_number']) ?>)</small>
                                    </span>
                            <?php
                                else:
                                    $sisa = count($expiringProducts) - $limit;
                                    echo "<span class='badge rounded-pill bg-secondary bg-opacity-10 text-secondary px-3 py-2'>+$sisa lainnya...</span>";
                                    break;
                                endif;
                                $count++;
                            endforeach;
                            ?>
                        </div>
                        <hr style="border-top: 1px solid rgba(133, 100, 4, 0.1);">
                        <small class="text-muted">Segera lakukan pembayaran untuk diperpanjang</small>
                    </div>
                <?php endif; ?>

                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-collection-fill"></i></div>
                            <p class="text-muted small mb-1 fw-bold">TOTAL LICENSE</p>
                            <h3 class="fw-bold m-0"><?= $totalProducts ?></h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="bi bi-check-circle-fill"></i></div>
                            <p class="text-muted small mb-1 fw-bold">ACTIVE</p>
                            <h3 class="fw-bold m-0 text-success"><?= $activeCount ?></h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning"><i class="bi bi-hourglass-split"></i></div>
                            <p class="text-muted small mb-1 fw-bold">EXPIRING SOON</p>
                            <h3 class="fw-bold m-0 text-warning"><?= $expiringCount ?></h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-danger bg-opacity-10 text-danger"><i class="bi bi-x-octagon-fill"></i></div>
                            <p class="text-muted small mb-1 fw-bold">EXPIRED</p>
                            <h3 class="fw-bold m-0 text-danger"><?= $expiredCount ?></h3>
                        </div>
                    </div>
                </div>

                <div class="card-custom">
                    <div class="row g-3 mb-4 align-items-end">
                        <div class="col-md-3">
                            <label class="small fw-bold text-muted mb-1">Cari Data</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                                <input type="text" id="searchProduct" class="form-control border-start-0" placeholder="Search product or user...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="small fw-bold text-muted mb-1">Masa Aktif</label>
                            <select id="filterExpired" class="form-select">
                                <option value="">Semua Data</option>
                                <option value="week">Expired Minggu Ini</option>
                                <option value="month">Expired Bulan Ini</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="small fw-bold text-muted mb-1">Tampilkan</label>
                            <select id="rowsPerPage" class="form-select">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25" selected>25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="small fw-bold text-muted mb-1">Export Excel (Range Tanggal)</label>
                            <form action="/license_aplikasi/public/index.php" method="GET" class="d-flex gap-2">
                                <input type="hidden" name="action" value="exportExcel">
                                <input type="date" name="start_date" class="form-control">
                                <input type="date" name="end_date" class="form-control">
                                <button type="submit" class="btn btn-outline-success border-2 fw-bold">
                                    <i class="bi bi-file-earmark-excel"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive table-container">
                        <table class="table table-hover align-middle m-0" id="mainTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Agreement</th>
                                    <th>User / Dept</th>
                                    <th>Order Date</th>
                                    <th>Sisa Hari</th>
                                    <th>Quotation</th>
                                    <th>Foto</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($products)) : $no = 1;
                                    foreach ($products as $product) : ?>
                                        <?php
                                        $statusColor = "success";
                                        if ($product['status'] == "expired") $statusColor = "danger";
                                        elseif ($product['status'] == "expiring") $statusColor = "warning";
                                        ?>
                                        <tr>
                                            <td class="text-muted small row-number"><?= $no++ ?></td>
                                            <td>
                                                <div class="fw-bold text-dark"><?= htmlspecialchars($product['agreement_number']) ?></div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold"><?= htmlspecialchars($product['username']) ?></div>
                                                <small class="badge bg-secondary bg-opacity-10 text-secondary"><?= htmlspecialchars($product['departemen']) ?></small>
                                            </td>
                                            <td class="small text-muted"><?= $product['order_date'] ?></td>
                                            <td>
                                                <?php if ($product['sisa_hari'] < 0) : ?>
                                                    <span class="text-danger fw-bold"><i class="bi bi-arrow-down-circle me-1"></i><?= abs($product['sisa_hari']) ?> Hari</span>
                                                <?php else : ?>
                                                    <span class="text-primary fw-bold"><?= $product['sisa_hari'] ?> Hari</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="fw-bold text-dark">Rp <?= number_format($product['harga_order'], 0, ',', '.') ?></td>
                                            <td>
                                                <?php if (!empty($product['foto'])): ?>
                                                    <button type="button" class="btn btn-sm btn-outline-primary view-foto-btn"
                                                        data-img="/license_aplikasi/public/uploads/<?= $product['foto'] ?>">
                                                        <i class="bi bi-image"></i> View
                                                    </button>
                                                <?php else: ?>
                                                    <span class="text-muted small">No Image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $statusColor ?> px-3 py-2 rounded-pill">
                                                    <?= ucfirst($product['status']) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group shadow-sm">
                                                    <button class="btn btn-white btn-sm btn-update"
                                                        data-id="<?= $product['id'] ?>"
                                                        data-agreement="<?= htmlspecialchars($product['agreement_number']) ?>"
                                                        data-name="<?= htmlspecialchars($product['username']) ?>"
                                                        data-departemen="<?= htmlspecialchars($product['departemen']) ?>"
                                                        data-expired="<?= $product['order_date'] ?>"
                                                        data-harga="<?= $product['harga_order'] ?>"
                                                        data-foto="<?= $product['foto'] ?>">
                                                        <i class="bi bi-pencil-fill text-warning"></i>
                                                    </button>
                                                    <button class="btn btn-white btn-sm done-btn" data-id="<?= $product['id'] ?>">
                                                        <i class="bi bi-wallet2 text-success"></i>
                                                    </button>
                                                    <a href="/license_aplikasi/public/index.php?action=delete&id=<?= $product['id'] ?>"
                                                        class="btn btn-white btn-sm" onclick="return confirm('Yakin Anda Ingin Menghapus Data Ini?');">
                                                        <i class="bi bi-trash3-fill text-danger"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                else : ?>
                                    <tr id="noData">
                                        <td colspan="9" class="text-center py-5 text-muted">No data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 px-2">
                        <div class="text-muted small" id="tableInfo">
                            Showing 0 to 0 of 0 entries
                        </div>
                        <nav>
                            <ul class="pagination pagination-sm mb-0" id="paginationWrapper">
                            </ul>
                        </nav>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card-custom">
                <form id="productForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createProductModalLabel">Add New License</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Agreement Number</label>
                                <input type="text" class="form-control" name="agreement_number" placeholder="Enter agreement number" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">User</label>
                                <input type="text" class="form-control" name="username" placeholder="Enter user name" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Departemen</label>
                                <input type="text" class="form-control" name="departemen" placeholder="Enter department" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Order Date</label>
                                <input type="date" class="form-control" name="order_date" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Quotation</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="harga_order" placeholder="0">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Foto Nota</label>
                                <input type="file" class="form-control" name="foto" accept="image/*" onchange="previewImage(event)">
                                <img id="preview" class="mt-2" style="max-width:100%; display:none;" />
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card-custom">
                <form id="editProductForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">Update License</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_product_id">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Agreement Number</label>
                                <input type="text" class="form-control" id="edit_agreement_number" name="agreement_number" placeholder="Enter agreement number" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">User</label>
                                <input type="text" class="form-control" id="edit_username" name="username" placeholder="Enter user name" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Departemen</label>
                                <input type="text" class="form-control" id="edit_departemen" name="departemen" placeholder="Enter department" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Order Date</label>
                                <input type="date" class="form-control" id="edit_order_date" name="order_date" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Quotation</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="edit_harga_order" name="harga_order" placeholder="0">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Update Foto</label>
                                <input type="file" class="form-control" id="edit_foto" name="foto" accept="image/*" onchange="previewEditImage(event)">

                                <small class="text-muted d-block mt-1">
                                    Kosongkan jika tidak ingin mengubah foto
                                </small>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Data</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content card-custom">
                <form id="paymentForm">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="payment_product_id" name="product_id">

                        <div class="row">

                            <div class="col-12 mb-3">
                                <label class="form-label">Payment Date</label>
                                <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Payment</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content card-custom">
                <div class="modal-header">
                    <h5 class="modal-title">Lampiran Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="imgPreview" class="img-fluid rounded shadow-sm" alt="Preview">
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('productForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('/license_aplikasi/public/index.php?action=create', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        this.reset();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('createProductModal'));
                        modal.hide();
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan!');
                });
        });

        document.querySelectorAll('.btn-update').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('edit_product_id').value = this.dataset.id;
                document.getElementById('edit_agreement_number').value = this.dataset.agreement;
                document.getElementById('edit_username').value = this.dataset.name;
                document.getElementById('edit_departemen').value = this.dataset.departemen;
                document.getElementById('edit_order_date').value = this.dataset.expired;
                document.getElementById('edit_harga_order').value = this.dataset.harga;
                document.getElementById('edit_foto').value = "";

                const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                editModal.show();
            });
        });

        document.getElementById('editProductForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const id = document.getElementById('edit_product_id').value;

            fetch('/license_aplikasi/public/index.php?action=update&id=' + id, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        this.reset();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editProductModal'));
                        modal.hide();
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan!');
                });
        });

        const toggleBtn = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');

            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarStatus', isCollapsed ? 'collapsed' : 'open');
        });

        window.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('sidebarStatus') === 'collapsed') {
                sidebar.classList.add('collapsed');
                content.classList.add('expanded');
            }
        });

        const searchInput = document.getElementById('searchProduct');
        const filterSelect = document.getElementById('filterExpired');
        const tableRows = document.querySelectorAll('table tbody tr');

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();
            const filterValue = filterSelect.value;
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            tableRows.forEach(row => {
                const textContent = row.innerText.toLowerCase();
                const orderDateStr = row.cells[3].innerText;
                const expiredDate = new Date(orderDateStr);

                let matchesSearch = textContent.includes(searchText);
                let matchesFilter = true;

                if (filterValue !== "") {
                    const diffTime = expiredDate - today;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    if (filterValue === 'week' && (diffDays < 0 || diffDays > 7)) matchesFilter = false;
                    if (filterValue === 'month' && (diffDays < 0 || diffDays > 30)) matchesFilter = false;
                }
                row.style.display = (matchesSearch && matchesFilter) ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        filterSelect.addEventListener('change', filterTable);

        document.querySelectorAll('.done-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                document.getElementById('payment_product_id').value = id;

                const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
                modal.show();
            });
        });

        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const id = document.getElementById('payment_product_id').value;
            const date = document.getElementById('payment_date').value;

            const formData = new FormData();
            formData.append('payment_status', 'done');
            formData.append('payment_date', date);

            fetch('/license_aplikasi/public/index.php?action=update&id=' + id, {
                    method: 'POST',
                    body: formData,
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert("Payment Success!");
                    } else {
                        alert("Payment Failed: " + data.message);
                    }
                    location.reload();
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan!');
                });
        });

        document.querySelectorAll('.view-foto-btn').forEach(button => {
            button.addEventListener('click', function() {
                const imgSrc = this.getAttribute('data-img');
                const imgElement = document.getElementById('imgPreview');

                imgElement.src = imgSrc;

                const photoModal = new bootstrap.Modal(document.getElementById('photoModal'));
                photoModal.show();
            });
        });

        let currentPage = 1;
        let rowsPerPage = 25;
        const tableBody = document.querySelector('table tbody');
        const originalRows = Array.from(tableBody.querySelectorAll('tr'));
        const rowsPerPageSelect = document.getElementById('rowsPerPage');
        const paginationWrapper = document.getElementById('paginationWrapper');
        const tableInfo = document.getElementById('tableInfo');

        function updateTable() {
            const searchText = document.getElementById('searchProduct').value.toLowerCase();
            const filterValue = document.getElementById('filterExpired').value;
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            let filteredRows = originalRows.filter(row => {
                if (row.cells.length < 2) return false;

                const textContent = row.innerText.toLowerCase();
                const orderDateStr = row.cells[3].innerText;
                const expiredDate = new Date(orderDateStr);

                let matchesSearch = textContent.includes(searchText);
                let matchesFilter = true;

                if (filterValue !== "") {
                    const diffTime = expiredDate - today;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    if (filterValue === 'week' && (diffDays < 0 || diffDays > 7)) matchesFilter = false;
                    if (filterValue === 'month' && (diffDays < 0 || diffDays > 30)) matchesFilter = false;
                }
                return matchesSearch && matchesFilter;
            });

            const totalRows = filteredRows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);

            if (currentPage > totalPages) currentPage = 1;
            if (currentPage < 1) currentPage = 1;

            const start = (currentPage - 1) * rowsPerPage;
            const end = start + parseInt(rowsPerPage);
            const paginatedRows = filteredRows.slice(start, end);

            tableBody.innerHTML = '';
            if (paginatedRows.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="9" class="text-center py-4">No matching records found</td></tr>';
            } else {
                paginatedRows.forEach(row => tableBody.appendChild(row));
            }


            renderPagination(totalPages);
            tableInfo.innerText = `Showing ${totalRows === 0 ? 0 : start + 1} to ${Math.min(end, totalRows)} of ${totalRows} entries`;
        }

        function renderPagination(totalPages) {
            paginationWrapper.innerHTML = '';

            const prevLi = document.createElement('li');
            prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
            prevLi.innerHTML = `<a class="page-link" href="javascript:void(0)">Previous</a>`;
            prevLi.onclick = () => {
                if (currentPage > 1) {
                    currentPage--;
                    updateTable();
                }
            };
            paginationWrapper.appendChild(prevLi);

            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                    const li = document.createElement('li');
                    li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                    li.innerHTML = `<a class="page-link" href="javascript:void(0)">${i}</a>`;
                    li.onclick = () => {
                        currentPage = i;
                        updateTable();
                    };
                    paginationWrapper.appendChild(li);
                } else if (i === currentPage - 2 || i === currentPage + 2) {
                    const li = document.createElement('li');
                    li.className = `page-item disabled`;
                    li.innerHTML = `<a class="page-link" href="#">...</a>`;
                    paginationWrapper.appendChild(li);
                }
            }


            const nextLi = document.createElement('li');
            nextLi.className = `page-item ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''}`;
            nextLi.innerHTML = `<a class="page-link" href="javascript:void(0)">Next</a>`;
            nextLi.onclick = () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    updateTable();
                }
            };
            paginationWrapper.appendChild(nextLi);
        }

        rowsPerPageSelect.addEventListener('change', function() {
            rowsPerPage = parseInt(this.value);
            currentPage = 1;
            updateTable();
        });

        document.getElementById('searchProduct').addEventListener('input', () => {
            currentPage = 1;
            updateTable();
        });

        document.getElementById('filterExpired').addEventListener('change', () => {
            currentPage = 1;
            updateTable();
        });


        document.addEventListener('DOMContentLoaded', updateTable);

        (function() {
            window.onpageshow = function(event) {
                if (event.persisted) {
                    window.location.reload();
                }
            };
        });
    </script>
</body>

</html>