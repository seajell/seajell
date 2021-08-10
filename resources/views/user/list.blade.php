@extends('layout.main')
@section('content')
    <p class="fs-2">Senarai Pengguna</p>
    @if(session()->has('removeUserSuccess'))
        <span><div class="alert alert-success w-100 ml-1">{{ session('removeUserSuccess') }}</div></span>
    @endif
    @error('removeUserError')
        <span><div class="alert alert-danger w-100 ml-1">{{ $message }}</div></span>
    @enderror
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
                            <td class="fs-3 text-center">
                                @if($user->username != 'admin')
                                <a class="text-light" href="{{ route('user.update', [$user->username]) }}"><i class="bi bi-pencil-square"></i></a>      
                                @endif
                            </td>
                            <td class="fs-3 text-center">
                                @if($user->username != 'admin')
                                    <a class="text-light" href="" data-bs-toggle="modal" data-bs-target="#{{ 'delete-user-modal-' . $user->username}}"><i class="bi bi-trash"></a></i>
                                @endif
                            </td>
                        </tr>
                        {{-- 
                            Modal for delete confirmation 
                            --}}
                        <div class="modal fade" id="{{ 'delete-user-modal-' . $user->username}}" tabindex="-1" aria-labelledby="{{ 'delete-user-modal-' . $user->username . '-label'}}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('user.remove') }}" method="post">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="{{ 'delete-user-modal-' . $user->username . '-label'}}">Buang Pengguna</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Anda yakin ingin membuang pengguna ini?</p>
                                            <p>Setiap sijil yang ditambah untuk pengguna ini akan dibuang bersama.</p>
                                            <p class="fw-bold">Username: <span class="fw-normal">{{ strtoupper($user->username) }}</span></p>
                                            <p class="fw-bold">Nama Penuh: <span class="fw-normal">{{ strtoupper($user->fullname) }}</span></p>
                                            <input type="text" name="username" id="username" value="{{ $user->username }}" hidden>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Tidak</button>
                                            <button type="submit" class="btn btn-danger">Ya</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>   
    </div>
@endsection