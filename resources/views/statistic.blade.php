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
            <p class="fs-2">Statistik</p>
        </div>
        <div class="row mb-5">
            <div class="form-floating w-50">
                <select class="form-select" id="update-options" aria-label="Update options floating">
                    <option selected value="all">Sepanjang Masa</option>
                    <option value="today">Hari Ini</option>
                    <option value="month">Bulan Ini</option>
                    <option value="year">Tahun Ini</option>
                </select>
                <label for="floatingSelect">Jangka Masa</label>
            </div>
            <button class="btn btn-outline-light btn-sm w-25" type="button" id="update-options-btn"><i class="bi bi-arrow-repeat"></i> Kemas Kini</button>
        </div>
        <div class="row my-3">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center" id="update-status"></div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 h-100 mb-3" id="statistics">
            <div class="table-responsive">
                <p class="fs-5">Jumlah Log Masuk</p>
                <table class="table table-dark table-hover table-striped table-bordered border-light align-middle">
                    <tr>
                        <th>Peserta</th>
                        <th>Admin</th>
                        <th>Jumlah</th>
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
                <p class="fs-5">Jumlah Lihat / Muat Turun Sijil</p>
                <div class="border border-light border-3 h-75 d-flex justify-content-center align-items-center">
                    <p class="fs-1" id="total-viewed">0</p>
                </div>
            </div>
            <div>
                <p class="fs-5">Jumlah Sijil Ditambah</p>
                <div class="border border-light border-3 h-75 d-flex justify-content-center align-items-center">
                    <p class="fs-1" id="total-added">0</p>
                </div>
            </div>
        </div>
        <div class="row mt-5 mb-3">
            <p>Jika anda mahu memberi maklumat balas berkenaan sistem ini, anda boleh melakukan sedemikian dengan mengisi borang ini: <a href="https://forms.gle/KLjTCqRGdpwQKCw7A" target="_blank">https://forms.gle/KLjTCqRGdpwQKCw7A</a></p>
        </div>
    </div>
    <script src="{{ asset('js/statistic.js') }}"></script>
@endsection