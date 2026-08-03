{{-- Variables: $form, $fillLink, $viewLink, $isDue, $canFill (optional), $dateBlocked (optional), $reason (optional) --}}
@php
    $canFill     = $canFill     ?? null;
    $dateBlocked = $dateBlocked ?? false;
    $reason      = $reason      ?? null;
    $isOwner     = auth()->check() && auth()->user()->isKilangOwner();
@endphp
@if($isDue)
    @php $status = $form ? $form->status : 'Tidak Diisi'; @endphp
    @if($status === 'Ditutup' && $canFill !== true)
        {{-- Stale/placeholder "Ditutup" status: only show as closed if the flow
             service agrees it isn't actually fillable yet (or flow data is unavailable).
             Same icon rule as the branch below: a real date-window issue (or unknown
             flow data) gets the calendar icon; a missing prerequisite gets the
             dimmed X circle, not a date icon. --}}
        @if($dateBlocked || $canFill === null)
            <img src="{{ asset('calendar.png') }}" height='28' alt=""
                style="color:grey;font-size:20pt"
                data-toggle="tooltip" data-placement="bottom" title="{{ $reason ?? 'Borang belum dibuka' }}">
        @else
            <img src="{{ asset('circle_times.png') }}" height='28' alt=""
                data-toggle="tooltip" data-placement="bottom"
                title="{{ $reason ?? 'Sila lengkapkan borang sebelumnya terlebih dahulu.' }}"
                style="opacity:0.4">
        @endif
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
    @elseif($status === 'Tidak Diisi' || $status === 'Ditutup')
        @if($isOwner)
            <img src="{{ asset('circle_times.png') }}" height="28" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
        @else
            <a href="{{ $fillLink }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                <img src="{{ asset('circle_times.png') }}" height="28">
            </a>
        @endif
    @elseif($status === 'Tidak Lengkap')
        @if($isOwner)
            <img src="{{ asset('history.png') }}" height="28" data-toggle="tooltip" data-placement="bottom" title="Borang tidak lengkap">
        @else
            <a href="{{ $fillLink }}" data-toggle="tooltip" data-placement="bottom" title="Borang tidak lengkap">
                <img src="{{ asset('history.png') }}" height="28">
            </a>
        @endif
    @elseif($status === 'Sedang Diisi')
        @if($isOwner)
            <img src="{{ asset('circle_times.png') }}" height="28" data-toggle="tooltip" data-placement="bottom" title="Borang sedang diisi">
        @else
            <a href="{{ $fillLink }}" data-toggle="tooltip" data-placement="bottom" title="Borang sedang diisi">
                <img src="{{ asset('circle_times.png') }}" height="28">
            </a>
        @endif
    @elseif($status === 'Tiada Pengeluaran')
        @if($isOwner)
            <img src="{{ asset('tp_logo2.png') }}" height="28" data-toggle="tooltip" data-placement="bottom" title="Borang telah dihantar - Tiada Pengeluaran">
        @else
            <a href="{{ $viewLink }}" data-toggle="tooltip" data-placement="bottom" title="Borang telah dihantar - Tiada Pengeluaran">
                <img src="{{ asset('tp_logo2.png') }}" height="28">
            </a>
        @endif
    @elseif($status === 'Sedang Diproses')
        @if($isOwner)
            <img src="{{ asset('circle_check_yellow.png') }}" height="28" data-toggle="tooltip" data-placement="bottom" title="Borang telah dihantar">
        @else
            <a href="{{ $viewLink }}" data-toggle="tooltip" data-placement="bottom" title="Borang telah dihantar">
                <img src="{{ asset('circle_check_yellow.png') }}" height="28">
            </a>
        @endif
    @else
        @if($isOwner)
            <img src="{{ asset('circle_check.png') }}" height="28" data-toggle="tooltip" data-placement="bottom" title="Borang telah disahkan">
        @else
            <a href="{{ $viewLink }}" data-toggle="tooltip" data-placement="bottom" title="Borang telah disahkan">
                <img src="{{ asset('circle_check.png') }}" height="28">
            </a>
        @endif
    @endif
@else
    <img src="{{ asset('calendar.png') }}" height='28' alt=""
        style="color:grey;font-size:20pt"
        data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka">
@endif
