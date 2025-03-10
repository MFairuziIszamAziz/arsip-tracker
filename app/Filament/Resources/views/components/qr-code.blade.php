@if ($getState())
    <img src="{{ $getState() }}" alt="QR Code" style="max-width: 200px;">
@else
    <p>QR Code tidak tersedia</p>
@endif
