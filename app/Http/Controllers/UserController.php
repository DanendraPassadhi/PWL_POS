<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show($id, $name)
    {
        return view('users.profile', compact('id', 'name'));
    }

    public function index()
    {
        $user = UserModel::firstwhere('level_id', 1);
        return view('user', ['data' => $user]);
    }
}
