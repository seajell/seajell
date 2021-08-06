@extends('layout.main')
@section('content')
    <p class="fs-2">Tambah Pengguna</p>
    <form action="" method="post" class="mb-3">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nama Penuh Pengguna</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" name="" placeholder="Masukkan nama penuh pengguna.">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Alamat E-mel</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" name="" placeholder="Masukkan alamat e-mel pengguna.">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Kata Laluan</label>
            <input type="password" class="form-control" id="exampleFormControlInput1" name="" placeholder="Masukkan kata laluan pengguna.">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Sahkan Kata Laluan</label>
            <input type="password" class="form-control" id="exampleFormControlInput1" name="" placeholder="Masukkan kata laluan pengguna.">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nombor Kad Pengenalan</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" name="" placeholder="Masukkan nombor kad pengenalan pengguna.">
        </div>
        <label for="role" class="form-label">Peranan Pengguna</label>
        <select class="form-select mb-3" name="role" id="role" aria-label="role">
            <option value="admin">Admin</option>
            <option value="participant">Peserta</option>
        </select>
        <button class="btn btn-dark" type="submit">Cipta Akaun Pengguna</button>
    </form>
@endsection