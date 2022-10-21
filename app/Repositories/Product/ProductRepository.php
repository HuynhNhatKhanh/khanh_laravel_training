<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    private Product $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getAllProduct($requestAll)
    {
        $query = $this->product;

        $search = @$requestAll['search'];
        if (isset($search)) {
            $query = $query->where("product_name", "LIKE", '%' . $search . '%');
        }
        if (isset($requestAll['filter_status']) && $requestAll['filter_status'] != 'default') {
            $status = (int) ($requestAll['filter_status']);
            if ($status == 1) {
                $query = $query->where('ordering', '>', 0);
                $query = $query->where('is_sales', '=', 1);
            } elseif ($status == 2) {
                $query = $query->where('ordering', '=', 0);
                $query = $query->where('is_sales', '=', 1);
            } elseif ($status == 3) {
                $query = $query->where('ordering', '=', 0);
                $query = $query->where('is_sales', '=', 0);
            }
        }
        if (isset($requestAll['price_from']) || isset($requestAll['price_to'])) {
            if (empty($requestAll['price_from'])) {
                $query = $query->where('product_price', '>=', 0);
                $query = $query->where('product_price', '<=', $requestAll['price_to']);
            } elseif (empty($requestAll['price_to'])) {
                $query = $query->where('product_price', '>=', $requestAll['price_from']);
            } else {
                $query = $query->where('product_price', '>=', $requestAll['price_from']);
                $query = $query->where('product_price', '<=', $requestAll['price_to']);
            }
        }
        $query = $query->orderBy('updated_at', 'desc');
        return $query->paginate(20);
    }

    public function getProduct($id)
    {
        return $this->product->where('product_id', $id)->first();
    }

    public function delete($id)
    {
        return $this->product->where('product_id', $id)->delete();
    }

    public function store($request)
    {
        // return this->product->save
    }
}
