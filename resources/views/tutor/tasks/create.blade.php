@extends('layouts.tutor')

@section('title', 'Create New Task')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Create New Task</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('tutor.tasks.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Task Title *</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description *</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="instructions" class="form-label">Instructions</label>
                                    <textarea class="form-control @error('instructions') is-invalid @enderror" 
                                              id="instructions" name="instructions" rows="3" 
                                              placeholder="Additional instructions for students...">{{ old('instructions') }}</textarea>
                                    @error('instructions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="attachments" class="form-label">Attachments</label>
                                    <input type="file" class="form-control @error('attachments.*') is-invalid @enderror" 
                                           id="attachments" name="attachments[]" multiple 
                                           accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png">
                                    <div class="form-text">
                                        You can upload multiple files (PDF, DOC, PPT, Images). Max 10MB per file.
                                    </div>
                                    @error('attachments.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="class_id" class="form-label">Class *</label>
                                    <select class="form-select @error('class_id') is-invalid @enderror" 
                                            id="class_id" name="class_id" required>
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                {{ $class->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('class_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="due_date" class="form-label">Due Date *</label>
                                    <input type="datetime-local" class="form-control @error('due_date') is-invalid @enderror" 
                                           id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="priority" class="form-label">Priority *</label>
                                    <select class="form-select @error('priority') is-invalid @enderror" 
                                            id="priority" name="priority" required>
                                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority') === 'medium' || !old('priority') ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Task Guidelines</h6>
                                        <ul class="small mb-0">
                                            <li>Provide clear instructions</li>
                                            <li>Set realistic due dates</li>
                                            <li>Include relevant attachments</li>
                                            <li>Students can submit text and files</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tutor.tasks.index') }}" class="btn btn-secondary">
                                <i class="las la-arrow-left"></i> Back to Tasks
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="las la-save"></i> Create Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Set minimum date to current date/time
document.addEventListener('DOMContentLoaded', function() {
    const dueDateInput = document.getElementById('due_date');
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    dueDateInput.min = now.toISOString().slice(0, 16);
});
</script>
@endsection