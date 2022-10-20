<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function getAllUser($requestAll);
    public function delete($requestAll);
    public function status($requestAll);
    public function search($requestAll);
    public function getUser($requestAll);
}
