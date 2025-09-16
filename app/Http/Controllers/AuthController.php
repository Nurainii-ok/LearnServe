<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login/register
     */
    public function showAuth()
    {
        return view('auth'); // pastikan file: resources/views/auth.blade.php
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // cari user berdasarkan email atau username
        $user = User::where('email', $request->username)
                    ->orWhere('name', $request->username)
                    ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // simpan session
            session([
                'user_id'  => $user->id,
                'username' => $user->name,
                'role'     => $user->role,
            ]);

            // redirect sesuai role
            return match ($user->role) {
                'admin'  => redirect()->route('admin.dashboard'),
                'tutor'  => redirect()->route('tutor.dashboard'),
                'member' => redirect()->route('home'),
                default  => redirect()->route('auth')->with('error', 'Role tidak dikenali.'),
            };
        }

        return back()->with('error', 'Username/email atau password salah.');
    }

    /**
     * Proses register
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string|max:100|unique:users,name',
                'password' => 'required|string|min:4',
                'role'     => 'required|in:admin,tutor,member',
            ], [
                'username.unique' => 'Username sudah digunakan, silakan pilih username lain.',
                'username.required' => 'Username wajib diisi.',
                'password.min' => 'Password minimal 4 karakter.',
                'role.required' => 'Role wajib dipilih.',
                'role.in' => 'Role yang dipilih tidak valid.'
            ]);

            // Generate unique email
            $baseEmail = strtolower($request->username);
            $email = $baseEmail . '@learnserve.com';
            
            // Check if email already exists and make it unique
            $counter = 1;
            while (User::where('email', $email)->exists()) {
                $email = $baseEmail . $counter . '@learnserve.com';
                $counter++;
            }

            // buat user baru
            $user = User::create([
                'name'     => $request->username,
                'email'    => $email,
                'password' => Hash::make($request->password),
                'role'     => $request->role,
            ]);

            // auto login
            session([
                'user_id'  => $user->id,
                'username' => $user->name,
                'role'     => $user->role,
            ]);

            // redirect sesuai role
            return match ($user->role) {
                'admin'  => redirect()->route('admin.dashboard'),
                'tutor'  => redirect()->route('tutor.dashboard'),
                'member' => redirect()->route('home'),
                default  => redirect()->route('auth')->with('error', 'Role tidak dikenali.'),
            };
            
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            Log::error('Registration stack trace: ' . $e->getTraceAsString());
            return back()->withInput()->with('error', 'Terjadi kesalahan saat mendaftar: ' . $e->getMessage());
        }
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth')->with('success', 'Berhasil logout.');
    }

}
