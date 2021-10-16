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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="e-Certificate Powered by SeaJell">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('bootstraps-icons/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @if(!empty($systemSetting->logo))
    <link rel="shortcut icon" href="{{ asset('storage/') . $systemSetting->logo }}" type="image/png">
    @else
    <link rel="shortcut icon" href="{{ asset('/storage/logo/SeaJell-Logo.png') }}" type="image/png">
    @endif
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
    @bukStyles(true)
    <meta name="api-token" content="{{ $apiToken }}">
    <title>
        @if(!empty($systemSetting->name))
        {{ strtoupper($systemSetting->name) }}
        @else
        {{ 'SeaJell' }}
        @endif
        {{ '- SeaJell' }}
    </title>

</head>

<body style="background-color: #495057">
    <div class="container min-vh-100">
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark border border-dark rounded-bottom">
                <div class="container-fluid">
                    @if(Storage::disk('public')->exists($systemSetting->logo))
                    <a class="navbar-brand mx-3 system-logo" href="{{ route('home') }}"><img class="row mb-3"
                            src="{{ asset('storage/') . $systemSetting->logo }}" alt="SeaJell Logo"
                            style="height: 5em; width: 5em;"></a>
                    @else
                    <a class="navbar-brand mx-3 system-logo" href="{{ route('home') }}"><img class="row mb-3"
                            src="{{ asset('/storage/logo/SeaJell-Logo.png') }}" alt="SeaJell Logo"
                            style="height: 3em; width: 3em;"></a>
                    @endif
                    <a class="navbar-brand" href="{{ route('home') }}">
                        @if(!empty($systemSetting->name))
                        {{ strtoupper($systemSetting->name) }}
                        @else
                        {{ 'SeaJell' }}
                        @endif
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            @auth
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('home') }}">{{ trans('home/home.home') }}</a>
                            </li>
                            @endauth
                            @if(Gate::allows('authAdmin'))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ trans('home/home.event') }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ route('event.list') }}">{{ trans('home/home.event_list') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('event.add') }}">{{ trans('home/home.add_event') }}</a></li>
                                </ul>
                            </li>
                            @endif
                            @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ trans('home/home.certificate') }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                                    <li><a class="dropdown-item" href="{{ route('certificate.list') }}">{{ trans('home/home.certificate_list') }}</a></li>
                                    @if(Gate::allows('authAdmin'))
                                    <li><a class="dropdown-item" href="{{ route('certificate.add') }}">{{ trans('home/home.add_certificate') }}</a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endauth
                            @if(Gate::allows('authAdmin'))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ trans('home/home.user') }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ route('user.list') }}">{{ trans('home/home.user_list') }}</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('user.add') }}">{{ trans('home/home.add_user') }}</a></li>
                                </ul>
                            </li>
                            @endif
                            @if(Gate::allows('authAdmin'))
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{ route('statistic') }}">{{ trans('home/home.statistic') }}</a>
                            </li>
                            @endif
                            @if(Gate::allows('authAdmin'))
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{ route('system') }}">{{ trans('home/home.system') }}</a>
                            </li>
                            @endif
                        </ul>
                        @auth
                        <span class="navbar-text">
                            <span class="text-light">{{ trans('home/home.logged_in_as') }}: <a class="fw-bold"
                                    href="{{ route('user.update', [Auth::user()->username]) }}">{{ strtoupper(Auth::user()->username) }}</a></span>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button class="btn btn-light" type="submit"><i class="bi bi-door-closed"></i> {{ trans('home/home.log_out') }}</button>
                            </form>
                        </span>
                        @endauth
                    </div>
                </div>
            </nav>
        </header>
        <main>
            <div class="row shadow my-3 bg-dark text-light rounded-3">
                @yield('content')
            </div>
        </main>
    </div>
    <footer class="bg-dark text-center text-light pb-4">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <p class="mt-5"><a class="text-decoration-underline text-light" href="https://www.seajell.xyz/"
                    target="_blank">SeaJell</a> {{ $appVersion }}</p>
            <p>{{ trans('home/home.copyright') }} &copy; The SeaJell Contributors 2021</p>
        </div>
    </footer>

    @include('layout.footer')
</body>

</html>
