<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;

class RoleController extends Controller
{
    public function show(){
        $roles = User::find(11)
        ->roles;
        return $roles;

        // $users = Role::find(1)
        // ->users;
        // return $users;
    }

}
