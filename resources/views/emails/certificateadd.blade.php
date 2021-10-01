<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('bootstraps-icons/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
@component('mail::message', ['data' => $basicEmailDetails])
# Akaun anda berjaya dicipta!

Anda boleh mengakses akaun anda di <a href="{{ $basicEmailDetails['systemURL'] . '/login' }}" target="_blank">{{ $basicEmailDetails['systemURL'] . '/login' }}</a> dengan maklumat berikut:

- **Username:** {{ $emailDetails['username'] }}
- **Kata Laluan:** {{ $emailDetails['password'] }}

@component('mail::button', ['url' => $basicEmailDetails['systemURL'] . '/login'])
<i class="bi bi-arrow-right-square"></i> Log Masuk
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
