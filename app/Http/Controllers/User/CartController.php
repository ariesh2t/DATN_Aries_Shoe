<?php

namespace App\Http\Controllers\User;

use App\Helper\CartHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Color\ColorRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $productRepo;
    protected $sizeRepo;
    protected $colorRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        ColorRepositoryInterface $colorRepo,
        SizeRepositoryInterface $sizeRepo
    ) {
        $this->productRepo = $productRepo;
        $this->colorRepo = $colorRepo;
        $this->sizeRepo = $sizeRepo;
    }
    
    public function index()
    {
        $product = $this->productRepo;

        return view('customers.orders.cart', compact('product'));
    }

    public function add(Request $request, CartHelper $cart, $id)
    {
        $request->validate([
            'size_id' => ['required', 'numeric', 'exists:sizes,id'],
            'color_id' => ['required', 'numeric', 'exists:colors,id'],
            'quantity' => ['required', 'numeric', 'min:1'],
        ], [
            'size_id.required' => __('not select', ['attr' => __('size')]),
            'size_id.numeric' => __('numeric', ['attr' => __('size')]),
            'size_id.exists' => __('exists', ['attr' => __('size')]),
            'color_id.required' => __('not select', ['attr' => __('color')]),
            'color_id.numeric' => __('numeric', ['attr' => __('color')]),
            'color_id.exists' => __('exists', ['attr' => __('color')]),
            'quantity.required' => __('required', ['attr' => __('quantity')]),
            'quantity.numeric' => __('numeric', ['attr' => __('quantity')]),
            'quantity.min' => __('min numeric', ['attr' => __('quantity'), 'value' => 1]),
            
        ]);

        $product = $this->productRepo->find($id);
        $color = $this->colorRepo->find($request->color_id);
        $size = $this->sizeRepo->find($request->size_id);
        $quantity = $this->productRepo->getQuantity([
            'id' => $product->id,
            'color_id' => $color->id,
            'size_id' => $size->id,
        ]);

        if ($quantity < 1) {
            return redirect()->back()->with('error', __('add cart fail'));
        } else {
            $cart->add($product, $quantity, $color, $size, $request->quantity);
    
            return redirect()->back();
        }
    }

    public function remove(CartHelper $cart, $id)
    {
        $cart->remove($id);

        return redirect()->back();
    }

    public function update(CartHelper $cart, $id)
    {
        $quantityRequest = request()->quantity;

        $product = $cart->getProductById($id);

        $quantity = $this->productRepo->getQuantity([
            'id' => $id,
            'color_id', $product['color_id'],
            'size_id', $product['size_id'],
        ]);

        if (is_numeric($quantityRequest)) {
            $cart->update($id, $quantity, $quantityRequest);

            return redirect()->back();
        } else {
            return redirect()->back()->with('error', __('numeric', ['attr' => __('quantity') ]));
        }
    }

    public function clear(CartHelper $cart)
    {
        $cart->clear();

        return redirect()->back();
    }
}
