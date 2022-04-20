<?php
namespace App\Repositories\ProductInfor;

use App\Repositories\RepositoryInterface;

interface ProductInforRepositoryInterface extends RepositoryInterface
{

    public function checkExist($product_id, $color_id, $size_id);
}
