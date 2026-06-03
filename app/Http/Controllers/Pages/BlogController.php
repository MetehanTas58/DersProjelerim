<?php

namespace App\Http\Controllers\Pages;

use App\Models\Blogs;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        return view('pages.Blog.index');
    }

    public function new()
    {
        $blog = null;
        return view('pages.Blog.edit', compact('blog'));
    }

    public function edit($id)
    {
        $blog = Blogs::leftJoin('blogs_translate as bt', 'bt.blog_id', '=', 'blogs.id')
            ->select('blogs.*', 'bt.title', 'bt.description', 'bt.content')
            ->where('blogs.id', $id)
            ->where('bt.lang_code', 'tr')
            ->firstOrFail();

        return view('pages.Blog.edit', compact('blog'));
    }
}