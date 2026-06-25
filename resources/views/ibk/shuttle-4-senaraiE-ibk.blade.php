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
                                        <a type="button " href="{{ route('user.shuttle-4-senaraiA', $year) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:rgb(196, 188, 186)">Borang
                                            4A</a>
                                        <a type="button" href="{{ route('user.shuttle-4-senaraiB', $year) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#e72cc8f3">Borang 4B</a>
                                        <a type="button" href="{{ route('user.shuttle-4-senaraiC', $year) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#bbb235f3">Borang 4C</a>
                                        <a type="button" href="{{ route('user.shuttle-4-senaraiD', $year) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#1b9e21f3">Borang 4D</a>
                                        <a type="button" href="{{ route('user.shuttle-4-senaraiE', $year) }}"
                                            class="btn"
                                            style="background-color:rgb(54, 140, 238);color:black;border-color:rgb(54, 140, 238">Borang
                                            4E</a>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div>
                                <h4 class="text-center">PENYATA SHUTTLE 4 - KILANG PAPAN LAPIS/VENIR</h4>

                                <h4 class="text-center">BORANG 4E - PENYATA PENJUALAN PAPAN LAPIS/VENIR DALAM PASARAN
                                    TEMPATAN DAN EKSPORT</h4>
                            </div> <br>
                            <div class="">
                                <table id="" class="table-bordered text-center" style="width:100%">
                                    <thead>
                                        <tr style="background-color: #58afe9f3 ">
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
                                        <tr class="text-center">
                                            <td>Tindakan</td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '1')
                                                        @if ($flow['formE'][1]['can_fill'])
                                                            <a href="{{ route('user.shuttle-4-formE', [$year, '1']) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formE'][1]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][1]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][1]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '1')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '1')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '1')
                                                        <a href="{{ route('edit-form4E', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"><img
                                                                src="{{ asset('history.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '1')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diluluskan oleh IPJPSM"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '2')
                                                        @if ($flow['formE'][2]['can_fill'])
                                                            <a href="{{ route('user.shuttle-4-formE', [$year, '2']) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formE'][2]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][2]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][2]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '2')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '2')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '2')
                                                        <a href="{{ route('edit-form4E',  $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"><img
                                                                src="{{ asset('history.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '2')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diluluskan oleh IPJPSM"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '3')
                                                        @if ($flow['formE'][3]['can_fill'])
                                                            <a href="{{ route('user.shuttle-4-formE', [$year, '3']) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formE'][3]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][3]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][3]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '3')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '3')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '3')
                                                        <a href="{{ route('edit-form4E',  $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"><img
                                                                src="{{ asset('history.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '3')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diluluskan oleh IPJPSM"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '4')
                                                        @if ($flow['formE'][4]['can_fill'])
                                                            <a href="{{ route('user.shuttle-4-formE', [$year, '4']) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formE'][4]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][4]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][4]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '4')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '4')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '4')
                                                        <a href="{{ route('edit-form4E',  $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"><img
                                                                src="{{ asset('history.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '4')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diluluskan oleh IPJPSM"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '5')
                                                        @if ($flow['formE'][5]['can_fill'])
                                                            <a href="{{ route('user.shuttle-4-formE', [$year, '5']) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formE'][5]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][5]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][5]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '5')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '5')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '5')
                                                        <a href="{{ route('edit-form4E',  $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"><img
                                                                src="{{ asset('history.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '5')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diluluskan oleh IPJPSM"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '6')
                                                        @if ($flow['formE'][6]['can_fill'])
                                                            <a href="{{ route('user.shuttle-4-formE', [$year, '6']) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formE'][6]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][6]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][6]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '6')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '6')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '6')
                                                        <a href="{{ route('edit-form4E', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"><img
                                                                src="{{ asset('history.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '6')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diluluskan oleh IPJPSM"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '7')
                                                        @if ($flow['formE'][7]['can_fill'])
                                                            <a href="{{ route('user.shuttle-4-formE', [$year, '7']) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formE'][7]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][7]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][7]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '7')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '7')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '7')
                                                        <a href="{{ route('edit-form4E',  $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"><img
                                                                src="{{ asset('history.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '7')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diluluskan oleh IPJPSM"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '8')
                                                        @if ($flow['formE'][8]['can_fill'])
                                                            <a href="{{ route('user.shuttle-4-formE', [$year, '8']) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formE'][8]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][8]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][8]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '8')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '8')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '8')
                                                        <a href="{{ route('edit-form4E',  $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"><img
                                                                src="{{ asset('history.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '8')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diluluskan oleh IPJPSM"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '9')
                                                        @if ($flow['formE'][9]['can_fill'])
                                                            <a href="{{ route('user.shuttle-4-formE', [$year, '9']) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formE'][9]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][9]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][9]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '9')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '9')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '9')
                                                        <a href="{{ route('edit-form4E',  $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"><img
                                                                src="{{ asset('history.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '9')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diluluskan oleh IPJPSM"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '10')
                                                        @if ($flow['formE'][10]['can_fill'])
                                                            <a href="{{ route('user.shuttle-4-formE', [$year, '10']) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formE'][10]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][10]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][10]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '10')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '10')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '10')
                                                        <a href="{{ route('edit-form4E',  $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"><img
                                                                src="{{ asset('history.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '10')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diluluskan oleh IPJPSM"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '11')
                                                        @if ($flow['formE'][11]['can_fill'])
                                                            <a href="{{ route('user.shuttle-4-formE', [$year, '11']) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formE'][11]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][11]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][11]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '11')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '11')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '11')
                                                        <a href="{{ route('edit-form4E',  $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"><img
                                                                src="{{ asset('history.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '11')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diluluskan oleh IPJPSM"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '12')
                                                        @if ($flow['formE'][12]['can_fill'])
                                                            <a href="{{ route('user.shuttle-4-formE', [$year, '12']) }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px' alt="" style="font-size: 15pt;"></a>
                                                        @elseif ($flow['formE'][12]['date_blocked'])
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][12]['reason'] }}" style="color: black; font-size: 20pt;">
                                                        @else
                                                            <img src="{{ asset('circle_times.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $flow['formE'][12]['reason'] }}" style="opacity: 0.5;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '12')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '12')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '12')
                                                        <a href="{{ route('edit-form4E',  $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"><img
                                                                src="{{ asset('history.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '12')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-4-view-form4E', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diluluskan oleh IPJPSM"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @endif
                                                @endforeach
                                            </td>


                                        </tr>
                                    </tbody>
                                </table>
                                <br>

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

            window.location.href = "<?php echo URL::to('/pengguna/shuttle-4-senaraiE/" + year +"'); ?>";
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
            // if($('#example').DataTable().clear().destroy()){
            // $('#example').DataTable();
            // }
        });

        // document.getElementById("form_type").onchange = function() {
        //     myFunction()
        // };

        // function myFunction() {
        //     console.log('asasa');
        //     table.clear().draw();
        // }
    </script>

    <script>
        function onlyNumberKey(evt) {

            // Only ASCII charactar in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
    </script>

    {{-- <style >

    table, th, td {
      border: 1px solid black;
    }
    </style> --}}
@endsection
