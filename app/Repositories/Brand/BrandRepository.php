<?php
namespace App\Repositories\Brand;

use App\Models\Brand;
use App\Repositories\BaseRepository;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Brand::class;
    }

    public function get4Brands()
    {
        return $this->model->take(4)->get();
    }
}
