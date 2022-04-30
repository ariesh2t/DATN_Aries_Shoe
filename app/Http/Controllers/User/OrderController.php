<?php

namespace App\Http\Controllers\User;

use App\Helper\CartHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreRequest;
use App\Repositories\Color\ColorRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderProduct\OrderProductRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ProductInfor\ProductInforRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    protected $productRepo;
    protected $productInforRepo;
    protected $orderRepo;
    protected $orderProductRepo;
    protected $userRepo;
    protected $colorRepo;
    protected $sizeRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepo,
        OrderProductRepositoryInterface $orderProductRepo,
        ProductRepositoryInterface $productRepo,
        ProductInforRepositoryInterface $productInforRepo,
        UserRepositoryInterface $userRepo,
        ColorRepositoryInterface $colorRepo,
        SizeRepositoryInterface $sizeRepo,
    ) {
        $this->orderRepo = $orderRepo;
        $this->orderProductRepo = $orderProductRepo;
        $this->productRepo = $productRepo;
        $this->productInforRepo = $productInforRepo;
        $this->userRepo = $userRepo;
        $this->colorRepo = $colorRepo;
        $this->sizeRepo = $sizeRepo;
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

    public function postOrder(StoreRequest $request, CartHelper $cart)
    {
        if (!empty($cart)) {
            $order_status = config('orderstatus.waiting');
            $user = Auth::user();
            $total_price = 0;
            
            foreach ($cart->items as $item) {
                $product = $this->productRepo->find($item['id']);
                $productInfor = $this->productInforRepo->getProductInfor($item['id'], $item['color_id'], $item['size_id']);
                if ($productInfor->quantity >= $item['quantity']) {
                    $productInfor->decrement('quantity', $item['quantity']);
                } else {
                    return redirect()->route('cart')
                        ->with('error', __('not enough', ['attr' => $product->name, 'value' => $productInfor->quantity]));
                }
            }
            if ($total_price < 5000000) {
                $shipping = 26500;
            } elseif ($total_price < 10000000) {
                $shipping = 21000;
            } elseif ($total_price < 20000000) {
                $shipping = 15000;
            } else {
                $shipping = 0;
            }

            $order = $this->orderRepo->create([
                'user_id' => $user->id,
                'fullname' => $request->fullname,
                'phone' => $request->phone,
                'address' => $request->address,
                'note' => $request->note,
                'total_price' => $cart->total_price,
                'shipping' => $shipping,
                'order_status_id' => $order_status,
            ]);
            
            foreach ($cart->items as $item) {
                $productInfor = $this->productInforRepo->getProductInfor($item['id'], $item['color_id'], $item['size_id']);
                $this->orderProductRepo->create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'price' => $item['price'],
                    'color' => $productInfor->color->color,
                    'size' => $productInfor->size->size,
                    'quantity' => $item['quantity'],
                ]);
            }
            
            session()->forget('cart');

            return redirect()->route('home')->with('success', __('thanks order'));
        } else {
            return redirect()->back()->with('error', __('empty_cart'));
        }
    }

    public function showAll()
    {
        $orders = $this->orderRepo->getOrderByUserId(Auth::user()->id);

        return view('customers.orders.showAll', compact('orders'));
    }

    public function detail($id)
    {
        $order = $this->orderRepo->getOrderDetail(Auth::user()->id, $id);

        return view('customers.orders.detail', compact('order'));
    }

    public function cancelOrder($id)
    {
        $order = $this->orderRepo->find($id);
        $validator = Validator::make(request()->all(), [
            'reason' => 'required',
        ], [
            'reason.required' => __('required', ['attr' => __('reason')]),
        ]);

        if ($order->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', __('cannot cancel someone else order'));
        } elseif ($order->order_status_id == config('orderStatus.shipping') || 
            $order->order_status_id == config('orderStatus.delivered') ||
            $order->order_status_id == config('orderStatus.cancelled')) {
                return redirect()->back()->with('error', __('cannot cancel'));
        }

        if ($validator->fails()) {
            return redirect()->back()->with('error', __('empty reason'));
        } else {
            DB::transaction(function() use($order) {
                $order->update(['order_status_id' => config('orderstatus.cancelled')]);
                foreach($order->products as $product) {
                    $size_id = $this->sizeRepo->getSize($product->pivot->size)->id;
                    $color_id = $this->colorRepo->getColor($product->pivot->color)->id;

                    $productInfor = $this->productInforRepo->getProductInfor($product->id, $color_id, $size_id);
                    $productInfor->quantity += $product->pivot->quantity;
                    $productInfor->update();
                }
            });

            return redirect()->back()->with('success', __('update success', ['attr' => __('order')]));
        }
    }

    public function reOrder($id)
    {
        $orderCurrent = $this->orderRepo->find($id);
        if ($orderCurrent->order_status_id != config('orderstatus.cancelled') && $orderCurrent->order_status_id != config('orderstatus.delivered')) {
            return redirect()->back()->with('error', __('cannot re-order'));
        } elseif ($orderCurrent->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', __('cannot cancel someone else order'));
        }
        
        $orderNew = $this->orderRepo->create([
            'user_id' => $orderCurrent->user_id,
            'fullname' => $orderCurrent->fullname,
            'phone' => $orderCurrent->phone,
            'address' => $orderCurrent->address,
            'note' => $orderCurrent->note,
            'total_price' => $orderCurrent->total_price,
            'shipping' => $orderCurrent->shipping,
            'order_status_id' => config('orderstatus.waiting'),
        ]);

        foreach($orderCurrent->products as $product) {
            $size_id = $this->sizeRepo->getSize($product->pivot->size)->id;
            $color_id = $this->colorRepo->getColor($product->pivot->color)->id;

            $productInfor = $this->productInforRepo->getProductInfor($product->id, $color_id, $size_id);
            if ($productInfor->quantity < $product->pivot->quantity) {
                return redirect()->back()
                    ->with('error', __('not enough', ['attr' => $product->name, 'value' => $productInfor->quantity]));
            }
        }

        foreach($orderCurrent->products as $product) {
            $this->orderProductRepo->create([
                'order_id' => $orderNew->id,
                'product_id' => $product->pivot->product_id,
                'price' => $product->pivot->price,
                'color' => $product->pivot->color,
                'size' => $product->pivot->size,
                'quantity' => $product->pivot->quantity,
            ]);
        }

        return redirect()->route('home')->with('success', __('thanks order'));
    }
}
