<?php

namespace App\Http\Controllers\Api;

use App\Classes\LoginClass;

class AuhtApiController
{
    public function login()
    {
        $class= new LoginClass();

        return response()->json($class->login());
    }
}