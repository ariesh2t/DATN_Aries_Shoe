<?php
namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Category::class;
    }

    public function get7Categories()
    {
        return  $this->model->withCount('products')->orderBy('products_count', 'desc')->take(7)->get();
    }
}
