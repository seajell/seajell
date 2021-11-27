@component('mail::message', ['data' => $basicEmailDetails])
# Permintaan Penetapan Semula Kata Laluan

Terdapat permintaan untuk menetapkan semula kata laluan akaun anda.

Jika permintaan tersebut datangnya daripada anda, klik butang di bawah untuk meneruskan permintaan anda:

@component('mail::button', ['url' => $basicEmailDetails['systemURL'] . '/reset-password/' . $emailDetails['token']])
<i class="bi bi-arrow-right-square"></i> Tetapkan Semula Kata Laluan
@endcomponent

jika tidak, anda boleh mengabaikan e-mel ini.

@endcomponent
