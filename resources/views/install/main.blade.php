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
@section('page') Laman Utama @endsection
@section('content')
<div class="container d-flex flex-column h-auto align-items-center bg-dark my-5 text-light rounded-3 shadow-lg">
    <h1 class="mt-5">System Installation Script - {{ env('APP_NAME') }}</h1>
    <hr class="border-light w-100 border-4">
    <p class="fs-4">
        Make sure you have fulfilled all the requirements before proceeding.
    </p>
    <p class="fs-4">
        This script will add a new <span class="fw-bold">admin</span> user and run the database migration.
    </p>
    <a href="{{ route('install.config') }}" class="btn w-50 my-5 hvr-shrink btn-outline-light fs-4"><i class="bi bi-box-arrow-right"></i> Proceed</a>
</div>
@endsection
