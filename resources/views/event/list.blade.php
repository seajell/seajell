@extends('layout.main')
@section('content')
    <p class="fs-2">Senarai Pengguna</p>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-dark table-striped w-100 rounded-3 table-bordered border-light align-middle">
                <thead>
                    <tr>
                        <th class="col-1 text-center">ID</th>
                        <th class="col-2 text-center">Username</th>
                        <th class="col-3 text-center">Nama Penuh</th>
                        <th class="col-2 text-center">Alamat E-mel</th>
                        <th class="col-1 text-center">Peranan</th>
                        <th class="col-1 text-center">Lihat</th>
                        <th class="col-1 text-center">Kemas Kini</th>
                        <th class="col-1 text-center">Buang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th class="text-center">{{ $user->id }}</th>
                            <td>{{ strtoupper($user->username) }}</td>
                            <td>{{ strtoupper($user->fullname) }}</td>
                            <td>{{ strtoupper($user->email) }}</td>
                            <td>
                            @if($user->role == 'participant')
                                PESERTA
                            @elseif($user->role == 'admin')
                                ADMIN
                            @elseif($user->role == 'superadmin')
                                SUPERADMIN
                            @endif
                            </td>
                            <td class="fs-3 text-center"><a class="text-light" href=""><i class="bi bi-eye"></i></a></td>
                            <td class="fs-3 text-center"><a class="text-light" href=""><i class="bi bi-pencil-square"></i></a></td>
                            <td class="fs-3 text-center"><a class="text-light" href=""><i class="bi bi-trash"></a></i></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>   
    </div>
@endsection