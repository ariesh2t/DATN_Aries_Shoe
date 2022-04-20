<?php
namespace App\Repositories\ProductInfor;

use App\Models\ProductInfor;
use App\Repositories\BaseRepository;

class ProductInforRepository extends BaseRepository implements ProductInforRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return ProductInfor::class;
    }

    public function checkExist($product_id, $color_id, $size_id)
    {
        return $this->model->whereColumn([
            ['product_id', '=', $product_id],
            ['color_id', '=', $color_id],
            ['size_id', '=', $size_id],
        ])->get();
    }
}
