<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\BlogClass;

class BlogApiController extends Controller
{
    /**
    * Return blog data as JSON.
    */
    
    public function getData(Request $request)
    {
        $class = new BlogClass();
        return $class->getData();
    }

    public function saveBlog()
    {
        $class = new BlogClass();
        return response()->json($class->saveBlog());
    }

    public function delBlog()
    {
        $class = new BlogClass();
        return response()->json($class->delBlog());
    }

    public function toggleStatus()
    {
        $class = new BlogClass();
        return response()->json($class->toggleStatus());
    }
    public function passive()
    {
        $class = new BlogClass();
        return response()->json($class->passive());
    }
     public function active()
    {
        $class = new BlogClass();
        return response()->json($class->active());
    }
}