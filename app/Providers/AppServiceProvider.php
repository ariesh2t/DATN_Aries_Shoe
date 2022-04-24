<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Color\ColorRepository;
use App\Repositories\Color\ColorRepositoryInterface;
use App\Repositories\Image\ImageRepository;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ProductInfor\ProductInforRepository;
use App\Repositories\ProductInfor\ProductInforRepositoryInterface;
use App\Repositories\Size\SizeRepository;
use App\Repositories\Size\SizeRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductInforRepositoryInterface::class, ProductInforRepository::class);
        $this->app->bind(ColorRepositoryInterface::class, ColorRepository::class);
        $this->app->bind(SizeRepositoryInterface::class, SizeRepository::class);
        $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        view()->composer('partials.language_switcher', function ($view) {
            $view->with('current_locale', app()->getLocale());
            $view->with('available_locales', config('app.available_locales'));
        });

        Blade::directive('money', function ($price) {
            return "number_format($price, 0, '.',',') . 'đ'";
        });

        $totalCategories = Category::count();
        $totalBrands = Brand::count();
        $totalProducts = Product::count();

        $brands = Brand::all();
        $categories = Category::all();

        View::share(compact(
            'totalCategories',
            'totalBrands',
            'totalProducts',
            'brands',
            'categories',
        ));
    }
}
