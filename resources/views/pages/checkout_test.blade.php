@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h2>Test Checkout Page</h2>
            <p>This is a test to verify Blade rendering is working correctly.</p>
            
            <div class="alert alert-info">
                Current time: {{ now() }}
            </div>
            
            <button type="button" class="btn btn-primary" id="test-button">
                <i class="fas fa-credit-card me-2"></i>Test Button
            </button>
            
            <hr>
            
            <div class="border p-4 rounded">
                <h5>Payment Button Test</h5>
                <button type="button" 
                        class="btn w-100 fw-bold" 
                        style="background-color:#944e25; color:white; border:none; padding: 12px; border-radius: 8px; font-size: 16px;">
                    <i class="fas fa-credit-card me-2"></i>Beli Sekarang - Rp169.000
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Test page loaded successfully');
    
    const testButton = document.getElementById('test-button');
    testButton.addEventListener('click', function() {
        alert('Button click works correctly!');
    });
});
</script>
@endsection