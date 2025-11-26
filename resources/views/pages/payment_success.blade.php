@extends('layouts.app')

@section('title', 'Payment Success')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h2 class="card-title text-success mb-3">Payment Successful!</h2>
                    <p class="card-text mb-4">Thank you for your payment. Your transaction has been completed successfully.</p>
                    
                    @if($payment)
                    <div class="bg-light p-4 rounded mb-4">
                        <h5 class="mb-3">Payment Details</h5>
                        <div class="row text-start">
                            <div class="col-sm-6">
                                <strong>Order ID:</strong><br>
                                <span class="text-muted">{{ $payment->transaction_id }}</span>
                            </div>
                            <div class="col-sm-6">
                                <strong>{{ $payment->class ? 'Course' : 'Bootcamp' }}:</strong><br>
                                <span class="text-muted">{{ $payment->class->title ?? $payment->bootcamp->title ?? 'N/A' }}</span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <strong>Amount:</strong><br>
                                <span class="text-muted">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <strong>Payment Date:</strong><br>
                                <span class="text-muted">{{ $payment->payment_date ? $payment->payment_date->format('d M Y, H:i') : 'Processing' }}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($payment && session('user_id'))
                        @php
                            $isEnrolled = false;
                            $courseUrl = '';
                            
                            if ($payment->class_id) {
                                $isEnrolled = \App\Models\Enrollment::where('user_id', session('user_id'))
                                              ->where('class_id', $payment->class_id)
                                              ->where('type', 'class')
                                              ->exists();
                                $courseUrl = route('elearning.class', $payment->class_id);
                            } elseif ($payment->bootcamp_id) {
                                $isEnrolled = \App\Models\Enrollment::where('user_id', session('user_id'))
                                              ->where('bootcamp_id', $payment->bootcamp_id)
                                              ->where('type', 'bootcamp')
                                              ->exists();
                                $courseUrl = route('elearning.bootcamp', $payment->bootcamp_id);
                            }
                        @endphp
                        
                        @if(!$isEnrolled)
                            <div class="alert alert-info mb-4">
                                <i class="fas fa-info-circle me-2"></i>
                                Your enrollment is being processed. Please check your dashboard in a few minutes.
                            </div>
                        @endif
                    @endif
                    
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        @if($payment && session('user_id') && $isEnrolled)
                            <a href="{{ $courseUrl }}" class="btn btn-success btn-lg">
                                <i class="fas fa-play-circle me-2"></i>Start Learning Now!
                            </a>
                            <!--<a href="{{ route('elearning.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-graduation-cap me-2"></i>My E-Learning
                            </a>-->
                        @endif
                        
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-2"></i>kembali
                        </a>
                        
                        @if(session()->has('role'))
                            @if(session('role') === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-tachometer-alt me-2"></i>Masuk ke Dashboard
                                </a>
                            @elseif(session('role') === 'tutor')
                                <a href="{{ route('tutor.dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-tachometer-alt me-2"></i>Masuk ke Dashboard
                                </a>
                            @elseif(session('role') === 'member')
                                <a href="{{ route('member.dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-tachometer-alt me-2"></i>Masuk ke profil
                                </a>
                            @endif
                        @endif
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