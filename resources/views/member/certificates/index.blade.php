@extends('layouts.member')

@section('title', 'My Certificates')

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

.certificate-card {
    border: 2px solid var(--primary-gold);
    border-radius: 15px;
    background: linear-gradient(135deg, #ffffff 0%, var(--light-cream) 100%);
    box-shadow: 0 8px 25px rgba(148, 78, 37, 0.1);
    transition: all 0.3s ease;
    overflow: hidden;
}

.certificate-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(148, 78, 37, 0.15);
    border-color: var(--soft-gold);
}

.certificate-card .card-header {
    background: linear-gradient(135deg, var(--primary-brown) 0%, var(--deep-brown) 100%);
    color: white;
    border: none;
    padding: 1.2rem 1.5rem;
    position: relative;
}

.certificate-card .card-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="50" height="50" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.certificate-card .card-header h6 {
    margin: 0;
    font-weight: 600;
    font-size: 1rem;
    position: relative;
    z-index: 1;
}

.certificate-card .card-body {
    padding: 1.5rem;
    background: white;
}

.certificate-card .card-title {
    color: var(--primary-brown);
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 0.8rem;
}

.certificate-card .card-text {
    color: var(--text-secondary);
    line-height: 1.5;
}

.certificate-card .badge {
    background: var(--primary-gold);
    color: white;
    font-weight: 500;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
}

.certificate-card .card-footer {
    background: var(--light-cream);
    border-top: 1px solid rgba(148, 78, 37, 0.1);
    padding: 1rem 1.5rem;
}

.certificate-card .btn-group .btn {
    border-radius: 8px;
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
}

.certificate-card .btn-outline-primary {
    border-color: var(--primary-brown);
    color: var(--primary-brown);
}

.certificate-card .btn-outline-primary:hover {
    background: var(--primary-brown);
    border-color: var(--primary-brown);
    color: white;
}

.certificate-card .btn-primary {
    background: var(--primary-gold);
    border-color: var(--primary-gold);
    color: white;
}

.certificate-card .btn-primary:hover {
    background: var(--soft-gold);
    border-color: var(--soft-gold);
    transform: translateY(-1px);
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

.page-header {
    background: linear-gradient(135deg, var(--primary-brown) 0%, var(--deep-brown) 100%);
    color: white;
    padding: 2rem 0;
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

.certificate-stats {
    background: var(--light-cream);
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border-left: 4px solid var(--primary-gold);
}

.certificate-stats .stat-item {
    text-align: center;
}

.certificate-stats .stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-brown);
}

.certificate-stats .stat-label {
    color: var(--text-secondary);
    font-size: 0.9rem;
    font-weight: 500;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4><i class="las la-certificate"></i> My Certificates</h4>
                    <p class="mb-0 opacity-75">Your earned certificates and achievements</p>
                </div>
                <div class="text-end">
                    <div class="badge bg-light text-dark fs-6">{{ $certificates->total() }} Certificates</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    @if($certificates->count() > 0)
                        <div class="row p-4">
                            @foreach($certificates as $certificate)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="certificate-card h-100">
                                        <div class="card-header">
                                            <h6>
                                                <i class="las la-certificate"></i>
                                                Bootcamp Certificate
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $certificate->bootcamp->title ?? 'Bootcamp Certificate' }}</h6>
                                            
                                            <div class="mb-3">
                                                <small class="text-muted d-block mb-1">
                                                    <i class="las la-id-card"></i> <strong>Certificate ID:</strong>
                                                </small>
                                                <code class="text-primary">{{ $certificate->certificate_id }}</code>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <small class="text-muted d-block mb-1">
                                                    <i class="las la-calendar"></i> <strong>Issued Date:</strong>
                                                </small>
                                                <span class="text-dark">{{ $certificate->issued_at->format('F d, Y') }}</span>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <small class="text-muted d-block mb-1">
                                                    <i class="las la-check-circle"></i> <strong>Status:</strong>
                                                </small>
                                                <span class="badge">{{ ucfirst($certificate->status) }}</span>
                                            </div>
                                            
                                            @if($certificate->bootcamp && $certificate->bootcamp->tutor)
                                                <div class="mb-2">
                                                    <small class="text-muted d-block mb-1">
                                                        <i class="las la-user-tie"></i> <strong>Instructor:</strong>
                                                    </small>
                                                    <span class="text-dark">{{ $certificate->bootcamp->tutor->name }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            <div class="btn-group w-100" role="group">
                                                <a href="{{ route('certificate.verify', $certificate->certificate_id) }}" 
                                                   class="btn btn-outline-primary btn-sm" target="_blank">
                                                    <i class="las la-external-link-alt"></i> Verify
                                                </a>
                                                @if($certificate->pdf_url)
                                                    <a href="{{ $certificate->pdf_url }}" 
                                                       class="btn btn-primary btn-sm" target="_blank">
                                                        <i class="las la-download"></i> Download PDF
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $certificates->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="las la-certificate"></i>
                            <h5>No Certificates Yet</h5>
                            <p>Complete bootcamp tasks and earn certificates to showcase your achievements!</p>
                            <a href="{{ route('member.bootcamp-tasks') }}" class="btn btn-outline-primary">
                                <i class="las la-tasks"></i> View Bootcamp Tasks
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection