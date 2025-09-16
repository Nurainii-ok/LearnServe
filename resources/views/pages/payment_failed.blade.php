@extends('layouts.app')

@section('title', 'Payment Failed')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <i class="fas fa-times-circle text-danger" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h2 class="card-title text-danger mb-3">Payment Failed</h2>
                    <p class="card-text mb-4">Sorry, your payment could not be processed. Please try again or contact our support team.</p>
                    
                    @if(session('error'))
                        <div class="alert alert-danger mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>Back to Home
                        </a>
                        <a href="{{ route('learning') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-book me-2"></i>Browse Courses
                        </a>
                    </div>
                    
                    <div class="mt-4">
                        <small class="text-muted">
                            Need help? Contact our support team at 
                            <a href="mailto:support@learnserve.com">support@learnserve.com</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.fas {
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection