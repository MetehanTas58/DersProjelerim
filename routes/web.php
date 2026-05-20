<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Pages\PagesController;
use App\Http\Controllers\Pages\UsersController;
use App\Http\Controllers\Pages\BlogController;
use App\Http\Controllers\Api\UsersApiController;

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



Route::post('/api/users/getData',[UsersApiController::class,'getData'])->middleware('auth');
Route::post('/api/users/saveUser',[UsersApiController::class,'saveUser'])->middleware('auth');
Route::post('/api/users/delUser',[UsersApiController::class,'delUser'])->middleware('auth');
Route::post('/api/users/createAdmin',[UsersApiController::class,'createAdmin'])->middleware('auth');


Route::get('/blog',[BlogController::class,'index'])->name('blog')->middleware('auth');