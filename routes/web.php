<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorSizeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductInforController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\User\BrandController as UserBrandController;
use App\Http\Controllers\User\CategoryController as UserCategoryController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\ProfileController;

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
        Route::resource('products', ProductController::class);
        Route::resource('product-infors', ProductInforController::class);
        Route::get('color-size/show-all', [ColorSizeController::class, 'showAll'])->name('color-size.show');
        Route::post('add-color', [ColorSizeController::class, 'addColor'])->name('add-color');
        Route::post('add-size', [ColorSizeController::class, 'addSize'])->name('add-size');
        Route::post('delete-image', [ProductController::class, 'deleteImage'])->name('delete-image');
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
    Route::get('/home-cat/{id}', [UserProductController::class, 'get4ProductByCat'])->name('home-cat');
    Route::get('/brand/{id}', [UserBrandController::class, 'showProduct'])->name('brand');
    Route::get('/category/{id}', [UserCategoryController::class, 'showProduct'])->name('category');
    Route::get('/products', [UserProductController::class, 'showAll'])->name('products');
    Route::get('/product/{id}', [UserProductController::class, 'detail'])->name('product.detail');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/{id}/change-pass', [ProfileController::class, 'changePass'])->name('profile.change-pass');
});
