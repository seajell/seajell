<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('bootstraps-icons/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
@component('mail::message', ['data' => $basicEmailDetails])
# Sijil baru telah dikeluarkan kepada anda!

Terdapat sijil baru telah dikeluarkan kepada akaun anda.

- **Nama Acara**: {{ $emailDetails['eventName'] }}
- **ID Sijil**: {{ $emailDetails['certificateID'] }}

@component('mail::button', ['url' => url('/certificate/view/' . $data['data']['certificateID'])])
    <i class="bi bi-arrow-right-square"></i> Lihat Sijil
@endcomponent

Daripada, <br>
@if(!empty($basicEmailDetails['systemName']))
    {{ '**' . strtoupper($basicEmailDetails['systemName']) . '**' }}
@else
    {{ '**SeaJell**' }}
@endif

@if(!empty($basicEmailDetails['supportEmail']))
_Jika anda menghadapi sebarang masalah atau mempunyai pertanyaan, sila hubungi melalui e-mel <a href="mailto:{{ $basicEmailDetails['supportEmail'] }}">{{ $basicEmailDetails['supportEmail'] }}</a> untuk mendapatkan bantuan._
@endif
@endcomponent
