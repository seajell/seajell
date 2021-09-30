<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('bootstraps-icons/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
@component('mail::message', ['data' => $data])
# Permintaan penetapan semula kata laluan

Terdapat sebuah permintaan untuk menetapkan semula kata laluan anda.

Jika anda tidak membuat permintaan ini, sila abaikan.

@component('mail::button', ['url' => url('/')])
    <i class="bi bi-arrow-right-square"></i> Tetapkan Semula Kata Laluan
@endcomponent

Daripada, <br>
@if(!empty($data['data']['systemName']))
    {{ '**' . strtoupper($data['data']['systemName']) . '**' }}
@else
    {{ '**SeaJell**' }}
@endif

_Jika anda menghadapi sebarang masalah atau mempunyai pertanyaan, sila hubungi melalui e-mel <a href="mailto:{{ $data['data']['supportEmail'] }}">{{ $data['data']['supportEmail'] }}</a> untuk mendapatkan bantuan._
@endcomponent
