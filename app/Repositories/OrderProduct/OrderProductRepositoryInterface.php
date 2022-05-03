<?php
namespace App\Repositories\OrderProduct;

use App\Repositories\RepositoryInterface;

interface OrderProductRepositoryInterface extends RepositoryInterface
{
    public function checkExists($product_id, $color, $size);
}
