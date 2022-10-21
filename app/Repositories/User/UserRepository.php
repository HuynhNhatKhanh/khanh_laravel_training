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
        $query = $query->where("is_delete", '=', 0);
        $query = $query->orderBy('id', 'desc');
        return $query->paginate(20);
    }

    public function store($requestAll)
    {
        return $this->user::create($requestAll);
    }

    public function edit($id, $requestAll)
    {
        // name: name,
        // email: email,
        // password: password,
        // password_confirm: passwordConfirm,
        // group_role: role,
        // is_active: status,

        unset($requestAll['password_confirm']);
        // $dataUpdate = [
        //     'name' => $requestAll['name'];
        // ]
        return $this->user::where('id', $id)->update($requestAll);
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
}
