@extends('layouts.admin')

@section('title', 'Data Tutor')

@section('styles')
<style>
.table-wrapper {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.table-header h2 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
}
.search-box {
    position: relative;
}
.search-box input {
    padding: 10px 35px 10px 15px;
    border-radius: 8px;
    border: 1px solid #ddd;
}
.search-box::after {
    content: "🔍";
    position: absolute;
    right: 10px;
    top: 8px;
    font-size: 18px;
    color: #888;
}

.table-custom {
    width: 100%;
    border-collapse: collapse;
}
.table-custom thead {
    background: #f9fafb;
}
.table-custom th {
    text-align: left;
    font-weight: 600;
    padding: 12px;
    font-size: 14px;
    color: #555;
}
.table-custom td {
    padding: 16px 12px;
    vertical-align: middle;
    border-top: 1px solid #eee;
}

.tutor-info {
    display: flex;
    align-items: center;
    gap: 12px;
}
.tutor-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
}
.tutor-name {
    font-weight: 600;
    font-size: 16px;
}
.tutor-phone {
    font-size: 13px;
    color: #666;
}

.badge {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
}
.badge-status {
    background: #e0f0ff;
    color: #007bff;
}
.badge-premium {
    background: #ffe999;
    color: #9c7400;
}
</style>
@endsection

@section('content')
<div class="table-wrapper">
    <div class="table-header">
        <h2>Daftar Tutor</h2>
        <div class="search-box">
            <input type="text" placeholder="Cari tutor...">
        </div>
    </div>

    <table class="table-custom">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tutor</th>
                <th>Email</th>
                <th>Tanggal Gabung</th>
                <th>Status</th>
                <th>Kelas</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#001</td>
                <td>
                    <div class="tutor-info">
                        <img src="{{ asset('assets/img/tutor1.jpg') }}" alt="Tutor" class="tutor-avatar">
                        <div>
                            <div class="tutor-name">Anne Belle</div>
                            <div class="tutor-phone">+62 812-3456-7890</div>
                        </div>
                    </div>
                </td>
                <td>anne@example.com</td>
                <td>15 Jan 2025</td>
                <td><span class="badge badge-status">Aktif</span></td>
                <td>5 Kelas</td>
            </tr>
            <tr>
                <td>#002</td>
                <td>
                    <div class="tutor-info">
                        <img src="{{ asset('assets/img/tutor2.jpg') }}" alt="Tutor" class="tutor-avatar">
                        <div>
                            <div class="tutor-name">Rasiva</div>
                            <div class="tutor-phone">+62 813-9876-5432</div>
                        </div>
                    </div>
                </td>
                <td>rasiva@example.com</td>
                <td>10 Feb 2025</td>
                <td><span class="badge badge-status">Aktif</span></td>
                <td>3 Kelas</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
