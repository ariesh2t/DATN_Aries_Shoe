<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $productRepo;
    protected $categoryRepo;
    protected $sizeRepo;

    public function __construct(
        CategoryRepositoryInterface $categoryRepo,
        ProductRepositoryInterface $productRepo,
        SizeRepositoryInterface $sizeRepo
    ) {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
        $this->sizeRepo = $sizeRepo;
    }

    public function showProduct(Request $request, $id)
    {
        $category = $this->categoryRepo->find($id);
        $products = $this->productRepo->getAllByCategory($id, $request);
        $sizes = $this->sizeRepo->getAll();
        $min_price = $this->productRepo->getMinMax('min', 'promotion');
        $max_price = $this->productRepo->getMinMax('max', 'promotion');

        return view('customers.categories.showProduct', compact('category', 'products', 'min_price', 'max_price', 'sizes'));
    }
}
