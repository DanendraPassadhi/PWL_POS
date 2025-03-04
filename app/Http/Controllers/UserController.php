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
        $user = UserModel::create([
                'username' => 'manager55',
                'nama' => 'Manager55',
                'password' => Hash::make('12345'),
                'level_id' => 2
            ],
        );

        $user->username = 'manager56';

        $user->isDirty(); //true
        $user->isDirty('username'); //true
        $user->isDirty('nama'); //false
        $user->isDirty('nama', 'username'); //true
        
        $user->isClean(); //false
        $user->isClean('username'); //false
        $user->isClean('nama'); //true
        $user->isClean('nama', 'username'); //false
        
        $user->save();
        
        $user->isDirty(); //false
        $user->isClean(); //true
        dd($user->isDirty());

        return view('user', ['data' => $user]);
    }
}
