<?php
namespace App\Repositories\Size;

use App\Models\Size;
use App\Repositories\BaseRepository;

class SizeRepository extends BaseRepository implements SizeRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Size::class;
    }

    public function getAll()
    {
        return $this->model->orderBy('size', 'asc')->get();
    }
}
