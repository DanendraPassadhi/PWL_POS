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
        $user = UserModel::where('level_id', '2')->count();
        dd($user);
        return view('user', ['data' => $user]);
    }
}
