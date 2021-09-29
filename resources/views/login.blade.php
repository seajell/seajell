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

@extends('layout.auth')

@section('content')
<div class="container mt-5">
    <p class="fs-3 text-center text-white fw-bold mb-5">{{ strtoupper($systemSetting->name) }}</p>

    <div class="col-4 mx-auto bg-light p-4 rounded">
        <form action="" method="post">
            @csrf
            <div class="my-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control mb-3" id="username" name="username" placeholder="">
            </div>
            @error('username')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="mb-4">
                <label for="password" class="form-label">Kata Laluan</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="">
            </div>
            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <button class="btn btn-outline-dark mb-3" type="submit"><i class="bi bi-door-open"></i> Log
                Masuk</button>
        </form>
    </div>
</div>
</div>
@endsection