@extends('layouts.app')

@section('title', 'Home - LearnServe')

@section('content')
    <div class="container">
        <div class="header">
            <h1>Ratusan Skill Impian Kini Dalam Genggamanmu</h1>
            <p>Lihat contoh beberapa materi terpopuler rancangan experts berikut. Materi baru setiap bulan tanpa tambahan biaya.</p>
        </div>

        <div class="categories">
            <button class="category-tag">Digital Marketing</button>
            <button class="category-tag">Data Science & Data Analysis</button>
            <button class="category-tag">Microsoft Excel, Word and PowerPoint</button>
            <button class="category-tag">UI-UX Research and Design</button>
            <button class="category-tag">Product and Project</button>
        </div>

        <div class="courses-grid">
            {{-- ... semua card course disini ... --}}
        </div>

        <div class="actions">
            <a href="#" class="btn btn-primary">Mulai Berlangganan</a>
            <a href="#" class="btn btn-secondary">Lihat Semua Materi</a>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Pindahin semua CSS custom kamu di sini */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }
        /* dst... */
    </style>
@endpush

@push('scripts')
    <script>
        // Pindahin semua JS kamu disini
    </script>
@endpush
