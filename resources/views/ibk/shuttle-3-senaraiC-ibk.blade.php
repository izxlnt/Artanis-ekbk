@extends('layouts.layout-ibk-nicepage')

@section('content')
    {{-- @livewire('shuttle-three.shuttle3') --}}


    <div>

        <link href="{{ asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css') }}" rel="stylesheet" />


        <script src="{{ asset('https://code.jquery.com/jquery-3.5.1.js') }}"></script>
        <script src="{{ asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js') }}"></script>

        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            @if (session()->has('message'))
                <div class="row">
                    <div class="col-md-12" style="padding-top: 1% ; text-align:center">
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    </div>
                </div>
            @endif

            <div class="page-breadcrumb" style="padding: 0px">
                <div class="pb-2 row">
                    <div class="col-5 align-self-center">
                        <a href="{{ $returnArr['kembali'] }}" class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    @foreach ($returnArr['breadcrumbs'] as $breadcrumb)
                                        @if (!$loop->last)
                                            <li class="breadcrumb-item">
                                                <a href="{{ $breadcrumb['link'] }}" style="color: white !important;"
                                                    onMouseOver="this.style.color='lightblue'"
                                                    onMouseOut="this.style.color='white'"> {{ $breadcrumb['name'] }}
                                                </a>
                                            </li>
                                        @else
                                            <li class="breadcrumb-item active" aria-current="page"
                                                style="color: yellow !important;">
                                                {{ $breadcrumb['name'] }}
                                            </li>
                                        @endif
                                    @endforeach

                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <select name="select_year" id="select_year" class="form-control"
                                        onchange="return changePage();">

                                        @foreach ($year_list as $data)
                                            <option value="{{ $data->tahun }}"
                                                {{ $data->tahun == $year ? 'selected' : '' }}>
                                                Tahun {{ $data->tahun }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a type="button " href="{{ route('user.shuttle-3-senaraiA', $year) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:black">Borang 3A</a>
                                        <a type="button" href="{{ route('user.shuttle-3-senaraiB', $year) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#e72cc8f3">Borang 3B</a>
                                        <a type="button" href="{{ route('user.shuttle-3-senaraiC', $year) }}"
                                            class="btn"
                                            style="background-color:#f3e741f3;color:black;border-color:#f3e741f3">Borang
                                            3C</a>
                                        <a type="button" href="{{ route('user.shuttle-3-senaraiD', $year) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#1b9e21f3">Borang 3D</a>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div>
                                <h4 class="text-center">PENYATA SHUTTLE 3 - KILANG PAPAN</h4>

                                <h4 class="text-center">BORANG 3C - PENYATA KEMASUKAN & PEMPROSESAN KAYU BALAK DAN
                                    PENGELUARAN KAYU GERGAJI
                                    MENGIKUT KUMPULAN KAYU KAYAN</h4>
                            </div>
                            <br>
                            <div class="">
                                <table id="" class="text-center table-bordered" style="width:100%">
                                    <thead>
                                        <tr style="background-color: #f3e741f3 ">
                                            <th width="10%">Bulan</th>
                                            <th width="7.5%">Januari</th>
                                            <th width="7.5%">Februari</th>
                                            <th width="7.5%">Mac</th>
                                            <th width="7.5%">April</th>
                                            <th width="7.5%">Mei</th>
                                            <th width="7.5%">Jun</th>
                                            <th width="7.5%">Julai</th>
                                            <th width="7.5%">Ogos</th>
                                            <th width="7.5%">September</th>
                                            <th width="7.5%">Oktober</th>
                                            <th width="7.5%">November</th>
                                            <th width="7.5%">Disember</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Tindakan</td>
                                            <td>
                                                @if ($list->where('bulan', 1)->isEmpty())
                                                    @if (1 > (int)date('n'))
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @else
                                                        <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                    @endif
                                                @endif
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '1')
                                                                        @if ($flow['formC'][$data->bulan]['can_fill'])
                                                            <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formC'][$data->bulan]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '1')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '1')
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('tpbiru.png') }}" height='30px' alt=""
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD - Tiada Pengeluaran"></a>
                                                        @else
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                    alt="" style="color: green; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD"></i></a>
                                                        @endif
                                                    @elseif($data->status == 'Tiada Pengeluaran' && $data->bulan == '1')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('tp_logo2.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar - Tiada Pengeluaran"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '1')
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 1, $year]) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap" class="mr-1 btn btn-warning"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '1')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Sedang Diisi' && $data->bulan == '1')
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 1, $year]) }}">
                                                            <img src="{{ asset('sync.png') }}" height='30px'
                                                                    alt="" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang sedang diisi">
                                                    @elseif($data->status == 'Ditutup' && $data->bulan == '1')
                                                    @if ($flow['formC'][$data->bulan]['can_fill'])
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($list->where('bulan', 2)->isEmpty())
                                                    @if (2 > (int)date('n'))
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @else
                                                        <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                    @endif
                                                @endif
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '2')
                                                        @if ($flow['formC'][$data->bulan]['can_fill'])
                                                            <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formC'][$data->bulan]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '2')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '2')
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('tpbiru.png') }}" height='30px' alt=""
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD - Tiada Pengeluaran"></a>
                                                        @else
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                    alt="" style="color: green; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD"></i></a>
                                                        @endif
                                                    @elseif($data->status == 'Tiada Pengeluaran' && $data->bulan == '2')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('tp_logo2.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar - Tiada Pengeluaran"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '2')
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 2, $year]) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap" class="mr-1 btn btn-warning"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '2')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Sedang Diisi' && $data->bulan == '2')
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 2, $year]) }}">
                                                            <img src="{{ asset('sync.png') }}" height='30px'
                                                                    alt="" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang sedang diisi">
                                                    @elseif($data->status == 'Ditutup' && $data->bulan == '2')
                                                    @if ($flow['formC'][$data->bulan]['can_fill'])
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($list->where('bulan', 3)->isEmpty())
                                                    @if (3 > (int)date('n'))
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @else
                                                        <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                    @endif
                                                @endif
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '3')
                                                        @if ($flow['formC'][$data->bulan]['can_fill'])
                                                            <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></i></a>
                                                        @elseif ($flow['formC'][$data->bulan]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '3')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '3')
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('tpbiru.png') }}" height='30px' alt=""
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD - Tiada Pengeluaran"></a>
                                                        @else
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                    alt="" style="color: green; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD"></i></a>
                                                        @endif
                                                    @elseif($data->status == 'Tiada Pengeluaran' && $data->bulan == '3')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('tp_logo2.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar - Tiada Pengeluaran"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '3')
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 3, $year]) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap" class="mr-1 btn btn-warning"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '3')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Sedang Diisi' && $data->bulan == '3')
                                                    <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 3, $year]) }}">
                                                        <img src="{{ asset('sync.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip"
                                                        data-placement="bottom" title="Borang sedang diisi">
                                                    @elseif($data->status == 'Ditutup' && $data->bulan == '3')
                                                    @if ($flow['formC'][$data->bulan]['can_fill'])
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($list->where('bulan', 4)->isEmpty())
                                                    @if (4 > (int)date('n'))
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @else
                                                        <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                    @endif
                                                @endif
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '4')
                                                        @if ($flow['formC'][$data->bulan]['can_fill'])
                                                            <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formC'][$data->bulan]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '4')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '4')
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('tpbiru.png') }}" height='30px' alt=""
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD - Tiada Pengeluaran"></a>
                                                        @else
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                    alt="" style="color: green; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD"></i></a>
                                                        @endif
                                                    @elseif($data->status == 'Tiada Pengeluaran' && $data->bulan == '4')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('tp_logo2.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar - Tiada Pengeluaran"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '4')
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 4, $year]) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap" class="mr-1 btn btn-warning"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '4')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Sedang Diisi' && $data->bulan == '4')
                                                    <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 4, $year]) }}">
                                                        <img src="{{ asset('sync.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip"
                                                        data-placement="bottom" title="Borang sedang diisi">
                                                    @elseif($data->status == 'Ditutup' && $data->bulan == '4')
                                                    @if ($flow['formC'][$data->bulan]['can_fill'])
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($list->where('bulan', 5)->isEmpty())
                                                    @if (5 > (int)date('n'))
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @else
                                                        <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                    @endif
                                                @endif
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '5')
                                                        @if ($flow['formC'][$data->bulan]['can_fill'])
                                                            <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formC'][$data->bulan]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '5')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '5')
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('tpbiru.png') }}" height='30px' alt=""
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD - Tiada Pengeluaran"></a>
                                                        @else
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                    alt="" style="color: green; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD"></i></a>
                                                        @endif
                                                    @elseif($data->status == 'Tiada Pengeluaran' && $data->bulan == '5')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('tp_logo2.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar - Tiada Pengeluaran"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '5')
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 5, $year]) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap" class="mr-1 btn btn-warning"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '5')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Sedang Diisi' && $data->bulan == '5')
                                                    <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 5, $year]) }}">
                                                        <img src="{{ asset('sync.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip"
                                                        data-placement="bottom" title="Borang sedang diisi">
                                                    @elseif($data->status == 'Ditutup' && $data->bulan == '5')
                                                    @if ($flow['formC'][$data->bulan]['can_fill'])
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($list->where('bulan', 6)->isEmpty())
                                                    @if (6 > (int)date('n'))
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @else
                                                        <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                    @endif
                                                @endif
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '6')
                                                        @if ($flow['formC'][$data->bulan]['can_fill'])
                                                            <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formC'][$data->bulan]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '6')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '6')
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('tpbiru.png') }}" height='30px' alt=""
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD - Tiada Pengeluaran"></a>
                                                        @else
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                    alt="" style="color: green; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD"></i></a>
                                                        @endif
                                                    @elseif($data->status == 'Tiada Pengeluaran' && $data->bulan == '6')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('tp_logo2.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar - Tiada Pengeluaran"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '6')
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 6, $year]) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap" class="mr-1 btn btn-warning"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '6')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Sedang Diisi' && $data->bulan == '6')
                                                    <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 6, $year]) }}">
                                                        <img src="{{ asset('sync.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip"
                                                        data-placement="bottom" title="Borang sedang diisi">
                                                    @elseif($data->status == 'Ditutup' && $data->bulan == '6')
                                                    @if ($flow['formC'][$data->bulan]['can_fill'])
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($list->where('bulan', 7)->isEmpty())
                                                    @if (7 > (int)date('n'))
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @else
                                                        <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                    @endif
                                                @endif
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '7')
                                                        @if ($flow['formC'][$data->bulan]['can_fill'])
                                                            <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formC'][$data->bulan]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '7')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '7')
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('tpbiru.png') }}" height='30px'
                                                                    alt="" data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD - Tiada Pengeluaran"></a>
                                                        @else
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                    alt="" style="color: green; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD"></i></a>
                                                        @endif
                                                    @elseif($data->status == 'Tiada Pengeluaran' && $data->bulan == '7')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('tp_logo2.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar - Tiada Pengeluaran"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '7')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}"><a
                                                                href="{{ route('user.shuttle-3-formC.KKB', [$id = 7, $year]) }}"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang tidak lengkap" class="mr-1 btn btn-warning"><i
                                                                    class="fas fa-pencil-alt"></i></a>
                                                        @elseif($data->status == 'Lulus' && $data->bulan == '7')
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                    alt="" data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah diperaku"
                                                                    style="color: green; font-size: 20pt;"></i></a>
                                                        @elseif($data->status == 'Sedang Diisi' && $data->bulan == '7')
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 7, $year]) }}">
                                                            <img src="{{ asset('sync.png') }}" height='30px'
                                                                    alt="" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang sedang diisi">
                                                    @elseif($data->status == 'Ditutup' && $data->bulan == '7')
                                                    @if ($flow['formC'][$data->bulan]['can_fill'])
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($list->where('bulan', 8)->isEmpty())
                                                    @if (8 > (int)date('n'))
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @else
                                                        <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                    @endif
                                                @endif
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '8')
                                                        @if ($flow['formC'][$data->bulan]['can_fill'])
                                                            <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formC'][$data->bulan]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '8')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '8')
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('tpbiru.png') }}" height='30px'
                                                                    alt="" data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD - Tiada Pengeluaran"></a>
                                                        @else
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                    alt="" style="color: green; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD"></i></a>
                                                        @endif
                                                    @elseif($data->status == 'Tiada Pengeluaran' && $data->bulan == '8')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('tp_logo2.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar - Tiada Pengeluaran"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '8')
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 8, $year]) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap" class="mr-1 btn btn-warning"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '8')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Sedang Diisi' && $data->bulan == '8')
                                                    <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 8, $year]) }}">
                                                        <img src="{{ asset('sync.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip"
                                                        data-placement="bottom" title="Borang sedang diisi">
                                                    @elseif($data->status == 'Ditutup' && $data->bulan == '8')
                                                    @if ($flow['formC'][$data->bulan]['can_fill'])
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($list->where('bulan', 9)->isEmpty())
                                                    @if (9 > (int)date('n'))
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @else
                                                        <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                    @endif
                                                @endif
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '9')
                                                        @if ($flow['formC'][$data->bulan]['can_fill'])
                                                            <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formC'][$data->bulan]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '9')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '9')
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('tpbiru.png') }}" height='30px'
                                                                    alt="" data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD - Tiada Pengeluaran"></a>
                                                        @else
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                    alt="" style="color: green; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD"></i></a>
                                                        @endif
                                                    @elseif($data->status == 'Tiada Pengeluaran' && $data->bulan == '9')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('tp_logo2.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar - Tiada Pengeluaran"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '9')
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 9, $year]) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap" class="mr-1 btn btn-warning"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '9')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Sedang Diisi' && $data->bulan == '9')
                                                    <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 9, $year]) }}">
                                                        <img src="{{ asset('sync.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip"
                                                        data-placement="bottom" title="Borang sedang diisi">
                                                    @elseif($data->status == 'Ditutup' && $data->bulan == '9')
                                                    @if ($flow['formC'][$data->bulan]['can_fill'])
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($list->where('bulan', 10)->isEmpty())
                                                    @if (10 > (int)date('n'))
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @else
                                                        <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                    @endif
                                                @endif
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '10')
                                                        @if ($flow['formC'][$data->bulan]['can_fill'])
                                                            <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formC'][$data->bulan]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '10')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '10')
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('tpbiru.png') }}" height='30px'
                                                                    alt="" data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD - Tiada Pengeluaran"></a>
                                                        @else
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                    alt="" style="color: green; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD"></i></a>
                                                        @endif
                                                    @elseif($data->status == 'Tiada Pengeluaran' && $data->bulan == '10')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('tp_logo2.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar - Tiada Pengeluaran"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '10')
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 10, $year]) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap" class="mr-1 btn btn-warning"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '10')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Sedang Diisi' && $data->bulan == '10')
                                                    <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 10, $year]) }}">
                                                        <img src="{{ asset('sync.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip"
                                                        data-placement="bottom" title="Borang sedang diisi">
                                                    @elseif($data->status == 'Ditutup' && $data->bulan == '10')
                                                    @if ($flow['formC'][$data->bulan]['can_fill'])
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($list->where('bulan', 11)->isEmpty())
                                                    @if (11 > (int)date('n'))
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @else
                                                        <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                    @endif
                                                @endif
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '11')
                                                        @if ($flow['formC'][$data->bulan]['can_fill'])
                                                            <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formC'][$data->bulan]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '11')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '11')
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('tpbiru.png') }}" height='30px'
                                                                    alt="" data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD - Tiada Pengeluaran"></a>
                                                        @else
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                    alt="" style="color: green; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD"></i></a>
                                                        @endif
                                                    @elseif($data->status == 'Tiada Pengeluaran' && $data->bulan == '11')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('tp_logo2.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar - Tiada Pengeluaran"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '11')
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 11, $year]) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap" class="mr-1 btn btn-warning"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '11')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Sedang Diisi' && $data->bulan == '11')
                                                    <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 11, $year]) }}">
                                                        <img src="{{ asset('sync.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip"
                                                        data-placement="bottom" title="Borang sedang diisi">
                                                    @elseif($data->status == 'Ditutup' && $data->bulan == '11')
                                                    @if ($flow['formC'][$data->bulan]['can_fill'])
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($list->where('bulan', 12)->isEmpty())
                                                    @if (12 > (int)date('n'))
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @else
                                                        <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                    @endif
                                                @endif
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '12')
                                                        @if ($flow['formC'][$data->bulan]['can_fill'])
                                                            <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formC'][$data->bulan]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formC'][$data->bulan]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '12')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '12')
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('tpbiru.png') }}" height='30px'
                                                                    alt="" data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD - Tiada Pengeluaran"></a>
                                                        @else
                                                            <a
                                                                href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                                <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                    alt="" style="color: green; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD"></i></a>
                                                        @endif
                                                    @elseif($data->status == 'Tiada Pengeluaran' && $data->bulan == '12')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('tp_logo2.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar - Tiada Pengeluaran"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '12')
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 12, $year]) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap" class="mr-1 btn btn-warning"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '12')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formC', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Sedang Diisi' && $data->bulan == '12')
                                                    <a href="{{ route('user.shuttle-3-formC.KKB', [$id = 12, $year]) }}">
                                                        <img src="{{ asset('sync.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip"
                                                        data-placement="bottom" title="Borang sedang diisi">
                                                    @elseif($data->status == 'Ditutup' && $data->bulan == '12')
                                                    @if ($flow['formC'][$data->bulan]['can_fill'])
                                                        <a href="{{ route('user.shuttle-3-formC.KKB', [$data->bulan, $year]) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka" style="color: black; font-size: 20pt;">
                                                    @endif
                                                    @endif
                                                @endforeach
                                            </td>


                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <div class="row">
                                    <a class="btn btn-primary" href="{{ route('home-user') }}"
                                        style="color:white">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->


    </div>
    <script>
        function changePage() {
            var year = $("#select_year").val();
            window.location.href = "<?php echo URL::to('/pengguna/shuttle-3-senaraiC/" + year +"'); ?>";
        }

        // Update all form links when page loads
        $(document).ready(function() {
            updateFormLinks();
        });

        function updateFormLinks() {
            var currentYear = {{ $year }};

            // Update all KKB form links
            $('a[href*="shuttle-3-formC/KKB"]').each(function() {
                var href = $(this).attr('href');
                var monthMatch = href.match(/KKB\/(\d+)/);
                if (monthMatch) {
                    var month = monthMatch[1];
                    var newHref = '/pengguna/shuttle-3-formC/KKB/' + month + '/' + currentYear;
                    $(this).attr('href', newHref);
                }
            });

            // Update all KKS form links
            $('a[href*="shuttle-3-formC/KKS"]').each(function() {
                var href = $(this).attr('href');
                var monthMatch = href.match(/KKS\/(\d+)/);
                if (monthMatch) {
                    var month = monthMatch[1];
                    var newHref = '/pengguna/shuttle-3-formC/KKS/' + month + '/' + currentYear;
                    $(this).attr('href', newHref);
                }
            });
        }
    </script>

    <script>
        // document.addEventListener("DOMContentLoaded", () => {
        //     Livewire.hook('component.initialized', (component) => {
        //         console.log(component);
        //         $(document).ready(function() {
        //             $('#example').DataTable();
        //         });
        //     })
        // });
    </script>

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable();
        });

        $(window).on('changed', (e) => {

        });
    </script>

    {{-- <script>
        $(document).ready(function() {
    $('[title]').removeAttr('title');               //remove double tooltip
});
    </script> --}}

    {{-- <script>
        $(document).ready(function(){
            $(".fas fa-calendar-times").hover(function(){
                $(this).attr("data-title", $(this).attr("title"));
                $(this).removeAttr("title");
            }, function(){
                $(this).attr("title", $(this).attr("data-title"));
                $(this).removeAttr("data-title");
            });
        });
    </script> --}}

    <script>
        function onlyNumberKey(evt) {

            // Only ASCII charactar in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
    </script>
@endsection
