@extends('layouts.layout-ipjpsm-nicepage')

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
                                                <a href="{{ $breadcrumb['link'] }}" style="color: white !important;" onMouseOver="this.style.color='lightblue'" onMouseOut="this.style.color='white'"> {{ $breadcrumb['name'] }}
                                                </a>
                                            </li>
                                        @else
                                        <li class="breadcrumb-item active" aria-current="page" style="color: yellow !important;">
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
                                        <option value="" selected hidden disabled>
                                            TIADA BORANG DIREKODKAN
                                        </option>
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
                                        <a type="button "
                                            href="{{ route('ipjpsm.borang-keseluruhan.shuttle4.borangA', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:black">Borang
                                            4A</a>
                                        <a type="button"
                                            href="{{ route('ipjpsm.borang-keseluruhan.shuttle4.borangB', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#ee8dcd">Borang 4B</a>
                                        <a type="button"
                                            href="{{ route('ipjpsm.borang-keseluruhan.shuttle4.borangC', date('Y')) }}"
                                            class="btn"
                                            style="background-color:#white;color:black;border-color:#bbb235f3">Borang 4C</a>
                                        <a type="button"
                                            href="{{ route('ipjpsm.borang-keseluruhan.shuttle4.borangD', date('Y')) }}"
                                            class="btn"
                                            style="background-color:rgb(33, 235, 77);color:black;border-color:rgb(33, 235, 77)">Borang 4D</a>
                                        <a type="button"
                                            href="{{ route('ipjpsm.borang-keseluruhan.shuttle4.borangE', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#2692ebf3">Borang 4E</a>

                                    </div>
                                </div>
                            </div>
                            <div class="pt-5 row">
                                <div class="col-md-12">

                                    <h4 class="text-center">SENARAI PENUH MAKLUMAT BORANG - BORANG 4D</h4>

                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="display" style="width:100%">
                                    <thead style="background-color:rgb(33, 235, 77);">
                                        <tr>
                                            <th>Bil</th>
                                            <th>Negeri</th>
                                            <th>Daerah</th>
                                            <th>Nama Kilang</th>
                                            <th>No. SSM</th>
                                            <th>No. Lesen</th>

                                            <th>Jan</th>
                                            <th>Feb</th>
                                            <th>Mac</th>
                                            <th>Apr</th>
                                            <th>Mei</th>
                                            <th>Jun</th>
                                            <th>Jul</th>
                                            <th>Ogo</th>
                                            <th>Sep</th>
                                            <th>Okt</th>
                                            <th>Nov</th>
                                            <th>Dis</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($list_kilang as $shuttle)

                                        <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $shuttle->negeri_id }}</td>
                                                <td>{{ $shuttle->daerah_id }}</td>
                                                <td style="text-align:left">{{ $shuttle->nama_kilang }}</td>
                                                <td>{{ $shuttle->no_ssm }}</td>
                                                <td>{{ $shuttle->no_lesen ?? 'Tiada' }}</td>


                                                <td>
                                                    @if ($form4D)
                                                        @foreach ($form4D as $data)

                                                            @if ($shuttle->id == $data->shuttle_id && $data->bulan == '1')

                                                                @if ($data->status == 'Lulus')
                                                                <a href="{{ route('ipjpsm.shuttle-4-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                        style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Borang telah diperaku "></i></a>
                                                                @elseif($data->status == "Dihantar ke IPJPSM")
                                                                    <img src="{{ asset('circle_check.png') }}" height='30px' alt=""
                                                                        style="color: blue;  font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang telah disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Sedang Diproses")
                                                                    <i class="fas fa-hourglass-start"
                                                                        style="color: yellow;font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang belum disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Tidak Lengkap")
                                                                    <i class="fas fa-undo-alt"
                                                                        style="color: orange; font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang tidak lengkap"></i>
                                                                @elseif($data->status == "Tiada Pengeluaran")
                                                                <i class="fas fa-store-alt-slash" style="color: darkgrey; font-size: 20pt;"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Tiada Pengeluaran"></i>

                                                                @elseif($data->status == "Tidak Diisi")
                                                                    @php
                                                                        $time = strtotime($data->tarikh_tutup_borang);
                                                                        $delay = '+' . $buffer->delay . ' month';
                                                                        $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                                    @endphp
                                                                    @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                                        <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                            style="color: red; font-size: 25pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang tidak diisi"></i>
                                                                    @else
                                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                            style="color: grey; font-size: 20pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang ditutup"></i>
                                                                    @endif

                                                                @endif

                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($form4D)
                                                        @foreach ($form4D as $data)

                                                            @if ($shuttle->id == $data->shuttle_id && $data->bulan == '2')

                                                                @if ($data->status == 'Lulus')
                                                                <a href="{{ route('ipjpsm.shuttle-4-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                        style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Borang telah diperaku "></i></a>
                                                                @elseif($data->status == "Dihantar ke IPJPSM")
                                                                    <img src="{{ asset('circle_check.png') }}" height='30px' alt=""
                                                                        style="color: blue;  font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang telah disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Sedang Diproses")
                                                                    <i class="fas fa-hourglass-start"
                                                                        style="color: yellow;font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang belum disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Tidak Lengkap")
                                                                    <i class="fas fa-undo-alt"
                                                                        style="color: orange; font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang tidak lengkap"></i>
                                                                @elseif($data->status == "Tiada Pengeluaran")
                                                                <i class="fas fa-store-alt-slash" style="color: darkgrey; font-size: 20pt;"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Tiada Pengeluaran"></i>

                                                                @elseif($data->status == "Tidak Diisi")
                                                                    @php
                                                                        $time = strtotime($data->tarikh_tutup_borang);
                                                                        $delay = '+' . $buffer->delay . ' month';
                                                                        $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                                    @endphp
                                                                    @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                                        <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                            style="color: red; font-size: 25pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang tidak diisi"></i>
                                                                    @else
                                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                            style="color: grey; font-size: 20pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang ditutup"></i>
                                                                    @endif

                                                                @endif

                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($form4D)
                                                        @foreach ($form4D as $data)

                                                            @if ($shuttle->id == $data->shuttle_id && $data->bulan == '3')

                                                                @if ($data->status == 'Lulus')
                                                                <a href="{{ route('ipjpsm.shuttle-4-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                        style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Borang telah diperaku "></i></a>
                                                                @elseif($data->status == "Dihantar ke IPJPSM")
                                                                    <img src="{{ asset('circle_check.png') }}" height='30px' alt=""
                                                                        style="color: blue;  font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang telah disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Sedang Diproses")
                                                                    <i class="fas fa-hourglass-start"
                                                                        style="color: yellow;font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang belum disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Tidak Lengkap")
                                                                    <i class="fas fa-undo-alt"
                                                                        style="color: orange; font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang tidak lengkap"></i>
                                                                @elseif($data->status == "Tiada Pengeluaran")
                                                                <i class="fas fa-store-alt-slash" style="color: darkgrey; font-size: 20pt;"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Tiada Pengeluaran"></i>

                                                                @elseif($data->status == "Tidak Diisi")
                                                                    @php
                                                                        $time = strtotime($data->tarikh_tutup_borang);
                                                                        $delay = '+' . $buffer->delay . ' month';
                                                                        $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                                    @endphp
                                                                    @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                                        <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                            style="color: red; font-size: 25pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang tidak diisi"></i>
                                                                    @else
                                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                            style="color: grey; font-size: 20pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang ditutup"></i>
                                                                    @endif

                                                                @endif

                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($form4D)
                                                        @foreach ($form4D as $data)

                                                            @if ($shuttle->id == $data->shuttle_id && $data->bulan == '4')

                                                                @if ($data->status == 'Lulus')
                                                                <a href="{{ route('ipjpsm.shuttle-4-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                        style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Borang telah diperaku "></i></a>
                                                                @elseif($data->status == "Dihantar ke IPJPSM")
                                                                    <img src="{{ asset('circle_check.png') }}" height='30px' alt=""
                                                                        style="color: blue;  font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang telah disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Sedang Diproses")
                                                                    <i class="fas fa-hourglass-start"
                                                                        style="color: yellow;font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang belum disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Tidak Lengkap")
                                                                    <i class="fas fa-undo-alt"
                                                                        style="color: orange; font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang tidak lengkap"></i>
                                                                @elseif($data->status == "Tiada Pengeluaran")
                                                                <i class="fas fa-store-alt-slash" style="color: darkgrey; font-size: 20pt;"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Tiada Pengeluaran"></i>

                                                                @elseif($data->status == "Tidak Diisi")
                                                                    @php
                                                                        $time = strtotime($data->tarikh_tutup_borang);
                                                                        $delay = '+' . $buffer->delay . ' month';
                                                                        $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                                    @endphp
                                                                    @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                                        <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                            style="color: red; font-size: 25pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang tidak diisi"></i>
                                                                    @else
                                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                            style="color: grey; font-size: 20pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang ditutup"></i>
                                                                    @endif

                                                                @endif

                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($form4D)
                                                        @foreach ($form4D as $data)

                                                            @if ($shuttle->id == $data->shuttle_id && $data->bulan == '5')

                                                                @if ($data->status == 'Lulus')
                                                                <a href="{{ route('ipjpsm.shuttle-4-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                        style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Borang telah diperaku "></i></a>
                                                                @elseif($data->status == "Dihantar ke IPJPSM")
                                                                    <img src="{{ asset('circle_check.png') }}" height='30px' alt=""
                                                                        style="color: blue;  font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang telah disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Sedang Diproses")
                                                                    <i class="fas fa-hourglass-start"
                                                                        style="color: yellow;font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang belum disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Tidak Lengkap")
                                                                    <i class="fas fa-undo-alt"
                                                                        style="color: orange; font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang tidak lengkap"></i>
                                                                @elseif($data->status == "Tiada Pengeluaran")
                                                                <i class="fas fa-store-alt-slash" style="color: darkgrey; font-size: 20pt;"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Tiada Pengeluaran"></i>

                                                                @elseif($data->status == "Tidak Diisi")
                                                                    @php
                                                                        $time = strtotime($data->tarikh_tutup_borang);
                                                                        $delay = '+' . $buffer->delay . ' month';
                                                                        $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                                    @endphp
                                                                    @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                                        <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                            style="color: red; font-size: 25pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang tidak diisi"></i>
                                                                    @else
                                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                            style="color: grey; font-size: 20pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang ditutup"></i>
                                                                    @endif

                                                                @endif

                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($form4D)
                                                        @foreach ($form4D as $data)

                                                            @if ($shuttle->id == $data->shuttle_id && $data->bulan == '6')

                                                                @if ($data->status == 'Lulus')
                                                                <a href="{{ route('ipjpsm.shuttle-4-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                        style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Borang telah diperaku "></i></a>
                                                                @elseif($data->status == "Dihantar ke IPJPSM")
                                                                    <img src="{{ asset('circle_check.png') }}" height='30px' alt=""
                                                                        style="color: blue;  font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang telah disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Sedang Diproses")
                                                                    <i class="fas fa-hourglass-start"
                                                                        style="color: yellow;font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang belum disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Tidak Lengkap")
                                                                    <i class="fas fa-undo-alt"
                                                                        style="color: orange; font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang tidak lengkap"></i>
                                                                @elseif($data->status == "Tiada Pengeluaran")
                                                                <i class="fas fa-store-alt-slash" style="color: darkgrey; font-size: 20pt;"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Tiada Pengeluaran"></i>

                                                                @elseif($data->status == "Tidak Diisi")
                                                                    @php
                                                                        $time = strtotime($data->tarikh_tutup_borang);
                                                                        $delay = '+' . $buffer->delay . ' month';
                                                                        $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                                    @endphp
                                                                    @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                                        <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                            style="color: red; font-size: 25pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang tidak diisi"></i>
                                                                    @else
                                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                            style="color: grey; font-size: 20pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang ditutup"></i>
                                                                    @endif

                                                                @endif

                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($form4D)
                                                        @foreach ($form4D as $data)

                                                            @if ($shuttle->id == $data->shuttle_id && $data->bulan == '7')

                                                                @if ($data->status == 'Lulus')
                                                                <a href="{{ route('ipjpsm.shuttle-4-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                        style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Borang telah diperaku "></i></a>
                                                                @elseif($data->status == "Dihantar ke IPJPSM")
                                                                    <img src="{{ asset('circle_check.png') }}" height='30px' alt=""
                                                                        style="color: blue;  font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang telah disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Sedang Diproses")
                                                                    <i class="fas fa-hourglass-start"
                                                                        style="color: yellow;font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang belum disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Tidak Lengkap")
                                                                    <i class="fas fa-undo-alt"
                                                                        style="color: orange; font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang tidak lengkap"></i>
                                                                @elseif($data->status == "Tiada Pengeluaran")
                                                                <i class="fas fa-store-alt-slash" style="color: darkgrey; font-size: 20pt;"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Tiada Pengeluaran"></i>

                                                                @elseif($data->status == "Tidak Diisi")
                                                                    @php
                                                                        $time = strtotime($data->tarikh_tutup_borang);
                                                                        $delay = '+' . $buffer->delay . ' month';
                                                                        $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                                    @endphp
                                                                    @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                                        <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                            style="color: red; font-size: 25pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang tidak diisi"></i>
                                                                    @else
                                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                            style="color: grey; font-size: 20pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang ditutup"></i>
                                                                    @endif

                                                                @endif

                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($form4D)
                                                        @foreach ($form4D as $data)

                                                            @if ($shuttle->id == $data->shuttle_id && $data->bulan == '8')

                                                                @if ($data->status == 'Lulus')
                                                                <a href="{{ route('ipjpsm.shuttle-4-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                        style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Borang telah diperaku "></i></a>
                                                                @elseif($data->status == "Dihantar ke IPJPSM")
                                                                    <img src="{{ asset('circle_check.png') }}" height='30px' alt=""
                                                                        style="color: blue;  font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang telah disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Sedang Diproses")
                                                                    <i class="fas fa-hourglass-start"
                                                                        style="color: yellow;font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang belum disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Tidak Lengkap")
                                                                    <i class="fas fa-undo-alt"
                                                                        style="color: orange; font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang tidak lengkap"></i>
                                                                @elseif($data->status == "Tiada Pengeluaran")
                                                                <i class="fas fa-store-alt-slash" style="color: darkgrey; font-size: 20pt;"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Tiada Pengeluaran"></i>

                                                                @elseif($data->status == "Tidak Diisi")
                                                                    @php
                                                                        $time = strtotime($data->tarikh_tutup_borang);
                                                                        $delay = '+' . $buffer->delay . ' month';
                                                                        $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                                    @endphp
                                                                    @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                                        <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                            style="color: red; font-size: 25pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang tidak diisi"></i>
                                                                    @else
                                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                            style="color: grey; font-size: 20pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang ditutup"></i>
                                                                    @endif

                                                                @endif

                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($form4D)
                                                        @foreach ($form4D as $data)

                                                            @if ($shuttle->id == $data->shuttle_id && $data->bulan == '9')

                                                                @if ($data->status == 'Lulus')
                                                                <a href="{{ route('ipjpsm.shuttle-4-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                        style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Borang telah diperaku "></i></a>
                                                                @elseif($data->status == "Dihantar ke IPJPSM")
                                                                    <img src="{{ asset('circle_check.png') }}" height='30px' alt=""
                                                                        style="color: blue;  font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang telah disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Sedang Diproses")
                                                                    <i class="fas fa-hourglass-start"
                                                                        style="color: yellow;font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang belum disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Tidak Lengkap")
                                                                    <i class="fas fa-undo-alt"
                                                                        style="color: orange; font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang tidak lengkap"></i>
                                                                @elseif($data->status == "Tiada Pengeluaran")
                                                                <i class="fas fa-store-alt-slash" style="color: darkgrey; font-size: 20pt;"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Tiada Pengeluaran"></i>

                                                                @elseif($data->status == "Tidak Diisi")
                                                                    @php
                                                                        $time = strtotime($data->tarikh_tutup_borang);
                                                                        $delay = '+' . $buffer->delay . ' month';
                                                                        $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                                    @endphp
                                                                    @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                                        <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                            style="color: red; font-size: 25pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang tidak diisi"></i>
                                                                    @else
                                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                            style="color: grey; font-size: 20pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang ditutup"></i>
                                                                    @endif

                                                                @endif

                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($form4D)
                                                        @foreach ($form4D as $data)

                                                            @if ($shuttle->id == $data->shuttle_id && $data->bulan == '10')

                                                                @if ($data->status == 'Lulus')
                                                                <a href="{{ route('ipjpsm.shuttle-4-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                        style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Borang telah diperaku "></i></a>
                                                                @elseif($data->status == "Dihantar ke IPJPSM")
                                                                    <img src="{{ asset('circle_check.png') }}" height='30px' alt=""
                                                                        style="color: blue;  font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang telah disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Sedang Diproses")
                                                                    <i class="fas fa-hourglass-start"
                                                                        style="color: yellow;font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang belum disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Tidak Lengkap")
                                                                    <i class="fas fa-undo-alt"
                                                                        style="color: orange; font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang tidak lengkap"></i>
                                                                @elseif($data->status == "Tiada Pengeluaran")
                                                                <i class="fas fa-store-alt-slash" style="color: darkgrey; font-size: 20pt;"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Tiada Pengeluaran"></i>

                                                                @elseif($data->status == "Tidak Diisi")
                                                                    @php
                                                                        $time = strtotime($data->tarikh_tutup_borang);
                                                                        $delay = '+' . $buffer->delay . ' month';
                                                                        $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                                    @endphp
                                                                    @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                                        <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                            style="color: red; font-size: 25pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang tidak diisi"></i>
                                                                    @else
                                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                            style="color: grey; font-size: 20pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang ditutup"></i>
                                                                    @endif

                                                                @endif

                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($form4D)
                                                        @foreach ($form4D as $data)

                                                            @if ($shuttle->id == $data->shuttle_id && $data->bulan == '11')

                                                                @if ($data->status == 'Lulus')
                                                                <a href="{{ route('ipjpsm.shuttle-4-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                        style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Borang telah diperaku "></i></a>
                                                                @elseif($data->status == "Dihantar ke IPJPSM")
                                                                    <img src="{{ asset('circle_check.png') }}" height='30px' alt=""
                                                                        style="color: blue;  font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang telah disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Sedang Diproses")
                                                                    <i class="fas fa-hourglass-start"
                                                                        style="color: yellow;font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang belum disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Tidak Lengkap")
                                                                    <i class="fas fa-undo-alt"
                                                                        style="color: orange; font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang tidak lengkap"></i>
                                                                @elseif($data->status == "Tiada Pengeluaran")
                                                                <i class="fas fa-store-alt-slash" style="color: darkgrey; font-size: 20pt;"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Tiada Pengeluaran"></i>

                                                                @elseif($data->status == "Tidak Diisi")
                                                                    @php
                                                                        $time = strtotime($data->tarikh_tutup_borang);
                                                                        $delay = '+' . $buffer->delay . ' month';
                                                                        $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                                    @endphp
                                                                    @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                                        <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                            style="color: red; font-size: 25pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang tidak diisi"></i>
                                                                    @else
                                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                            style="color: grey; font-size: 20pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang ditutup"></i>
                                                                    @endif

                                                                @endif

                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($form4D)
                                                        @foreach ($form4D as $data)

                                                            @if ($shuttle->id == $data->shuttle_id && $data->bulan == '12')

                                                                @if ($data->status == 'Lulus')
                                                                <a href="{{ route('ipjpsm.shuttle-4-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                        style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Borang telah diperaku "></i></a>
                                                                @elseif($data->status == "Dihantar ke IPJPSM")
                                                                    <img src="{{ asset('circle_check.png') }}" height='30px' alt=""
                                                                        style="color: blue;  font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang telah disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Sedang Diproses")
                                                                    <i class="fas fa-hourglass-start"
                                                                        style="color: yellow;font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang belum disahkan oleh PHD"></i>
                                                                @elseif($data->status == "Tidak Lengkap")
                                                                    <i class="fas fa-undo-alt"
                                                                        style="color: orange; font-size: 25pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang tidak lengkap"></i>
                                                                @elseif($data->status == "Tiada Pengeluaran")
                                                                <i class="fas fa-store-alt-slash" style="color: darkgrey; font-size: 20pt;"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Tiada Pengeluaran"></i>

                                                                @elseif($data->status == "Tidak Diisi")
                                                                    @php
                                                                        $time = strtotime($data->tarikh_tutup_borang);
                                                                        $delay = '+' . $buffer->delay . ' month';
                                                                        $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                                    @endphp
                                                                    @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                                        <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                            style="color: red; font-size: 25pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang tidak diisi"></i>
                                                                    @else
                                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                            style="color: grey; font-size: 20pt;"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title="Borang ditutup"></i>
                                                                    @endif

                                                                @endif

                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @endif
                                                </td>
                                        </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                            </div>
                            <div class="row">
                                <a class="btn btn-primary" href="{{ route('home') }}" style="color:white">Kembali</a>
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

            window.location.href = "<?php echo URL::to('/admin/borang-keseluruhan/shuttle-4/borang-D/" + year +"'); ?>";

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
            var table = $('#example').DataTable({
            ordering : false,
                "language": {
      "lengthMenu": "Memaparkan _MENU_ rekod per halaman",
      "zeroRecords": "Maaf, tiada rekod.",
      "info": "Memaparkan halaman _PAGE_ dari _PAGES_",
      "infoEmpty": "Tidak ada rekod yang tersedia",
      "infoFiltered": "(Ditapis dari _MAX_ jumlah rekod)",
      "search": "Carian",
      "previous": "Sebelum",
      "paginate": {
          "first":      "Pertama",
          "last":       "Terakhir",
          "next":       "Seterusnya",
          "previous":   "Sebelumnya"
      },
  },
            });
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

@endsection
