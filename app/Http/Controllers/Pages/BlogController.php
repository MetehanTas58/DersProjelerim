<?php

namespace App\Http\Controllers\Pages;

use App\Models\User;

class BlogController
{

    public function index()
    {
        return view('pages.Blog.index');
    }
}