<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class StaffController extends Controller
{
    protected $userRepo;
    protected $orderRepo;
    protected $productRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
        ProductRepositoryInterface $productRepo,
        OrderRepositoryInterface $orderRepo
    ) {
        $this->userRepo = $userRepo;
        $this->productRepo = $productRepo;
        $this->orderRepo = $orderRepo;
    }

    public function index()
    {
        $dt = new Carbon();
        $startWeek = $dt->startOfWeek()->toDateTimeString();
        $endWeek = $dt->endOfWeek()->toDateTimeString();
        $ordersWeek = $this->orderRepo->getBetweenDay($startWeek, $endWeek);
        $revenueWeek = [
            'Mon' => 0,
            'Tue' => 0,
            'Wed' => 0,
            'Thu' => 0,
            'Fri' => 0,
            'Sat' => 0,
            'Sun' => 0,
        ];
        foreach($ordersWeek as $order) {
            $key = $order->updated_at->format('D');
            if (array_key_exists($key, $revenueWeek)) {
                $revenueWeek[$key] += $order->total_price;
            }
        }
        [$keys_week, $values_week] = Arr::divide($revenueWeek);

        $startYear = $dt->startOfYear()->toDateTimeString();
        $endYear = $dt->endOfYear()->toDateTimeString();
        $ordersYear = $this->orderRepo->getBetweenDay($startYear, $endYear);
        $revenueYear = [
            'Jan' => 0,
            'Feb' => 0,
            'Mar' => 0,
            'Apr' => 0,
            'May' => 0,
            'Jun' => 0,
            'Jul' => 0,
            'Aug' => 0,
            'Sep' => 0,
            'Oct' => 0,
            'Nov' => 0,
            'Dec' => 0,
        ];
        foreach($ordersYear as $order) {
            $key = $order->updated_at->format('M');
            if (array_key_exists($key, $revenueYear)) {
                $revenueYear[$key] += $order->total_price;
            }
        }
        [$keys_year, $values_year] = Arr::divide($revenueYear);
        
        return view('staffs.dashboard', compact('keys_week', 'values_week', 'keys_year', 'values_year'));
    }
}
