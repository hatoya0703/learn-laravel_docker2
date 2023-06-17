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

Route::get('/admin/blogs', [AdminBlogController::class, 'index'])->name('admin.blogs.index')->middleware('auth');
Route::get('/admin/blogs/create', [AdminBlogController::class, 'create'])->name('admin.blogs.create')->middleware('auth');
Route::post('/admin/blogs/store', [AdminBlogController::class, 'store'])->name('admin.blogs.store')->middleware('auth');
Route::get('/admin/blogs/{blog}', [AdminBlogController::class, 'edit'])->name('admin.blogs.edit')->middleware('auth');
Route::put('/admin/blogs/{blog}', [AdminBlogController::class, 'update'])->name('admin.blogs.update')->middleware('auth');
Route::delete('/admin/blogs/{blog}', [AdminBlogController::class, 'destroy'])->name('admin.blogs.delete')->middleware('auth');

Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create')->middleware('auth');
Route::post('/admin/users/store', [AdminUserController::class, 'store'])->name('admin.users.store')->middleware('auth');

Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');