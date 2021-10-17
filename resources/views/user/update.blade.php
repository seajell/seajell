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
    <p class="fs-2">{{ trans('user/update.update_user') }}</p>
    @php
    //  Check if there's old value, if not insert data from database if available

        if(old('fullname') != NULL){ // fullname
            $valueFullname = old('fullname');
        }else{
            if($data != NULL && $data != ''){
                if($data->fullname != NULL && $data->fullname != ''){
                    $valueFullname = strtoupper($data->fullname);
                }else{
                    $valueFullname = "";
                }
            }
        }

        if(old('email') != NULL){ // email
            $valueEmail = old('email');
        }else{
            if($data != NULL && $data != ''){
                if($data->email != NULL && $data->email != ''){
                    $valueEmail = strtoupper($data->email);
                }else{
                    $valueEmail = "";
                }
            }
        }

        if(old('identification_number') != NULL){ // identification_number
            $valueIdentificationNumber = old('identification_number');
        }else{
            if($data != NULL && $data != ''){
                if($data->identification_number != NULL && $data->identification_number != ''){
                    $valueIdentificationNumber = $data->identification_number;
                }else{
                    $valueIdentificationNumber = "";
                }
            }
        }
    @endphp
    @if(session()->has('updateUserSuccess'))
        <span><div class="alert alert-success w-100 ml-1">{{ session('updateUserSuccess') }}</div></span>
    @endif
    @error('userNotExisted')
        <span><div class="alert alert-danger w-100 ml-1">{{ $message }}</div></span>
    @enderror
    <form action="" method="post" class="mb-3">
        @csrf
        <div class="mb-3">
            <label for="fullname" class="form-label">{{ trans('user/update.user_fullname') }}</label>
            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="{{ trans('user/update.placeholder_user_fullname') }}." value="{{ $valueFullname }}">
        </div>
        @error('fullname')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="email" class="form-label">{{ trans('user/update.email_address') }}</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="{{ trans('user/update.placeholder_user_email_address') }}." value="{{ $valueEmail }}">
        </div>
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="identification_number " class="form-label">{{ trans('user/update.identification_card_number') }}</label>
            <input type="text" class="form-control" id="identification_number " name="identification_number" placeholder="{{ trans('user/update.placeholder_identification_card_number') }}." value="{{ $valueIdentificationNumber }}">
            <div id="identification_number_help" class="form-text">
                {{ trans('user/update.label_user_message_one') }}
                <br>
                {{ trans('user/update.label_user_message_two') }}
            </div>
        </div>
        @error('identification_number')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
            @can('authAdmin')
                @if($data->role !== 'superadmin')
                    {{-- Only superadmin can edit someone else's role --}}
                    @if(Auth::user()->role == 'superadmin')
                        <label for="role" class="form-label">{{ trans('user/update.user_role') }}</label>
                        <select class="form-select mb-3" name="role" id="role" aria-label="role">
                            <option value="participant">{{ trans('user/update.user_role_participant') }}</option>
                            <option value="admin">{{ trans('user/update.user_role_admin') }}</option>
                        </select>
                        @error('role')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    @endif
                @endif
            @endcan
        <button class="btn btn-outline-light" type="submit" name="info">{{ trans('user/update.update_information') }}</button>
    </form>

    <hr>

    {{-- Only admin can change their own password. Othe admins can't. Superadmin is an exception. --}}
    <p class="fs-2">{{ trans('user/update.update_password') }}</p>
    @if(session()->has('updateUserPasswordSuccess'))
        <span><div class="alert alert-success w-100 ml-1">{{ session('updateUserPasswordSuccess') }}</div></span>
    @endif
    @error('userNotExisted')
        <span><div class="alert alert-danger w-100 ml-1">{{ $message }}</div></span>
    @enderror
    <form action="" method="post" class="mb-3">
        @csrf
        {{-- Admin won't need to know participant password to change it --}}
        {{-- Admin must enter their old password to change it --}}
        @if($data->username == Auth::user()->username)
            <div class="mb-3">
                <label for="old_password" class="form-label">{{ trans('user/update.old_password') }}</label>
                <input type="password" class="form-control" id="old_password" name="old_password" placeholder="{{ trans('user/update.placeholder_old_password') }}.">
            </div>
            @error('old_password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('oldPasswordWrong')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        @endif
        <div class="mb-3">
            <label for="password" class="form-label">{{ trans('user/update.new_password') }}</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="{{ trans('user/update.placeholder_new_password') }}.">
        </div>
        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="password_confirmation " class="form-label">{{ trans('user/update.confirm_new_password') }}</label>
            <input type="password" class="form-control" id="password_confirmation " name="password_confirmation" placeholder="{{ trans('user/update.placeholder_confirm_new_password') }}.">
        </div>
        <button class="btn btn-outline-light" type="submit" name="password-update">{{ trans('user/update.update_password') }}</button>
    </form>
@endsection
