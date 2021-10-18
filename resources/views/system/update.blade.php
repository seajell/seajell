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

@php
    if(!empty(old('system-name'))){
        $systemNameValue = strtoupper(old('system-name'));
    }elseif(!empty($systemSetting->name)){
        $systemNameValue = strtoupper($systemSetting->name);
    }

    if(!empty(old('system-language'))){
        switch (old('system-language')) {
            case 'en':
                $systemLanguageSelectedEn = 'selected';
                $systemLanguageSelectedMs = '';
                break;
            case 'ms-MY':
                $systemLanguageSelectedEn = '';
                $systemLanguageSelectedMs = 'selected';
                break;
            default:
                $systemLanguageSelectedEn = 'selected';
                $systemLanguageSelectedMs = '';
                break;
        }
        $systemLanguageSelectedEn = '';
        $systemLanguageSelectedMs = '';
    }elseif(!empty($systemSetting->language)){
        switch ($systemSetting->language) {
            case 'en':
                $systemLanguageSelectedEn = 'selected';
                $systemLanguageSelectedMs = '';
                break;
            case 'ms-MY':
                $systemLanguageSelectedEn = '';
                $systemLanguageSelectedMs = 'selected';
                break;
            default:
                $systemLanguageSelectedEn = 'selected';
                $systemLanguageSelectedMs = '';
                break;
        }
    }
@endphp

@extends('layout.main')
@section('content')
    <p class="fs-2">{{ trans('system/update.system_setting') }}</p>
    @if(session()->has('systemSettingSuccess'))
        <span><div class="alert alert-success w-100 ml-1">{{ session('systemSettingSuccess') }}</div></span>
    @endif
    <p class="fs-4">{{ trans('system/update.organization_information') }}</p>
    <form action="" method="post" class="mb-3" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="system-name" class="form-label">{{ trans('system/update.organization_name') }}</label>
            <input type="text" class="form-control" id="system-name" name="system-name" aria-describedby="systemNameHelp" value="{{ $systemNameValue }}">
            <div id="systemNameHelp" class="form-text">{{ trans('system/update.label_organization_name') }}.</div>
        </div>
        @error('system-name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label for="system-language" class="form-label">{{ trans('system/update.system_language') }}</label>
        <select class="form-select mb-3" aria-label="System language" name="system-language" id="system-language">
            <option value="en" {{ $systemLanguageSelectedEn }}>English</option>
            <option value="ms-MY" {{ $systemLanguageSelectedMs }}>Malay</option>
        </select>
        <div id="systemLanguageHelp" class="form-text">{{ trans('system/update.label_system_language') }}.</div>
        @error('system-language')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <img src="{{ asset('storage/') . $systemSetting->logo }}" alt="" class="img img-thumbnail my-3">
        <div class="mb-3">
            <label for="system-logo" class="form-label">{{ trans('system/update.organization_logo') }}</label>
            <input class="form-control" type="file" id="system-logo" name="system-logo">
            <div id="systemLogoHelp" class="form-text">{{ trans('system/update.label_organization_logo') }}.</div>
        </div>
        @error('system-logo')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button class="btn btn-outline-light" type="submit" name="organisation-information"><i class="bi bi-building"></i> {{ trans('system/update.system_setting_update') }}</button>
    </form>

    <hr>

    @php
        if(!empty(old('email-service-switch'))){
            switch (old('email-service-switch')) {
                case 'on':
                    $emailServiceStatus = 'checked';
                    break;
                case 'off':
                    $emailServiceStatus = '';
                    break;
                default:
                    $emailServiceStatus = '';
                    break;
            }
        }elseif(!empty($emailServiceSetting->service_status)){
            switch ($emailServiceSetting->service_status) {
                case 'on':
                    $emailServiceStatus = 'checked';
                    break;
                case 'off':
                    $emailServiceStatus = '';
                    break;
                default:
                    $emailServiceStatus = '';
                    break;
            }
        }else{
            $emailServiceStatus = '';
        }

        if(!empty(old('email-service-host'))){
            $emailServiceHost = old('email-service-host');
        }elseif(!empty($emailServiceSetting->service_host)){
            $emailServiceHost = $emailServiceSetting->service_host;
        }else{
            $emailServiceHost = '';
        }

        if(!empty(old('email-service-port'))){
            $emailServicePort = old('email-service-port');
        }elseif(!empty($emailServiceSetting->service_port)){
            $emailServicePort = $emailServiceSetting->service_port;
        }else{
            $emailServicePort = '';
        }

        if(!empty(old('email-service-username'))){
            $emailServiceUsername = old('email-service-username');
        }elseif(!empty($emailServiceSetting->account_username)){
            $emailServiceUsername = $emailServiceSetting->account_username;
        }else{
            $emailServiceUsername = '';
        }

        if(!empty(old('email-service-password'))){
            $emailServicePassword = old('email-service-password');
        }elseif(!empty($emailServiceSetting->account_password)){
            $emailServicePassword = $emailServiceSetting->account_password;
        }else{
            $emailServicePassword = '';
        }

        if(!empty(old('email-service-from-email'))){
            $emailServiceFromEmail = old('email-service-from-email');
        }elseif(!empty($emailServiceSetting->from_email)){
            $emailServiceFromEmail = $emailServiceSetting->from_email;
        }else{
            $emailServiceFromEmail = '';
        }

        if(!empty(old('email-service-support-email'))){
            $emailServiceSupportEmail = old('email-service-support-email');
        }elseif(!empty($emailServiceSetting->support_email)){
            $emailServiceSupportEmail = $emailServiceSetting->support_email;
        }else{
            $emailServiceSupportEmail = '';
        }

    @endphp
    @if(session()->has('updateEmailServiceSuccess'))
        <span><div class="alert alert-success w-100 ml-1">{{ session('updateEmailServiceSuccess') }}</div></span>
    @endif
    <p class="fs-4">{{ trans('system/update.email_service_information') }}</p>
    <form action="" method="post" class="mb-3">
        @csrf
        <p>{{ trans('system/update.email_service_information_description') }}.</p>
        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="email-service-switch" name="email-service-switch" {{ $emailServiceStatus }}>
            <label class="form-check-label" for="email-service-switch">{{ trans('system/update.email_active_switch') }}</label>
        </div>
        @error('email-service-switch')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="email-service-host" class="form-label">{{ trans('system/update.smtp_host') }}</label>
            <input type="text" class="form-control" id="email-service-host" name="email-service-host" aria-describedby="emailServiceHostHelp" value="{{ $emailServiceHost }}">
            <div id="emailServiceHostHelp" class="form-text">
                {{ trans('system/update.label_used_for_connecting_to_email_server') }}.
                <br>
                {{ trans('system/update.label_host_example') }}.
            </div>
        </div>
        @error('email-service-host')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="email-service-port" class="form-label">{{ trans('system/update.smtp_port') }}</label>
            <input type="number" class="form-control" id="email-service-port" name="email-service-port" aria-describedby="emailServicePortHelp" value="{{ $emailServicePort }}">
            <div id="emailServicePortHelp" class="form-text">
                {{ trans('system/update.label_used_for_connecting_to_email_server') }}.
                <br>
                {{ trans('system/update.label_host_example') }}.
            </div>
        </div>
        @error('email-service-port')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="email-service-username" class="form-label">{{ trans('system/update.email_user_username') }}</label>
            <input type="text" class="form-control" id="email-service-username" name="email-service-username" aria-describedby="emailServiceUsernameHelp" value="{{ $emailServiceUsername }}">
            <div id="emailServiceUsernameHelp" class="form-text">{{ trans('system/update.label_user_username') }}.</div>
        </div>
        @error('email-service-username')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="email-service-password" class="form-label">{{ trans('system/update.email_user_password') }}</label>
            <input type="password" class="form-control" id="email-service-password" name="email-service-password" aria-describedby="emailServicePasswordHelp" value="{{ $emailServicePassword }}">
            <div id="emailServicePasswordHelp" class="form-text">{{ trans('system/update.label_user_password') }}.</div>
        </div>
        @error('email-service-password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="email-service-from-email" class="form-label">{{ trans('system/update.sender_email_address') }}</label>
            <input type="email" class="form-control" id="email-service-from-email" name="email-service-from-email" aria-describedby="emailServiceFromEmailHelp" value="{{ $emailServiceFromEmail }}">
            <div id="emailServiceFromEmailHelp" class="form-text">{{ trans('system/update.label_sender_email_address') }}.</div>
        </div>
        @error('email-service-from-email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="email-service-support-email" class="form-label">{{ trans('system/update.support_email_address') }}</label>
            <input type="email" class="form-control" id="email-service-support-email" name="email-service-support-email" aria-describedby="emailServiceSupportEmailHelp" value="{{ $emailServiceSupportEmail }}">
            <div id="emailServiceSupportEmailHelp" class="form-text">
                {{ trans('system/update.label_support_email_address_one') }}.
                <br>
                {{ trans('system/update.label_support_email_address_two') }}.
            </div>
        </div>
        @error('email-service-support-email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button class="btn btn-outline-light" type="submit" name="email-information"><i class="bi bi-envelope"></i> {{ trans('system/update.email_service_update') }}</button>
    </form>
@endsection
