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
    <form action="" method="get" class="row my-3">
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col mb-2">
                <div class="form-floating">
                    <select class="form-select" id="sort_by" name="sort_by" aria-label="sortby">
                        <option value="uid">ID Unik</option>
                        <option value="user_id">Nama Pengguna</option>
                        <option value="event_id">Nama Acara</option>
                        <option value="type">Jenis Sijil</option>
                        <option value="position">Kategori</option>
                        <option value="category">Kedudukan</option>
                    </select>
                    <label for="sort_by">Susun Mengikut:</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating">
                    <select class="form-select" id="sort_order" name="sort_order" aria-label="sortorder">
                        <option value="asc">Meningkat</option>
                        <option value="desc">Menurun</option>
                    </select>
                    <label for="sort_order">Susun Secara:</label>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-7 col-md-10">
                <input type="text" class="form-control" name="search" placeholder="Carian">
            </div>
            <div class="col-5 col-md-2">
                <button type="submit" class="btn btn-dark hvr-shrink w-100"><i class="bi bi-search"></i> Cari</button>
            </div>
            @if(!empty($sortAndSearch))
                <div class="col-12 row gy-3">
                    @switch($sortAndSearch['sortBy'])
                        @case('uid')
                            <p class="col-6">DISUSUN MENGIKUT: <span class="fst-italic">ID Unik</span></p>
                            @break
                        @case('user_id')
                            <p class="col-6">DISUSUN MENGIKUT: <span class="fst-italic">Nama Pengguna</span></p>
                            @break
                        @case('event_id')
                            <p class="col-6">DISUSUN MENGIKUT: <span class="fst-italic">Nama Acara</span></p>
                            @break
                        @case('type')
                            <p class="col-6">DISUSUN MENGIKUT: <span class="fst-italic">Jenis Sijil</span></p>
                            @break
                        @case('position')
                            <p class="col-6">DISUSUN MENGIKUT: <span class="fst-italic">Kategori</span></p>
                            @break
                        @case('category')
                            <p class="col-6">DISUSUN MENGIKUT: <span class="fst-italic">Kedudukan</span></p>
                            @break
                        @default
                            <p class="col-6">DISUSUN MENGIKUT: <span class="fst-italic"></span></p>
                            @break
                    @endswitch
                    @switch($sortAndSearch['sortOrder'])
                        @case('asc')
                            <p class="col-6">DISUSUN SECARA: <span class="fst-italic">MENINGKAT</span></p>
                            @break
                        @case('desc')
                            <p class="col-6">DISUSUN SECARA: <span class="fst-italic">MENURUN</span></p>
                            @break
                        @default
                            <p class="col-6">DISUSUN SECARA:</p>     
                    @endswitch
                    @if(!empty($sortAndSearch['search']))
                        @switch($sortAndSearch['search'])
                            @case('participation')
                                <p class="col-12">CARIAN: <span class="fst-italic">PENYERTAAN</span></p>
                                @break
                            @case('achievement')
                                <p class="col-12">CARIAN: <span class="fst-italic">PENCAPAIAN</span></p>
                                @break
                            @case('appreciation')
                                <p class="col-12">CARIAN: <span class="fst-italic">PENGHARGAAN</span></p>
                                @break
                            @default
                                <p class="col-12">CARIAN: <span class="fst-italic">{{ strtoupper($sortAndSearch['search']) }}</span></p>
                                @break
                        @endswitch
                    @endif
                    <div class="col-12">
                        <a href="{{ route('certificate.list') }}" class="btn btn-dark"><i class="bi bi-file-minus"></i> Kosongkan Carian Dan Susunan</a>
                    </div>
                </div>
            @endif
        </div>
    </form>
    @if(session()->has('removeCertificateSuccess'))
        <span><div class="alert alert-success w-100 ml-1">{{ session('removeCertificateSuccess') }}</div></span>
    @endif
    <div class="row">
        <div class="row my-3">
            <div class="col-3">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#certificateCollectionDownloadModal"><i class="bi bi-download"></i> Muat Turun Koleksi Sijil</button>
            </div>
            <div class="col-9">
                @error('id_username')
                    <div class="alert alert-danger">Ruangan ID / Username diperlukan.</div>
                @enderror
                @error('collectionUserNotFound')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                @error('collectionEventNotFound')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror 
                @error('collectionNoCertificate')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror 
                @error('collectionLimit')
                    <div class="alert alert-danger">
                        <p>Muat turun seterusnya boleh dilakukan selepas <span class="fw-bold">{{ $message }}</span></p>
                    </div>
                @enderror  
            </div>
            {{-- Modal for certificate collection download --}}
            <div class="modal fade" id="certificateCollectionDownloadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('certificate.collection') }}" method="get">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="certificateCollectionDownloadModalLabel">Muat Turun Koleksi Sijil</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @can('authAdmin')
                                    <p>Muat turun koleksi sijil bagi peserta dan acara dihadkan kepada 24 jam untuk setiap cubaan.</p>
                                    <p class="text-danger">Perhatian: Muat turun bagi koleksi yang mempunyai banyak sijil akan mengurangkan prestasi server sewaktu proses muat turun!</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="collection_download_options" id="collectionDownloadOptions1" value="participant" checked>
                                        <label class="form-check-label" for="collectionDownloadOptions1">Peserta</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="collection_download_options" id="collectionDownloadOptions2" value="event">
                                        <label class="form-check-label" for="collectionDownloadOptions2">Acara</label>
                                    </div>
                                    <div class="form-floating mt-3">
                                        <input type="text" class="form-control" id="id_username" name="id_username" placeholder="id_username">
                                        <label for="id_username">ID Acara / Username</label>
                                    </div>
                                @endcan
                                @cannot('authAdmin')
                                    <p>Muat turun koleksi sijil dihadkan kepada 24 jam untuk setiap cubaan.</p>
                                @endcannot
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-dark"><i class="bi bi-download"></i> Muat Turun</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-dark table-striped w-100 rounded-3 table-bordered border-light align-middle">
                @if ($certificates->count() > 0)
                    <thead>
                        <tr>
                            <th class="col-1 text-center">ID Unik</th>
                            <th class="col text-center">Nama Pengguna</th>
                            <th class="col text-center">Nama Acara</th>
                            <th class="col text-center">Jenis Sijil</th>
                            <th class="col text-center">Kategori</th>
                            <th class="col text-center">Kedudukan</th>
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
                                <th class="text-center">{{ $certificate->uid }}</th>
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
                                <td>
                                    @if($certificate->category !== NULL && $certificate->category !== '')
                                        {{ strtoupper($certificate->category) }} 
                                    @else
                                        {{ "TIADA" }}
                                    @endif
                                </td>
                                <td>{{ strtoupper($certificate->position) }}</td>
                                <td class="fs-3 text-center"><a class="text-light" href="{{ route('certificate.view', [$certificate->uid]) }}" target="_blank"><i class="bi bi-eye"></i></a></td>
                                @can('authAdmin')
                                    <td class="fs-3 text-center"><a class="text-light" href="{{ route('certificate.update', [$certificate->uid]) }}"><i class="bi bi-pencil-square"></i></a></td>
                                    <td class="fs-3 text-center"><a class="text-light" href="" data-bs-toggle="modal" data-bs-target="#{{ 'delete-certificate-modal-' . $certificate->uid}}"><i class="bi bi-trash"></a></i></td>
                                @endcan   
                            </tr>
                                {{-- 
                                Modal for delete confirmation 
                                --}}
                                <div class="modal fade" id="{{ 'delete-certificate-modal-' . $certificate->uid}}" tabindex="-1" aria-labelledby="{{ 'delete-certificate-modal-' . $certificate->uid}}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('certificate.remove') }}" method="post">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="{{ 'delete-certificate-modal-' . $certificate->uid . '-label'}}">Buang Sijil</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin membuang sijil ini?</p>
                                                    <p class="fw-bold">ID Unik Sijil: <span class="fw-normal">{{ $certificate->uid }}</span></p>
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
                                                    <input type="text" name="certificate-id" id="certificate-id" value="{{ $certificate->uid }}" hidden>
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
                @else
                    <p class="text-center fw-bold mt-3">Tiada rekod dijumpai.</p>
                @endif
            </table>
            {{ $certificates->links() }}
        </div>   
    </div>
@endsection