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
        $blog = Blogs::leftJoin('blogs_translate as bt', function ($join) {
                $join->on('bt.blog_id', '=', 'blogs.id')
                     ->where('bt.lang_code', '=', app()->getLocale());
            })
            ->leftJoin('blogs_translate as bt_fallback', function ($join) {
                $join->on('bt_fallback.blog_id', '=', 'blogs.id')
                     ->where('bt_fallback.lang_code', '=', 'tr');
            })
            ->select(
                'blogs.*',
                \Illuminate\Support\Facades\DB::raw('COALESCE(bt.title, bt_fallback.title) as title'),
                \Illuminate\Support\Facades\DB::raw('COALESCE(bt.description, bt_fallback.description) as description'),
                \Illuminate\Support\Facades\DB::raw('COALESCE(bt.content, bt_fallback.content) as content')
            )
            ->where('blogs.id', $id)
            ->firstOrFail();

        return view('pages.Blog.edit', compact('blog'));
    }
}