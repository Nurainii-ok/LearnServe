@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('styles')
<style>
.dashboard-content {
    padding: 2rem;
    margin: 0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
}

.stat-card.featured {
    background: linear-gradient(135deg, var(--primary-gold) 0%, #e59f4f 100%);
    color: white;
    border: none;
}

.stat-info h3 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    line-height: 1;
}

.stat-info p {
    margin: 0.5rem 0 0 0;
    font-size: 0.875rem;
    opacity: 0.8;
    font-weight: 500;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    background: var(--light-cream);
    color: var(--primary-brown);
}

.stat-card.featured .stat-icon {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.dashboard-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fafafa;
}

.card-header h3 {
    margin: 0;
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
}

.card-body {
    padding: 0;
}

.btn-secondary {
    background: var(--primary-brown);
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-secondary:hover {
    background: var(--deep-brown);
    color: white;
    text-decoration: none;
}

.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead th {
    background: #f8fafc;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.875rem;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
}

.data-table tbody td {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}

.data-table tbody tr:hover {
    background: #f9fafb;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--primary-gold);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    background: #dcfce7;
    color: #166534;
}

.tutor-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #f3f4f6;
    transition: background 0.2s ease;
}

.tutor-item:hover {
    background: #f9fafb;
}

.tutor-item:last-child {
    border-bottom: none;
}

.tutor-contact {
    display: flex;
    gap: 0.5rem;
}

.contact-btn {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f3f4f6;
    color: #6b7280;
    text-decoration: none;
    transition: all 0.2s ease;
    font-size: 1rem;
}

.contact-btn:hover {
    background: var(--primary-brown);
    color: white;
}

.quick-actions {
    margin-top: 2rem;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    padding: 1.5rem;
}

.action-btn {
    background: var(--primary-brown);
    color: white;
    padding: 1rem;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
    transition: all 0.3s ease;
    text-decoration: none;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    color: white;
    text-decoration: none;
}

.action-btn.gold { background: var(--primary-gold); }
.action-btn.green { background: var(--success-green); }
.action-btn.blue { background: var(--info-blue); }

.empty-state {
    text-align: center;
    padding: 3rem 1.5rem;
    color: #6b7280;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

@media (max-width: 1024px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
}

@media (max-width: 640px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .actions-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card featured">
            <div class="stat-info">
                <h3>{{ $totalMembers }}</h3>
                <p>Total Members</p>
            </div>
            <div class="stat-icon">
                <i class="las la-users"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $totalTutors }}</h3>
                <p>Total Tutors</p>
            </div>
            <div class="stat-icon">
                <i class="las la-chalkboard-teacher"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $totalClasses }}</h3>
                <p>Active Classes</p>
            </div>
            <div class="stat-icon">
                <i class="las la-graduation-cap"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $totalBootcamps }}</h3>
                <p>Active Bootcamps</p>
            </div>
            <div class="stat-icon">
                <i class="las la-rocket"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>Rp{{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <p>Monthly Revenue</p>
            </div>
            <div class="stat-icon">
                <i class="las la-chart-line"></i>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Grid -->
    <div class="dashboard-grid">
        <!-- Recent Members Table -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Recent Members</h3>
                <a href="{{ route('admin.members') }}" class="btn-secondary">
                    See all <i class="las la-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                @if($recentMembers->count() > 0)
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Email</th>
                                    <th>Joined Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentMembers as $member)
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                {{ strtoupper(substr($member->name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium">{{ $member->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $member->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="status-badge">Active</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="las la-users"></i>
                        <h4>No members found</h4>
                        <p>No members have registered yet.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Recent Tutors -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Recent Tutors</h3>
                <a href="{{ route('admin.tutors') }}" class="btn-secondary">
                    See all <i class="las la-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                @if($recentTutors->count() > 0)
                    @foreach($recentTutors as $tutor)
                    <div class="tutor-item">
                        <div class="user-info">
                            <div class="user-avatar" style="background: var(--primary-gold);">
                                {{ strtoupper(substr($tutor->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-medium">{{ $tutor->name }}</div>
                                <div class="text-sm text-gray-500">{{ $tutor->email }}</div>
                            </div>
                        </div>
                        <div class="tutor-contact">
                            <a href="#" class="contact-btn" title="Send Email">
                                <i class="las la-envelope"></i>
                            </a>
                            <a href="#" class="contact-btn" title="Call">
                                <i class="las la-phone"></i>
                            </a>
                            <a href="#" class="contact-btn" title="Message">
                                <i class="las la-comment"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="las la-chalkboard-teacher"></i>
                        <h4>No tutors found</h4>
                        <p>No tutors have registered yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Quick Actions</h3>
            </div>
            <div class="card-body">
                <div class="actions-grid">
                    <a href="{{ route('admin.members') }}" class="action-btn">
                        <i class="las la-user-plus"></i>
                        Manage Members
                    </a>
                    
                    <a href="{{ route('admin.classes') }}" class="action-btn gold">
                        <i class="las la-graduation-cap"></i>
                        Manage Classes
                    </a>
                    
                    <a href="{{ route('admin.payments') }}" class="action-btn green">
                        <i class="las la-credit-card"></i>
                        View Payments
                    </a>
                    
                    <a href="{{ route('admin.tasks') }}" class="action-btn blue">
                        <i class="las la-tasks"></i>
                        Manage Tasks
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Dashboard interactions
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth animations to cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Action button hover effects
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endsection