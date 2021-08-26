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
    <p class="fs-2 text-center">Semakan Ketulenan Sijil</p>
    <div class="table-responsive w-100 mb-3">
        <table class="table table-dark table-hover table-bordered border-light border-3 align-middle">
            <tr>
                <th style="width: 25%;">Nama Pemegang Sijil</th>
                <td>{{ strtoupper($certificate->fullname) }}</td>
            </tr>
            <tr>
                <th>ID Sijil</th>
                <td>{{ $certificate->uid }}</td>
            </tr>
            <tr>
                <th>Jenis Sijil</th>
                <td>
                    @switch($certificate->type)
                        @case('participation')
                            PENYERTAAN
                            @break
                        @case('achievement')
                            PENCAPAIAN
                            @break
                        @case('appreciation')
                            PENGHARGAAN
                            @break
                        @default
                    @endswitch
                </td>
            </tr>
            <tr>
                <th>Nama Acara</th>
                <td>{{ strtoupper($certificate->name) }}</td>
            </tr>
            <tr>
                <th>Tarikh Acara</th>
                <td>{{ strtoupper($certificate->date) }}</td>
            </tr>
            @if(!empty($certificate->category))
                <tr>
                    <th>Kategori</th>
                    <td>{{ strtoupper($certificate->category) }}</td>
                </tr> 
            @endif 
            <tr>
                <th>Kedudukan</th>
                <td>{{ strtoupper($certificate->position) }}</td>
            </tr>
            <tr>
                <th>Nama Penganjur</th>
                <td>{{ strtoupper($certificate->organiser_name) }}</td>
            </tr>
        </table>
    </div>
@endsection