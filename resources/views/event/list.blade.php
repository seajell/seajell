@extends('layout.main')
@section('content')
    <p class="fs-2">Senarai Acara</p>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-dark table-striped w-100 rounded-3 table-bordered border-light align-middle">
                <thead>
                    <tr>
                        <th class="col text-center">ID</th>
                        <th class="col text-center">Tarikh</th>
                        <th class="col text-center">Lokasi</th>
                        <th class="col text-center">Nama Penganjur</th>
                        <th class="col text-center">Nama Institusi</th>
                        <th class="col text-center">Keterlihatan</th>
                        <th class="col text-center">Lihat</th>
                        <th class="col text-center">Kemas Kini</th>
                        <th class="col text-center">Buang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <th class="text-center">{{ $event->id }}</th>
                            <td>{{ $event->date }}</td>
                            <td>{{ strtoupper($event->location) }}</td>
                            <td>{{ strtoupper($event->organiser_name) }}</td>
                            <td>{{ strtoupper($event->institute_name) }}</td>
                            <td>
                                @if($event->visibility == 'public')
                                    AWAM
                                @elseif($event->visibility == 'hidden')
                                    TERSEMBUNYI
                                @endif
                            </td>
                            <td class="fs-3 text-center"><a class="text-light" href=""><i class="bi bi-eye"></i></a></td>
                            <td class="fs-3 text-center"><a class="text-light" href=""><i class="bi bi-pencil-square"></i></a></td>
                            <td class="fs-3 text-center"><a class="text-light" href=""><i class="bi bi-trash"></a></i></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $users->links() }} --}}
        </div>   
    </div>
@endsection