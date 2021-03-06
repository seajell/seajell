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
    <p class="fs-2">Kemas Sijil</p>
    @if(session()->has('updateCertificateSuccess'))
        <span><div class="alert alert-success w-100 ml-1">{{ session('updateCertificateSuccess') }}</div></span>
    @endif
    @php
        
        if(old('event-id') != NULL){ 
            $valueEventID = old('event-id');
        }else{
            if($data != NULL && $data != ''){
                if($data->id != NULL && $data->id != ''){
                    $valueEventID = strtoupper($data->id);
                }else{
                    $valueEventID = "";
                }
            }else{
                $valueEventID = "";
            }
        }

        if(old('position') != NULL){ 
            $valuePosition = old('position');
        }else{
            if($data != NULL && $data != ''){
                if($data->position != NULL && $data->position != ''){
                    $valuePosition = strtoupper($data->position);
                }else{
                    $valuePosition = "";
                }
            }else{
                $valuePosition = "";
            }
        }

        if(old('category') != NULL){ 
            $valueCategory = old('category');
        }else{
            if($data != NULL && $data != ''){
                if($data->category != NULL && $data->category != ''){
                    $valueCategory = strtoupper($data->category);
                }else{
                    $valueCategory = "";
                }
            }else{
                $valueCategory = "";
            }
        }

    @endphp
    <form action="" method="post" class="mb-3">
        @csrf
        <div class="mb-3">
            <div class="row">
                <label for="event-id" class="form-label">ID Acara</label>   
            </div>
            <div class="row">
                <div class="col-11">
                    <input type="text" class="form-control w-100" id="event-id" name="event-id" placeholder="Masukkan ID acara." value="{{ $valueEventID }}">
                </div>
                <div class="col-1">
                    <button type="button" id="event-search" class="btn btn-outline-light w-100"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>
        @error('event-id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="my-1" id="event-search-status">
        </div>
        <div class="mb-3 border border-dark border-3">
            <div class="row my-1 mx-1">
                <p class="fw-bold">Nama: <span class="fw-normal" id="event-name-text"></span></p>
                <p class="fw-bold">Tarikh: <span class="fw-normal" id="event-date-text"></span></p>
                <p class="fw-bold">Lokasi: <span class="fw-normal" id="event-location-text"></span></p>
                <p class="fw-bold">Nama Penganjur: <span class="fw-normal" id="event-organiser-name-text"></span></p>
                <p class="fw-bold">Nama Institusi: <span class="fw-normal" id="event-institute-name-text"></span></p>
                <p class="fw-bold">Keterlihatan: <span class="fw-normal" id="event-visibility-text"></span></p>
            </div>
        </div>
        <label class="form-label mt-1">Jenis Sijil (Pilih Satu)</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="certificate-type" id="certificate-type" value="participation" checked>
            <label class="form-check-label" for="certificate-type">
              Penyertaan
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="certificate-type" id="certificate-type" value="achievement" >
            <label class="form-check-label" for="certificate-type">
              Pencapaian
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="certificate-type" id="certificate-type" value="appreciation" >
            <label class="form-check-label" for="certificate-type">
              Penghargaan
            </label>
        </div>
        <div id="certification_type_help mb-3" class="form-text">
            Penyertaan: Untuk penyertaan sesuatu acara. <br>
            Pencapaian: Jika seseorang mendapat sebarang pencapaian. Contoh: Tempat pertama dalam sesebuah pertandingan. <br>
            Penghargaan: Diberikan kepada seseorang yang membantu dalam menjayakan acara. Contoh: Ahli Jawatankuasa Pertandingan.
        </div>
        <div class="my-3">
            <label for="position" class="form-label">Kedudukan (Diperlukan)</label>
            <input type="text" class="form-control" id="position" name="position" placeholder="Masukkan posisi peserta." value="{{ $valuePosition }}">
        </div>
        @error('position')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div id="position_help mb-3" class="form-text">
            Sijil Penyertaan. Contoh: "Peserta". <br>
            Sijil Pencapaian. Contoh: "Tempat Pertama", "Tempat Kedua", "Tempat Ketiga". <br>
            Sijil Penghargaan. Contoh: "Ahli Jawatankuasa", "Setiusaha".
        </div>
        <div class="my-3">
            <label for="category" class="form-label">Kategori (Pilihan)</label>
            <input type="text" class="form-control" id="category" name="category" placeholder="Masukkan kategori sijil." value="{{ $valueCategory }}">
        </div>
        @error('category')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div id="category_help mb-3" class="form-text">
            Kategori untuk pertandingan yang disertai peserta.
        </div>
        <input type="hidden" id="user-id" name="user-id" value="{{ $data->user_id }}">
        <button class="btn btn-outline-light mt-3" type="submit">Kemas Kini</button>
    </form>
    <script src="{{ asset('js/addCertificateSearch.js') }}"></script>
@endsection