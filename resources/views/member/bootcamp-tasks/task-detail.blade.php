@extends('layouts.member')

@section('title', $task->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Task Details -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $task->title }}</h4>
                        <small class="text-muted">Task #{{ $task->task_order }} - {{ $task->task_type_display }}</small>
                    </div>
                    <div>
                        <span class="badge 
                            @if($task->task_type === 'final_project') bg-danger
                            @elseif($task->task_type === 'project') bg-warning
                            @elseif($task->task_type === 'quiz') bg-info
                            @else bg-secondary
                            @endif">
                            {{ $task->task_type_display }}
                        </span>
                        @if($task->due_date)
                            <span class="badge {{ $task->is_overdue ? 'bg-danger' : 'bg-info' }} ms-1">
                                Due: {{ $task->due_date->format('M d, Y') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <h6>Deskripsi Tugas:</h6>
                                <p>{{ $task->description }}</p>
                            </div>
                            
                            @if($task->instructions)
                                <div class="mb-3">
                                    <h6>Instruksi:</h6>
                                    <div class="alert alert-info">
                                        {!! nl2br(e($task->instructions)) !!}
                                    </div>
                                </div>
                            @endif

                            @if($task->attachments && count($task->attachments) > 0)
                                <div class="mb-3">
                                    <h6>File Lampiran:</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($task->attachments as $attachment)
                                            <a href="{{ asset('storage/' . $attachment['path']) }}" 
                                               class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i class="las la-download"></i> {{ $attachment['original_name'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Info Tugas</h6>
                                    <p class="mb-2"><strong>Bootcamp:</strong> {{ $task->bootcamp->title }}</p>
                                    <p class="mb-2"><strong>Instructor:</strong> {{ $task->assignedBy->name }}</p>
                                    <p class="mb-2"><strong>Min. Score:</strong> {{ $task->min_score }}%</p>
                                    <p class="mb-2"><strong>Weight:</strong> {{ $task->weight }}x</p>
                                    @if($task->due_date)
                                        <p class="mb-0"><strong>Deadline:</strong></p>
                                        <p class="mb-0">
                                            <span class="badge {{ $task->is_overdue ? 'bg-danger' : 'bg-info' }} fs-6">
                                                {{ $task->due_date->format('M d, Y H:i') }}
                                            </span>
                                        </p>
                                        @if($task->is_overdue)
                                            <small class="text-danger">
                                                <i class="las la-exclamation-triangle"></i> 
                                                Tugas sudah melewati deadline
                                            </small>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submission Section -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        @if($submission)
                            📤 Submission Saya
                        @else
                            📝 Submit Tugas
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($submission)
                        <!-- Show existing submission -->
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Submission Status -->
                                <div class="alert 
                                    @if($submission->submission_status === 'passed') alert-success
                                    @elseif($submission->submission_status === 'revision') alert-warning
                                    @elseif($submission->submission_status === 'failed') alert-danger
                                    @else alert-info
                                    @endif">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>Status: {{ $submission->status_display }}</strong>
                                            @if($submission->revision_count > 0)
                                                <span class="badge bg-secondary ms-2">Revisi ke-{{ $submission->revision_count }}</span>
                                            @endif
                                        </div>
                                        @if($submission->grade)
                                            <span class="badge bg-dark fs-6">
                                                Score: {{ $submission->grade }}% ({{ $submission->grade_letter }})
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Submission Content -->
                                @if($submission->content)
                                    <div class="mb-3">
                                        <h6>Jawaban Text:</h6>
                                        <div class="border p-3 bg-light rounded">
                                            {!! nl2br(e($submission->content)) !!}
                                        </div>
                                    </div>
                                @endif

                                @if($submission->submission_url)
                                    <div class="mb-3">
                                        <h6>Link Submission:</h6>
                                        <a href="{{ $submission->submission_url }}" target="_blank" class="btn btn-outline-primary">
                                            <i class="las la-external-link-alt"></i> {{ $submission->submission_url }}
                                        </a>
                                    </div>
                                @endif

                                @if($submission->file_path)
                                    <div class="mb-3">
                                        <h6>File Upload:</h6>
                                        <a href="{{ $submission->file_url }}" target="_blank" class="btn btn-outline-primary">
                                            <i class="las la-download"></i> {{ $submission->original_filename }}
                                        </a>
                                    </div>
                                @endif

                                @if($submission->submission_notes)
                                    <div class="mb-3">
                                        <h6>Catatan:</h6>
                                        <div class="border p-3 bg-light rounded">
                                            {!! nl2br(e($submission->submission_notes)) !!}
                                        </div>
                                    </div>
                                @endif

                                <!-- Mentor Feedback -->
                                @if($submission->mentor_feedback)
                                    <div class="mb-3">
                                        <h6>Feedback dari Mentor:</h6>
                                        <div class="alert alert-secondary">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <strong>{{ $submission->reviewedBy->name ?? 'Mentor' }}</strong>
                                                <small class="text-muted">{{ $submission->reviewed_at?->format('M d, Y H:i') }}</small>
                                            </div>
                                            <p class="mb-0">{!! nl2br(e($submission->mentor_feedback)) !!}</p>
                                        </div>
                                    </div>
                                @endif

                                <!-- Resubmission Form -->
                                @if($submission->can_resubmit)
                                    <div class="alert alert-warning">
                                        <h6><i class="las la-exclamation-triangle"></i> Perlu Perbaikan</h6>
                                        <p class="mb-0">Tugas Anda perlu diperbaiki. Silakan submit ulang dengan perbaikan yang diperlukan.</p>
                                    </div>
                                    
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#resubmitModal">
                                        <i class="las la-redo"></i> Submit Ulang
                                    </button>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Status Submission</h6>
                                        <p class="mb-2">
                                            <strong>Submitted:</strong><br>
                                            {{ $submission->created_at->format('M d, Y H:i') }}
                                        </p>
                                        @if($submission->resubmitted_at)
                                            <p class="mb-2">
                                                <strong>Last Resubmit:</strong><br>
                                                {{ $submission->resubmitted_at->format('M d, Y H:i') }}
                                            </p>
                                        @endif
                                        @if($submission->reviewed_at)
                                            <p class="mb-2">
                                                <strong>Reviewed:</strong><br>
                                                {{ $submission->reviewed_at->format('M d, Y H:i') }}
                                            </p>
                                        @endif
                                        <p class="mb-0">
                                            <strong>Status:</strong><br>
                                            <span class="badge {{ $submission->status_badge_class }}">
                                                {{ $submission->status_display }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Submission form -->
                        <form action="{{ route('member.bootcamp-tasks.submit', [$task->bootcamp_id, $task->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Jawaban/Response Text</label>
                                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                                  id="content" name="content" rows="6" 
                                                  placeholder="Tulis jawaban atau penjelasan Anda di sini...">{{ old('content') }}</textarea>
                                        @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="submission_url" class="form-label">Link Submission (Optional)</label>
                                        <input type="url" class="form-control @error('submission_url') is-invalid @enderror" 
                                               id="submission_url" name="submission_url" value="{{ old('submission_url') }}"
                                               placeholder="https://github.com/username/project atau https://figma.com/...">
                                        <div class="form-text">
                                            Link ke GitHub, Figma, Google Drive, atau platform lainnya
                                        </div>
                                        @error('submission_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="file" class="form-label">Upload File (Optional)</label>
                                        <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                               id="file" name="file" 
                                               accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.zip,.rar">
                                        <div class="form-text">
                                            Supported: PDF, DOC, PPT, Images, ZIP. Max size: 10MB
                                        </div>
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="submission_notes" class="form-label">Catatan Tambahan (Optional)</label>
                                        <textarea class="form-control @error('submission_notes') is-invalid @enderror" 
                                                  id="submission_notes" name="submission_notes" rows="3" 
                                                  placeholder="Catatan atau penjelasan tambahan untuk mentor...">{{ old('submission_notes') }}</textarea>
                                        @error('submission_notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">Panduan Submission</h6>
                                            <ul class="small mb-3">
                                                <li>Baca instruksi dengan teliti</li>
                                                <li>Anda bisa submit text, link, file, atau kombinasi</li>
                                                <li>Pastikan link dapat diakses public</li>
                                                <li>File akan direview oleh mentor</li>
                                                <li>Anda bisa revisi jika diminta</li>
                                            </ul>
                                            
                                            @if($task->is_overdue)
                                                <div class="alert alert-warning small">
                                                    <i class="las la-exclamation-triangle"></i>
                                                    Tugas sudah melewati deadline, tapi masih bisa disubmit.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('member.bootcamp-tasks.tasks', $task->bootcamp_id) }}" class="btn btn-secondary">
                                    <i class="las la-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="las la-paper-plane"></i> Submit Tugas
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Resubmit Modal -->
@if($submission && $submission->can_resubmit)
<div class="modal fade" id="resubmitModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('member.bootcamp-tasks.submit', [$task->bootcamp_id, $task->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Submit Ulang Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="las la-info-circle"></i>
                        Submit ulang akan mengganti submission sebelumnya dan reset status menjadi "Pending Review".
                    </div>
                    
                    <div class="mb-3">
                        <label for="modal_content" class="form-label">Jawaban/Response Text</label>
                        <textarea class="form-control" id="modal_content" name="content" rows="6">{{ $submission->content }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="modal_url" class="form-label">Link Submission</label>
                        <input type="url" class="form-control" id="modal_url" name="submission_url" value="{{ $submission->submission_url }}">
                    </div>

                    <div class="mb-3">
                        <label for="modal_file" class="form-label">Upload File Baru (Optional)</label>
                        <input type="file" class="form-control" id="modal_file" name="file" 
                               accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.zip,.rar">
                        <div class="form-text">
                            Kosongkan jika tidak ingin mengganti file. Upload file baru untuk mengganti.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="modal_notes" class="form-label">Catatan Revisi</label>
                        <textarea class="form-control" id="modal_notes" name="submission_notes" rows="3" 
                                  placeholder="Jelaskan perbaikan yang telah Anda lakukan...">{{ $submission->submission_notes }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Submit Ulang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection