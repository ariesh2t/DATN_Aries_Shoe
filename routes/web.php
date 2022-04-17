<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\User\HomeController;

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

Route::redirect('/', 'home');

Auth::routes();

Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');

Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');

Route::get('/language/{locale}', [LangController::class, 'switchLang'])->name('lang');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin');
        Route::resource('categories', CategoryController::class);
        Route::resource('brands', BrandController::class);
        // Route::resource('products', ProductController::class);
        // Route::resource('users', UserController::class);
        // Route::resource('orders', AdminOrderController::class);
        // Route::delete('products/image/{id}', [ProductController::class, 'deleteImage'])->name('delete.image');
    });
});

Route::middleware(['auth', 'staff'])->group(function () {
    Route::prefix('staff')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('staff');
        // Route::resource('categories', CategoryController::class);
        // Route::resource('products', ProductController::class);
        // Route::resource('users', UserController::class);
        // Route::resource('orders', AdminOrderController::class);
        // Route::delete('products/image/{id}', [ProductController::class, 'deleteImage'])->name('delete.image');
    });
});

Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
