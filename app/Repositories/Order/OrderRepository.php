<?php
namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Order::class;
    }

    public function getAll()
    {
        return $this->model
            ->orderBy('order_status_id', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getOrderByUserId($user_id) {
        return $this->model
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(config('paginate.pagination.list_12'));
    }

    public function getOrderDetail($user_id, $order_id)
    {
        return $this->model->where('user_id', $user_id)
            ->with('products', 'orderStatus')
            ->find($order_id);
    }

    public function getBetweenDay($start, $end) {
        return $this->model->whereBetween('updated_at', [$start, $end])
            ->where('order_status_id', config('orderstatus.delivered'))
            ->get();
    }

    public function getNewOrderOnWeek($start)
    {
        return $this->model->where('created_at', '>', $start)->count();
    }

    public function getWeekRevenue($start, $end)
    {
        $orders = $this->model->whereBetween('updated_at', [$start, $end])
            ->where('order_status_id', config('orderstatus.delivered'))
            ->get();
        $revenue = 0;
        foreach ($orders as $order) {
            $revenue += $order->total_price;
        }

        return $revenue;
    }

    public function getMonthRevenue($start, $end)
    {
        $orders = $this->model->whereBetween('updated_at', [$start, $end])
            ->where('order_status_id', config('orderstatus.delivered'))
            ->get();
        $revenue = 0;
        foreach ($orders as $order) {
            $revenue += $order->total_price;
        }

        return $revenue;
    }
}
