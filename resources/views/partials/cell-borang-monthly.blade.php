{{--
    Monthly form status cell (borang C/D/E).
    Required variables: $data, $current_batch, $buffer, $viewRoute, $batchField
--}}
@if ($data)
    @if ($data->status == 'Tidak Diisi')
        @php
            $tarikh_tutup_terkini = date('Y-m-d',
                strtotime('+' . $buffer->delay . ' month', strtotime($data->tarikh_tutup_borang)));
        @endphp
        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
            <img src="{{ asset('circle_times.png') }}" height='30px' alt=""
                style="color:red;font-size:25pt"
                data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
        @else
            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                style="color:grey;font-size:20pt"
                data-toggle="tooltip" data-placement="bottom" title="Borang ditutup">
        @endif
    @elseif ($data->status == 'Sedang Diisi')
        <img src="{{ asset('circle_times.png') }}" height='30px' alt=""
            style="color:yellow;font-size:25pt"
            data-toggle="tooltip" data-placement="bottom" title="Borang sedang diisi">
    @elseif ($data->status == 'Tidak Lengkap')
        <img src="{{ asset('history.png') }}" height='30px' alt=""
            style="color:#dbd400;font-size:20pt"
            data-toggle="tooltip" data-placement="bottom" title="Borang tidak lengkap">
    @elseif ($data->status == 'Sedang Diproses')
        <img src="{{ asset('circle_times_yellow.png') }}" height='30px' alt=""
            style="color:#dbd400;font-size:25pt"
            data-toggle="tooltip" data-placement="bottom" title="Borang perlu disahkan PHD">
    @elseif ($data->status == 'Tiada Pengeluaran')
        <img src="{{ asset('tp_logo2.png') }}" height='30px' alt=""
            style="color:#dbd400;font-size:20pt"
            data-toggle="tooltip" data-placement="bottom" title="Borang perlu disahkan PHD - Tiada Pengeluaran">
    @elseif ($data->status == 'Dihantar ke IPJPSM')
        @if ($current_batch && $current_batch->status == 'Dihantar ke IPJPSM' && $current_batch->$batchField == 2)
            @if (isset($data->tiada_pengeluaran) && $data->tiada_pengeluaran == 1)
                <a href="{{ route($viewRoute, $data->id) }}">
                    <img src="{{ asset('tpbiru.png') }}" height='30px' alt=""
                        data-toggle="tooltip" data-placement="bottom"
                        title="Borang perlu diperaku - Tiada Pengeluaran">
                </a>
            @else
                <a href="{{ route($viewRoute, $data->id) }}">
                    <img src="{{ asset('circle_check_yellow.png') }}" height='30px' alt=""
                        style="color:white;font-size:18pt"
                        data-toggle="tooltip" data-placement="bottom" title="Borang perlu diperaku">
                </a>
            @endif
        @else
            <img src="{{ asset('package.png') }}" height='40px' alt=""
                data-toggle="tooltip" data-placement="bottom" title="Pakej belum dihantar">
        @endif
    @elseif ($data->status == 'Lulus')
        @if (isset($data->tiada_pengeluaran) && $data->tiada_pengeluaran == 1)
            <a href="{{ route($viewRoute, $data->id) }}">
                <img src="{{ asset('tpcoklat.png') }}" height='30px' alt=""
                    data-toggle="tooltip" data-placement="bottom" title="Borang telah diperaku">
            </a>
        @else
            <a href="{{ route($viewRoute, $data->id) }}">
                <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                    style="color:green;font-size:20pt"
                    data-toggle="tooltip" data-placement="bottom" title="Borang telah diperaku">
            </a>
        @endif
    @else
        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
            style="color:grey;font-size:20pt"
            data-toggle="tooltip" data-placement="bottom" title="Borang ditutup">
    @endif
@endif
