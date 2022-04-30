<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderStatusRequest;
use App\Repositories\Color\ColorRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderProduct\OrderProductRepositoryInterface;
use App\Repositories\OrderStatus\OrderStatusRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ProductInfor\ProductInforRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $productRepo;
    protected $productInforRepo;
    protected $orderRepo;
    protected $orderStatusRepo;
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
        OrderStatusRepositoryInterface $orderStatusRepo
    ) {
        $this->orderRepo = $orderRepo;
        $this->orderStatusRepo = $orderStatusRepo;
        $this->orderProductRepo = $orderProductRepo;
        $this->productRepo = $productRepo;
        $this->productInforRepo = $productInforRepo;
        $this->userRepo = $userRepo;
        $this->colorRepo = $colorRepo;
        $this->sizeRepo = $sizeRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orderRepo->getAll();

        return view('staffs.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->orderRepo->find($id);
        $statuses = $this->orderStatusRepo->getAll();

        return view('staffs.orders.detail', compact('order', 'statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderStatusRequest $request, $id)
    {
        $order = $this->orderRepo->find($id);

        if($order->order_status_id == config('orderstatus.delivered') || $order->order_status_id == config('orderstatus.cancelled')) {
            return redirect()->back()->with('error', __('cannot cancel'));
        } elseif ($request->status < $order->order_status_id) {
            return redirect()->back()->with('error', __('cannot update order status'));
        }

        DB::transaction(function() use($order, $request) {
            $order->update([
                'order_status_id' => $request->status
            ]);

            if ($request->status == config('orderstatus.cancelled')) {
                foreach($order->products as $product) {
                    $size_id = $this->sizeRepo->getSize($product->pivot->size)->id;
                    $color_id = $this->colorRepo->getColor($product->pivot->color)->id;
    
                    $productInfor = $this->productInforRepo->getProductInfor($product->id, $color_id, $size_id);
                    $productInfor->quantity += $product->pivot->quantity;
                    $productInfor->update();
                }
            }
        });

        return redirect()->back()->with('success', __('update success', ['attr' => __('order')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
