<?php

namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function getAllProduct($requestAll);
    public function getProduct($id);
    public function delete($id);
}
