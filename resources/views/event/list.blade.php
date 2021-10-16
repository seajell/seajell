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
    <p class="fs-2">{{ trans('event/list.event_list') }}</p>
    <form action="" method="get" class="row my-3">
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col mb-2">
                <div class="form-floating">
                    <select class="form-select" id="sort_by" name="sort_by" aria-label="sortby">
                        <option value="id">ID</option>
                        <option value="date">{{ trans('event/list.date') }}</option>
                        <option value="location">{{ trans('event/list.event_location') }}</option>
                        <option value="name">{{ trans('event/list.event_name') }}</option>
                        <option value="organiser_name">{{ trans('event/list.organiser_name') }}</option>
                        <option value="visibility">{{ trans('event/list.visibility') }}</option>
                    </select>
                    <label for="sort_by">{{ trans('event/list.sort_by') }}:</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating">
                    <select class="form-select" id="sort_order" name="sort_order" aria-label="sortorder">
                        <option value="asc">{{ trans('event/list.order_ascending') }}</option>
                        <option value="desc">{{ trans('event/list.order_descending') }}</option>
                    </select>
                    <label for="sort_order">{{ trans('event/list.order_by') }}:</label>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-7 col-md-10">
                <input type="text" class="form-control" name="search" placeholder="{{ trans('event/list.search') }}">
            </div>
            <div class="col-5 col-md-2">
                <button type="submit" class="btn btn-outline-light hvr-shrink w-100"><i class="bi bi-search"></i> {{ trans('event/list.search') }}</button>
            </div>
            @if(!empty($sortAndSearch))
                <div class="col-12 row gy-3">
                    @switch($sortAndSearch['sortBy'])
                        @case('id')
                            <p class="col-6">{{ trans('event/list.sort_by') }}: <span class="fst-italic">ID</span></p>
                            @break
                        @case('date')
                            <p class="col-6">{{ trans('event/list.sort_by') }}: <span class="fst-italic">{{ trans('event/list.date') }}</span></p>
                            @break
                        @case('location')
                            <p class="col-6">{{ trans('event/list.sort_by') }}: <span class="fst-italic">{{ trans('event/list.event_location') }}</span></p>
                            @break
                        @case('name')
                            <p class="col-6">{{ trans('event/list.sort_by') }}: <span class="fst-italic">{{ trans('event/list.event_name') }}</span></p>
                            @break
                        @case('organiser_name')
                            <p class="col-6">{{ trans('event/list.sort_by') }}: <span class="fst-italic">{{ trans('event/list.organiser_name') }}</span></p>
                            @break
                        @case('visibility')
                            <p class="col-6">{{ trans('event/list.sort_by') }}: <span class="fst-italic">{{ trans('event/list.visibility') }}</span></p>
                            @break
                        @default
                            <p class="col-6">DISUSUN MENGIKUT: <span class="fst-italic"></span></p>
                            @break
                    @endswitch
                    @switch($sortAndSearch['sortOrder'])
                        @case('asc')
                            <p class="col-6">{{ trans('event/list.order_by') }}: <span class="fst-italic">{{ trans('event/list.order_ascending') }}</span></p>
                            @break
                        @case('desc')
                            <p class="col-6">{{ trans('event/list.order_by') }}: <span class="fst-italic">{{ trans('event/list.order_descending') }}</span></p>
                            @break
                        @default
                            <p class="col-6">{{ trans('event/list.order_by') }}:</p>
                    @endswitch
                    @if(!empty($sortAndSearch['search']))
                        <p class="col-12">{{ trans('event/list.search') }}: <span class="fst-italic">{{ strtoupper($sortAndSearch['search']) }}</span></p>
                    @endif
                    <div class="col-12">
                        <a href="{{ route('event.list') }}" class="btn btn-outline-light"><i class="bi bi-file-minus"></i> {{ trans('event/list.clear_search_and_order') }}</a>
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
                            <th class="col-1 text-center">{{ trans('event/list.date') }}</th>
                            <th class="col-2 text-center">{{ trans('event/list.event_location') }}</th>
                            <th class="col-2 text-center">{{ trans('event/list.event_name') }}</th>
                            <th class="col-2 text-center">{{ trans('event/list.organiser_name') }}</th>
                            <th class="col-1 text-center">{{ trans('event/list.visibility') }}</th>
                            <th class="col-1 text-center">{{ trans('event/list.update') }}</th>
                            <th class="col-1 text-center">{{ trans('event/list.remove') }}</th>
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
                                        {{ strtoupper(trans('event/list.visibility_public')) }}
                                    @elseif($event->visibility == 'hidden')
                                        {{ strtoupper(trans('event/list.visibility_hidden')) }}
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
                                                    <h5 class="modal-title" id="{{ 'delete-event-modal-' . $event->id . '-label'}}">{{ trans('event/list.remove_modal_title') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{{ trans('event/list.remove_modal_message_one') }}?</p>
                                                    <p>{{ trans('event/list.remove_modal_message_two') }}.</p>
                                                    <p class="fw-bold">ID: <span class="fw-normal">{{ $event->id }}</span></p>
                                                    <p class="fw-bold">{{ trans('event/list.event_name') }}: <span class="fw-normal">{{ strtoupper($event->name) }}</span></p>
                                                    <p class="fw-bold">{{ trans('event/list.date') }}: <span class="fw-normal">{{ $event->date }}</span></p>
                                                    <p class="fw-bold">{{ trans('event/list.event_location') }}: <span class="fw-normal">{{ strtoupper($event->location) }}</span></p>
                                                    <input type="text" name="event-id" id="event-id" value="{{ $event->id }}" hidden>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('event/list.remove_modal_no') }}</button>
                                                    <button type="submit" class="btn btn-danger">{{ trans('event/list.remove_modal_yes') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                    </tbody>
                @else
                    <p class="text-center fw-bold mt-3">{{ trans('event/list.no_record_found') }}.</p>
                @endif
            </table>
            {{ $events->links() }}
        </div>
    </div>
@endsection
