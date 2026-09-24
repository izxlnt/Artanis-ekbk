{{--
    Status pill for a form row. Uses the same wording as the status icon and
    its tooltip for that role (the "Status icons by role" matrix), so the
    Status column and the Tindakan icon always agree.

    Variables:
      $role         'IBK' | 'PHD' | 'JPN' | 'IPJPSM'
      $form         the form row (status, tiada_pengeluaran)
      $packageSent  optional bool - whether PHD's package reached IPJPSM;
                    only used for PHD/JPN/IPJPSM on 'Dihantar ke IPJPSM'
--}}
@php
    $status = $form->status ?? 'Tidak Diisi';
    $isTp = !empty($form->tiada_pengeluaran) && $form->tiada_pengeluaran == 1;
    $sent = $packageSent ?? true;
    $style = $role === 'IBK' ? '' : 'font-size: 11pt;';

    if ($status === 'Tidak Diisi') {
        [$text, $class] = ['Borang belum diisi', 'label-danger'];
    } elseif ($status === 'Sedang Diisi') {
        [$text, $class] = ['Borang sedang diisi', 'label-danger'];
    } elseif ($status === 'Tidak Lengkap') {
        [$text, $class] = ['Borang tidak lengkap', 'label-danger'];
    } elseif ($status === 'Ditutup') {
        [$text, $class] = ['Borang ditutup', 'label-inverse'];
    } elseif ($role === 'IBK') {
        if ($status === 'Sedang Diproses') {
            [$text, $class] = ['Borang telah dihantar', 'label-warning'];
        } elseif ($status === 'Tiada Pengeluaran') {
            [$text, $class] = ['Borang telah dihantar - Tiada Pengeluaran', 'label-warning'];
        } elseif (in_array($status, ['Dihantar ke IPJPSM', 'Lulus'], true)) {
            [$text, $class] = $isTp
                ? ['Borang telah disahkan PHD - Tiada Pengeluaran', 'label-info']
                : ['Borang telah disahkan PHD', 'label-success'];
        } else {
            [$text, $class] = [$status, 'label-inverse'];
        }
    } else {
        if ($status === 'Sedang Diproses') {
            [$text, $class] = ['Borang perlu disahkan PHD', 'label-primary'];
        } elseif ($status === 'Tiada Pengeluaran') {
            [$text, $class] = ['Borang perlu disahkan PHD - Tiada Pengeluaran', 'label-primary'];
        } elseif ($status === 'Dihantar ke IPJPSM' && !$sent) {
            [$text, $class] = ['Pakej belum dihantar', 'label-warning'];
        } elseif ($status === 'Dihantar ke IPJPSM') {
            if ($role === 'IPJPSM') {
                [$text, $class] = [$isTp ? 'Borang perlu diperaku - Tiada Pengeluaran' : 'Borang perlu diperaku', 'label-primary'];
            } else {
                [$text, $class] = $isTp
                    ? ['Borang telah disahkan PHD - Tiada Pengeluaran', 'label-info']
                    : ['Borang telah disahkan PHD', 'label-success'];
            }
        } elseif ($status === 'Lulus') {
            [$text, $class] = $isTp
                ? ['Borang telah diperaku IPJPSM - Tiada Pengeluaran', 'label-brown']
                : ['Borang telah diperaku', 'label-success'];
        } else {
            [$text, $class] = [$status, 'label-inverse'];
        }
    }
    if ($class === 'label-brown') {
        $class = 'label-inverse';
        $style .= ' background-color:#9c6035;';
    }
@endphp
<span class="label {{ $class }} label-rounded" @if(trim($style) !== '') style="{{ trim($style) }}" @endif>{{ $text }}</span>
