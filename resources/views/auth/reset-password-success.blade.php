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
<div class="container">
    <div class="d-flex justify-content-center align-items-center">
        @if(Storage::disk('public')->exists($systemSetting->logo))
            <img class="row system-logo" src="{{ asset('storage/') . $systemSetting->logo }}" alt="SeaJell Logo" style="height: 10em; width: 10em;">
        @else
            <img class="row system-logo" src="{{ asset('/storage/logo/SeaJell-Logo.png') }}" alt="SeaJell Logo" style="height: 10em; width: 10em;">
        @endif
    </div>
    <p class="fw-bold fs-1 text-center mb-1 text-light">
        @if(!empty($systemSetting->name))
            {{ strtoupper($systemSetting->name) }}
        @else
            {{ 'SeaJell' }}
        @endif
    </p>

    <p class="text-center mb-5 text-light fs-3">{{ trans('password_reset/reset_password_success.reset_password') }}</p>

    <div class="col-4 mx-auto bg-light p-4 rounded">
        <div class="alert alert-success">{{ trans('password_reset/reset_password_success.password_reset_success') }}!</div>
        <a href="{{ route('login') }}" class="btn btn-dark"><i class="bi bi-arrow-return-left"></i> {{ trans('password_reset/reset_password_success.return_login_page') }}</a>
    </div>
</div>
</div>
@endsection
