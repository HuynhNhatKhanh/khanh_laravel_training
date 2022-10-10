<?php

namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function getAllProduct();
    public function getProduct($id);
}
