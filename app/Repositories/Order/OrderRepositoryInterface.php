<?php
namespace App\Repositories\Order;

use App\Repositories\RepositoryInterface;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getOrderByUserId($user_id);
    public function getOrderDetail($user_id, $order_id);
}
