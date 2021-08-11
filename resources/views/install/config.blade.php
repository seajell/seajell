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

@extends('install.layout')
@section('page') Konfigurasi Sistem @endsection
@section('content')
<div class="container d-flex flex-column h-auto align-items-center bg-dark my-5 text-light rounded-3 shadow-lg">
    <h1 class="mt-5">Skrip Instalasi Sistem - {{ env('APP_NAME') }}</h1>
    <h2>Konfigurasi</h2>
    <hr class="border-light w-100 border-4">
    <div class="form-list w-50 mb-5 d-flex flex-column justify-content-around">
        <form action="{{ route('install.config') }}" method="POST">
            {{-- Admin account 
            Username: admin (Default: User cannot choose)
            Password: (User could choose)
            --}}
            @csrf
            <h3 class="mt-2">Akaun Admin</h3>
            <div class="form-floating mb-3 mt-3">
                <input type="text" class="form-control" name="adminFullName" id="adminFullname" placeholder="" value="{{ old('adminFullName') }}">
                <label class="text-dark" for="adminFullName">Nama Penuh</label>
            </div>
            @error('adminFullName')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="adminEmailAddress" id="adminEmailAddress" placeholder="" value="{{ old('adminEmailAddress') }}">
                <label class="text-dark" for="adminEmailAddress">Alamat Emel</label>
            </div>
            @error('adminEmailAddress')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="" value="{{ old('password') }}">
                <label class="text-dark" for="password">Kata Laluan</label>
            </div>
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="">
                <label class="text-dark" for="password_confirmation">Sahkan Kata Laluan</label>
            </div>
            <button type="submit" class="btn w-50 my-5 hvr-shrink btn-outline-light fs-4">Pasang <i class="bi bi-gear"></i></button>
        </form>
    </div>
</div>
@endsection