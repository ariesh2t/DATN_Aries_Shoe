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

    public function getAllByBrand($brand_id, $request)
    {
        $products = $this->model->where('brand_id', $brand_id);
        if ($request->min_value) {
            $products->whereBetween('promotion', [$request->min_value, $request->max_value]);

            if ($request->list_size) {
                $products->whereHas('productInfors', function ($query) use($request) {
                    $query->whereIn('size_id', $request->list_size);
                });
            }
        }

        return $products->paginate(config('paginate.pagination'));
    }

    public function getAllByCategory($category_id, $request)
    {
        $products = $this->model->where('category_id', $category_id);
        if ($request->min_value) {
            $products->whereBetween('promotion', [$request->min_value, $request->max_value]);

            if ($request->list_size) {
                $products->whereHas('productInfors', function ($query) use($request) {
                    $query->whereIn('size_id', $request->list_size);
                });
            }
        }

        return $products->paginate(config('paginate.pagination'));
    }
    
    public function getMinMax($condition, $key)
    {
        if ($condition == 'min') {
            return $this->model->min($key);
        } else {
            return $this->model->max($key);
        }
    }
}
