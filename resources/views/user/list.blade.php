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
    <p class="fs-2">Senarai Pengguna</p>
    <form action="" method="get" class="row my-3">
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col mb-2">
                <div class="form-floating">
                    <select class="form-select" id="sort_by" name="sort_by" aria-label="sortby">
                        <option value="id">ID</option>
                        <option value="username">Username</option>
                        <option value="fullname">Nama Penuh</option>
                        <option value="email">Alamat E-mel</option>
                        <option value="role">Peranan</option>
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
                    <p class="col-6">DISUSUN MENGIKUT: <span class="fst-italic">{{ strtoupper($sortAndSearch['sortBy']) }}</span></p>
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
                        <p class="col-12">CARIAN: <span class="fst-italic">{{ strtoupper($sortAndSearch['search']) }}</span></p>
                    @endif
                    <div class="col-12">
                        <a href="{{ route('user.list') }}" class="btn btn-dark"><i class="bi bi-file-minus"></i> Kosongkan Carian Dan Susunan</a>
                    </div>
                </div>
            @endif
        </div>
    </form>
    @if(session()->has('removeUserSuccess'))
        <span><div class="alert alert-success w-100 ml-1">{{ session('removeUserSuccess') }}</div></span>
    @endif
    @error('removeUserError')
        <span><div class="alert alert-danger w-100 ml-1">{{ $message }}</div></span>
    @enderror
    <div class="row">
        <div class="table-responsive">
            <table class="table table-dark table-striped w-100 rounded-3 table-bordered border-light align-middle">
                @if ($users->count() > 0)
                    <thead>
                        <tr>
                            <th class="col-1 text-center">ID</th>
                            <th class="col-2 text-center">Username</th>
                            <th class="col-3 text-center">Nama Penuh</th>
                            <th class="col-2 text-center">Alamat E-mel</th>
                            <th class="col-1 text-center">Peranan</th>
                            <th class="col-1 text-center">Lihat</th>
                            <th class="col-1 text-center">Kemas Kini</th>
                            <th class="col-1 text-center">Buang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th class="text-center">{{ $user->id }}</th>
                                <td>{{ strtoupper($user->username) }}</td>
                                <td>{{ strtoupper($user->fullname) }}</td>
                                <td>{{ strtoupper($user->email) }}</td>
                                <td>
                                @if($user->role == 'participant')
                                    PESERTA
                                @elseif($user->role == 'admin')
                                    ADMIN
                                @elseif($user->role == 'superadmin')
                                    SUPERADMIN
                                @endif
                                </td>
                                <td class="fs-3 text-center"><a class="text-light" href=""><i class="bi bi-eye"></i></a></td>
                                <td class="fs-3 text-center">
                                    @if($user->username != 'admin')
                                    <a class="text-light" href="{{ route('user.update', [$user->username]) }}"><i class="bi bi-pencil-square"></i></a>      
                                    @endif
                                </td>
                                <td class="fs-3 text-center">
                                    @if($user->username != 'admin')
                                        <a class="text-light" href="" data-bs-toggle="modal" data-bs-target="#{{ 'delete-user-modal-' . $user->username}}"><i class="bi bi-trash"></a></i>
                                    @endif
                                </td>
                            </tr>
                            {{-- 
                                Modal for delete confirmation 
                                --}}
                            <div class="modal fade" id="{{ 'delete-user-modal-' . $user->username}}" tabindex="-1" aria-labelledby="{{ 'delete-user-modal-' . $user->username . '-label'}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('user.remove') }}" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="{{ 'delete-user-modal-' . $user->username . '-label'}}">Buang Pengguna</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Anda yakin ingin membuang pengguna ini?</p>
                                                <p>Setiap sijil yang ditambah untuk pengguna ini akan dibuang bersama.</p>
                                                <p class="fw-bold">Username: <span class="fw-normal">{{ strtoupper($user->username) }}</span></p>
                                                <p class="fw-bold">Nama Penuh: <span class="fw-normal">{{ strtoupper($user->fullname) }}</span></p>
                                                <input type="text" name="username" id="username" value="{{ $user->username }}" hidden>
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
            {{ $users->links() }}
        </div>   
    </div>
@endsection