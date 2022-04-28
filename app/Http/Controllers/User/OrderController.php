<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderProduct\OrderProductRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    protected $productRepo;
    protected $orderRepo;
    protected $orderProductRepo;
    protected $userRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepo,
        OrderProductRepositoryInterface $orderProductRepo,
        ProductRepositoryInterface $productRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->orderRepo = $orderRepo;
        $this->orderProductRepo = $orderProductRepo;
        $this->productRepo = $productRepo;
        $this->userRepo = $userRepo;
    }

    public function infoOrder()
    {
        $cart = [];

       $total_price = 0;
        if (Session::has('cart')) {
            $cart = session()->get('cart');
            foreach($cart as $item) {
                $total_price += $item['price']*$item['quantity'];
            }
            if (count($cart) > 0) {
                if ($total_price < 5000000) {
                    $shipping = 26500;
                } elseif ($total_price < 10000000) {
                    $shipping = 21000;
                } elseif ($total_price < 20000000) {
                    $shipping = 15000;
                } else {
                    $shipping = 0;
                }
                return view('customers.orders.checkout')->with(compact('cart', 'total_price', 'shipping'));
            } else {
                return redirect()->back()->with('error', __('empty cart'));
            }
        } else {
            return redirect()->back()->with('error', __('empty cart'));
        }
    }
}
