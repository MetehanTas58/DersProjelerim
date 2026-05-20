<?php

namespace App\Http\Controllers\Pages;

class PagesController
{
    public function index()
    {
        return view('pages.dashboard');
    }
}