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
            <tr>
                <th>Pengesahan</th>
                <td>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                        @if(Storage::disk('public')->exists($certificate->signature_first))
                            <div class="col d-flex flex-column justify-content-center">
                                <img src="{{ asset('storage/' . $certificate->signature_first) }}" alt="signature" class="bg-light mb-2">
                                <p>{{ strtoupper($certificate->signature_first_name) }}</p>
                                <p class="fst-italic">{{ strtoupper($certificate->signature_first_position) }}</p>
                            </div>
                        @endif
                        @if(Storage::disk('public')->exists($certificate->signature_second))
                            <div class="col d-flex flex-column justify-content-center">
                                <img src="{{ asset('storage/' . $certificate->signature_second) }}" alt="signature" class="bg-light mb-2">
                                <p>{{ strtoupper($certificate->signature_second_name) }}</p>
                                <p class="fst-italic">{{ strtoupper($certificate->signature_second_position) }}</p>
                            </div>
                        @endif
                        @if(Storage::disk('public')->exists($certificate->signature_third))
                            <div class="col d-flex flex-column justify-content-center">
                                <img src="{{ asset('storage/' . $certificate->signature_third) }}" alt="signature" class="bg-light mb-2">
                                <p>{{ strtoupper($certificate->signature_third_name) }}</p>
                                <p class="fst-italic">{{ strtoupper($certificate->signature_third_position) }}</p>
                            </div>
                        @endif
                    </div>
                </td>
            </tr>
        </table>
        <p class="align-middle fs-5 text-warning"><i class="bi bi-patch-check-fill fs-5 text-warning"></i> Sijil ini telah dijana di <a href="{{ 'http://' . Request::getHost() }}" class="fw-bold text-warning">{{ Request::getHost() }}</a></p>
        <a href="{{ route('certificate.view', ['uid' => $certificate->uid]) }}" class="btn btn-outline-light"><i class="bi bi-eye"></i> Lihat Sijil</a>
    </div>
@endsection