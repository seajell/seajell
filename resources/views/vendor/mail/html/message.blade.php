@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => url('/')])
<div class="row w-100 m-0 d-flex flex-column justify-content-center align-items-center">
    @if(Storage::disk('public')->exists($data['systemLogo']))
        <img class="system-logo" src="{{ asset('storage/') . $data['systemLogo'] }}" alt="SeaJell Logo" style="height: 10em; width: 10em;">
    @else
        <img class="system-logo" src="{{ asset('/storage/logo/SeaJell-Logo.png') }}" alt="SeaJell Logo" style="height: 10em; width: 10em;">
    @endif
    @if(!empty($data['systemName']))
        <p>{{ strtoupper($data['systemName']) }}</p>
    @else
        <p>{{ 'SeaJell' }}</p>
    @endif
</div>
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
Dijana menggunakan sistem <a href="https://www.seajell.xyz">SeaJell</a>.
@endcomponent
@endslot
@endcomponent
