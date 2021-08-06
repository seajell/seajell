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
    <title>SeaJell</title>
</head>
<body class="min-vh-100">
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center vh-100">
        <img class="row mb-3" src="{{ asset('/storage/img/logo/SeaJell-Logo.png') }}" alt="SeaJell Logo" style="height: 7em; width: 7em;">
        <div class="row w-100 mb-3">
            <div class="col-4 rounded-start d-flex flex-column align-items-center justify-content-center bg-dark text-light border border-dark border-2">
                <p class="fw-bold fs-1">SeaJell</p>
                <p class="fw-normal fs-4">Log Masuk</p>
            </div>
            <div class="col-8 rounded-end bg-light text-dark border border-dark border-2">
                <form action="" method="post">
                    @csrf
                    <div class="my-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="">
                    </div>
                    @error('username')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="my-3">
                        <label for="password" class="form-label">Kata Laluan</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="">
                    </div>
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <button class="btn btn-dark mb-3" type="submit">Log Masuk</button>
                </form>
            </div>
        </div>
        <div class="row-100 text-center">
            <p>Sistem <a class="text-decoration-underline text-dark" href="">SeaJell</a></p>
            <p>Hak Cipta &copy; Muhammad Hanis Irfan bin Mohd Zaid 2021</p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>
</html>