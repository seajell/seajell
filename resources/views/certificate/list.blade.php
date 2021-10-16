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
    <p class="fs-2">{{ trans('certificate/list.certificate_list') }}</p>
    <form action="" method="get" class="row my-3">
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col mb-2">
                <div class="form-floating">
                    <select class="form-select" id="sort_by" name="sort_by" aria-label="sortby">
                        <option value="uid">{{ trans('certificate/list.unique_id') }}</option>
                        <option value="user_id">{{ trans('certificate/list.user_name') }}</option>
                        <option value="event_id">{{ trans('certificate/list.event_name') }}</option>
                        <option value="type">{{ trans('certificate/list.certificate_type') }}</option>
                        <option value="category">{{ trans('certificate/list.certificate_category') }}</option>
                        <option value="position">{{ trans('certificate/list.certificate_position') }}</option>
                    </select>
                    <label for="sort_by">{{ trans('certificate/list.sort_by') }}:</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating">
                    <select class="form-select" id="sort_order" name="sort_order" aria-label="sortorder">
                        <option value="asc">{{ trans('certificate/list.order_ascending') }}</option>
                        <option value="desc">{{ trans('certificate/list.order_descending') }}</option>
                    </select>
                    <label for="sort_order">{{ trans('certificate/list.order_by') }}:</label>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-7 col-md-10">
                <input type="text" class="form-control" name="search" placeholder="{{ trans('certificate/list.search') }}">
            </div>
            <div class="col-5 col-md-2">
                <button type="submit" class="btn btn-outline-light hvr-shrink w-100"><i class="bi bi-search"></i> {{ trans('certificate/list.search') }}</button>
            </div>
            @if(!empty($sortAndSearch))
                <div class="col-12 row gy-3">
                    @switch($sortAndSearch['sortBy'])
                        @case('uid')
                            <p class="col-6">{{ trans('certificate/list.sort_by') }}: <span class="fst-italic">{{ trans('certificate/list.unique_id') }}</span></p>
                            @break
                        @case('user_id')
                            <p class="col-6">{{ trans('certificate/list.sort_by') }}: <span class="fst-italic">{{ trans('certificate/list.user_name') }}</span></p>
                            @break
                        @case('event_id')
                            <p class="col-6">{{ trans('certificate/list.sort_by') }}: <span class="fst-italic">{{ trans('certificate/list.event_name') }}</span></p>
                            @break
                        @case('type')
                            <p class="col-6">{{ trans('certificate/list.sort_by') }}: <span class="fst-italic">{{ trans('certificate/list.certificate_type') }}</span></p>
                            @break
                        @case('position')
                            <p class="col-6">{{ trans('certificate/list.sort_by') }}: <span class="fst-italic">{{ trans('certificate/list.certificate_category') }}</span></p>
                            @break
                        @case('category')
                            <p class="col-6">{{ trans('certificate/list.sort_by') }}: <span class="fst-italic">{{ trans('certificate/list.certificate_position') }}</span></p>
                            @break
                        @default
                            <p class="col-6">{{ trans('certificate/list.sort_by') }}: <span class="fst-italic"></span></p>
                            @break
                    @endswitch
                    @switch($sortAndSearch['sortOrder'])
                        @case('asc')
                            <p class="col-6">{{ trans('certificate/list.order_by') }}: <span class="fst-italic">{{ trans('certificate/list.order_ascending') }}</span></p>
                            @break
                        @case('desc')
                            <p class="col-6">{{ trans('certificate/list.order_by') }}: <span class="fst-italic">{{ trans('certificate/list.order_descending') }}</span></p>
                            @break
                        @default
                            <p class="col-6">{{ trans('certificate/list.order_by') }}:</p>
                    @endswitch
                    @if(!empty($sortAndSearch['search']))
                        @switch($sortAndSearch['search'])
                            @case('participation')
                                <p class="col-12">{{ trans('certificate/list.search') }}: <span class="fst-italic">{{ trans('certificate/type.participation') }}</span></p>
                                @break
                            @case('achievement')
                                <p class="col-12">{{ trans('certificate/list.search') }}: <span class="fst-italic">{{ trans('certificate/type.achievement') }}</span></p>
                                @break
                            @case('appreciation')
                                <p class="col-12">{{ trans('certificate/list.search') }}: <span class="fst-italic">{{ trans('certificate/type.appreciation') }}</span></p>
                                @break
                            @default
                                <p class="col-12">{{ trans('certificate/list.search') }}: <span class="fst-italic">{{ strtoupper($sortAndSearch['search']) }}</span></p>
                                @break
                        @endswitch
                    @endif
                    <div class="col-12">
                        <a href="{{ route('certificate.list') }}" class="btn btn-outline-light"><i class="bi bi-file-minus"></i> {{ trans('certificate/list.clear_search_and_order') }}</a>
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
            <div class="col-4">
                <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#certificateCollectionDownloadModal"><i class="bi bi-download"></i> {{ trans('certificate/list.download_certificate_collection') }}</button>
            </div>
            <div class="col-8">
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
                        <p>{{ trans('certificate/list.certificate_collection_limit') }}!</p>
                        <p>{{ trans('certificate/list.certificate_collection_limit_after') }} <span class="fw-bold">{{ $message }}</span></p>
                    </div>
                @enderror
                @if(session()->has('collectionDownloadSuccessPath'))
                    <div class="alert alert-success">
                        <div class="row">
                            <span>{{ trans('certificate/list.certificate_collection_download_url') }}: <a href="{{ session('collectionDownloadSuccessPath') }}" class="fw-bold text-success">{{ trans('certificate/list.download') }}</a></span>
                        </div>
                    </div>
                @endif
            </div>
            {{-- Modal for certificate collection download --}}
            <div class="modal fade text-dark" id="certificateCollectionDownloadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('certificate.collection') }}" method="get">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="certificateCollectionDownloadModalLabel">{{ trans('certificate/list.certificate_collection_modal_title') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @can('authAdmin')
                                    <p>{{ trans('certificate/list.certificate_collection_modal_message_one') }}.</p>
                                    <p class="text-danger">{{ trans('certificate/list.certificate_collection_modal_message_two') }}!</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="collection_download_options" id="collectionDownloadOptions1" value="participant" checked>
                                        <label class="form-check-label" for="collectionDownloadOptions1">{{ trans('certificate/list.certificate_collection_modal_participant') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="collection_download_options" id="collectionDownloadOptions2" value="event">
                                        <label class="form-check-label" for="collectionDownloadOptions2">{{ trans('certificate/list.certificate_collection_modal_event') }}</label>
                                    </div>
                                    <div class="form-floating mt-3">
                                        <input type="text" class="form-control" id="id_username" name="id_username" placeholder="id_username">
                                        <label for="id_username">{{ trans('certificate/list.certificate_collection_modal_id_username') }}</label>
                                    </div>
                                @endcan
                                @cannot('authAdmin')
                                    <p>{{ trans('certificate/list.certificate_collection_modal_message_one') }}.</p>
                                @endcannot
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('certificate/list.certificate_collection_modal_close') }}</button>
                                <button type="submit" class="btn btn-outline-dark"><i class="bi bi-download"></i> {{ trans('certificate/list.certificate_collection_modal_download') }}</button>
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
                            <th class="col-1 text-center">{{ trans('certificate/list.unique_id') }}</th>
                            <th class="col text-center">{{ trans('certificate/list.user_name') }}</th>
                            <th class="col text-center">{{ trans('certificate/list.event_name') }}</th>
                            <th class="col text-center">{{ trans('certificate/list.certificate_type') }}</th>
                            <th class="col text-center">{{ trans('certificate/list.certificate_category') }}</th>
                            <th class="col text-center">{{ trans('certificate/list.certificate_position') }}</th>
                            <th class="col-1 text-center">{{ trans('certificate/list.view') }}</th>
                            @can('authAdmin')
                                <th class="col-1 text-center">{{ trans('certificate/list.update') }}</th>
                                <th class="col-1 text-center">{{ trans('certificate/list.remove') }}</th>
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
                                            {{ strtoupper(trans('certificate/type.participation')) }}
                                            @break
                                        @case('achievement')
                                            {{ strtoupper(trans('certificate/type.achievement')) }}
                                            @break
                                        @case('appreciation')
                                            {{ strtoupper(trans('certificate/type.appreciation')) }}
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
                                <div class="modal text-dark fade" id="{{ 'delete-certificate-modal-' . $certificate->uid}}" tabindex="-1" aria-labelledby="{{ 'delete-certificate-modal-' . $certificate->uid}}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('certificate.remove') }}" method="post">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="{{ 'delete-certificate-modal-' . $certificate->uid . '-label'}}">{{ trans('certificate/list.remove_modal_title') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{{ trans('certificate/list.remove_modal_message_one') }}?</p>
                                                    <p class="fw-bold">{{ trans('certificate/list.unique_id') }}: <span class="fw-normal">{{ $certificate->uid }}</span></p>
                                                    <p class="fw-bold">{{ trans('certificate/list.user_name') }}: <span class="fw-normal">{{ strtoupper($certificate->fullname) }}</span></p>
                                                    <p class="fw-bold">{{ trans('certificate/list.event_name') }}: <span class="fw-normal">{{ strtoupper($certificate->name) }}</span></p>
                                                    <p class="fw-bold">{{ trans('certificate/list.certificate_type') }}: <span class="fw-normal">
                                                        @switch($certificate->type)
                                                            @case('participation')
                                                                {{ strtoupper(trans('certificate/type.participation')) }}
                                                                @break
                                                            @case('achievement')
                                                                {{ strtoupper(trans('certificate/type.achievement')) }}
                                                                @break
                                                            @case('appreciation')
                                                                {{ strtoupper(trans('certificate/type.appreciation')) }}
                                                                @break
                                                            @default
                                                        @endswitch
                                                    </span></p>
                                                    <input type="text" name="certificate-id" id="certificate-id" value="{{ $certificate->uid }}" hidden>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('certificate/list.remove_modal_no') }}</button>
                                                    <button type="submit" class="btn btn-danger">{{ trans('certificate/list.remove_modal_yes') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                    </tbody>
                @else
                    <p class="text-center fw-bold mt-3">{{ trans('certificate/list.no_record_found') }}.</p>
                @endif
            </table>
            {{ $certificates->links() }}
        </div>
    </div>
@endsection
