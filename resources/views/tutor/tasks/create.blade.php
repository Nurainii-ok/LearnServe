@extends('layouts.tutor')

@section('title', 'Create New Task')

@section('content')
<style>
    .form-section-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 15px;
        color: #4a4a4a;
        border-left: 4px solid #944e25;
        padding-left: 10px;
    }

    .card-body {
        padding: 2rem !important;
    }

    .form-card {
        border: 1px solid #e9e9e9;
        border-radius: 10px;
        padding: 20px;
        background: #fafafa;
    }

    .form-label {
        font-weight: 600;
        color: #5a5a5a;
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0 fw-bold">Create New Task</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('tutor.tasks.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            <!-- LEFT SIDE -->
                            <div class="col-md-8">
                                <div class="form-card mb-4">

                                    <h6 class="form-section-title">Task Information</h6>

                                    {{-- Title --}}
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Task Title *</label>
                                        <input type="text" 
                                            class="form-control @error('title') is-invalid @enderror"
                                            id="title" 
                                            name="title" 
                                            value="{{ old('title') }}" 
                                            placeholder="Enter task title"
                                            required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Description --}}
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description *</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                id="description"
                                                name="description"
                                                rows="4"
                                                placeholder="Describe the task..." 
                                                required>{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Instructions --}}
                                    <div class="mb-3">
                                        <label for="instructions" class="form-label">Instructions</label>
                                        <textarea class="form-control @error('instructions') is-invalid @enderror"
                                                id="instructions"
                                                name="instructions"
                                                rows="3"
                                                placeholder="Additional guidelines for students">{{ old('instructions') }}</textarea>
                                        @error('instructions')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Attachments --}}
                                    <div class="mb-3">
                                        <label for="attachments" class="form-label">Attachments</label>
                                        <input type="file"
                                            class="form-control @error('attachments.*') is-invalid @enderror"
                                            id="attachments"
                                            name="attachments[]"
                                            multiple
                                            accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png">
                                        <div class="form-text">Allowed: PDF, DOC, PPT, Images. Max 10MB each.</div>
                                        @error('attachments.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <!-- RIGHT SIDE -->
                            <div class="col-md-4">
                                <div class="form-card mb-4">

                                    <h6 class="form-section-title">Task Settings</h6>

                                    {{-- Bootcamp --}}
                                    <div class="mb-3">
                                        <label for="bootcamp_id" class="form-label">Bootcamp *</label>
                                        <select class="form-select @error('bootcamp_id') is-invalid @enderror"
                                                id="bootcamp_id"
                                                name="bootcamp_id"
                                                required>
                                            <option value="">Select Bootcamp</option>
                                            @foreach($bootcamps as $bootcamp)
                                                <option value="{{ $bootcamp->id }}"
                                                    {{ old('bootcamp_id') == $bootcamp->id ? 'selected' : '' }}>
                                                    {{ $bootcamp->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('bootcamp_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Due Date --}}
                                    <div class="mb-3">
                                        <label for="due_date" class="form-label">Due Date *</label>
                                        <input type="datetime-local"
                                            class="form-control @error('due_date') is-invalid @enderror"
                                            id="due_date"
                                            name="due_date"
                                            value="{{ old('due_date') }}"
                                            required>
                                        @error('due_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Priority --}}
                                    <div class="mb-3">
                                        <label for="priority" class="form-label">Priority *</label>
                                        <select class="form-select @error('priority') is-invalid @enderror"
                                                id="priority"
                                                name="priority"
                                                required>
                                            <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                                            <option value="medium" {{ old('priority') === 'medium' || !old('priority') ? 'selected' : '' }}>Medium</option>
                                            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                                        </select>
                                        @error('priority')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                        </div>

                        <!-- BUTTONS -->
                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('tutor.tasks.index') }}" class="btn btn-secondary">
                                <i class="las la-arrow-left"></i> Back to Tasks
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
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
// Set minimum date to now
document.addEventListener('DOMContentLoaded', function () {
    const dueDateInput = document.getElementById('due_date');
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    dueDateInput.min = now.toISOString().slice(0, 16);
});
</script>

@endsection
