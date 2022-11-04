<?php

namespace App\Repositories\Customer;

interface CustomerRepositoryInterface
{
    public function getAllCustomer($requestAll);
    public function store($request);
    public function edit($id, $request);
}
