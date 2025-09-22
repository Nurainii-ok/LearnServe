@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <!-- Left side: Video + Overview + Comment -->
    <div class="col-lg-8">
      <!-- Video Section -->
      <div class="video-container mb-3">
        <div class="ratio ratio-16x9">
          {{-- Bisa diganti URL video dari database --}}
          <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                  title="Class Video" allowfullscreen></iframe>
        </div>
      </div>

      <!-- Overview -->
      <div class="mb-4">
        <h5>Overview</h5>
        <p>
          {{ $class->overview ?? 'This class contains how to arrange layout concepts and ideas quickly...' }}
        </p>
      </div>

      <!-- Comments -->
      <div>
        <h6>{{ $comments->count() }} Comments</h6>
        <form action="{{ route('comment.store', $class->id) }}" method="POST" class="d-flex mb-3">
          @csrf
          <input type="text" name="comment" class="form-control me-2 comment-box" placeholder="Write your comment here">
          <button class="btn btn-primary">Comment</button>
        </form>

        {{-- List komentar --}}
        @foreach($comments as $comment)
          <div class="mb-2 p-2 bg-white rounded shadow-sm">
            <strong>{{ $comment->user->name }}</strong><br>
            {{ $comment->content }}
          </div>
        @endforeach
      </div>
    </div>

    <!-- Right side: Chapters + Other Class -->
    <div class="col-lg-4">
      <!-- Class Chapter -->
      <div class="mb-4">
        <h6>Class Chapter</h6>
        <ul class="list-group chapter-list">
          @foreach($chapters as $chapter)
            <li class="list-group-item {{ $loop->first ? 'active' : '' }}">
              📘 {{ $chapter->title }}
            </li>
          @endforeach
        </ul>
      </div>

      <!-- Other Class -->
      <div>
        <h6>Other Class</h6>
        @foreach($otherClasses as $oc)
          <div class="card mb-3">
            <div class="row g-0">
              <div class="col-4">
                <img src="{{ $oc->thumbnail }}" class="img-fluid rounded-start" alt="{{ $oc->title }}">
              </div>
              <div class="col-8">
                <div class="card-body p-2">
                  <h6 class="card-title mb-0">{{ $oc->title }}</h6>
                  <small class="text-muted">by {{ $oc->author }}</small>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  body {
    background-color: #f8f9fa;
  }
  .chapter-list .list-group-item.active {
    background-color: #4a6cf7;
    border-color: #4a6cf7;
    color: #fff;
  }
  .video-container {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  }
  .comment-box {
    border-radius: 10px;
  }
</style>
@endpush
