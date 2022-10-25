<?php

namespace App\Repositories\User;

use Carbon\Carbon;
use App\Models\User;
use Yajra\DataTables\DataTables;

class UserRepository implements UserRepositoryInterface
{
    private User $user;
    protected $now;
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->now = date_format(Carbon::now('Asia/Ho_Chi_Minh'), 'Y/m/d:H-i-s');
    }

    public function getAllUser($requestAll)
    {
        $query = $this->user;

        if ($request->load == 'index') {
            $query = $query->where("is_delete", '=', 0);
            $query = $query->orderBy('id', 'desc')->get();
            $results = $query;
        }
        if ($request->load == 'search') {
            $query = $query->where("name", "LIKE", '%' . $requestAll['name'] . '%')
                            ->where("email", "LIKE", '%' . $requestAll['email'] . '%');
            if (isset($requestAll['role']) && $requestAll['role'] != 'default') {
                $query->where("group_role", '=', $requestAll['role']);
            }
            if (isset($requestAll['status']) && $requestAll['status'] != 'default') {
                $query->where("is_active", '=', $requestAll['status']);
            }
            $results = $query;
        }

        return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn(
                    'action',
                    function ($results) {
                        $xhtml = '<td class="text-center ">';
                        $xhtml .= '<button type="button" value="'. $results->id .'" class="rounded-circle btn btn-sm btn-info m-1 editbtn-user " title="Chỉnh sửa" data-id="'. $results->id .'"><i class="fas fa-pencil-alt"></i></button>';
                        $xhtml .= '<button type="button" class="rounded-circle btn btn-sm btn-danger m-1 btn-delete-user "title="Xoá" data-id="'. $results->id .'" ><i class="fas fa-trash-alt"></i> </button>';
                        $xhtml .= '<button class="rounded-circle btn btn-sm btn-dark m-1 btn-block-user" title="Khoá/Mở thành viên" data-id="'. $results->id .'" data-status="'.$results->is_active.'"><i class="fas fa-user-times"></i></button> </td>';
                        return $xhtml;
                    }
                )
                ->editColumn(
                    'group_role',
                    function ($results) {
                        return ucfirst($results->group_role);
                    }
                )
                ->editColumn(
                    'is_active',
                    function ($results) {
                        $results->is_active === 1 ? $status = 'Đang hoạt động' : $status = 'Tạm khóa';
                        return $status;
                    }
                )
                ->rawColumns(['action'])
                ->make(true);
    }

    public function store($requestAll)
    {
        $dataCreate = [
            'name' => $requestAll['name'],
            'email' => $requestAll['email'],
            'password' => $requestAll['password'],
            'group_role' => $requestAll['group_role'],
            'is_active' => $requestAll['is_active'],
        ];
        return $this->user::create($dataCreate);
    }

    public function edit($id, $requestAll)
    {
        $dataUpdate = [
            'name' => $requestAll['name'],
            'email' => $requestAll['email'],
            'password' => $requestAll['password'],
            'group_role' => $requestAll['group_role'],
            'is_active' => $requestAll['is_active'],
        ];
        return $this->user::where('id', $id)->update($dataUpdate);
    }

    public function delete($requestAll)
    {
        $requestAll['delete'] = ($requestAll['delete'] == 1) ? 0 : 1;
        return $this->user->where('id', $requestAll['id'])->update(['is_delete' => $requestAll['delete']]);
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
        return $this->user->where('id', $requestAll['id'])->first();
    }

    public function login($request)
    {
        return $this->user->where('email', $request->email)
                            ->update([
                                'last_login_at' => $this->now,
                                'last_login_ip' => $request->ip(),
                            ]);
    }
}
