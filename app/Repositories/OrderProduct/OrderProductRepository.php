<?php
namespace App\Repositories\OrderProduct;

use App\Models\OrderProduct;
use App\Repositories\BaseRepository;

class OrderProductRepository extends BaseRepository implements OrderProductRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return OrderProduct::class;
    }

    public function checkExists($product_id, $color, $size) {
        return $this->model
            ->where('product_id', $product_id)
            ->where('color', $color)
            ->where('size', $size)
            ->count() > 0;
    }
}
