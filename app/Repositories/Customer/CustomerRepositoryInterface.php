<?php

namespace App\Repositories\Customer;

interface CustomerRepositoryInterface
{
    public function getAllCustomer($requestAll);
    public function delete($requestAll);
    public function store($request);
    public function edit($id, $requestAll);
    public function getCustomer($requestAll);
}
