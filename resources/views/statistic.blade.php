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
    <div class="container text-center h-100">
        <div class="row">
            <p class="fs-2">{{ trans('statistic/main.statistic_title') }}</p>
        </div>
        <div class="row mb-5">
            <div class="form-floating w-50">
                <select class="form-select" id="update-options" aria-label="Update options floating">
                    <option selected value="all">{{ trans('statistic/main.filter_all') }}</option>
                    <option value="today">{{ trans('statistic/main.filter_today') }}</option>
                    <option value="month">{{ trans('statistic/main.filter_month') }}</option>
                    <option value="year">{{ trans('statistic/main.filter_year') }}</option>
                </select>
                <label for="floatingSelect">{{ trans('statistic/main.filter_timeframe') }}</label>
            </div>
            <button class="btn btn-outline-light btn-sm w-25" type="button" id="update-options-btn"><i class="bi bi-arrow-repeat"></i> {{ trans('statistic/main.filter_update') }}</button>
        </div>
        <div class="row my-3">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center" id="update-status">
                <div id="statistic-status-progress" class="alert alert-warning w-50" style="display: none;"><i class="bi bi-arrow-repeat"></i> {{ trans('statistic/main.statistic_status_progress') }}!</div>
                <div id="statistic-status-succes" class="alert alert-success w-50" style="display: none;"><i class="bi bi-check"></i> {{ trans('statistic/main.statistic_status_success') }}!</div>
                <div id="statistic-status-error" class="alert alert-danger w-50" style="display: none;"><i class="bi bi-x"></i> {{ trans('statistic/main.statistic_status_error') }}!</div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 h-100 mb-3" id="statistics">
            <div class="table-responsive">
                <p class="fs-5">{{ trans('statistic/main.login_title') }}</p>
                <table class="table table-dark table-hover table-striped table-bordered border-light align-middle">
                    <tr>
                        <th class="col-1">{{ trans('statistic/main.login_participant') }}</th>
                        <th class="col-1">{{ trans('statistic/main.login_admin') }}</th>
                        <th class="col-1">{{ trans('statistic/main.login_total') }}</th>
                    </tr>
                    <tr>
                        <td id="participant-login">0</td>
                        <td id="admin-login">0</td>
                        <th id="total-login">0</th>
                    </tr>
                    <tr>
                        <td id="participant-login-percentage">0</td>
                        <td id="admin-login-percentage">0</td>
                        <th id="total-login-percentage">0</th>
                    </tr>
                </table>
              </div>
            <div>
                <p class="fs-5">{{ trans('statistic/main.title_view_download') }}</p>
                <div class="border border-light border-3 h-75 d-flex justify-content-center align-items-center">
                    <p class="fs-1" id="total-viewed">0</p>
                </div>
            </div>
            <div>
                <p class="fs-5">{{ trans('statistic/main.title_certificate_added') }}</p>
                <div class="border border-light border-3 h-75 d-flex justify-content-center align-items-center">
                    <p class="fs-1" id="total-added">0</p>
                </div>
            </div>
        </div>
        <div class="row mt-5 mb-3">
            <p>{{ trans('statistic/main.feedback') }}: <a href="https://forms.gle/KLjTCqRGdpwQKCw7A" target="_blank">https://forms.gle/KLjTCqRGdpwQKCw7A</a></p>
        </div>
    </div>
    <script src="{{ asset('js/statistic.js') }}"></script>
@endsection
