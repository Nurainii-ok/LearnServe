@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('styles')

@endsection

@section('content')
<main>
    <div class="page-header">
        <h2>Data Member</h2>
        <div class="filter-controls">
            <select class="filter-select">
                <option>Semua Status</option>
                <option>Aktif</option>
                <option>Tidak Aktif</option>
                <option>Pending</option>
            </select>
            <select class="filter-select">
                <option>Semua Langganan</option>
                <option>Basic</option>
                <option>Premium</option>
                <option>Pro</option>
            </select>
            <button class="export-btn"><span class="las la-download"></span> Export</button>
        </div>
    </div>

    <div class="members-table">
        <div class="table-header">
            <h3>Daftar Member</h3>
            <div class="table-search">
                <span class="las la-search"></span>
                <input type="text" placeholder="Cari member...">
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Member</th>
                        <th>Email</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th>Langganan</th>
                        <th>Kelas Diikuti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#001</td>
                        <td>
                            <div class="member-profile">
                                <div class="member-avatar">AS</div>
                                <div class="member-info">
                                    <h4>Andi Saputra</h4>
                                    <p>+62 812-3456-7890</p>
                                </div>
                            </div>
                        </td>
                        <td>andi.saputra@email.com</td>
                        <td>15 Jan 2025</td>
                        <td><span class="status-badge status-active">Aktif</span></td>
                        <td><span class="subscription-badge sub-premium">Premium</span></td>
                        <td>3 Kelas</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-view"><span class="las la-eye"></span></button>
                                <button class="btn-action btn-edit"><span class="las la-edit"></span></button>
                                <button class="btn-action btn-delete"><span class="las la-trash"></span></button>
                            </div>
                        </td>
                    </tr>
                    {{-- Tambahkan data member lain di sini --}}
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <button><span class="las la-angle-left"></span> Sebelumnya</button>
            <button class="active">1</button>
            <button>2</button>
            <button>3</button>
            <div class="page-info">Menampilkan 1-10 dari 54 member</div>
            <button>Selanjutnya <span class="las la-angle-right"></span></button>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    // contoh script pencarian
    document.querySelector('.table-search input').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const memberName = row.querySelector('.member-info h4').textContent.toLowerCase();
            const email = row.cells[2].textContent.toLowerCase();
            row.style.display = (memberName.includes(searchTerm) || email.includes(searchTerm)) ? '' : 'none';
        });
    });
</script>
@endsection
