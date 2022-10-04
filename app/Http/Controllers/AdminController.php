<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\User;
use App\Http\Models\Role;

class AdminController extends Controller
{
    public function __construct(){

    }

    public function index(){
        return view('admin');
    }

    public function dashboard(){
        $users = Auth::user();
        return $users->role->name;
    }

}
