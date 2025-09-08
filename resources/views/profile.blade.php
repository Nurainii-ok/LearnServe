<!-- resources/views/profile.blade.php -->
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <!-- Card Profil -->
    <div class="bg-white shadow-lg rounded-2xl p-6">
        <div class="flex items-center space-x-6">
            <!-- Foto profil -->
            <img src="https://ui-avatars.com/api/?name={{ $member->name }}" 
                 class="w-24 h-24 rounded-full border-4 border-indigo-500" alt="Foto Profil">
            
            <!-- Info utama -->
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $member->name }}</h2>
                <p class="text-gray-600">{{ $member->email }}</p>
                <p class="text-gray-600">{{ $member->phone }}</p>
            </div>
        </div>

        <!-- Detail tambahan -->
        <div class="mt-6 border-t pt-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Detail Profil</h3>
            <p><span class="font-medium">Alamat:</span> {{ $member->address }}</p>
            <p><span class="font-medium">Role:</span> {{ ucfirst($member->role) }}</p>
        </div>

        <!-- Tombol aksi -->
        <div class="mt-6 flex gap-3">
            <a href="{{ route('profile.edit', $member->id) }}" 
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Edit Profil</a>
            <a href="{{ route('dashboard') }}" 
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Kembali</a>
        </div>
    </div>
</div>
@endsection
