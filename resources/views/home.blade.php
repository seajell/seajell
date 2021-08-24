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
    <div class="container text-center">
        <div class="row">
            <p class="fs-2">Navigasi</p>
        </div>
        <div class="row mb-3">
            <div class="col">
                <a href="{{ route('certificate.list') }}" class="fs-4 btn btn-outline-light"><i class="bi bi-patch-check"></i> Sijil</a>
            </div>
            <div class="col">
                <a href="{{ route('signature') }}" class="fs-4 btn btn-outline-light"><i class="bi bi-pen"></i> Tandatangan</a>
            </div>
        </div>
    </div>
@endsection