@extends('layouts.admin')

@section('title', 'Certificates Management')

@section('styles')
<style>
:root {
    --primary-gold: #ecac57;
    --primary-brown: #944e25;
    --light-cream: #f3efec;
    --deep-brown: #6b3419;
    --soft-gold: #f4d084;
    --success-green: #4a7c59;
    --text-primary: #2c2c2c;
    --text-secondary: #666666;
}

.page-header {
    background: linear-gradient(135deg, var(--primary-brown) 0%, var(--deep-brown) 100%);
    color: white;
    padding: 2rem;
    margin-bottom: 2rem;
    border-radius: 15px;
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="50" height="50" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.page-header h4 {
    margin: 0;
    font-weight: 600;
    position: relative;
    z-index: 1;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid rgba(148, 78, 37, 0.1);
    box-shadow: 0 4px 15px rgba(148, 78, 37, 0.08);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(148, 78, 37, 0.15);
}

.stat-card.primary {
    background: linear-gradient(135deg, var(--primary-brown) 0%, var(--deep-brown) 100%);
    color: white;
}

.stat-card.gold {
    background: linear-gradient(135deg, var(--primary-gold) 0%, var(--soft-gold) 100%);
    color: white;
}

.stat-card.success {
    background: linear-gradient(135deg, var(--success-green) 0%, #3d6b4a 100%);
    color: white;
}

.stat-card.info {
    background: linear-gradient(135deg, #5b7c8a 0%, #4a6b78 100%);
    color: white;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
    font-weight: 500;
}

.certificate-table {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(148, 78, 37, 0.08);
}

.table thead th {
    background: var(--light-cream);
    color: var(--primary-brown);
    font-weight: 600;
    border: none;
    padding: 1rem;
}

.table tbody td {
    padding: 1rem;
    border-color: rgba(148, 78, 37, 0.1);
    vertical-align: middle;
}

.table tbody tr:hover {
    background: rgba(148, 78, 37, 0.02);
}

.badge.bg-primary {
    background: var(--primary-brown) !important;
}

.badge.bg-info {
    background: var(--primary-gold) !important;
}

.badge.bg-success {
    background: var(--success-green) !important;
}

.btn-outline-primary {
    border-color: var(--primary-brown);
    color: var(--primary-brown);
}

.btn-outline-primary:hover {
    background: var(--primary-brown);
    border-color: var(--primary-brown);
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-secondary);
}

.empty-state i {
    font-size: 4rem;
    color: var(--primary-gold);
    margin-bottom: 1.5rem;
    opacity: 0.7;
}

.empty-state h5 {
    color: var(--primary-brown);
    font-weight: 600;
    margin-bottom: 1rem;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4><i class="las la-certificate"></i> Certificates Management</h4>
                <p class="mb-0 opacity-75">Monitor and manage all issued certificates</p>
            </div>
            <div class="text-end">
                <div class="badge bg-light text-dark fs-6">{{ $certificates->total() }} Total Certificates</div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-number">{{ $taskCertificates }}</div>
            <div class="stat-label">Task Certificates</div>
        </div>
        <div class="stat-card gold">
            <div class="stat-number">{{ $classCertificates }}</div>
            <div class="stat-label">Class Certificates</div>
        </div>
        <div class="stat-card success">
            <div class="stat-number">{{ $bootcampCertificates }}</div>
            <div class="stat-label">Bootcamp Certificates</div>
        </div>
        <div class="stat-card info">
            <div class="stat-number">{{ $certificates->where('issued_at', '>=', now()->startOfMonth())->count() }}</div>
            <div class="stat-label">This Month</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="certificate-table">
                <div class="card-header bg-transparent border-0 p-3">
                    <h5 class="mb-0 text-primary-brown">All Certificates</h5>
                </div>
                <div class="card-body p-0">
                    @if($certificates->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Certificate ID</th>
                                        <th>Student</th>
                                        <th>Bootcamp</th>
                                        <th>Issued Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($certificates as $certificate)
                                        <tr>
                                            <td>
                                                <code class="text-primary">{{ $certificate->certificate_id }}</code>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-primary-brown text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; background: var(--primary-brown);">
                                                        {{ substr($certificate->user->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <strong>{{ $certificate->user->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $certificate->user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>{{ $certificate->bootcamp->title ?? 'N/A' }}</strong>
                                                @if($certificate->bootcamp && $certificate->bootcamp->tutor)
                                                    <br><small class="text-muted">by {{ $certificate->bootcamp->tutor->name }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $certificate->issued_at->format('M d, Y') }}</strong>
                                                <br><small class="text-muted">{{ $certificate->issued_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <span class="badge 
                                                    @if($certificate->status === 'active') bg-success
                                                    @else bg-danger
                                                    @endif">
                                                    {{ ucfirst($certificate->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('certificate.verify', $certificate->certificate_id) }}" 
                                                       class="btn btn-sm btn-outline-primary" target="_blank">
                                                        <i class="las la-external-link-alt"></i> Verify
                                                    </a>
                                                    @if($certificate->pdf_url)
                                                        <a href="{{ $certificate->pdf_url }}" 
                                                           class="btn btn-sm btn-outline-secondary" target="_blank">
                                                            <i class="las la-download"></i> PDF
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $certificates->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="las la-certificate"></i>
                            <h5>No Certificates Issued</h5>
                            <p>Certificates will appear here when students complete bootcamp programs.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection