@extends('layouts.app')

@section('title', 'Excel for Accounting Course')

@section('content')

    {{-- Hero Section --}}
    <section class="bg-gray-100 py-12">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
            <div class="bg-gray-300 h-56 md:h-64 rounded-xl"></div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-dark mb-4">
                    Excel for Accounting Course
                </h1>
                <div class="bg-white shadow rounded-lg p-4 mb-6">
                    <p class="font-semibold">Excel for Accounting Course</p>
                    <span class="text-sm text-gray-600">GRATIS!</span>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('daftar') }}" class="px-6 py-3 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition">
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('promo') }}" class="px-6 py-3 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition">
                        Dapatkan Promo
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Content Section --}}
    <section class="max-w-6xl mx-auto px-6 py-12 grid md:grid-cols-4 gap-10">

        {{-- Sidebar --}}
        <aside class="md:col-span-1">
            <div class="bg-white rounded-xl shadow p-6 sticky top-20">
                <h3 class="font-bold text-lg mb-4">Detail</h3>
                <ul class="space-y-3 text-sm" id="sidebar-nav">
                    <li><a href="#tentang" class="nav-link text-gray-700 hover:text-yellow-600">Tentang Bootcamp</a></li>
                    <li><a href="#prospek" class="nav-link text-gray-700 hover:text-yellow-600">Prospek Karir</a></li>
                    <li><a href="#skill" class="nav-link text-gray-700 hover:text-yellow-600">Skill Yang Akan Kamu Miliki</a></li>
                    <li><a href="#benefit" class="nav-link text-gray-700 hover:text-yellow-600">Benefit Bootcamp</a></li>
                    <li><a href="#kurikulum" class="nav-link text-gray-700 hover:text-yellow-600">Kurikulum & Silabus</a></li>
                    <li><a href="#testimoni" class="nav-link text-gray-700 hover:text-yellow-600">Testimoni</a></li>
                </ul>
                <a href="{{ route('daftar') }}" 
                   class="mt-6 block w-full text-center px-4 py-3 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition">
                    Daftar Sekarang
                </a>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="md:col-span-3 space-y-12">

            <section id="tentang" class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-lg text-yellow-700 mb-3">Tentang Bootcamp</h2>
                <p class="text-gray-600">Lorem ipsum dolor sit amet...</p>
            </section>

            <section id="prospek" class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-lg text-yellow-700 mb-3">Prospek Karir</h2>
                <p class="text-gray-600">Lorem ipsum dolor sit amet...</p>
            </section>

            <section id="skill" class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-lg text-yellow-700 mb-3">Skill Yang Akan Kamu Miliki</h2>
                <p class="text-gray-600">Lorem ipsum dolor sit amet...</p>
            </section>

            <section id="benefit" class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-lg text-yellow-700 mb-3">Benefit Bootcamp</h2>
                <p class="text-gray-600">Lorem ipsum dolor sit amet...</p>
            </section>

            <section id="kurikulum" class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-lg text-yellow-700 mb-3">Kurikulum & Silabus</h2>
                <p class="text-gray-600">Lorem ipsum dolor sit amet...</p>
            </section>

            <section id="testimoni" class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-lg text-yellow-700 mb-3">Testimoni</h2>
                <div class="grid md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg shadow text-center">
                        <p class="text-sm text-gray-600 mb-2">Lorem ipsum dolor sit amet...</p>
                        <span class="font-semibold">Nama</span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow text-center">
                        <p class="text-sm text-gray-600 mb-2">Lorem ipsum dolor sit amet...</p>
                        <span class="font-semibold">Nama</span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow text-center">
                        <p class="text-sm text-gray-600 mb-2">Lorem ipsum dolor sit amet...</p>
                        <span class="font-semibold">Nama</span>
                    </div>
                </div>
            </section>

        </main>
    </section>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const sections = document.querySelectorAll("main section");
        const navLinks = document.querySelectorAll("#sidebar-nav .nav-link");

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    navLinks.forEach(link => link.classList.remove("text-yellow-600", "font-bold"));
                    const activeLink = document.querySelector(`#sidebar-nav a[href="#${entry.target.id}"]`);
                    activeLink.classList.add("text-yellow-600", "font-bold");
                }
            });
        }, { threshold: 0.5 });

        sections.forEach(section => observer.observe(section));
    });
</script>
@endpush
