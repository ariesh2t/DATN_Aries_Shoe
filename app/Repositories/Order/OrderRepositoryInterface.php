<?php
namespace App\Repositories\Order;

use App\Repositories\RepositoryInterface;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getOrderByUserId($user_id);
    public function getOrderDetail($user_id, $order_id);
    public function getBetweenDay($start, $end);
    public function getNewOrderOnWeek($start);
    public function getWeekRevenue($start, $end);
    public function getMonthRevenue($start, $end);
}
