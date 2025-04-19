@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Profil Pengguna</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form action="{{ url('profile/update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="profile_picture">Foto Profil</label>
                    <div class="mb-3">
                        <img id="profile_preview"
                            src="{{ Storage::disk('public')->exists('profile/' . $user->profile_picture) ? asset('storage/profile/' . $user->profile_picture) : asset('profile.png') }}"
                            class="img-thumbnail" alt="User Image" style="width: 150px; height: 150px; object-fit: cover">
                    </div>

                    <input type="file" class="form-control-file @error('profile_picture') is-invalid @enderror"
                        id="profile_picture" name="profile_picture" accept="image/jpeg, image/png">
                    @error('profile_picture')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
                    @error('username')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $user->nama }}">
                    @error('nama')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" class="form-control" id="password" name="password">
                    @error('password')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    @error('password_confirmation')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('profile_picture').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                document.getElementById('profile_preview').src = URL.createObjectURL(file);
            }
        });
    </script>
@endsection
