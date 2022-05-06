<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $brandRepo;
    protected $categoryRepo;
    protected $productRepo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        BrandRepositoryInterface $brandRepo,
        CategoryRepositoryInterface $categoryRepo,
        ProductRepositoryInterface $productRepo
    ) {
        $this->middleware('auth');
        $this->brandRepo = $brandRepo;
        $this->categoryRepo = $categoryRepo;
        $this->productRepo = $productRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $get4Brands = $this->brandRepo->get4Brands();
        $get7Categories = $this->categoryRepo->get7Categories();
        $productSuggests = $this->productRepo->getProductSuggests();
        return view('customers.home', compact('get4Brands', 'productSuggests', 'get7Categories'));
    }
}
