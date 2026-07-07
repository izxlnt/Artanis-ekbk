{{-- Variables: $form, $fillLink, $viewLink, $isDue, $canFill (optional), $dateBlocked (optional), $reason (optional) --}}
@php
    $canFill     = $canFill     ?? null;
    $dateBlocked = $dateBlocked ?? false;
    $reason      = $reason      ?? null;
@endphp
@if($isDue)
    @php $status = $form ? $form->status : 'Tidak Diisi'; @endphp
    @if($status === 'Ditutup')
        <img src="{{ asset('calendar.png') }}" height='28' alt=""
            style="color:grey;font-size:20pt"
            data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka">
    @elseif(in_array($status, ['Tidak Diisi', 'Sedang Diisi']) && $canFill === false)
        {{-- Due but prerequisites not met --}}
        @if($dateBlocked)
            <img src="{{ asset('calendar.png') }}" height='28' alt=""
                data-toggle="tooltip" data-placement="bottom"
                title="{{ $reason ?? 'Tempoh pengisian belum dibuka.' }}"
                style="color:black;font-size:20pt">
        @else
            <img src="{{ asset('circle_times.png') }}" height='28' alt=""
                data-toggle="tooltip" data-placement="bottom"
                title="{{ $reason ?? 'Sila lengkapkan borang sebelumnya terlebih dahulu.' }}"
                style="opacity:0.4">
        @endif
    @elseif($status === 'Tidak Diisi')
        <a href="{{ $fillLink }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
            <img src="{{ asset('circle_times.png') }}" height="28">
        </a>
    @elseif($status === 'Tidak Lengkap')
        <a href="{{ $fillLink }}" data-toggle="tooltip" data-placement="bottom" title="Borang tidak lengkap">
            <img src="{{ asset('history.png') }}" height="28">
        </a>
    @elseif($status === 'Sedang Diisi')
        <a href="{{ $fillLink }}" data-toggle="tooltip" data-placement="bottom" title="Borang sedang diisi">
            <img src="{{ asset('circle_times.png') }}" height="28">
        </a>
    @elseif($status === 'Tiada Pengeluaran')
        <a href="{{ $viewLink }}" data-toggle="tooltip" data-placement="bottom" title="Borang telah dihantar - Tiada Pengeluaran">
            <img src="{{ asset('tp_logo2.png') }}" height="28">
        </a>
    @elseif($status === 'Sedang Diproses')
        <a href="{{ $viewLink }}" data-toggle="tooltip" data-placement="bottom" title="Borang telah dihantar">
            <img src="{{ asset('circle_check_yellow.png') }}" height="28">
        </a>
    @else
        <a href="{{ $viewLink }}" data-toggle="tooltip" data-placement="bottom" title="Borang telah disahkan">
            <img src="{{ asset('circle_check.png') }}" height="28">
        </a>
    @endif
@else
    <img src="{{ asset('calendar.png') }}" height='28' alt=""
        style="color:grey;font-size:20pt"
        data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka">
@endif
