@component('mail::message', ['data' => $basicEmailDetails])
# E-sijil baru telah dikeluarkan kepada anda!

Berikut merupakan maklumat sijil anda:

- **Nama Acara:** {{ strtoupper($emailDetails['eventName']) }}
- **ID Sijil:** {{ $emailDetails['certificateID'] }}

@component('mail::button', ['url' => $basicEmailDetails['systemURL'] . '/certificate/view/' . $emailDetails['certificateID']])
<i class="bi bi-arrow-right-square"></i> Lihat Sijil
@endcomponent

@endcomponent
