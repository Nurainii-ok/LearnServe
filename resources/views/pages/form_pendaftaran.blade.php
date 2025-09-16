@extends('layouts.app')
@section('title', 'Pendaftaran Bootcamp')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">

                    <h2 class="fw-bold mb-3 text-center">Form Pendaftaran Bootcamp</h2>
                    <p class="text-muted text-center mb-4">
                        Silakan isi data berikut untuk mendaftar bootcamp.
                    </p>

                    <!-- Alert sukses (hidden default) -->
                    <div id="successAlert" class="alert alert-success d-none" role="alert">
                        ✅ Pendaftaran berhasil! 
                    </div>

                    <form id="bootcampForm">
                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" id="email" placeholder="nama@email.com" required>
                        </div>

                        <!-- Nomor HP -->
                        <div class="mb-3">
                            <label for="hp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="hp" placeholder="0812xxxxxxx" required>
                        </div>

                        <!-- Nama Bootcamp -->
                        <div class="mb-3">
                            <label for="bootcamp" class="form-label">Pilih Bootcamp</label>
                            <select id="bootcamp" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Bootcamp --</option>
                                <option value="laravel" data-price="169000">Laravel: Pemula sampai Mahir (Rp169.000)</option>
                                <option value="uiux" data-price="149000">UI/UX Design Fundamentals (Rp149.000)</option>
                                <option value="digital_marketing" data-price="0">Digital Marketing (Gratis)</option>
                                <option value="data_science" data-price="199000">Data Science dengan Python (Rp199.000)</option>
                            </select>
                        </div>

                        <!-- Tombol -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Daftar Sekarang
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.getElementById('bootcampForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Ambil data harga dari opsi bootcamp
    const bootcampSelect = document.getElementById('bootcamp');
    const selectedOption = bootcampSelect.options[bootcampSelect.selectedIndex];
    const price = parseInt(selectedOption.getAttribute('data-price'));

    if (price === 0) {
        // Gratis → tampilkan alert sukses
        document.getElementById('successAlert').classList.remove('d-none');
        this.reset();
        document.getElementById('successAlert').scrollIntoView({ behavior: 'smooth' });
    } else {
        // Berbayar → pindah ke halaman checkout
        window.location.href = "/checkout?bootcamp=" + selectedOption.value;
    }
});
</script>
@endsection
