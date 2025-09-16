@extends('layouts.app') {{-- Kalau kamu pakai layout utama --}}

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Bagian Kiri: Form -->
        <div class="col-md-7">
            <h3 class="mb-4">Checkout</h3>

            <!-- Alamat Penagihan -->
            <div class="mb-4">
                <label class="form-label fw-bold">Alamat Penagihan</label>
                <select class="form-select">
                    <option selected>Indonesia</option>
                    <option>Malaysia</option>
                    <option>Singapore</option>
                </select>
                <small class="text-muted">Wajib diisi untuk menghitung pajak transaksi</small>
            </div>

            <!-- Metode Pembayaran -->
            <div class="mb-4">
                <label class="form-label fw-bold">Metode Pembayaran</label>

                <!-- Kartu -->
                <div class="border p-3 rounded mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="card" checked>
                        <label class="form-check-label fw-bold" for="card">Kartu</label>
                        <div class="mt-3">
                            <input type="text" class="form-control mb-2" placeholder="Nomor kartu">
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control mb-2" placeholder="MM/YY">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" placeholder="CVC">
                                </div>
                            </div>
                            <input type="text" class="form-control mb-2" placeholder="Nama pada kartu">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="save_card">
                                <label class="form-check-label" for="save_card">
                                    Simpan kartu untuk pembelian berikutnya
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pembayaran Lain -->
                @php
                    $methods = [
                        'Alfamart', 'Indomaret',
                        'Transfer Bank ke Bank Permata',
                        'Transfer Bank ke Bank Mandiri',
                        'Transfer Bank ke BRI',
                        'Transfer Bank ke BNI',
                        'Transfer Bank ke CIMB Niaga',
                        'Transfer Bank ke Bank Danamon',
                        'Doku Wallet',
                        'PayPal'
                    ];
                @endphp

                @foreach($methods as $m)
                    <div class="border p-3 rounded mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="{{ Str::slug($m) }}">
                            <label class="form-check-label fw-bold" for="{{ Str::slug($m) }}">{{ $m }}</label>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Detail Pesanan -->
            <div class="mt-5">
    <h6 class="fw-bold">Detail pesanan (1 kursus)</h6>
    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
        <div class="d-flex align-items-center">
            <img src="{{ asset('assets/Digital Marketing.jpg') }}" 
                 alt="thumbnail" 
                 class="img-fluid rounded me-2" 
                 style="width: 100px; height: auto;">
            <span>Digital Marketing</span>
        </div>
        <span class="fw-bold">Rp169.000</span>
    </div>
</div>

        </div>

        <!-- Bagian Kanan: Ringkasan -->
        <div class="col-md-5">
            <div class="border p-4 rounded shadow-sm">
                <h5 class="mb-3">Ringkasan Pesanan</h5>
                <div class="d-flex justify-content-between">
                    <span>Harga Asli</span>
                    <span>Rp169.000</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold">
                    <span>Total (1 kursus)</span>
                    <span>Rp169.000</span>
                </div>
                <button class="btn btn-primary w-100 mt-4">Bayar Rp169.000</button>
                <div class="mt-3 text-center small text-muted">
                    Jaminan Uang Kembali 30 Hari
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
