@extends('layouts.layout-ipjpsm-nicepage')

@section('content')


    {{-- @livewire('shuttle-three.shuttle3') --}}


    <div>

        <link href="{{ asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css') }}" rel="stylesheet" />


        <script src="{{ asset('https://code.jquery.com/jquery-3.5.1.js') }}"></script>
        <script src="{{ asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js') }}"></script>


        <div class="container-fluid">


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
                                        <a type="button " href="{{ route('shuttle-5-listA', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:black">Borang 5A</a>
                                        <a type="button" href="{{ route('shuttle-5-listB', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#ee8dcd">Borang 5B</a>
                                        <a type="button" href="{{ route('shuttle-5-listC', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#bbb235f3">Borang 5C</a>
                                        <a type="button" href="{{ route('shuttle-5-listD', date('Y')) }}"
                                            class="btn"
                                            style="background-color:rgb(33, 235, 77);color:black;border-color:rgb(33, 235, 77)">Borang
                                            5D</a>
                                        <a type="button" href="{{ route('shuttle-5-listE', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#2692ebf3">Borang 5E</a>

                                    </div>
                                </div>
                            </div>
                            <div class="pt-5 row">
                                <div class="col-md-12">
                            <h4 class="text-center">PENYATA SHUTTLE 5 - KILANG KAYU KUMAI</h4>

                                    <h4 class="text-center">PERAKUAN MAKLUMAT BORANG 5D- PENYATA PENGELUARAN KAYU KUMAI MENGIKUT JENIS KAYU
                                        KUMAI
                                    </h4>

                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="text-center display" style="width:100%">
                                    <thead style="background-color:rgb(33, 235, 77);">
                                        <tr>
                                            <th>Bil</th>
                                            <th>Nama Kilang</th>
                                            <th>Negeri</th>
                                            <th>Daerah Hutan</th>
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
                                        @foreach ($form5D_kilang as $shuttle)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td style="text-align:left">{{ $shuttle->nama_kilang }}</td>
                                                <td>{{ $shuttle->negeri_id }}</td>
                                                <td>{{ $shuttle->daerah_id }}</td>
                                                <td>{{ $shuttle->no_ssm }}</td>
                                                <td>{{ $shuttle->no_lesen ?? 'Tiada' }}</td>

                                                <td>
                                                    @foreach ($form5D as $data)

                                                        @if ($shuttle->id == $data->shuttle_id && $data->bulan == '1')

                                                            @if ($data->status == 'Tidak Diisi')

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

                                                            @elseif($data->status =="Tidak Lengkap")
                                                               <img src="{{ asset('history.png') }}" height='30px' alt=""
                                                                    style="color: #dbd400; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang tidak lengkap "></i>
                                                            @elseif($data->status =="Sedang Diproses")
                                                                <i class="fas fa-times"
                                                                    style="color: #dbd400; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang perlu disahkan PHD "></i>

                                                            @elseif($data->status =="Dihantar ke IPJPSM")

                                                                @php
                                                                    foreach ($batch as $checker) {
                                                                        if ($checker->tahun == $year && $checker->bulan == $data->bulan && $checker->shuttle_id == $shuttle->id) {
                                                                            $current_batch = $checker;
                                                                        }
                                                                    }
                                                                @endphp

                                                                @if ($current_batch->status == 'Dihantar ke IPJPSM' && $current_batch->borang_c == 2)
                                                                    @if ($data->tiada_pengeluaran == 1)
                                                                        <a
                                                                            href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                            <img src="{{ asset('tpbiru.png') }}"
                                                                                height='30px' alt="" data-toggle="tooltip"
                                                                                data-placement="bottom"
                                                                                title="Borang perlu diperaku - Tiada Pengeluaran">
                                                                        </a>
                                                                    @else
                                                                        <a href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}"
                                                                            ><img src="{{ asset('circle_check_yellow.png') }}" height='30px' alt=""
                                                                                style="color: white; font-size: 18pt;"
                                                                                data-toggle="tooltip"
                                                                                data-placement="bottom"
                                                                                title="Borang perlu diperaku"></i></a>
                                                                    @endif
                                                                @else
                                                                    <img src="{{ asset('package.png') }}" height='40px'
                                                                        alt="" data-toggle="tooltip" data-placement="bottom"
                                                                        title="Pakej belum dihantar">
                                                                @endif

                                                            @elseif($data->status =="Lulus")
                                                                @if ($data->tiada_pengeluaran == 1)
                                                                    <img src="{{ asset('tpcoklat.png') }}" height='30px'
                                                                        alt="" data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang telah diperaku">
                                                                @else
                                                                    <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                        style="color: green; font-size: 20pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang telah diperaku"></i>
                                                                @endif
                                                            @break
                                                        @endif
                                                    @endif
                                        @endforeach
                                        </td>


                                        <td>
                                            @foreach ($form5D as $data)

                                                @if ($shuttle->id == $data->shuttle_id && $data->bulan == '2')

                                                    @if ($data->status == 'Tidak Diisi')

                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp

                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)

                                                            <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                style="color: red; font-size: 25pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang tidak diisi"></i>

                                                        @else

                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang ditutup"></i>

                                                        @endif

                                                    @elseif($data->status =="Tidak Lengkap")
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses")
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang perlu disahkan PHD "></i>

                                                    @elseif($data->status =="Dihantar ke IPJPSM")
                                                        @php
                                                            foreach ($batch as $checker) {
                                                                if ($checker->tahun == $year && $checker->bulan == $data->bulan && $checker->shuttle_id == $shuttle->id) {
                                                                    $current_batch = $checker;
                                                                }
                                                            }
                                                        @endphp

                                                        @if ($current_batch->status == 'Dihantar ke IPJPSM' && $current_batch->borang_c == 2)
                                                            @if ($data->tiada_pengeluaran == 1)
                                                                <a
                                                                    href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('tpbiru.png') }}" height='30px'
                                                                        alt="" data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang perlu diperaku - Tiada Pengeluaran">
                                                                </a>
                                                            @else
                                                                <a href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                     <img src="{{ asset('circle_check_yellow.png') }}" height='30px' alt=""
                                                                        style="color: white; font-size: 18pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang perlu diperaku"></i></a>
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('package.png') }}" height='40px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Pakej belum dihantar">
                                                        @endif

                                                    @elseif($data->status =="Lulus")
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <img src="{{ asset('tpcoklat.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku">
                                                        @else
                                                            <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah diperaku"></i>
                                                        @endif
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($form5D as $data)

                                                @if ($shuttle->id == $data->shuttle_id && $data->bulan == '3')

                                                    @if ($data->status == 'Tidak Diisi')

                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp

                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)

                                                            <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                style="color: red; font-size: 25pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang tidak diisi"></i>

                                                        @else

                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang ditutup"></i>

                                                        @endif

                                                    @elseif($data->status =="Tidak Lengkap")
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses")
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang perlu disahkan PHD "></i>

                                                    @elseif($data->status =="Dihantar ke IPJPSM")
                                                        @php
                                                            foreach ($batch as $checker) {
                                                                if ($checker->tahun == $year && $checker->bulan == $data->bulan && $checker->shuttle_id == $shuttle->id) {
                                                                    $current_batch = $checker;
                                                                }
                                                            }
                                                        @endphp

                                                        @if ($current_batch->status == 'Dihantar ke IPJPSM' && $current_batch->borang_c == 2)
                                                            @if ($data->tiada_pengeluaran == 1)
                                                                <a
                                                                    href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('tpbiru.png') }}" height='30px'
                                                                        alt="" data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang perlu diperaku - Tiada Pengeluaran">
                                                                </a>
                                                            @else
                                                            <a href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                <img src="{{ asset('circle_check_yellow.png') }}" height='30px' alt=""
                                                                   style="color: white; font-size: 18pt;"
                                                                   data-toggle="tooltip" data-placement="bottom"
                                                                   title="Borang perlu diperaku"></i></a>
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('package.png') }}" height='40px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Pakej belum dihantar">
                                                        @endif

                                                    @elseif($data->status =="Lulus")
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <img src="{{ asset('tpcoklat.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku">
                                                        @else
                                                            <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah diperaku"></i>
                                                        @endif
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($form5D as $data)

                                                @if ($shuttle->id == $data->shuttle_id && $data->bulan == '4')

                                                    @if ($data->status == 'Tidak Diisi')

                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp

                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)

                                                            <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                style="color: red; font-size: 25pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang tidak diisi"></i>

                                                        @else

                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang ditutup"></i>

                                                        @endif

                                                    @elseif($data->status =="Tidak Lengkap")
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses")
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang perlu disahkan PHD "></i>

                                                    @elseif($data->status =="Dihantar ke IPJPSM")
                                                        @php
                                                            foreach ($batch as $checker) {
                                                                if ($checker->tahun == $year && $checker->bulan == $data->bulan && $checker->shuttle_id == $shuttle->id) {
                                                                    $current_batch = $checker;
                                                                }
                                                            }
                                                        @endphp

                                                        @if ($current_batch->status == 'Dihantar ke IPJPSM' && $current_batch->borang_c == 2)
                                                            @if ($data->tiada_pengeluaran == 1)
                                                                <a
                                                                    href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('tpbiru.png') }}" height='30px'
                                                                        alt="" data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang perlu diperaku - Tiada Pengeluaran">
                                                                </a>
                                                            @else
                                                            <a href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                <img src="{{ asset('circle_check_yellow.png') }}" height='30px' alt=""
                                                                   style="color: white; font-size: 18pt;"
                                                                   data-toggle="tooltip" data-placement="bottom"
                                                                   title="Borang perlu diperaku"></i></a>
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('package.png') }}" height='40px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Pakej belum dihantar">
                                                        @endif

                                                    @elseif($data->status =="Lulus")
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <img src="{{ asset('tpcoklat.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku">
                                                        @else
                                                            <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah diperaku"></i>
                                                        @endif
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($form5D as $data)

                                                @if ($shuttle->id == $data->shuttle_id && $data->bulan == '5')

                                                    @if ($data->status == 'Tidak Diisi')

                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp

                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)

                                                            <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                style="color: red; font-size: 25pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang tidak diisi"></i>

                                                        @else

                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang ditutup"></i>

                                                        @endif

                                                    @elseif($data->status =="Tidak Lengkap")
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses")
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang perlu disahkan PHD "></i>

                                                    @elseif($data->status =="Dihantar ke IPJPSM")
                                                        @php
                                                            foreach ($batch as $checker) {
                                                                if ($checker->tahun == $year && $checker->bulan == $data->bulan && $checker->shuttle_id == $shuttle->id) {
                                                                    $current_batch = $checker;
                                                                }
                                                            }
                                                        @endphp

                                                        @if ($current_batch->status == 'Dihantar ke IPJPSM' && $current_batch->borang_c == 2)
                                                            @if ($data->tiada_pengeluaran == 1)
                                                                <a
                                                                    href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('tpbiru.png') }}" height='30px'
                                                                        alt="" data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang perlu diperaku - Tiada Pengeluaran">
                                                                </a>
                                                            @else
                                                            <a href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                <img src="{{ asset('circle_check_yellow.png') }}" height='30px' alt=""
                                                                   style="color: white; font-size: 18pt;"
                                                                   data-toggle="tooltip" data-placement="bottom"
                                                                   title="Borang perlu diperaku"></i></a>
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('package.png') }}" height='40px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Pakej belum dihantar">
                                                        @endif

                                                    @elseif($data->status =="Lulus")
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <img src="{{ asset('tpcoklat.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku">
                                                        @else
                                                            <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah diperaku"></i>
                                                        @endif
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($form5D as $data)

                                                @if ($shuttle->id == $data->shuttle_id && $data->bulan == '6')

                                                    @if ($data->status == 'Tidak Diisi')

                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp

                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)

                                                            <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                style="color: red; font-size: 25pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang tidak diisi"></i>

                                                        @else

                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang ditutup"></i>

                                                        @endif

                                                    @elseif($data->status =="Tidak Lengkap")
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses")
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang perlu disahkan PHD "></i>

                                                    @elseif($data->status =="Dihantar ke IPJPSM")
                                                        @php
                                                            foreach ($batch as $checker) {
                                                                if ($checker->tahun == $year && $checker->bulan == $data->bulan && $checker->shuttle_id == $shuttle->id) {
                                                                    $current_batch = $checker;
                                                                }
                                                            }
                                                        @endphp

                                                        @if ($current_batch->status == 'Dihantar ke IPJPSM' && $current_batch->borang_c == 2)
                                                            @if ($data->tiada_pengeluaran == 1)
                                                                <a
                                                                    href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('tpbiru.png') }}" height='30px'
                                                                        alt="" data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang perlu diperaku - Tiada Pengeluaran">
                                                                </a>
                                                            @else
                                                            <a href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                <img src="{{ asset('circle_check_yellow.png') }}" height='30px' alt=""
                                                                   style="color: white; font-size: 18pt;"
                                                                   data-toggle="tooltip" data-placement="bottom"
                                                                   title="Borang perlu diperaku"></i></a>
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('package.png') }}" height='40px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Pakej belum dihantar">
                                                        @endif

                                                    @elseif($data->status =="Lulus")
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <img src="{{ asset('tpcoklat.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku">
                                                        @else
                                                            <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah diperaku"></i>
                                                        @endif
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($form5D as $data)

                                                @if ($shuttle->id == $data->shuttle_id && $data->bulan == '7')

                                                    @if ($data->status == 'Tidak Diisi')

                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp

                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)

                                                            <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                style="color: red; font-size: 25pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang tidak diisi"></i>

                                                        @else

                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang ditutup"></i>

                                                        @endif

                                                    @elseif($data->status =="Tidak Lengkap")
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses")
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang perlu disahkan PHD "></i>

                                                    @elseif($data->status =="Dihantar ke IPJPSM")
                                                        @php
                                                            foreach ($batch as $checker) {
                                                                if ($checker->tahun == $year && $checker->bulan == $data->bulan && $checker->shuttle_id == $shuttle->id) {
                                                                    $current_batch = $checker;
                                                                }
                                                            }
                                                        @endphp

                                                        @if ($current_batch->status == 'Dihantar ke IPJPSM' && $current_batch->borang_c == 2)
                                                            @if ($data->tiada_pengeluaran == 1)
                                                                <a
                                                                    href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('tpbiru.png') }}" height='30px'
                                                                        alt="" data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang perlu diperaku - Tiada Pengeluaran">
                                                                </a>
                                                            @else
                                                            <a href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                <img src="{{ asset('circle_check_yellow.png') }}" height='30px' alt=""
                                                                   style="color: white; font-size: 18pt;"
                                                                   data-toggle="tooltip" data-placement="bottom"
                                                                   title="Borang perlu diperaku"></i></a>
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('package.png') }}" height='40px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Pakej belum dihantar">
                                                        @endif

                                                    @elseif($data->status =="Lulus")
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <img src="{{ asset('tpcoklat.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku">
                                                        @else
                                                            <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah diperaku"></i>
                                                        @endif
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($form5D as $data)

                                                @if ($shuttle->id == $data->shuttle_id && $data->bulan == '8')

                                                    @if ($data->status == 'Tidak Diisi')

                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp

                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)

                                                            <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                style="color: red; font-size: 25pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang tidak diisi"></i>

                                                        @else

                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang ditutup"></i>

                                                        @endif

                                                    @elseif($data->status =="Tidak Lengkap")
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses")
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang perlu disahkan PHD "></i>

                                                    @elseif($data->status =="Dihantar ke IPJPSM")
                                                        @php
                                                            foreach ($batch as $checker) {
                                                                if ($checker->tahun == $year && $checker->bulan == $data->bulan && $checker->shuttle_id == $shuttle->id) {
                                                                    $current_batch = $checker;
                                                                }
                                                            }
                                                        @endphp

                                                        @if ($current_batch->status == 'Dihantar ke IPJPSM' && $current_batch->borang_c == 2)
                                                            @if ($data->tiada_pengeluaran == 1)
                                                                <a
                                                                    href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('tpbiru.png') }}" height='30px'
                                                                        alt="" data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang perlu diperaku - Tiada Pengeluaran">
                                                                </a>
                                                            @else
                                                            <a href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                <img src="{{ asset('circle_check_yellow.png') }}" height='30px' alt=""
                                                                   style="color: white; font-size: 18pt;"
                                                                   data-toggle="tooltip" data-placement="bottom"
                                                                   title="Borang perlu diperaku"></i></a>
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('package.png') }}" height='40px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Pakej belum dihantar">
                                                        @endif

                                                    @elseif($data->status =="Lulus")
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <img src="{{ asset('tpcoklat.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku">
                                                        @else
                                                            <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah diperaku"></i>
                                                        @endif
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($form5D as $data)

                                                @if ($shuttle->id == $data->shuttle_id && $data->bulan == '9')

                                                    @if ($data->status == 'Tidak Diisi')

                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp

                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)

                                                            <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                style="color: red; font-size: 25pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang tidak diisi"></i>

                                                        @else

                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang ditutup"></i>

                                                        @endif

                                                    @elseif($data->status =="Tidak Lengkap")
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses")
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang perlu disahkan PHD "></i>

                                                    @elseif($data->status =="Dihantar ke IPJPSM")
                                                        @php
                                                            foreach ($batch as $checker) {
                                                                if ($checker->tahun == $year && $checker->bulan == $data->bulan && $checker->shuttle_id == $shuttle->id) {
                                                                    $current_batch = $checker;
                                                                }
                                                            }
                                                        @endphp

                                                        @if ($current_batch->status == 'Dihantar ke IPJPSM' && $current_batch->borang_c == 2)
                                                            @if ($data->tiada_pengeluaran == 1)
                                                                <a
                                                                    href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('tpbiru.png') }}" height='30px'
                                                                        alt="" data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang perlu diperaku - Tiada Pengeluaran">
                                                                </a>
                                                            @else
                                                            <a href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                <img src="{{ asset('circle_check_yellow.png') }}" height='30px' alt=""
                                                                   style="color: white; font-size: 18pt;"
                                                                   data-toggle="tooltip" data-placement="bottom"
                                                                   title="Borang perlu diperaku"></i></a>
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('package.png') }}" height='40px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Pakej belum dihantar">
                                                        @endif

                                                    @elseif($data->status =="Lulus")
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <img src="{{ asset('tpcoklat.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku">
                                                        @else
                                                            <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah diperaku"></i>
                                                        @endif
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($form5D as $data)

                                                @if ($shuttle->id == $data->shuttle_id && $data->bulan == '10')

                                                    @if ($data->status == 'Tidak Diisi')

                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp

                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)

                                                            <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                style="color: red; font-size: 25pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang tidak diisi"></i>

                                                        @else

                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang ditutup"></i>

                                                        @endif

                                                    @elseif($data->status =="Tidak Lengkap")
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses")
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang perlu disahkan PHD "></i>

                                                    @elseif($data->status =="Dihantar ke IPJPSM")
                                                        @php
                                                            foreach ($batch as $checker) {
                                                                if ($checker->tahun == $year && $checker->bulan == $data->bulan && $checker->shuttle_id == $shuttle->id) {
                                                                    $current_batch = $checker;
                                                                }
                                                            }
                                                        @endphp

                                                        @if ($current_batch->status == 'Dihantar ke IPJPSM' && $current_batch->borang_c == 2)
                                                            @if ($data->tiada_pengeluaran == 1)
                                                                <a
                                                                    href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('tpbiru.png') }}" height='30px'
                                                                        alt="" data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang perlu diperaku - Tiada Pengeluaran">
                                                                </a>
                                                            @else
                                                            <a href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                <img src="{{ asset('circle_check_yellow.png') }}" height='30px' alt=""
                                                                   style="color: white; font-size: 18pt;"
                                                                   data-toggle="tooltip" data-placement="bottom"
                                                                   title="Borang perlu diperaku"></i></a>
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('package.png') }}" height='40px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Pakej belum dihantar">
                                                        @endif

                                                    @elseif($data->status =="Lulus")
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <img src="{{ asset('tpcoklat.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku">
                                                        @else
                                                            <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah diperaku"></i>
                                                        @endif
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($form5D as $data)

                                                @if ($shuttle->id == $data->shuttle_id && $data->bulan == '11')

                                                    @if ($data->status == 'Tidak Diisi')

                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp

                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)

                                                            <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                style="color: red; font-size: 25pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang tidak diisi"></i>

                                                        @else

                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang ditutup"></i>

                                                        @endif

                                                    @elseif($data->status =="Tidak Lengkap")
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses")
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang perlu disahkan PHD "></i>

                                                    @elseif($data->status =="Dihantar ke IPJPSM")
                                                        @php
                                                            foreach ($batch as $checker) {
                                                                if ($checker->tahun == $year && $checker->bulan == $data->bulan && $checker->shuttle_id == $shuttle->id) {
                                                                    $current_batch = $checker;
                                                                }
                                                            }
                                                        @endphp

                                                        @if ($current_batch->status == 'Dihantar ke IPJPSM' && $current_batch->borang_c == 2)
                                                            @if ($data->tiada_pengeluaran == 1)
                                                                <a
                                                                    href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('tpbiru.png') }}" height='30px'
                                                                        alt="" data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang perlu diperaku - Tiada Pengeluaran">
                                                                </a>
                                                            @else
                                                            <a href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                <img src="{{ asset('circle_check_yellow.png') }}" height='30px' alt=""
                                                                   style="color: white; font-size: 18pt;"
                                                                   data-toggle="tooltip" data-placement="bottom"
                                                                   title="Borang perlu diperaku"></i></a>
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('package.png') }}" height='40px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Pakej belum dihantar">
                                                        @endif

                                                    @elseif($data->status =="Lulus")
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <img src="{{ asset('tpcoklat.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku">
                                                        @else
                                                            <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah diperaku"></i>
                                                        @endif
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>


                                        <td>
                                            @foreach ($form5D as $data)

                                                @if ($shuttle->id == $data->shuttle_id && $data->bulan == '12')

                                                    @if ($data->status == 'Tidak Diisi')

                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp

                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)

                                                            <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                style="color: red; font-size: 25pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang tidak diisi"></i>

                                                        @else

                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang ditutup"></i>

                                                        @endif

                                                    @elseif($data->status =="Tidak Lengkap")
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses")
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang perlu disahkan PHD "></i>

                                                    @elseif($data->status =="Dihantar ke IPJPSM")
                                                        @php
                                                            foreach ($batch as $checker) {
                                                                if ($checker->tahun == $year && $checker->bulan == $data->bulan && $checker->shuttle_id == $shuttle->id) {
                                                                    $current_batch = $checker;
                                                                }
                                                            }
                                                        @endphp

                                                        @if ($current_batch->status == 'Dihantar ke IPJPSM' && $current_batch->borang_c == 2)
                                                            @if ($data->tiada_pengeluaran == 1)
                                                                <a
                                                                    href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                    <img src="{{ asset('tpbiru.png') }}" height='30px'
                                                                        alt="" data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang perlu diperaku - Tiada Pengeluaran">
                                                                </a>
                                                            @else
                                                            <a href="{{ route('ipjpsm.shuttle-5-view-formD', $data->id) }}">
                                                                <img src="{{ asset('circle_check_yellow.png') }}" height='30px' alt=""
                                                                   style="color: white; font-size: 18pt;"
                                                                   data-toggle="tooltip" data-placement="bottom"
                                                                   title="Borang perlu diperaku"></i></a>
                                                            @endif
                                                        @else
                                                            <img src="{{ asset('package.png') }}" height='40px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Pakej belum dihantar">
                                                        @endif

                                                    @elseif($data->status =="Lulus")
                                                        @if ($data->tiada_pengeluaran == 1)
                                                            <img src="{{ asset('tpcoklat.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku">
                                                        @else
                                                            <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah diperaku"></i>
                                                        @endif
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        @endforeach
                                        </tr>
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
        function changePage() {

            var year = $("#select_year").val();

            window.location.href = "<?php echo URL::to('/admin/shuttle-5-listD/" + year +"'); ?>";
        }
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
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Seterusnya",
                        "previous": "Sebelumnya"
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
