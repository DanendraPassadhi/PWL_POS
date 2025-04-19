<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) { // jika sudah login, maka redirect ke halaman home
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }

        return redirect('login');
    }

    public function register()
    {
        $level = LevelModel::select('level_id', 'level_kode', 'level_nama')->get();

        return view('auth.register', compact('level'));
    }

    public function postRegister(Request $request)
    {
        $rules = [
            'level_id' => 'required|integer',
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama'     => 'required|string|max:100',
            'password' => 'required|min:6|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        $user = new UserModel();
        $user->level_id = $request->level_id;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->nama = $request->nama;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Registrasi Berhasil. Silakan login.',
            'redirect' => url('login')
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function profile()
    {
        $user = Auth::user();
        $activeMenu = 'profile';

        $breadcrumb = (object) [
            'title' => 'Profil Pengguna',
            'list'  => ['Home', 'Profil']
        ];

        return view('profile.index', compact('user', 'activeMenu', 'breadcrumb'))->with([
            'status' => true,
            'data' => $user
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'username' => 'required|string|min:3|unique:m_user,username,' . $user->user_id . ',user_id',
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:6|confirmed',
            'profile_picture' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->username = $request->username;
        $user->nama = $request->nama;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && Storage::disk('public')->exists('profile/' . $user->profile_picture)) {
                Storage::disk('public')->delete('profile/' . $user->profile_picture);
            }
            
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/profile', $filename);
            $user->profile_picture = basename($path);
        }

        /** @var \App\Models\User $user **/
        $user->save();

        return redirect()->route('profile')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
