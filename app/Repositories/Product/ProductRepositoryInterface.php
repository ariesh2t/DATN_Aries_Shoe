<?php
namespace App\Repositories\Product;

use App\Repositories\RepositoryInterface;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function get4ProductByCat($id);

    public function getAllByBrand($brand_id, $request);

    public function getAllByCategory($category_id, $request);

    public function getMinMax($condition, $key);

    public function getAllWithSearch($request);

    public function getQuantity($attr);

    public function getRelatedProduct($brand_id, $category_id);
}
