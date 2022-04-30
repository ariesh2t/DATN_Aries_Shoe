<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorSizeController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductInforController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\User\BrandController as UserBrandController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CategoryController as UserCategoryController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\OrderController;
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
        Route::resource('orders', AdminOrderController::class);
        Route::get('color-size/show-all', [ColorSizeController::class, 'showAll'])->name('color-size.show');
        Route::post('add-color', [ColorSizeController::class, 'addColor'])->name('add-color');
        Route::post('add-size', [ColorSizeController::class, 'addSize'])->name('add-size');
        Route::post('delete-image', [ProductController::class, 'deleteImage'])->name('delete-image');
        Route::get('profile', [AdminProfileController::class, 'show'])->name('admin.profile');
        Route::get('profile/edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::put('profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
        Route::post('profile/change-pass', [AdminProfileController::class, 'changePass'])->name('admin.profile.change-pass');
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::get('user/{id}/detail', [UserController::class, 'detail'])->name('users.detail');
        Route::patch('user/{id}/update-status', [UserController::class, 'updateStatus'])->name('users.updateStatus');
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
    Route::get('/product/{id}/quantity', [UserProductController::class, 'getQuantity']);
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/{id}/change-pass', [ProfileController::class, 'changePass'])->name('profile.change-pass');
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart');
        Route::get('add/{id}', [CartController::class, 'add'])->name('cart.add');
        Route::get('remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::get('update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::get('clear', [CartController::class, 'clear'])->name('cart.clear');
    });
    Route::get('/cart/checkout', [OrderController::class, 'infoOrder'])->name('checkout');
    Route::post('/post-order', [OrderController::class, 'postOrder'])->name('post-order');
    Route::get('/orders', [OrderController::class, 'showAll'])->name('orders');
    Route::get('/order/{id}', [OrderController::class, 'detail'])->name('order.detail');
    Route::patch('/order/cancel-order/{id}', [OrderController::class, 'cancelOrder'])->name('order.cancel');
    Route::post('/order/re-order/{id}', [OrderController::class, 'reOrder'])->name('order.reOrder');
});
