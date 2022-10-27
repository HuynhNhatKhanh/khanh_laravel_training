<?php

namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function getAllProduct($requestAll);
    public function store($request);
    public function getProduct($request);
    public function delete($id);
}
