<?php

namespace App\Http\Controllers;

use App\Models\Member;

class ProfileController extends Controller
{
    public function show($id)
    {
        $member = Member::findOrFail($id);
        return view('profile', compact('member'));
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('profile-edit', compact('member'));
    }
}
