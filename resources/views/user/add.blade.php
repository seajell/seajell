@extends('layout.main')
@section('content')
    <p class="fs-2">Tambah Pengguna</p>
    @if(session()->has('addUserSuccess'))
        <div class="alert alert-success w-75 ml-1">{{ session('addUserSuccess') }}</div>
    @endif
    @error('userExisted')
        <div class="alert alert-danger w-75 ml-1">{{ $message }}</div>
    @enderror
    <form action="" method="post" class="mb-3">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Username Pengguna</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username pengguna." value="{{ old('username') }}">
            <div id="identification_number_help" class="form-text">
                Username ini digunakan untuk pengguna log masuk.
            </div>
        </div>
        @error('username')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="fullname" class="form-label">Nama Penuh Pengguna</label>
            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Masukkan nama penuh pengguna." value="{{ old('fullname') }}">
        </div>
        @error('fullname')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="email" class="form-label">Alamat E-mel</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan alamat e-mel pengguna." value="{{ old('email') }}">
        </div>
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="password" class="form-label">Kata Laluan</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan kata laluan pengguna.">
        </div>
        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="password_confirmation " class="form-label">Sahkan Kata Laluan</label>
            <input type="password" class="form-control" id="password_confirmation " name="password_confirmation" placeholder="Masukkan kata laluan pengguna semula.">
        </div>
        <div class="mb-3">
            <label for="identification_number " class="form-label">Nombor Kad Pengenalan</label>
            <input type="text" class="form-control" id="identification_number " name="identification_number" placeholder="Masukkan nombor kad pengenalan pengguna." value="{{ old('identification_number') }}">
            <div id="identification_number_help" class="form-text">
                Nombor kad pengenalan mestilah diisi tanpa "-". <br>
                Contoh: 012345-67-8901
            </div>
        </div>
        @error('identification_number')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label for="role" class="form-label">Peranan Pengguna</label>
        <select class="form-select mb-3" name="role" id="role" aria-label="role">
            <option value="participant">Peserta</option>
            <option value="admin">Admin</option>
        </select>
        @error('role')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button class="btn btn-dark" type="submit">Cipta Akaun Pengguna</button>
    </form>
@endsection