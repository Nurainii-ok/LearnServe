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

                        <!-- Catatan -->
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan Tambahan</label>
                            <textarea id="catatan" class="form-control" rows="3" placeholder="Tuliskan catatan atau pertanyaan..."></textarea>
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

    // Tampilkan alert sukses
    document.getElementById('successAlert').classList.remove('d-none');

    // Reset form
    this.reset();

    // Scroll ke alert
    document.getElementById('successAlert').scrollIntoView({ behavior: 'smooth' });
});
</script>
@endsection
