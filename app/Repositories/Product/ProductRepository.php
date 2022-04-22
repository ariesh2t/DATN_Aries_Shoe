<?php
namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Product::class;
    }

    public function get4ProductByCat($id)
    {
        return $this->model->with('images')->where('category_id', $id)->take(4)->get();
    }
}
