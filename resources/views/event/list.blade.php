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
    <p class="fs-2">Senarai Acara</p>
    <form action="" method="get" class="row my-3">
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col mb-2">
                <div class="form-floating">
                    <select class="form-select" id="sort_by" name="sort_by" aria-label="sortby">
                        <option value="id">ID</option>
                        <option value="date">Tarikh</option>
                        <option value="location">Lokasi</option>
                        <option value="name">Nama Acara</option>
                        <option value="organiser_name">Nama Penganjur</option>
                        <option value="visibility">Keterlihatan</option>
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
                <button type="submit" class="btn btn-outline-light hvr-shrink w-100"><i class="bi bi-search"></i> Cari</button>
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
                        <a href="{{ route('event.list') }}" class="btn btn-outline-light"><i class="bi bi-file-minus"></i> Kosongkan Carian Dan Susunan</a>
                    </div>
                </div>
            @endif
        </div>
    </form>
    @if(session()->has('removeEventSuccess'))
        <span><div class="alert alert-success w-100 ml-1">{{ session('removeEventSuccess') }}</div></span>
    @endif
    <div class="row">
        <div class="table-responsive">
            <table class="table table-dark table-striped w-100 rounded-3 table-bordered border-light align-middle">
                @if ($events->count() > 0)
                    <thead>
                        <tr>
                            <th class="col-1 text-center">ID</th>
                            <th class="col-1 text-center">Tarikh</th>
                            <th class="col-2 text-center">Lokasi</th>
                            <th class="col-2 text-center">Nama Acara</th>
                            <th class="col-2 text-center">Nama Penganjur</th>
                            <th class="col-1 text-center">Keterlihatan</th>
                            <th class="col-1 text-center">Kemas Kini</th>
                            <th class="col-1 text-center">Buang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <th class="text-center">{{ $event->id }}</th>
                                <td>{{ $event->date }}</td>
                                <td>{{ strtoupper($event->location) }}</td>
                                <td>{{ strtoupper($event->name) }}</td>
                                <td>{{ strtoupper($event->organiser_name) }}</td>
                                <td>
                                    @if($event->visibility == 'public')
                                        AWAM
                                    @elseif($event->visibility == 'hidden')
                                        TERSEMBUNYI
                                    @endif
                                </td>
                                <td class="fs-3 text-center"><a class="text-light" href="{{ route('event.update', [$event->id]) }}"><i class="bi bi-pencil-square"></i></a></td>
                                <td class="fs-3 text-center"><a class="text-light" href="" data-bs-toggle="modal" data-bs-target="#{{ 'delete-event-modal-' . $event->id}}"><i class="bi bi-trash"></a></i></td>
                            </tr>
                            {{-- 
                                Modal for delete confirmation 
                                --}}
                                <div class="modal text-dark fade" id="{{ 'delete-event-modal-' . $event->id}}" tabindex="-1" aria-labelledby="{{ 'delete-event-modal-' . $event->id}}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('event.remove') }}" method="post">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="{{ 'delete-event-modal-' . $event->id . '-label'}}">Buang Acara</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin membuang acara ini?</p>
                                                    <p>Setiap sijil yang ditambah berdasarkan acara ini akan dibuang bersama.</p>
                                                    <p class="fw-bold">ID Acara: <span class="fw-normal">{{ $event->id }}</span></p>
                                                    <p class="fw-bold">Nama Acara: <span class="fw-normal">{{ strtoupper($event->name) }}</span></p>
                                                    <p class="fw-bold">Tarikh: <span class="fw-normal">{{ $event->date }}</span></p>
                                                    <p class="fw-bold">Lokasi: <span class="fw-normal">{{ strtoupper($event->location) }}</span></p>
                                                    <input type="text" name="event-id" id="event-id" value="{{ $event->id }}" hidden>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
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
            {{ $events->links() }}
        </div>   
    </div>
@endsection