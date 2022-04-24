<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $productRepo;
    protected $brandRepo;
    protected $sizeRepo;

    public function __construct(
        BrandRepositoryInterface $brandRepo,
        ProductRepositoryInterface $productRepo,
        SizeRepositoryInterface $sizeRepo
    ) {
        $this->productRepo = $productRepo;
        $this->brandRepo = $brandRepo;
        $this->sizeRepo = $sizeRepo;
    }

    public function showProduct(Request $request, $id)
    {
        $brand = $this->brandRepo->find($id);
        $products = $this->productRepo->getAllByBrand($id, $request);
        $sizes = $this->sizeRepo->getAll();
        $min_price = $this->productRepo->getMinMax('min', 'promotion');
        $max_price = $this->productRepo->getMinMax('max', 'promotion');

        return view('customers.brands.showProduct', compact('brand', 'products', 'min_price', 'max_price', 'sizes'));
    }
}
