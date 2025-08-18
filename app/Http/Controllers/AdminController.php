<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Members
    public function members()
    {
        return view('admin.members.index');
    }

    public function createMember()
    {
        return view('admin.members.create');
    }

    // Tutors
    public function tutors()
    {
        return view('admin.tutors.index');
    }

    // Classes
    public function classes()
    {
        return view('admin.classes.index');
    }

    // Payments
    public function payments()
    {
        return view('admin.payments.index');
    }

    // Tasks
    public function tasks()
    {
        return view('admin.tasks.index');
    }

    // Account
    public function account()
    {
        return view('admin.account.index');
    }
}
