@extends('layouts.admin')

@section('title', 'Payment Management')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
<style>
/* Override conflicting CSS from admin.css */
.main-content {
    margin-left: 0 !important;
}

header {
    position: relative !important;
    left: auto !important;
    width: 100% !important;
    top: auto !important;
    z-index: auto !important;
}

.page-container { padding: 0; margin: 0; }
.page-header { background: white; padding: 2rem; border-bottom: 1px solid #e5e7eb; margin-bottom: 2rem; }
.page-header h1 { font-size: 1.875rem; font-weight: 700; color: var(--text-primary); margin: 0; }
.page-header p { color: var(--text-secondary); margin: 0.5rem 0 0 0; }
.content-card { background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); border: 1px solid #e5e7eb; margin: 0 2rem; }
.card-header { padding: 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%); }
.card-header h2 { margin: 0; font-size: 1.25rem; font-weight: 600; color: var(--text-primary); }
.btn-primary { background: var(--info-blue); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; text-decoration: none; }
.btn-primary:hover { background: #5b7c8a; transform: translateY(-1px); color: white; text-decoration: none; }
.card-body { padding: 3rem 2rem; text-align: center; }
.empty-state { color: #6b7280; }
.empty-state i { font-size: 4rem; display: block; margin-bottom: 1.5rem; opacity: 0.6; color: var(--info-blue); }
.empty-state h3 { font-size: 1.5rem; font-weight: 600; margin: 0 0 1rem 0; color: var(--text-primary); }
.empty-state p { font-size: 1rem; line-height: 1.6; margin: 0; max-width: 500px; margin-left: auto; margin-right: auto; }
.feature-list { background: #f8fafc; border-radius: 8px; padding: 1.5rem; margin-top: 2rem; text-align: left; }
.feature-list h4 { margin: 0 0 1rem 0; color: var(--text-primary); font-weight: 600; }
.feature-list ul { margin: 0; padding-left: 1.5rem; color: var(--text-secondary); }
.feature-list li { margin-bottom: 0.5rem; }
</style>
@endsection

@section('content')
<input type="checkbox" id="nav-toggle">

<div class="page-container">
    <div class="page-header">
        <h1>Payment Management</h1>
        <p>Monitor payments, transactions, refunds, and financial reports.</p>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h2>Payments & Transactions</h2>
            <a href="#" class="btn-primary" onclick="alert('Generate report feature coming soon!')">
                <i class="las la-file-download"></i>
                Generate Report
            </a>
        </div>
        <div class="card-body">
            <div class="empty-state">
                <i class="las la-credit-card"></i>
                <h3>Payment Management System</h3>
                <p>Comprehensive payment management system to handle all financial transactions and reporting efficiently.</p>
                
                <div class="feature-list">
                    <h4>Upcoming Features:</h4>
                    <ul>
                        <li>Transaction monitoring and tracking</li>
                        <li>Payment gateway integration</li>
                        <li>Refund and dispute management</li>
                        <li>Financial reporting and analytics</li>
                        <li>Invoice generation and management</li>
                        <li>Revenue tracking and forecasting</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection