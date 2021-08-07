@extends('layout.main')
@section('content')
    <p class="fs-2">Senarai Sijil</p>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-dark table-striped w-100 rounded-3 table-bordered border-light align-middle">
                <thead>
                    <tr>
                        <th class="col-1 text-center">ID</th>
                        <th class="col-2 text-center">Nama Pengguna</th>
                        <th class="col-3 text-center">Nama Acara</th>
                        <th class="col-2 text-center">Jenis Sijil</th>
                        <th class="col-1 text-center">Kedudukan</th>
                        <th class="col-1 text-center">Lihat</th>
                        @can('authAdmin')
                            <th class="col-1 text-center">Kemas Kini</th>
                            <th class="col-1 text-center">Buang</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($certificates as $certificate)
                        <tr>
                            <th class="text-center">{{ $certificate->id }}</th>
                            <td>{{ strtoupper($certificate->fullname) }}</td>
                            <td>{{ strtoupper($certificate->name) }}</td>
                            <td>
                                @switch($certificate->type)
                                    @case('participation')
                                        PENYERTAAN
                                        @break
                                    @case('achievement')
                                        PENCAPAIAN
                                        @break
                                    @case('appreciation')
                                        PENGHARGAAN
                                        @break
                                    @default
                                        
                                @endswitch
                            </td>
                            <td>{{ strtoupper($certificate->position) }}</td>
                            <td class="fs-3 text-center"><a class="text-light" href=""><i class="bi bi-eye"></i></a></td>
                            @can('authAdmin')
                                <td class="fs-3 text-center"><a class="text-light" href=""><i class="bi bi-pencil-square"></i></a></td>
                                <td class="fs-3 text-center"><a class="text-light" href=""><i class="bi bi-trash"></a></i></td>
                            @endcan   
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $certificates->links() }}
        </div>   
    </div>
@endsection