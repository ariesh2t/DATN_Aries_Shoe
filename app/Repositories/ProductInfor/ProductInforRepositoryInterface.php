<?php
namespace App\Repositories\ProductInfor;

use App\Repositories\RepositoryInterface;

interface ProductInforRepositoryInterface extends RepositoryInterface
{
    public function getProductInfor($product_id, $color_id, $size_id);

    public function getAllByProduct($product_id);

    public function getDistinct($product_id, $key);
}
