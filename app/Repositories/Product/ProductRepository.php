<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductRepository implements ProductRepositoryInterface
{
    private Product $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getAllProduct()
    {
        return $this->product->paginate(10);
    }

    public function getProduct($id)
    {
        return $this->product->where('product_id', $id)->get();
    }
}
