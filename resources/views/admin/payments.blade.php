@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('styles')

<style>
    :root {
        --primary-gold: #ecac57;
        --primary-brown: #944e25;
        --light-cream: #f3efec;
        --deep-brown: #6b3419;
        --soft-gold: #f4d084;
        --text-primary: #2c2c2c;
        --text-secondary: #666666;
        --bg-section: #f8f8f8;
        --success-green: #4a7c59;
        --info-blue: #5b7c8a;
        --alert-orange: #d97435;
    }

    .main-content {
        padding: 2rem;
        min-height: 100vh;
        background-color: var(--bg-section);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-brown), var(--deep-brown));
        color: white;
        padding: 2rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(148, 78, 37, 0.2);
    }

    .stats-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-left: 4px solid var(--primary-gold);
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .stats-number {
        font-size: 2rem;
        font-weight: bold;
        color: var(--primary-brown);
    }

    .stats-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .filter-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .table-card {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .table-header {
        background: var(--light-cream);
        padding: 1.5rem;
        border-bottom: 2px solid var(--primary-gold);
    }

    .table thead th {
        background-color: var(--primary-gold);
        color: var(--primary-brown);
        border: none;
        font-weight: 600;
        padding: 1rem;
    }

    .table tbody tr {
        transition: background-color 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: var(--light-cream);
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-success {
        background-color: var(--success-green);
        color: white;
    }

    .status-pending {
        background-color: var(--alert-orange);
        color: white;
    }

    .status-failed {
        background-color: #dc3545;
        color: white;
    }

    .btn-primary {
        background-color: var(--primary-gold);
        border-color: var(--primary-gold);
        color: var(--primary-brown);
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: var(--alert-orange);
        border-color: var(--alert-orange);
        color: white;
    }

    .btn-outline-primary {
        border-color: var(--primary-brown);
        color: var(--primary-brown);
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-brown);
        border-color: var(--primary-brown);
    }

    .form-control:focus {
        border-color: var(--primary-gold);
        box-shadow: 0 0 0 0.2rem rgba(236, 172, 87, 0.25);
    }

    .form-select:focus {
        border-color: var(--primary-gold);
        box-shadow: 0 0 0 0.2rem rgba(236, 172, 87, 0.25);
    }

    .pagination .page-link {
        color: var(--primary-brown);
        border-color: var(--primary-gold);
    }

    .pagination .page-link:hover {
        background-color: var(--primary-gold);
        color: var(--primary-brown);
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-brown);
        border-color: var(--primary-brown);
    }

    .action-btn {
        padding: 0.4rem 0.8rem;
        margin: 0 0.2rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-view {
        background-color: var(--info-blue);
        color: white;
    }

    .btn-view:hover {
        background-color: #4a6b77;
        transform: scale(1.05);
    }

    .btn-approve {
        background-color: var(--success-green);
        color: white;
    }

    .btn-approve:hover {
        background-color: #3a6347;
        transform: scale(1.05);
    }

    .export-section {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .chart-container {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2"><i class="fas fa-chart-bar me-3"></i>Rekap Pembayaran</h1>
                <p class="mb-0 opacity-75">Kelola dan pantau semua transaksi pembayaran</p>
            </div>
            <div class="text-end">
                <div class="text-white opacity-75">Update Terakhir</div>
                <div class="h5 mb-0" id="lastUpdate">31 Agustus 2025, 14:30</div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stats-number">Rp 125.5M</div>
                        <div class="stats-label">Total Pendapatan</div>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-arrow-up fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stats-number">1,247</div>
                        <div class="stats-label">Total Transaksi</div>
                    </div>
                    <div style="color: var(--info-blue)">
                        <i class="fas fa-credit-card fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stats-number">23</div>
                        <div class="stats-label">Pending Review</div>
                    </div>
                    <div style="color: var(--alert-orange)">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="stats-number">98.5%</div>
                        <div class="stats-label">Success Rate</div>
                    </div>
                    <div style="color: var(--success-green)">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Section -->
    <div class="export-section">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h5 style="color: var(--primary-brown); margin-bottom: 0.5rem;">
                    <i class="fas fa-download me-2"></i>Export Data
                </h5>
                <p class="mb-0" style="color: var(--text-secondary);">Download laporan pembayaran dalam berbagai format</p>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-outline-primary me-2" onclick="exportData('excel')">
                    <i class="fas fa-file-excel me-1"></i>Excel
                </button>
                <button class="btn btn-outline-primary me-2" onclick="exportData('pdf')">
                    <i class="fas fa-file-pdf me-1"></i>PDF
                </button>
                <button class="btn btn-primary" onclick="exportData('csv')">
                    <i class="fas fa-file-csv me-1"></i>CSV
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card">
        <h5 style="color: var(--primary-brown); margin-bottom: 1.5rem;">
            <i class="fas fa-filter me-2"></i>Filter & Pencarian
        </h5>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="startDate" value="2025-08-01">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" id="endDate" value="2025-08-31">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Status Pembayaran</label>
                <select class="form-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="success">Berhasil</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Gagal</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Metode Pembayaran</label>
                <select class="form-select" id="methodFilter">
                    <option value="">Semua Metode</option>
                    <option value="bank_transfer">Transfer Bank</option>
                    <option value="e_wallet">E-Wallet</option>
                    <option value="credit_card">Kartu Kredit</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Cari Transaksi</label>
                <input type="text" class="form-control" id="searchInput" placeholder="Cari berdasarkan ID, nama, atau email...">
            </div>
            <div class="col-md-6 mb-3 d-flex align-items-end">
                <button class="btn btn-primary me-2" onclick="applyFilters()">
                    <i class="fas fa-search me-1"></i>Terapkan Filter
                </button>
                <button class="btn btn-outline-secondary" onclick="resetFilters()">
                    <i class="fas fa-refresh me-1"></i>Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Payment Table -->
    <div class="table-card">
        <div class="table-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 style="color: var(--primary-brown); margin: 0;">
                    <i class="fas fa-table me-2"></i>Daftar Transaksi Pembayaran
                </h5>
                <div class="d-flex align-items-center">
                    <span class="me-3" style="color: var(--text-secondary);">
                        Menampilkan <span id="showingCount">10</span> dari <span id="totalCount">1,247</span> transaksi
                    </span>
                    <select class="form-select form-select-sm" id="perPage" style="width: auto;" onchange="changePerPage()">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="form-check-input" id="selectAll" onchange="toggleSelectAll()">
                        </th>
                        <th>ID Transaksi</th>
                        <th>Tanggal</th>
                        <th>Nama Siswa</th>
                        <th>Kursus/Bootcamp</th>
                        <th>Metode Pembayaran</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="paymentTableBody">
                    <!-- Data akan dimuat di sini -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-3 border-top">
            <nav aria-label="Pagination">
                <ul class="pagination justify-content-center mb-0" id="pagination">
                    <!-- Pagination akan dimuat di sini -->
                </ul>
            </nav>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <span class="me-3" style="color: var(--text-secondary);">
                    <span id="selectedCount">0</span> item dipilih
                </span>
                <button class="btn btn-success me-2" id="bulkApprove" onclick="bulkAction('approve')" disabled>
                    <i class="fas fa-check me-1"></i>Setujui Terpilih
                </button>
                <button class="btn btn-danger" id="bulkReject" onclick="bulkAction('reject')" disabled>
                    <i class="fas fa-times me-1"></i>Tolak Terpilih
                </button>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" onclick="refreshData()">
                <i class="fas fa-sync-alt me-1"></i>Refresh Data
            </button>
        </div>
    </div>
</div>

<!-- Modal Detail Pembayaran -->
<div class="modal fade" id="paymentDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: var(--light-cream);">
                <h5 class="modal-title" style="color: var(--primary-brown);">
                    <i class="fas fa-receipt me-2"></i>Detail Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="paymentDetailContent">
                <!-- Detail akan dimuat di sini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="printReceipt()">
                    <i class="fas fa-print me-1"></i>Cetak Bukti
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    // Sample payment data
    let paymentData = [
        {
            id: 'PAY-2025-001247',
            date: '2025-08-31',
            time: '14:25',
            studentName: 'Ahmad Rizki',
            email: 'ahmad.rizki@email.com',
            course: 'Full Stack Web Development',
            courseType: 'Bootcamp',
            method: 'Transfer Bank',
            amount: 2500000,
            status: 'success',
            paymentProof: 'proof_001247.jpg'
        },
        {
            id: 'PAY-2025-001246',
            date: '2025-08-31',
            time: '13:45',
            studentName: 'Siti Nurhaliza',
            email: 'siti.nur@email.com',
            course: 'UI/UX Design Mastery',
            courseType: 'E-Learning',
            method: 'E-Wallet (OVO)',
            amount: 899000,
            status: 'pending',
            paymentProof: 'proof_001246.jpg'
        },
        {
            id: 'PAY-2025-001245',
            date: '2025-08-31',
            time: '12:30',
            studentName: 'Budi Santoso',
            email: 'budi.santoso@email.com',
            course: 'Data Science Bootcamp',
            courseType: 'Bootcamp',
            method: 'Kartu Kredit',
            amount: 3200000,
            status: 'success',
            paymentProof: 'proof_001245.jpg'
        },
        {
            id: 'PAY-2025-001244',
            date: '2025-08-30',
            time: '16:20',
            studentName: 'Maya Sari',
            email: 'maya.sari@email.com',
            course: 'Mobile App Development',
            courseType: 'E-Learning',
            method: 'Transfer Bank',
            amount: 1200000,
            status: 'failed',
            paymentProof: 'proof_001244.jpg'
        },
        {
            id: 'PAY-2025-001243',
            date: '2025-08-30',
            time: '15:10',
            studentName: 'Andi Pratama',
            email: 'andi.pratama@email.com',
            course: 'Digital Marketing Pro',
            courseType: 'Bootcamp',
            method: 'E-Wallet (DANA)',
            amount: 1800000,
            status: 'success',
            paymentProof: 'proof_001243.jpg'
        }
    ];

    let currentPage = 1;
    let itemsPerPage = 10;
    let filteredData = [...paymentData];
    let selectedItems = new Set();

    // Format currency
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    }

    // Format date
    function formatDate(dateStr) {
        const date = new Date(dateStr);
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }

    // Get status badge HTML
    function getStatusBadge(status) {
        const statusMap = {
            'success': { class: 'status-success', text: 'Berhasil', icon: 'fas fa-check' },
            'pending': { class: 'status-pending', text: 'Pending', icon: 'fas fa-clock' },
            'failed': { class: 'status-failed', text: 'Gagal', icon: 'fas fa-times' }
        };
        const s = statusMap[status] || statusMap['pending'];
        return `<span class="status-badge ${s.class}"><i class="${s.icon} me-1"></i>${s.text}</span>`;
    }

    // Render table
    function renderTable() {
        const tbody = document.getElementById('paymentTableBody');
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const pageData = filteredData.slice(startIndex, endIndex);

        tbody.innerHTML = pageData.map(payment => `
            <tr>
                <td>
                    <input type="checkbox" class="form-check-input row-checkbox" 
                           value="${payment.id}" onchange="updateSelectedCount()">
                </td>
                <td><span class="fw-bold" style="color: var(--primary-brown)">${payment.id}</span></td>
                <td>
                    <div>${formatDate(payment.date)}</div>
                    <small style="color: var(--text-secondary)">${payment.time}</small>
                </td>
                <td>
                    <div class="fw-semibold">${payment.studentName}</div>
                    <small style="color: var(--text-secondary)">${payment.email}</small>
                </td>
                <td>
                    <div>${payment.course}</div>
                    <small class="badge" style="background-color: var(--soft-gold); color: var(--primary-brown)">
                        ${payment.courseType}
                    </small>
                </td>
                <td>${payment.method}</td>
                <td class="fw-bold" style="color: var(--success-green)">${formatCurrency(payment.amount)}</td>
                <td>${getStatusBadge(payment.status)}</td>
                <td>
                    <button class="action-btn btn-view" onclick="viewPaymentDetail('${payment.id}')" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                    </button>
                    ${payment.status === 'pending' ? `
                        <button class="action-btn btn-approve" onclick="approvePayment('${payment.id}')" title="Setujui">
                            <i class="fas fa-check"></i>
                        </button>
                    ` : ''}
                </td>
            </tr>
        `).join('');

        // Update pagination
        renderPagination();
        
        // Update showing count
        document.getElementById('showingCount').textContent = pageData.length;
        document.getElementById('totalCount').textContent = filteredData.length;
    }

    // Render pagination
    function renderPagination() {
        const totalPages = Math.ceil(filteredData.length / itemsPerPage);
        const pagination = document.getElementById('pagination');
        
        let paginationHTML = '';
        
        // Previous button
        paginationHTML += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="goToPage(${currentPage - 1})">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
        `;
        
        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                paginationHTML += `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="goToPage(${i})">${i}</a>
                    </li>
                `;
            } else if (i === currentPage - 3 || i === currentPage + 3) {
                paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
        }
        
        // Next button
        paginationHTML += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="goToPage(${currentPage + 1})">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        `;
        
        pagination.innerHTML = paginationHTML;
    }

    // Go to page
    function goToPage(page) {
        const totalPages = Math.ceil(filteredData.length / itemsPerPage);
        if (page >= 1 && page <= totalPages) {
            currentPage = page;
            renderTable();
        }
    }

    // Change items per page
    function changePerPage() {
        itemsPerPage = parseInt(document.getElementById('perPage').value);
        currentPage = 1;
        renderTable();
    }

    // Apply filters
    function applyFilters() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        const status = document.getElementById('statusFilter').value;
        const method = document.getElementById('methodFilter').value;
        const search = document.getElementById('searchInput').value.toLowerCase();

        filteredData = paymentData.filter(payment => {
            const dateMatch = (!startDate || payment.date >= startDate) && 
                            (!endDate || payment.date <= endDate);
            const statusMatch = !status || payment.status === status;
            const methodMatch = !method || payment.method.toLowerCase().includes(method.replace('_', ' '));
            const searchMatch = !search || 
                              payment.id.toLowerCase().includes(search) ||
                              payment.studentName.toLowerCase().includes(search) ||
                              payment.email.toLowerCase().includes(search) ||
                              payment.course.toLowerCase().includes(search);

            return dateMatch && statusMatch && methodMatch && searchMatch;
        });

        currentPage = 1;
        renderTable();
    }

    // Reset filters
    function resetFilters() {
        document.getElementById('startDate').value = '2025-08-01';
        document.getElementById('endDate').value = '2025-08-31';
        document.getElementById('statusFilter').value = '';
        document.getElementById('methodFilter').value = '';
        document.getElementById('searchInput').value = '';
        
        filteredData = [...paymentData];
        currentPage = 1;
        renderTable();
    }

    // Toggle select all
    function toggleSelectAll() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.row-checkbox');
        
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
            if (selectAll.checked) {
                selectedItems.add(checkbox.value);
            } else {
                selectedItems.delete(checkbox.value);
            }
        });
        
        updateSelectedCount();
    }

    // Update selected count
    function updateSelectedCount() {
        const checkboxes = document.querySelectorAll('.row-checkbox:checked');
        selectedItems.clear();
        checkboxes.forEach(cb => selectedItems.add(cb.value));
        
        const count = selectedItems.size;
        document.getElementById('selectedCount').textContent = count;
        
        const bulkButtons = document.querySelectorAll('#bulkApprove, #bulkReject');
        bulkButtons.forEach(btn => btn.disabled = count === 0);
    }

        // View payment detail
    function viewPaymentDetail(paymentId) {
        const payment = paymentData.find(p => p.id === paymentId);
        
        if (payment) {
            const modalContent = document.getElementById('paymentDetailContent');
            modalContent.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6 style="color: var(--primary-brown); margin-bottom: 1rem;">Informasi Transaksi</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold" style="color: var(--text-secondary);">ID Transaksi:</td>
                                <td>${payment.id}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="color: var(--text-secondary);">Tanggal:</td>
                                <td>${formatDate(payment.date)} ${payment.time}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="color: var(--text-secondary);">Status:</td>
                                <td>${getStatusBadge(payment.status)}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="color: var(--text-secondary);">Jumlah:</td>
                                <td class="fw-bold" style="color: var(--success-green)">${formatCurrency(payment.amount)}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 style="color: var(--primary-brown); margin-bottom: 1rem;">Informasi Peserta</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold" style="color: var(--text-secondary);">Nama:</td>
                                <td>${payment.studentName}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="color: var(--text-secondary);">Email:</td>
                                <td>${payment.email}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="color: var(--text-secondary);">Kursus:</td>
                                <td>${payment.course} <span class="badge" style="background-color: var(--soft-gold); color: var(--primary-brown)">${payment.courseType}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="color: var(--text-secondary);">Metode:</td>
                                <td>${payment.method}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="mt-4">
                    <h6 style="color: var(--primary-brown); margin-bottom: 1rem;">Bukti Pembayaran</h6>
                    <img src="/uploads/${payment.paymentProof}" alt="Bukti Pembayaran" class="img-fluid rounded border">
                </div>
            `;

            // Tampilkan modal
            const modal = new bootstrap.Modal(document.getElementById('paymentDetailModal'));
            modal.show();
        }
    }

    // Approve payment
    function approvePayment(paymentId) {
        const payment = paymentData.find(p => p.id === paymentId);
        if (payment && payment.status === 'pending') {
            payment.status = 'success';
            renderTable();
            alert(`Pembayaran ${payment.id} telah disetujui ✅`);
        }
    }

    // Bulk action
    function bulkAction(action) {
        selectedItems.forEach(id => {
            const payment = paymentData.find(p => p.id === id);
            if (payment && payment.status === 'pending') {
                payment.status = (action === 'approve') ? 'success' : 'failed';
            }
        });
        renderTable();
        selectedItems.clear();
        updateSelectedCount();
        alert(`Aksi bulk "${action}" berhasil diterapkan ✅`);
    }

    // Refresh data
    function refreshData() {
        alert("Data berhasil diperbarui 🔄");
        renderTable();
    }

    // Export data
    function exportData(format) {
        alert(`Export data ke format ${format.toUpperCase()} berhasil ✅`);
    }

    // Print receipt
    function printReceipt() {
        const modalContent = document.getElementById('paymentDetailContent').innerHTML;
        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Cetak Bukti Pembayaran</title>
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
                </head>
                <body>
                    <div class="container my-4">
                        ${modalContent}
                    </div>
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    }

    // Inisialisasi tabel
    renderTable();
</script>
