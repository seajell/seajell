<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('bootstraps-icons/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
@component('mail::message', ['data' => $basicEmailDetails])
# Permintaan Penetapan Semula Kata Laluan

Terdapat permintaan untuk menetapkan semula kata laluan akaun anda.

Jika permintaan tersebut datangnya daripada anda, klik butang di bawah untuk meneruskan permintaan anda:

@component('mail::button', ['url' => $basicEmailDetails['systemURL'] . '/reset-password/' . $emailDetails['token']])
<i class="bi bi-arrow-right-square"></i> Tetapkan Semula Kata Laluan
@endcomponent

jika tidak, anda boleh mengabaikan e-mel ini.

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
