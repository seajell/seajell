@component('mail::message', ['data' => $basicEmailDetails])
# Akaun anda berjaya dicipta!

Anda boleh mengakses akaun anda di <a href="{{ $basicEmailDetails['systemURL'] . '/login' }}" target="_blank">{{ $basicEmailDetails['systemURL'] . '/login' }}</a> dengan maklumat berikut:

- **Username:** {{ $emailDetails['username'] }}
- **Kata Laluan:** {{ $emailDetails['password'] }}

@component('mail::button', ['url' => $basicEmailDetails['systemURL'] . '/login'])
<i class="bi bi-arrow-right-square"></i> Log Masuk
@endcomponent

@endcomponent
