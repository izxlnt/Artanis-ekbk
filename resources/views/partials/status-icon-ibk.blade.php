{{--
    IBK status icon for a form row (same rules as partials/status-label with
    role IBK, so the Status pill and this icon always agree).

    Variables:
      $form      the form row (status, tiada_pengeluaran)
      $editLink  optional URL for "Tidak Lengkap" (reopen the form to fix it)
--}}
@php
    $status = $form->status ?? 'Tidak Diisi';
    $isTp = !empty($form->tiada_pengeluaran) && $form->tiada_pengeluaran == 1;
    $editLink = $editLink ?? null;
@endphp
@if ($status === 'Tidak Lengkap')
    @if ($editLink)
        <a href="{{ $editLink }}"><img src="{{ asset('history.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang tidak lengkap"></a>
    @else
        <img src="{{ asset('history.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang tidak lengkap">
    @endif
@elseif ($status === 'Sedang Diproses')
    <img src="{{ asset('circle_check_yellow.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang telah dihantar">
@elseif ($status === 'Tiada Pengeluaran')
    <img src="{{ asset('tp_logo2.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang telah dihantar - Tiada Pengeluaran">
@elseif (in_array($status, ['Dihantar ke IPJPSM', 'Lulus'], true))
    <img src="{{ asset($isTp ? 'tpbiru.png' : 'circle_check.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $isTp ? 'Borang telah disahkan PHD - Tiada Pengeluaran' : 'Borang telah disahkan PHD' }}">
@elseif ($status === 'Ditutup')
    <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang ditutup">
@else
    <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $status === 'Sedang Diisi' ? 'Borang sedang diisi' : 'Borang belum diisi' }}">
@endif
