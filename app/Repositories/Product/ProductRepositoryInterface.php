<?php

namespace App\Repositories\Product;

use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function getAllProduct($requestAll);
    public function store(Request $request);
    public function edit($id, $request);
    public function getProduct($request);
    public function delete($id);
}
