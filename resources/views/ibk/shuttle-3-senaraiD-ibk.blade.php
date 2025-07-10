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
                                        <a type="button " href="{{ route('user.shuttle-3-senaraiA', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:black">Borang 3A</a>
                                        <a type="button" href="{{ route('user.shuttle-3-senaraiB', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#e72cc8f3">Borang 3B</a>
                                        <a type="button" href="{{ route('user.shuttle-3-senaraiC', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#bbb235f3">Borang 3C</a>
                                        <a type="button" href="{{ route('user.shuttle-3-senaraiD', date('Y')) }}"
                                            class="btn"
                                            style="background-color:rgb(33, 235, 77);color:black;border-color:rgb(33, 235, 77)">Borang
                                            3D</a>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div>
                                <h4 class="text-center">PENYATA SHUTTLE 3 - KILANG PAPAN</h4>

                                <h4 class="text-center">BORANG 3D - PENYATA PENJUALAN KAYU GERGAJI DALAM PASARAN
                                    TEMPATAN DAN EKSPORT</h4>
                            </div> <br>
                            <div class="">
                                <table id="" class="text-center table-bordered" style="width:100%">
                                    <thead>
                                        <tr style="background-color: rgb(33, 235, 77) ">
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
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '1')
                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp
                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                            <a href="{{ route('user.shuttle-3-formD', $id = 1) }}"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px'
                                                                    alt="" style="font-size: 15pt;"></i></a>
                                                        @else
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang ditutup" aria-hidden="false"
                                                                style="color: black; font-size: 20pt;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '1')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '1')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '1')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah disahkan PHD"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '1')
                                                        <a href="{{ route('edit-form3d', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"> <img
                                                                src="{{ asset('pencil.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '2')
                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp
                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                            <a href="{{ route('user.shuttle-3-formD', $id = 2) }}"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px'
                                                                    alt="" style="font-size: 15pt;"></i></a>
                                                        @else
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang ditutup" aria-hidden="false"
                                                                style="color: black; font-size: 20pt;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '2')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '2')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '2')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah disahkan PHD"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '2')
                                                        <a href="{{ route('edit-form3d', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"> <img
                                                                src="{{ asset('pencil.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '3')
                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp
                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                            <a href="{{ route('user.shuttle-3-formD', $id = 3) }}"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px'
                                                                    alt="" style="font-size: 15pt;"></i></a>
                                                        @else
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang ditutup" aria-hidden="false"
                                                                style="color: black; font-size: 20pt;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '3')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '3')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '3')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah disahkan PHD"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '3')
                                                        <a href="{{ route('edit-form3d', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"> <img
                                                                src="{{ asset('pencil.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '4')
                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp
                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                            <a href="{{ route('user.shuttle-3-formD', $id = 4) }}"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px'
                                                                    alt="" style="font-size: 15pt;"></i></a>
                                                        @else
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang ditutup" aria-hidden="false"
                                                                style="color: black; font-size: 20pt;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '4')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '4')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '4')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah disahkan PHD"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '4')
                                                        <a href="{{ route('edit-form3d', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"> <img
                                                                src="{{ asset('pencil.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '5')
                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp
                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                            <a href="{{ route('user.shuttle-3-formD', $id = 5) }}"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px'
                                                                    alt="" style="font-size: 15pt;"></i></a>
                                                        @else
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang ditutup" aria-hidden="false"
                                                                style="color: black; font-size: 20pt;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '5')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '5')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '5')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah disahkan PHD"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '5')
                                                        <a href="{{ route('edit-form3d', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"> <img
                                                                src="{{ asset('pencil.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '6')
                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp
                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                            <a href="{{ route('user.shuttle-3-formD', $id = 6) }}"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px'
                                                                    alt="" style="font-size: 15pt;"></i></a>
                                                        @else
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang ditutup" aria-hidden="false"
                                                                style="color: black; font-size: 20pt;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '6')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '6')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '6')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah disahkan PHD"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '6')
                                                        <a href="{{ route('edit-form3d', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"> <img
                                                                src="{{ asset('pencil.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '7')
                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp
                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                            <a href="{{ route('user.shuttle-3-formD', $id = 7) }}"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px'
                                                                    alt="" style="font-size: 15pt;"></i></a>
                                                        @else
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang ditutup" aria-hidden="false"
                                                                style="color: black; font-size: 20pt;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '7')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '7')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '7')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah disahkan PHD"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '7')
                                                        <a href="{{ route('edit-form3d', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"> <img
                                                                src="{{ asset('pencil.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '8')
                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp
                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                            <a href="{{ route('user.shuttle-3-formD', $id = 8) }}"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px'
                                                                    alt="" style="font-size: 15pt;"></i></a>
                                                        @else
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang ditutup" aria-hidden="false"
                                                                style="color: black; font-size: 20pt;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '8')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '8')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '8')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah disahkan PHD"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '8')
                                                        <a href="{{ route('edit-form3d', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"> <img
                                                                src="{{ asset('pencil.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '9')
                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp
                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                            <a href="{{ route('user.shuttle-3-formD', $id = 9) }}"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px'
                                                                    alt="" style="font-size: 15pt;"></i></a>
                                                        @else
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang ditutup" aria-hidden="false"
                                                                style="color: black; font-size: 20pt;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '9')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '9')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '9')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah disahkan PHD"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '9')
                                                        <a href="{{ route('edit-form3d', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"> <img
                                                                src="{{ asset('pencil.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '10')
                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp
                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                            <a href="{{ route('user.shuttle-3-formD', $id = 10) }}"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px'
                                                                    alt="" style="font-size: 15pt;"></i></a>
                                                        @else
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang ditutup" aria-hidden="false"
                                                                style="color: black; font-size: 20pt;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '10')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '10')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '10')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah disahkan PHD"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '10')
                                                        <a href="{{ route('edit-form3d', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"> <img
                                                                src="{{ asset('pencil.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '11')
                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp
                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                            <a href="{{ route('user.shuttle-3-formD', $id = 11) }}"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px'
                                                                    alt="" style="font-size: 15pt;"></i></a>
                                                        @else
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang ditutup" aria-hidden="false"
                                                                style="color: black; font-size: 20pt;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '11')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '11')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '11')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah disahkan PHD"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '11')
                                                        <a href="{{ route('edit-form3d', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"> <img
                                                                src="{{ asset('pencil.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '12')
                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp
                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                            <a href="{{ route('user.shuttle-3-formD', $id = 12) }}"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px'
                                                                    alt="" style="font-size: 15pt;"></i></a>
                                                        @else
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang ditutup" aria-hidden="false"
                                                                style="color: black; font-size: 20pt;">
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->bulan == '12')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Lulus' && $data->bulan == '12')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->bulan == '12')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah disahkan PHD"
                                                                style="color: green; font-size: 20pt;"></i>
                                                        </a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->bulan == '12')
                                                        <a href="{{ route('edit-form3d', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap"> <img
                                                                src="{{ asset('pencil.png') }}" height='30px'
                                                                alt=""></i></a>
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

            window.location.href = "<?php echo URL::to('/pengguna/shuttle-3-senaraiD/" + year +"'); ?>";
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
