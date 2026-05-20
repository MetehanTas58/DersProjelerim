<?php

namespace App\Http\Controllers\Auth;

use App\Classes\LoginClass;

class AuthController
{
    public function login(){
       return view('auth.login');
    }

    public function loginPost() {
        $class = new LoginClass();
        return response()->json($class->login());
    }
}