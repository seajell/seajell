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
    <div class="row">
        <p class="fs-2">{{ trans('home/home.signature') }}</p>
        <p>{{ trans('home/home.signature_one') }}</p>
        <p>{{ trans('home/home.signature_two') }}</p>
        <p>{{ trans('home/home.signature_three') }}</p>
    </div>
    <div class="container text-center mb-3 d-flex flex-column align-items-center">
        <div id="signature-pad-wrapper">
            <canvas id="signature-pad"></canvas>
        </div>
        <div class="row my-3 w-100" style="height: 10vh;">
            <div class="col-12 w-100 h-100 d-flex justify-content-around align-items-center ">
                <button type="button" id="signature-pad-clear" class="btn btn-outline-light w-25"><i class="bi bi-eraser"></i> {{ trans('home/home.signature_clean_pad') }}</button>
                <button type="button" id="signature-pad-undo" class="btn btn-outline-light w-25"><i class="bi bi-arrow-counterclockwise"></i> {{ trans('home/home.signature_undo_pad') }}</button>
                <button type="button" id="signature-pad-save" class="btn btn-outline-light w-25"><i class="bi bi-download"></i> {{ trans('home/home.signature_download_pad') }}</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/signature.js') }}"></script>
@endsection
