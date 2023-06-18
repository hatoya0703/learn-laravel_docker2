<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('contact', [ContactController::class, 'sendmail']) ;
Route::get('/contact/complete', [ContactController::class, 'complete'])->name('contact.complete');

Route::prefix('/admin')
    ->name('admin.')
    ->group(function () {
        Route::middleware('auth')
        // ログインが必要なルート群
            ->group(function () {
                Route::get('/blogs', [AdminBlogController::class, 'index'])->name('blogs.index');
                Route::get('/blogs/create', [AdminBlogController::class, 'create'])->name('blogs.create');
                Route::post('/blogs/store', [AdminBlogController::class, 'store'])->name('blogs.store');
                Route::get('/blogs/{blog}', [AdminBlogController::class, 'edit'])->name('blogs.edit');
                Route::put('/blogs/{blog}', [AdminBlogController::class, 'update'])->name('blogs.update');
                Route::delete('/blogs/{blog}', [AdminBlogController::class, 'destroy'])->name('blogs.delete');
                Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
                Route::post('/users/store', [AdminUserController::class, 'store'])->name('users.store');
                Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');
            });
        Route::middleware('auth')
        // ログインしている場合にアクセス出来ないルート群
            ->group(function () {
                Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login')->middleware('guest'); 
                Route::post('/admin/login', [AuthController::class, 'login']);
            });
    });