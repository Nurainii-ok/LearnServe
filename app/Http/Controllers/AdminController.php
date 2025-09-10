<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function members()
    {
        return view('admin.members'); // pastikan ada resources/views/admin/members.blade.php
    }

    public function tutors()
    {
        return view('admin.tutors');
    }

    public function classes()
    {
        return view('admin.classes');
    }

    public function payments()
    {
        return view('admin.payments');
    }

    public function tasks()
    {
        return view('admin.tasks');
    }

    public function account()
    {
        return view('admin.account');
    }

    public function createMember()
    {
        return view('admin.members-create'); // bisa juga bikin folder form tersendiri
    }
}
