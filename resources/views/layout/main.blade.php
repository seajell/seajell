<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('bootstraps-icons/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('/storage/img/logo/SeaJell-Logo.png') }}" type="image/png">
    <meta name="api-token" content="{{ $apiToken }}">
    <title>{{$orgName . ' - ' . $appName }}</title>
    @bukStyles(true)
</head>
<body>
    <div class="container min-vh-100">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark border border-dark rounded-bottom">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}"><img class="row mb-3" src="{{ asset('/storage/img/logo/SeaJell-Logo.png') }}" alt="SeaJell Logo" style="height: 3em; width: 3em;"></a>
                <a class="navbar-brand" href="{{ route('home') }}">SeaJell</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Laman Utama</a>
                        </li>
                        @if(Gate::allows('authAdmin'))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Acara
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('event.list') }}">Senarai Acara</a></li>
                                <li><a class="dropdown-item" href="{{ route('event.add') }}">Tambah Acara</a></li>
                                </ul>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Sijil
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                
                            <li><a class="dropdown-item" href="{{ route('certificate.list') }}">Senarai Sijil</a></li>
                            @if(Gate::allows('authAdmin'))
                                <li><a class="dropdown-item" href="{{ route('certificate.add') }}">Tambah Sijil</a></li>
                            @endif
                            </ul>
                        </li>
                        @if(Gate::allows('authAdmin'))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Pengguna
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('user.list') }}">Senarai Pengguna</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.add') }}">Tambah Pengguna</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                    <span class="navbar-text">
                        <span class="text-light">Log Masuk Sebagai: <a class="fw-bold" href="{{ route('home') }}">{{ Auth::user()->username }}</a></span>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="btn btn-light" type="submit">Log Keluar</button>
                        </form>
                    </span>
                </div>
            </div>
        </nav>
        <div class="row shadow my-3">
            @yield('content')
        </div>
    </div>
    <footer class="bg-dark text-center text-light pb-4">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <p class="mt-5">Sistem <a class="text-decoration-underline text-light" href="https://github.com/hanisirfan/seajell">SeaJell</a></p>
            <p>Hak Cipta &copy; <a href="http://hanisirfan.xyz" class="text-light">Muhammad Hanis Irfan bin Mohd Zaid</a> 2021</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    @bukScripts(true)
</body>
</html>