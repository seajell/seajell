{{-- Copyright (c) 2021 Muhammad Hanis Irfan bin Mohd Zaid

This file is part of SeaJell.

SeaJell is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

SeaJell is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with SeaJell.  If not, see <https://www.gnu.org/licenses/>. --}}

@extends('layout.main')
@section('content')
    <p class="fs-2">Tambah Pengguna</p>
    @if(session()->has('addUserSuccess'))
        <span><div class="alert alert-success w-100 ml-1">{{ session('addUserSuccess') }}</div></span>
    @endif
    @error('userExisted')
        <span><div class="alert alert-danger w-100 ml-1">{{ $message }}</div></span>
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
                Contoh: 012345678901
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