@extends('layouts.app')
@section('title', 'Checkout Berhasil')

@section('content')
<style>
    .success-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 20px;
        text-align: center;
    }
    
    .success-card {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    
    .success-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #28a745, #20c997);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: white;
        font-size: 2rem;
    }
    
    .instructions-card {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 10px;
        text-align: left;
        margin-bottom: 20px;
    }
    
    .step-list {
        list-style: none;
        padding: 0;
    }
    
    .step-list li {
        padding: 8px 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .step-list li:last-child {
        border-bottom: none;
    }
    
    .btn-home {
        background: linear-gradient(135deg, #944e25 0%, #ecac57 100%);
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        margin-top: 20px;
        font-weight: 600;
    }
    
    .btn-home:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(148, 78, 37, 0.3);
    }
</style>

<div class="success-container">
    <div class="success-card">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        
        <h1 style="color: #944e25; margin-bottom: 15px;">Pesanan Berhasil Dibuat!</h1>
        <p style="color: #666; font-size: 1.1rem; margin-bottom: 30px;">
            Terima kasih telah melakukan pemesanan. Silakan ikuti instruksi pembayaran di bawah ini.
        </p>
        
        @if(session('payment'))
            <div style="background: #e8f5e8; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <strong>Nomor Pesanan: </strong>PAY-{{ session('payment')->id }}<br>
                <strong>Total Pembayaran: </strong>Rp {{ number_format(session('payment')->amount, 0, ',', '.') }}
            </div>
        @endif
        
        @if(session('instructions'))
            <div class="instructions-card">
                <h3 style="color: #944e25; margin-bottom: 20px;">
                    <i class="fas fa-info-circle"></i> 
                    Instruksi {{ session('instructions')['title'] }}
                </h3>
                
                <ul class="step-list">
                    @foreach(session('instructions')['steps'] as $step)
                        <li><i class="fas fa-arrow-right" style="color: #944e25; margin-right: 10px;"></i> {{ $step }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div style="background: #fff3cd; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <i class="fas fa-exclamation-triangle" style="color: #856404;"></i>
            <strong style="color: #856404;">Penting:</strong> 
            <span style="color: #856404;">Pembayaran akan dikonfirmasi dalam 1x24 jam setelah transfer berhasil.</span>
        </div>
        
        <a href="{{ route('home') }}" class="btn-home">
            <i class="fas fa-home"></i> Kembali ke Beranda
        </a>
    </div>
</div>
@endsection