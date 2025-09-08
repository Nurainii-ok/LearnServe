<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Tutor;
use App\Models\Member;

class AuthController extends Controller
{
    public function formAuth()
    {
        return view('auth');
    }

    public function prosesLogin(Request $request)
    {
        // Cek Admin
        $admin = Admin::where('username', $request->username)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            session(['role' => 'admin', 'username' => $admin->username]);
            return redirect()->route('admin.dashboard');
        }

        // Cek Tutor
        $tutor = Tutor::where('email', $request->username)->first();
        if ($tutor && Hash::check($request->password, $tutor->password)) {
            session(['role' => 'tutor', 'username' => $tutor->name]);
            return redirect()->route('tutor.dashboard');
        }

        // Cek Member
        $member = Member::where('email', $request->username)->first();
        if ($member && Hash::check($request->password, $member->password)) {
            session(['role' => 'member', 'username' => $member->name]);
            return redirect()->route('home');
        }

        return back()->with('error', 'Username/email atau password salah.');
    }

    public function prosesRegister(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'password' => 'required|string|min:4',
            'role'     => 'required|in:admin,tutor,member',
        ]);

        if ($request->role === 'admin') {
            Admin::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);
        } elseif ($request->role === 'tutor') {
            Tutor::create([
                'name'     => $request->username,
                'email'    => strtolower($request->username).'@mail.com',
                'password' => Hash::make($request->password),
                'expertise'=> 'General',
            ]);
        } else {
            Member::create([
                'name'     => $request->username,
                'email'    => strtolower($request->username).'@mail.com',
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('auth')->with('success', 'Registrasi berhasil! Silakan login.');
    }

}
