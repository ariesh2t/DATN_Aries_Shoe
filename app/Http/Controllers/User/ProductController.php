<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ProductInfor\ProductInforRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productRepo;
    protected $productInforRepo;
    protected $brandRepo;
    protected $categoryRepo;
    protected $sizeRepo;
    protected $userRepo;
    protected $commentRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        ProductInforRepositoryInterface $productInforRepo,
        BrandRepositoryInterface $brandRepo,
        CategoryRepositoryInterface $categoryRepo,
        SizeRepositoryInterface $sizeRepo,
        UserRepositoryInterface $userRepo,
        CommentRepositoryInterface $commentRepo
    ) {
        $this->productRepo = $productRepo;
        $this->productInforRepo = $productInforRepo;
        $this->brandRepo = $brandRepo;
        $this->categoryRepo = $categoryRepo;
        $this->sizeRepo = $sizeRepo;
        $this->userRepo = $userRepo;
        $this->commentRepo = $commentRepo;
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
        $relatedProducts = $this->productRepo->getRelatedProduct($product->brand_id, $product->category_id);
        $sizes = $this->productInforRepo->getDistinct($id, 'size_id');
        $colors = $this->productInforRepo->getDistinct($id, 'color_id');
        $totalQuantity = $this->productRepo->getQuantity(['id' => $id]);
        $allowComment = false;

        $user = $this->userRepo->getUserByOrderDelivered(Auth::user()->id);
        foreach ($user->orders as $order) {
            foreach ($order->products as $p) {
                if ($p->id == $id) {
                    $allowComment = true;
                    foreach ($product->comments as $comment) {
                        if ($comment['product_id'] == $id && $comment['user_id'] == Auth::user()->id) {
                            $allowComment = false;
                            break;
                        }
                    }
                }
            }
        }
        for ($star=5; $star >=1 ; $star--) { 
            $count = $this->commentRepo->getTotalByStar($star, $id);
            $list_star[$star] = $count;
        }

        return view('customers.products.detail', compact(
            'product',
            'list_star',
            'relatedProducts',
            'allowComment',
            'totalQuantity',
            'sizes',
            'colors'
        ));
    }

    public function getQuantity(Request $request)
    {
        $totalQuantity = $this->productRepo->getQuantity($request->all());

        return response()->json($totalQuantity);
    }
}
