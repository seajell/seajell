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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('bootstraps-icons/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('/storage/logo/SeaJell-Logo.png') }}" type="image/png">
    <title>SeaJell</title>
</head>
<body class="min-vh-100">
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center vh-100">
        <img class="row mb-3" src="{{ asset('/storage/logo/SeaJell-Logo.png') }}" alt="SeaJell Logo" style="height: 7em; width: 7em;">
        <div class="row w-100 mb-3">
            <div class="col-4 rounded-start d-flex flex-column align-items-center justify-content-center bg-dark text-light border border-dark border-2">
                <p class="fw-bold fs-1">SeaJell</p>
                <p class="fw-normal fs-4">Log Masuk</p>
            </div>
            <div class="col-8 rounded-end bg-light text-dark border border-dark border-2">
                <form action="" method="post">
                    @csrf
                    <div class="my-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="">
                    </div>
                    @error('username')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="my-3">
                        <label for="password" class="form-label">Kata Laluan</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="">
                    </div>
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <button class="btn btn-dark mb-3" type="submit">Log Masuk</button>
                </form>
            </div>
        </div>
        <div class="row text-center">
            <p>Sistem <a class="text-decoration-underline text-dark" href="https://github.hanisirfan.xyz/seajell" target="_blank">SeaJell</a> {{ $appVersion }}</p>
            <p>Hak Cipta &copy; <a href="http://hanisirfan.xyz">Muhammad Hanis Irfan bin Mohd Zaid</a> 2021</p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>
</html>