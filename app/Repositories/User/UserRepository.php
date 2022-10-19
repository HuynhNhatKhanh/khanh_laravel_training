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
        // return Datatables::of($data)
        //         ->addIndexColumn()
        //         ->addColumn(
        //             'action',
        //             function ($data) {
        //                 $btn = '<button type="button" value="" class="rounded-circle btn btn-sm btn-info editbtn"
        //                 title="Chỉnh sửa">
        //                     <i class="fas fa-pencil-alt"></i>
        //                     </button>';
        //                 $btn .= '<a href="}" class="rounded-circle btn btn-sm btn-danger btn-delete"
        //                     title="Xoá">
        //                     <i class="fas fa-trash-alt"></i>
        //                 </a>';
        //                 $btn .= '<a href="" class="rounded-circle btn btn-sm btn-dark"
        //                     title="Khoá thành viên">
        //                     <i class="fas fa-user-times"></i>
        //                 </a>';
        //                 return $btn;
        //             }
        //         )
        //         ->editColumn(
        //             'is_active',
        //             function ($data) {
        //                 $data->is_active === 1 ? $status = 'Đang hoạt động' : $status = 'Tạm khóa';
        //                 return $status;
        //             }
        //         )
        //         ->rawColumns(['action'])
        //         ->make(true);
    }

    // public function getProduct($id)
    // {
    //     return $this->product->where('product_id', $id)->get();
    // }

    public function delete($id)
    {
        return $this->user->where('id', $id)->delete();
    }

    public function status($requestAll)
    {
        $requestAll['is_active'] = ($requestAll['is_active'] === 1) ? 0 : 1;
        return $this->user->where('id', $id)->update($requestAll);
    }

    public function search($requestAll)
    {
        return $this->user->where("name", "LIKE", '%' . $requestAll['name'] . '%')
                            ->where("email", "LIKE", '%' . $requestAll['email'] . '%')
                            ->paginate(20);
    }
    // public function store($request)
    // {
    //     // return this->product->save
    // }
}