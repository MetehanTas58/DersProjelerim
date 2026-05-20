<?php

namespace App\Http\Controllers\Pages;

use App\Models\User;

class UsersController
{

    public function index()
    {
        return view('pages.Users.index');
    }

    public function new()
    {
        $user = null;
        return view('pages.Users.detail', compact('user'));
    }
    
    public function edit($param)
    {
        $user = User::where('id', $param)->first();

        if ($user == null) {
            return redirect()->route('users');
        }

        return view('pages.Users.detail', compact('user'));
    }
}