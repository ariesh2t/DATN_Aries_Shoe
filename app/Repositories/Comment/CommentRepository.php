<?php
namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\BaseRepository;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Comment::class;
    }

    public function getTotalByStar($star, $product_id)
    {
        return $this->model->where('rating', $star)
            ->where('product_id', $product_id)
            ->count();
    }
}
