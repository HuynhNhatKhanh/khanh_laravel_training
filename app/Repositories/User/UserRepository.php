<?php

namespace App\Repositories\User;

use App\Models\User;
use Yajra\DataTables\DataTables;

class UserRepository implements UserRepositoryInterface
{
    private User $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAllUser($requestAll)
    {
        $query = $this->user;

        // $search = @$requestAll['search'];
        // if (isset($search)) {
        //     $query = $query->where("product_name", "LIKE", '%' . $search . '%');
        // }
        // if (isset($requestAll['filter_status']) && $requestAll['filter_status'] != 'default') {
        //     $status = (int) ($requestAll['filter_status']);
        //     if ($status == 1) {
        //         $query = $query->where('ordering', '>', 0);
        //         $query = $query->where('is_sales', '=', 1);
        //     } elseif ($status == 2) {
        //         $query = $query->where('ordering', '=', 0);
        //         $query = $query->where('is_sales', '=', 1);
        //     } elseif ($status == 3) {
        //         $query = $query->where('ordering', '=', 0);
        //         $query = $query->where('is_sales', '=', 0);
        //     }
        // }
        // if (isset($requestAll['price_from']) || isset($requestAll['price_to'])) {
        //     if (empty($requestAll['price_from'])) {
        //         $query = $query->where('product_price', '>=', 0);
        //         $query = $query->where('product_price', '<=', $requestAll['price_to']);
        //     } elseif (empty($requestAll['price_to'])) {
        //         $query = $query->where('product_price', '>=', $requestAll['price_from']);
        //     } else {
        //         $query = $query->where('product_price', '>=', $requestAll['price_from']);
        //         $query = $query->where('product_price', '<=', $requestAll['price_to']);
        //     }
        // }
        //$query = $query->orderBy('updated_at', 'desc');
        return $query->paginate(20);
    }

    // public function getProduct($id)
    // {
    //     return $this->product->where('product_id', $id)->get();
    // }

    public function delete($requestAll)
    {
        return $this->user->where('id', $requestAll['id'])->delete();
    }

    public function status($requestAll)
    {
        $requestAll['status'] = ($requestAll['status'] == 1) ? 0 : 1;
        return $this->user->where('id', $requestAll['id'])->update(['is_active' => $requestAll['status']]);
    }

    public function search($requestAll)
    {
        $querysearch = $this->user;
        $querysearch =$querysearch->where("name", "LIKE", '%' . $requestAll['name'] . '%')
                                ->where("email", "LIKE", '%' . $requestAll['email'] . '%');
        if (isset($requestAll['role']) && $requestAll['role'] != 'default') {
            $querysearch->where("group_role", '=', $requestAll['role']);
        }
        if (isset($requestAll['status']) && $requestAll['status'] != 'default') {
            $querysearch->where("is_active", '=', $requestAll['status']);
        }
        return $querysearch->paginate(20);
    }

    public function getUser($requestAll)
    {
        return $this->user->where('id', $requestAll['id'])->get();
    }
    // public function store($request)
    // {
    //     // return this->product->save
    // }
}
