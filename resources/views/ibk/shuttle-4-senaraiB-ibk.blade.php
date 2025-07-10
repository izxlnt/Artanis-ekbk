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
                                        <a type="button " href="{{ route('user.shuttle-4-senaraiA', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:rgb(196, 188, 186)">Borang
                                            4A</a>
                                        <a type="button" href="{{ route('user.shuttle-4-senaraiB', date('Y')) }}"
                                            class="btn"
                                            style="background-color:#ee8dcd;color:black;border-color:#e72cc8f3">Borang
                                            4B</a>
                                        <a type="button" href="{{ route('user.shuttle-4-senaraiC', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#bbb235f3">Borang 4C</a>
                                        <a type="button" href="{{ route('user.shuttle-4-senaraiD', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#1b9e21f3">Borang 4D</a>
                                        <a type="button" href="{{ route('user.shuttle-4-senaraiE', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:rgb(54, 140, 238">Borang
                                            4E</a>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div>
                                <h4 class="text-center">PENYATA SHUTTLE 4 - KILANG PAPAN LAPIS/VENIR</h4>

                                <h4 class="text-center">BORANG 4B - JUMLAH GUNA TENAGA PADA AKHIR BULAN</h4>
                            </div>
                            <br>
                            <div class="">
                                <table id="" class="table-bordered text-center" style="width:100%">
                                    <thead>
                                        <tr style="background-color: #ee8dcd ">
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
                                            <td>-</td>
                                            <td>-</td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->suku_tahun == '1')
                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp
                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                            <a href="{{ route('user.shuttle-4-formB', $id = 1) }}"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px'
                                                                    alt="" style="font-size: 15pt;"></i></a>
                                                        @else
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang ditutup"
                                                                style="color: black; font-size: 20pt;"></i>
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->suku_tahun == '1')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formB', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->suku_tahun == '1')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formB', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->suku_tahun == '1')
                                                        <a href="{{ route('edit-form3b', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap">
                                                            <img src="{{ asset('pencil.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->suku_tahun == '1')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formB', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diluluskan oleh IPJPSM"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->suku_tahun == '2')
                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp
                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                            <a href="{{ route('user.shuttle-4-formB', $id = 2) }}"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px'
                                                                    alt="" style="font-size: 15pt;"></i></a>
                                                        @else
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang ditutup"
                                                                style="color: black; font-size: 20pt;"></i>
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->suku_tahun == '2')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formB', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->suku_tahun == '2')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formB', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->suku_tahun == '2')
                                                        <a href="{{ route('edit-form3b', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap">
                                                            <img src="{{ asset('pencil.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->suku_tahun == '2')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formB', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diluluskan oleh IPJPSM"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->suku_tahun == '3')
                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp
                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                            <a href="{{ route('user.shuttle-4-formB', $id = 3) }}"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px'
                                                                    alt="" style="font-size: 15pt;"></i></a>
                                                        @else
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang ditutup"
                                                                style="color: black; font-size: 20pt;"></i>
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->suku_tahun == '3')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formB', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->suku_tahun == '3')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formB', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->suku_tahun == '3')
                                                        <a href="{{ route('edit-form3b', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap">
                                                            <img src="{{ asset('pencil.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->suku_tahun == '3')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formB', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diluluskan oleh IPJPSM"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>
                                                @foreach ($list as $data)
                                                    @if ($data->status == 'Tidak Diisi' && $data->suku_tahun == '4')
                                                        @php
                                                            $time = strtotime($data->tarikh_tutup_borang);
                                                            $delay = '+' . $buffer->delay . ' month';
                                                            $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));
                                                        @endphp
                                                        @if (date('Y-m-d') >= $data->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini)
                                                            <a href="{{ route('user.shuttle-4-formB', $id = 4) }}"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum diisi">
                                                                <img src="{{ asset('circle_times.png') }}" height='30px'
                                                                    alt="" style="font-size: 15pt;"></i></a>
                                                        @else
                                                            <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang ditutup"
                                                                style="color: black; font-size: 20pt;"></i>
                                                        @endif
                                                    @elseif($data->status == 'Sedang Diproses' && $data->suku_tahun == '4')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formB', $data->id) }}">
                                                            <img src="{{ asset('circle_check_yellow.png') }}"
                                                                height='30px' alt="" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM' && $data->suku_tahun == '4')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formB', $data->id) }}">
                                                            <img src="{{ asset('circle_check.png') }}" height='30px'
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah dihantar"
                                                                style="color: green; font-size: 20pt;"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap' && $data->suku_tahun == '4')
                                                        <a href="{{ route('edit-form3b', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap">
                                                            <img src="{{ asset('pencil.png') }}" height='30px'
                                                                alt=""></i></a>
                                                    @elseif($data->status == 'Lulus' && $data->suku_tahun == '4')
                                                        <a
                                                            href="{{ route('pengguna.shuttle-3-view-formB', $data->id) }}">
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

            window.location.href = "<?php echo URL::to('/pengguna/shuttle-4-senaraiB/" + year +"'); ?>";
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
