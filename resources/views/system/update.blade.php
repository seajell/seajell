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

@php
    if(!empty(old('system-name'))){
        $systemNameValue = strtoupper(old('system-name'));
    }elseif(!empty($systemSetting->name)){
        $systemNameValue = strtoupper($systemSetting->name);
    }
@endphp

@extends('layout.main')
@section('content')
    <p class="fs-2">Tetapan Sistem</p>
    @if(session()->has('systemSettingSuccess'))
        <span><div class="alert alert-success w-100 ml-1">{{ session('systemSettingSuccess') }}</div></span>
    @endif
    <form action="" method="post" class="mb-3" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="system-name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="system-name" name="system-name" aria-describedby="systemNameHelp" value="{{ $systemNameValue }}">
            <div id="systemNameHelp" class="form-text">Nama ini akan digunakan pada bar navigasi dan tajuk laman.</div>
        </div>
        @error('system-name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label for="system-language" class="form-label">Bahasa</label>
        <select class="form-select mb-3" aria-label="System language" name="system-language" id="system-language">
            <option selected value="en">English</option>
            <option value="ms-MY">Malay</option>
        </select>
        @error('system-language')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <img src="{{ asset('storage/') . $systemSetting->logo }}" alt="" class="img img-thumbnail my-3">
        <div class="mb-3">
            <label for="system-logo" class="form-label">Logo</label>
            <input class="form-control" type="file" id="system-logo" name="system-logo">
            <div id="systemLogoHelp" class="form-text">Logo ini akan digunakan pada bar navigasi dan favicon.</div>
        </div>
        @error('system-logo')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button class="btn btn-outline-light" type="submit">Kemas Kini</button>
    </form>
@endsection