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
        return $this->model->with('images', 'comments')->where('category_id', $id)->take(4)->get();
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

        return $products->paginate(config('paginate.pagination.list_8'));
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

        return $products->paginate(config('paginate.pagination.list_8'));
    }
    
    public function getMinMax($condition, $key)
    {
        if ($condition == 'min') {
            return $this->model->min($key);
        } else {
            return $this->model->max($key);
        }
    }

    public function getAllWithSearch($request) {
        $products = $this->model->orderBy('updated_at', 'desc');
        if ($request->min_value) {
            $products->whereBetween('promotion', [$request->min_value, $request->max_value]);

            if ($request->list_size) {
                $products->whereHas('productInfors', function ($query) use($request) {
                    $query->whereIn('size_id', $request->list_size);
                });
            }

            if ($request->list_brand) {
                $products->whereIn('brand_id', $request->list_brand);
            }

            if ($request->list_category) {
                $products->whereIn('category_id', $request->list_category);
            }
        }

        if ($request->name_value) {
            $products->where('name', 'like', '%'.$request->name_value.'%');
        }

        return $products->paginate(config('paginate.pagination.list_12'));
    }


    public function getQuantity($attr)
    {
        $totalQuantity = 0;
        $product = $this->model->find($attr['id']);

        if(array_key_exists('color_id', $attr) && array_key_exists('size_id', $attr)) {
            if (!empty($attr['color_id']) && !empty($attr['size_id'])) {
                $callback = function($query) use($attr) {
                    $query->where('color_id', $attr['color_id'])
                    ->where('product_id', $attr['id'])
                    ->where('size_id', $attr['size_id']);
                };
                $product = $product->whereHas('productInfors', $callback)->with(['productInfors' => $callback])->first();
            } elseif (empty($attr['size_id'])) {
                $callback = function($query) use($attr) {
                    $query->where('color_id', $attr['color_id'])
                    ->where('product_id', $attr['id']);
                };
                $product = $product->whereHas('productInfors', $callback)->with(['productInfors' => $callback])->first();
            } elseif (empty($attr['color_id'])) {
                $callback = function($query) use($attr) {
                    $query->where('size_id', $attr['size_id'])
                    ->where('product_id', $attr['id']);
                };
                $product = $product->whereHas('productInfors', $callback)->with(['productInfors' => $callback])->first();
            }
        }
        if ($product) {
            foreach ($product->productInfors as $infor) {
                $totalQuantity += $infor->quantity;
            }
        }

        return $totalQuantity;
    }
    
    public function getRelatedProduct($brand_id, $category_id)
    {
        return $this->model->where('brand_id', $brand_id)
            ->orWhere('category_id', $category_id)
            ->take(8)
            ->get();
    }

    public function getNextProduct($product_id)
    {
        $product = $this->model->where('id', '>', $product_id)->first();

        if (!$product) {
            return $this->model->first();
        }
        return $product;
    }

    public function getPreviousProduct($product_id)
    {
        $product = $this->model->where('id', '<', $product_id)->orderBy('id', 'desc')->first();

        if (!$product) {
            return $this->model->orderBy('id', 'desc')->first();
        }
        return $product;
    }

    public function getOrderDelivered($product_id) {
        return $this->model->with(['orders' => function ($query) {
            $query->where('order_status_id', config('orderstatus.delivered'));
        }])->findOrFail($product_id);
    }

    public function getProductByWhere($key, $where)
    {
        return $this->model->where($key, $where)->get();
    }
}
