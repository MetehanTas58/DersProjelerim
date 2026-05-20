<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Classes\UsersClass;

class UsersApiController extends Controller
{
    public function getData()
    {
        $class = new UsersClass();

        return $class->getData();
    }

    public function saveUser()
    {
        $class = new UsersClass();

        return response()->json($class->saveUser());
    }

    public function delUser()
    {
        $class = new UsersClass();

        return response()->json($class->delUser());
    }

    public function createAdmin()
    {
        $class = new UsersClass();

        return response()->json($class->createAdmin());
    }
}