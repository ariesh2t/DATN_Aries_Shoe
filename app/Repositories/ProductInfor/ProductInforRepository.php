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

    public function getAllByProduct($product_id)
    {
        return $this->model->with('color', 'size')->where('product_id', $product_id)->get();
    }

    public function getDistinct($product_id, $key)
    {
        return $this->model->where('product_id', $product_id)->select($key)->distinct()->get();
    }
}
