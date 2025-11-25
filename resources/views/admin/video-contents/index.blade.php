@extends('layouts.admin')

@section('title', 'Video Contents')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Video Contents</h5>
                    <a href="{{ session('role') === 'admin' ? route('admin.video-contents.create') : route('tutor.video-contents.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i> Add Video Content
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($videos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Thumbnail</th>
                                        <th>Title</th>
                                        <th>Course</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($videos as $video)
                                    <tr>
                                        <td>
                                            @if($video->thumbnail)
                                                <img src="{{ asset('storage/' . $video->thumbnail) }}" 
                                                     alt="Thumbnail" class="rounded" width="60" height="40" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 60px; height: 40px;">
                                                    <i class="bx bx-video text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $video->title }}</strong>
                                                @if($video->description)
                                                    <br><small class="text-muted">{{ Str::limit($video->description, 50) }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($video->class)
                                                <span class="badge bg-primary">Class</span><br>
                                                <small>{{ $video->class->title }}</small>
                                            @elseif($video->bootcamp)
                                                <span class="badge bg-warning">Bootcamp</span><br>
                                                <small>{{ $video->bootcamp->title }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $video->formatted_duration }}</td>
                                        <td>
                                            <span class="badge bg-{{ $video->status === 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($video->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $video->creator->name }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ session('role') === 'admin' ? route('admin.video-contents.show', $video) : route('tutor.video-contents.show', $video) }}">
                                                        <i class="bx bx-show me-1"></i> View
                                                    </a>
                                                    <a class="dropdown-item" href="{{ session('role') === 'admin' ? route('admin.video-contents.edit', $video) : route('tutor.video-contents.edit', $video) }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>
                                                    <form action="{{ session('role') === 'admin' ? route('admin.video-contents.destroy', $video) : route('tutor.video-contents.destroy', $video) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" 
                                                                onclick="return confirm('Are you sure you want to delete this video content?')">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($videos->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $videos->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="bx bx-video display-4 text-muted"></i>
                            <h5 class="mt-3">No Video Contents Found</h5>
                            <p class="text-muted">Start by creating your first video content.</p>
                            <a href="{{ session('role') === 'admin' ? route('admin.video-contents.create') : route('tutor.video-contents.create') }}" class="btn btn-primary">
                                <i class="bx bx-plus"></i> Add Video Content
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection