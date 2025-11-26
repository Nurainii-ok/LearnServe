@extends('layouts.member')

@section('title', 'E-Learning')

@section('styles')
<style>
:root {
    --primary-brown: #944e25;
    --primary-gold: #ecac57;
    --light-cream: #f3efec;
    --deep-brown: #6b3419;
    --soft-gold: #f4d084;
    --text-primary: #1a1a1a;
    --text-secondary: #666666;
}

* {
    box-sizing: border-box;
}

.container-xxl {
    padding-top: 100px;
    padding-bottom: 60px;
    max-width: 1400px;
    margin: 0 auto;
    padding-left: 20px;
    padding-right: 20px;
}

.page-header {
    background: linear-gradient(135deg, var(--primary-brown) 0%, var(--deep-brown) 100%);
    color: white;
    padding: 2.5rem 2rem;
    border-radius: 20px;
    margin-bottom: 2.5rem;
    box-shadow: 0 8px 30px rgba(148, 78, 37, 0.2);
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(236, 172, 87, 0.15) 0%, transparent 70%);
    border-radius: 50%;
}

.page-header h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
    letter-spacing: -0.02em;
}

.page-header p {
    margin: 0;
    opacity: 0.9;
    font-size: 1rem;
    position: relative;
    z-index: 1;
}

.table-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.05);
}

.table-wrapper {
    overflow-x: auto;
}

.elearning-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.elearning-table thead {
    background: linear-gradient(135deg, var(--primary-brown) 0%, var(--deep-brown) 100%);
    color: white;
}

.elearning-table thead th {
    padding: 1.25rem 1.5rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    white-space: nowrap;
    color: black !important;
}

.elearning-table thead th:first-child {
    border-radius: 20px 0 0 0;
}

.elearning-table thead th:last-child {
    border-radius: 0 20px 0 0;
}

.elearning-table tbody tr {
    border-bottom: 1px solid #f3f4f6;
    transition: background-color 0.2s ease;
}

.elearning-table tbody tr:hover {
    background-color: #fafafa;
}

.elearning-table tbody tr:last-child {
    border-bottom: none;
}

.elearning-table tbody td {
    padding: 1.25rem 1.5rem;
    vertical-align: middle;
    color: var(--text-primary);
}

.course-cell {
    display: flex;
    align-items: center;
    gap: 1rem;
    min-width: 320px;
}

.course-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--primary-gold), var(--soft-gold));
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
}

.course-icon::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.2) 0%, transparent 60%);
}

.course-icon i {
    font-size: 1.875rem;
    color: white;
    position: relative;
    z-index: 1;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
}

.course-info {
    flex: 1;
    min-width: 0;
}

.course-title {
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 0.375rem 0;
    font-size: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.course-description {
    font-size: 0.8125rem;
    color: var(--text-secondary);
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
}

.type-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.375rem 0.875rem;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 500;
    white-space: nowrap;
}

.type-class {
    background: rgba(59, 130, 246, 0.1);
    color: #2563eb;
}

.type-bootcamp {
    background: rgba(147, 51, 234, 0.1);
    color: #7c3aed;
}

.instructor-cell {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
    font-size: 0.875rem;
    white-space: nowrap;
}

.instructor-cell i {
    color: var(--primary-gold);
    font-size: 1.125rem;
}

.duration-cell {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
    font-size: 0.875rem;
    white-space: nowrap;
}

.duration-cell i {
    color: var(--primary-gold);
    font-size: 1.125rem;
}

.action-cell {
    text-align: center;
}

.btn-action {
    padding: 0.625rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    white-space: nowrap;
    border: none;
    cursor: pointer;
}

.btn-learning {
    background: linear-gradient(135deg, var(--primary-brown) 0%, var(--deep-brown) 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(148, 78, 37, 0.25);
}

.btn-learning:hover {
    background: linear-gradient(135deg, var(--deep-brown) 0%, #4a1f0d 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(148, 78, 37, 0.35);
}

.btn-meeting {
    background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(0, 102, 204, 0.25);
}

.btn-meeting:hover {
    background: linear-gradient(135deg, #0052a3 0%, #003d7a 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.35);
}

.btn-action i {
    font-size: 1.125rem;
}

.empty-state {
    text-align: center;
    padding: 5rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
    max-width: 600px;
    margin: 0 auto;
}

.empty-state i {
    font-size: 5rem;
    color: var(--primary-gold);
    margin-bottom: 1.5rem;
    opacity: 0.8;
    filter: drop-shadow(0 4px 12px rgba(236, 172, 87, 0.3));
}

.empty-state h3 {
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-size: 1.75rem;
    font-weight: 700;
}

.empty-state p {
    color: var(--text-secondary);
    margin-bottom: 2rem;
    font-size: 1rem;
    line-height: 1.6;
}

.btn-browse {
    background: linear-gradient(135deg, var(--primary-gold) 0%, var(--soft-gold) 100%);
    color: var(--deep-brown);
    border: none;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.625rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    box-shadow: 0 4px 12px rgba(236, 172, 87, 0.3);
}

.btn-browse:hover {
    background: linear-gradient(135deg, var(--soft-gold) 0%, var(--primary-gold) 100%);
    color: var(--primary-brown);
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(236, 172, 87, 0.4);
}

/* Responsive Design */
@media (max-width: 1200px) {
    .elearning-table {
        font-size: 0.875rem;
    }
    
    .elearning-table thead th,
    .elearning-table tbody td {
        padding: 1rem;
    }
    
    .course-cell {
        min-width: 280px;
    }
}

@media (max-width: 768px) {
    .container-xxl {
        padding-top: 80px;
        padding-bottom: 40px;
        padding-left: 12px;
        padding-right: 12px;
    }

    .page-header {
        padding: 2rem 1.5rem;
        border-radius: 16px;
    }

    .page-header h1 {
        font-size: 1.75rem;
    }
    
    .table-wrapper {
        border-radius: 16px;
    }
    
    .course-cell {
        min-width: 250px;
    }
    
    .course-icon {
        width: 50px;
        height: 50px;
    }
    
    .course-icon i {
        font-size: 1.5rem;
    }

    .empty-state {
        padding: 3rem 1.5rem;
    }

    .empty-state i {
        font-size: 4rem;
    }

    .empty-state h3 {
        font-size: 1.5rem;
    }
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.table-container {
    animation: fadeIn 0.6s ease-out;
}
</style>
@endsection

@section('content')
<div class="container-xxl">
    <!-- Page Header -->
    <!--<div class="page-header">
        <h1>E-Learning Dashboard</h1>
        <p>Access your enrolled courses and start learning</p>
    </div>-->

    @if($enrollments->count() > 0)
        <!-- E-Learning Table -->
        <div class="table-container">
            <div class="table-wrapper">
                <table class="elearning-table">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Type</th>
                            <th>Instructor</th>
                            <th>Duration</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $enrollment)
                        <tr>
                            <!-- Course Column -->
                            <td>
                                <div class="course-cell">
                                    <div class="course-icon">
                                        <i class="bx {{ $enrollment->type === 'class' ? 'bx-book-open' : 'bx-graduation' }}"></i>
                                    </div>
                                    <div class="course-info">
                                        @if($enrollment->type === 'class' && $enrollment->class)
                                            <h4 class="course-title">{{ $enrollment->class->title }}</h4>
                                            <p class="course-description">{{ $enrollment->class->description ?? 'No description available' }}</p>
                                        @elseif($enrollment->type === 'bootcamp' && $enrollment->bootcamp)
                                            <h4 class="course-title">{{ $enrollment->bootcamp->title }}</h4>
                                            <p class="course-description">{{ $enrollment->bootcamp->description ?? 'No description available' }}</p>
                                        @else
                                            <h4 class="course-title">Course Title</h4>
                                            <p class="course-description">No description available</p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Type Column -->
                            <td>
                                <span class="type-badge type-{{ $enrollment->type }}">
                                    {{ $enrollment->type === 'class' ? 'Class' : 'Bootcamp' }}
                                </span>
                            </td>

                            <!-- Instructor Column -->
                            <td>
                                <div class="instructor-cell">
                                    <i class="bx bx-user"></i>
                                    @if($enrollment->type === 'class' && $enrollment->class && $enrollment->class->tutor)
                                        {{ $enrollment->class->tutor->name }}
                                    @elseif($enrollment->type === 'bootcamp' && $enrollment->bootcamp && $enrollment->bootcamp->tutor)
                                        {{ $enrollment->bootcamp->tutor->name }}
                                    @else
                                        Instructor
                                    @endif
                                </div>
                            </td>

                            <!-- Duration Column -->
                            <td>
                                <div class="duration-cell">
                                    <i class="bx bx-time"></i>
                                    @if($enrollment->type === 'class' && $enrollment->class)
                                        {{ $enrollment->class->duration ?? 'Flexible' }}
                                    @elseif($enrollment->type === 'bootcamp' && $enrollment->bootcamp)
                                        {{ $enrollment->bootcamp->duration ?? 'Flexible' }}
                                    @else
                                        Flexible
                                    @endif
                                </div>
                            </td>

                            <!-- Action Column -->
                            <td class="action-cell">
                                @if($enrollment->type === 'class' && $enrollment->class)
                                    <a href="{{ route('elearning.class', $enrollment->class->id) }}" class="btn-action btn-learning">
                                        <i class="bx bx-play-circle"></i>
                                        Start Learning
                                    </a>
                                @elseif($enrollment->type === 'bootcamp' && $enrollment->bootcamp)
                                    @if($enrollment->bootcamp->zoom_link)
                                        <a href="{{ $enrollment->bootcamp->zoom_link }}" 
                                           class="btn-action btn-meeting" 
                                           target="_blank">
                                            <i class="bx bx-video"></i>
                                            Join Meeting
                                        </a>
                                    @else
                                        <a href="{{ route('elearning.bootcamp', $enrollment->bootcamp->id) }}" class="btn-action btn-learning">
                                            <i class="bx bx-play-circle"></i>
                                            Start Learning
                                        </a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @else
        <!-- Empty State -->
        <div class="empty-state">
            <i class="bx bx-book-open"></i>
            <h3>No Enrolled Courses</h3>
            <p>You haven't enrolled in any courses yet. Browse our available courses and start your learning journey!</p>
            <a href="{{ route('learning') }}" class="btn-browse">
                <i class="bx bx-search"></i>
                Browse Courses
            </a>
        </div>
    @endif
</div>
@endsection