<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ProductInfor\ProductInforRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepo;
    protected $productInforRepo;
    protected $brandRepo;
    protected $categoryRepo;
    protected $sizeRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        ProductInforRepositoryInterface $productInforRepo,
        BrandRepositoryInterface $brandRepo,
        CategoryRepositoryInterface $categoryRepo,
        SizeRepositoryInterface $sizeRepo
    ) {
        $this->productRepo = $productRepo;
        $this->productInforRepo = $productInforRepo;
        $this->brandRepo = $brandRepo;
        $this->categoryRepo = $categoryRepo;
        $this->sizeRepo = $sizeRepo;
    }
    
    public function get4ProductByCat($id) {
        $products = $this->productRepo->get4ProductByCat($id);

        return response()->json($products);
    }

    public function showAll(Request $request)
    {
        $products = $this->productRepo->getAllWithSearch($request);
        $brands = $this->brandRepo->getAll();
        $categories = $this->categoryRepo->getAll();
        $sizes = $this->sizeRepo->getAll();
        $min_price = $this->productRepo->getMinMax('min', 'promotion');
        $max_price = $this->productRepo->getMinMax('max', 'promotion');

        return view('customers.products.showAll', compact('products', 'brands', 'categories', 'sizes', 'min_price', 'max_price'));
    }

    public function detail($id)
    {
        $product = $this->productRepo->find($id);
        $sizes = $this->productInforRepo->getDistinct($id, 'size_id');
        $colors = $this->productInforRepo->getDistinct($id, 'color_id');

        return view('customers.products.detail', compact('product', 'sizes', 'colors'));
    }
}
