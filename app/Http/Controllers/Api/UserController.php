<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;

class UserController extends Controller
{
    public function index()
    {
        return UserModel::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'nama' => 'required',
            'password' => 'required|min:5|confirmed',
            'level_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = new UserModel();
        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = bcrypt($request->password);
        $user->level_id = $request->level_id;
        $user->save();

        return response()->json($user, 201);
    }

    public function show(UserModel $user)
    {
        return $user;
    }

    public function update(Request $request, UserModel $user)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'sometimes|required|unique:m_user,username,' . $user->user_id . ',user_id',
            'nama' => 'sometimes|required',
            'password' => 'sometimes|required|min:5|confirmed',
            'level_id' => 'sometimes|required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $updateData = [];

        if ($request->has('username')) {
            $updateData['username'] = $request->username;
        }

        if ($request->has('nama')) {
            $updateData['nama'] = $request->nama;
        }

        if ($request->has('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        if ($request->has('level_id')) {
            $updateData['level_id'] = $request->level_id;
        }

        $user->update($updateData);

        return response()->json($user, 200);
    }

    public function destroy(UserModel $user)
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}
