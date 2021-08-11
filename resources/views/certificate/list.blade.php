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
    <p class="fs-2">Senarai Sijil</p>
    @if(session()->has('removeCertificateSuccess'))
        <span><div class="alert alert-success w-100 ml-1">{{ session('removeCertificateSuccess') }}</div></span>
    @endif
    <div class="row">
        <div class="table-responsive">
            <table class="table table-dark table-striped w-100 rounded-3 table-bordered border-light align-middle">
                <thead>
                    <tr>
                        <th class="col-1 text-center">ID</th>
                        <th class="col-2 text-center">Nama Pengguna</th>
                        <th class="col-3 text-center">Nama Acara</th>
                        <th class="col-2 text-center">Jenis Sijil</th>
                        <th class="col-1 text-center">Kedudukan</th>
                        <th class="col-1 text-center">Lihat</th>
                        @can('authAdmin')
                            <th class="col-1 text-center">Kemas Kini</th>
                            <th class="col-1 text-center">Buang</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($certificates as $certificate)
                        <tr>
                            <th class="text-center">{{ $certificate->id }}</th>
                            <td>{{ strtoupper($certificate->fullname) }}</td>
                            <td>{{ strtoupper($certificate->name) }}</td>
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
                            <td>{{ strtoupper($certificate->position) }}</td>
                            <td class="fs-3 text-center"><a class="text-light" href="{{ route('certificate.view', [$certificate->id]) }}" target="_blank"><i class="bi bi-eye"></i></a></td>
                            @can('authAdmin')
                                <td class="fs-3 text-center"><a class="text-light" href="{{ route('certificate.update', [$certificate->id]) }}"><i class="bi bi-pencil-square"></i></a></td>
                                <td class="fs-3 text-center"><a class="text-light" href="" data-bs-toggle="modal" data-bs-target="#{{ 'delete-certificate-modal-' . $certificate->id}}"><i class="bi bi-trash"></a></i></td>
                            @endcan   
                        </tr>
                            {{-- 
                            Modal for delete confirmation 
                            --}}
                            <div class="modal fade" id="{{ 'delete-certificate-modal-' . $certificate->id}}" tabindex="-1" aria-labelledby="{{ 'delete-certificate-modal-' . $certificate->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('certificate.remove') }}" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="{{ 'delete-certificate-modal-' . $certificate->id . '-label'}}">Buang Sijil</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Anda yakin ingin membuang sijil ini?</p>
                                                <p class="fw-bold">ID Sijil: <span class="fw-normal">{{ $certificate->id }}</span></p>
                                                <p class="fw-bold">Nama Pengguna: <span class="fw-normal">{{ strtoupper($certificate->fullname) }}</span></p>
                                                <p class="fw-bold">Nama Acara: <span class="fw-normal">{{ strtoupper($certificate->name) }}</span></p>
                                                <p class="fw-bold">Jenis Sijil: <span class="fw-normal">
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
                                                </span></p>
                                                <input type="text" name="certificate-id" id="certificate-id" value="{{ $certificate->id }}" hidden>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Tidak</button>
                                                <button type="submit" class="btn btn-danger">Ya</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </tbody>
            </table>
            {{ $certificates->links() }}
        </div>   
    </div>
@endsection