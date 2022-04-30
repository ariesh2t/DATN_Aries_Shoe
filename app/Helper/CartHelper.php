<?php

namespace App\Helper;

class CartHelper
{
    public $items = [];
    public $total_quantity = 0;
    public $total_price = 0;

    public function __construct()
    {
        $this->items = session('cart') ? session('cart') : [];
        $this->total_quantity = $this->getTotalQuantity();
        $this->total_price = $this->getTotalPrice();
    }

    public function add($product, $productInfor, $quantityRequest)
    {
        $item = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->images->first()->name,
            'brand' => $product->brand->name,
            'category' => $product->category->name,
            'color_id' => $productInfor->color->id,
            'color' => $productInfor->color->color,
            'size_id' => $productInfor->size->id,
            'size' => $productInfor->size->size,
            'quantity' => $quantityRequest,
        ];

        if (isset($this->items[$productInfor->id])) {
            $this->items[$productInfor->id]['quantity'] += $quantityRequest;
            if ($this->items[$productInfor->id]['quantity'] > $productInfor->quantity) {
                $this->items[$productInfor->id]['quantity'] = $productInfor->quantity;
            }
        } else {
            $this->items[$productInfor->id] = $item;
        }

        session(['cart' => $this->items]);
    }

    public function remove($id)
    {
        if (isset($this->items[$id])) {
            unset($this->items[$id]);
        }

        session(['cart' => $this->items]);
    }

    public function update($id, $quantity, $quantityRequest)
    {
        if (isset($this->items[$id])) {
            $this->items[$id]['quantity'] = $quantityRequest;
            if ($this->items[$id]['quantity'] > $quantity) {
                $this->items[$id]['quantity'] = $quantity;
            }
        }

        session(['cart' => $this->items]);
    }
    
    public function clear()
    {
        session(['cart' => '']);
    }

    private function getTotalPrice()
    {
        $tprice = 0;

        foreach ($this->items as $item) {
            $tprice += $item['price'] * $item['quantity'];
        }

        return $tprice;
    }

    private function getTotalQuantity()
    {
        $tquantity = 0;

        foreach ($this->items as $item) {
            $tquantity += $item['quantity'];
        }
        
        return $tquantity;
    }
}
