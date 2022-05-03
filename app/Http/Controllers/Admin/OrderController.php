<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderStatusRequest;
use App\Notifications\OrderNotification;
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
use Illuminate\Support\Facades\Notification;

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

        return view('admins.orders.index', compact('orders'));
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

        return view('admins.orders.detail', compact('order', 'statuses'));
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
        } elseif ($request->status == $order->order_status_id) {
            return redirect()->back();
        }elseif ($request->status < $order->order_status_id) {
            return redirect()->back()->with('error', __('cannot update order status'));
        }

        DB::transaction(function() use($order, $request) {
            if ($request->status == config('orderstatus.cancelled')) {
                $order->update([
                    'order_status_id' => $request->status,
                    'reason' => "having a problem",
                ]);
                foreach($order->products as $product) {
                    $size_id = $this->sizeRepo->getSize($product->pivot->size)->id;
                    $color_id = $this->colorRepo->getColor($product->pivot->color)->id;
    
                    $productInfor = $this->productInforRepo->getProductInfor($product->id, $color_id, $size_id);
                    $productInfor->quantity += $product->pivot->quantity;
                    $productInfor->update();
                }
            } else {
                $order->update([
                    'order_status_id' => $request->status
                ]);
            }
        });
        switch ($request->status) {
            case config('orderstatus.preparing'):
                $data = [
                    'order_id' => $order->id,
                    'title' => 'admin preparing order title',
                    'content' => 'admin preparing order content',
                ];
                break;
            case config('orderstatus.shipping'):
                $data = [
                    'order_id' => $order->id,
                    'title' => 'admin shipping order title',
                    'content' => 'admin shipping order content',
                ];
                break;
            case config('orderstatus.delivered'):
                $data = [
                    'order_id' => $order->id,
                    'title' => 'admin delivered order title',
                    'content' => 'admin delivered order content',
                ];
                break;
            case config('orderstatus.cancelled'):
                $data = [
                    'order_id' => $order->id,
                    'title' => 'admin title cancelled order',
                    'content' => 'admin content cancelled order',
                ];
                break;
            default:
                break;
        }

        Notification::send($this->userRepo->find($order->user_id), new OrderNotification($data));

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
