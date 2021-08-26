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

@extends('errors.layout')
@section('title')
    Error 503
@endsection
@section('content')
    <div class="row d-flex justify-content-center align-items-center">
        <img src="{{ asset('storage/errors/503/503-SeaJell.svg') }}" class="img-fluid" alt="Error Image" style="width: 85vw;">
    </div>
    <div class="row d-flex justify-content-center align-items-center mt-3 mb-5">
        <h2 class="text-center text-light mb-5">{{ $exception->getMessage() }}</h2>
        <a href="{{ route('home') }}" class="btn btn-light text-center w-50 mb-5"><i class="bi bi-house"></i> Kembali Ke Laman Utama</a>
    </div>
@endsection