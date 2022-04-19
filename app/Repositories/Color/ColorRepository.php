<?php
namespace App\Repositories\Color;

use App\Models\Color;
use App\Repositories\BaseRepository;

class ColorRepository extends BaseRepository implements ColorRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Color::class;
    }
}
