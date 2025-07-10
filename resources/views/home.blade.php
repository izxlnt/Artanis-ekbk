@extends('layouts.layout-ipjpsm-nicepage')
@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" rel="stylesheet" type="text/css">
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/my/my-all.js"></script>
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">

        <div class="row">
            {{-- <div class="col-2"></div> --}}
            <div class="col-12">

                {{-- Flash Message --}}
                @if ($message = Session::get('success'))
                    <div class="border alert alert-success border-success" style="text-align: center;">{{ $message }}
                    </div>
                @elseif ($message = Session::get('error'))
                    <div class="border alert alert-danger border-danger" style="text-align: center;">{{ $message }}
                    </div>
                    {{-- @else --}}
                    {{-- Hidden Gap - Just Ignore --}}
                    <div class="alert alert-white" style="text-align: center;"></div>
                    {{-- <div style="padding: 23px;"></div> --}}
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-header bg-info"
                            style="text-align:center; background-color: #f3ce8f !important; font-size: 130%; font-weight: bold;">
                            <h4 class="text-white m-b-0" style="background-color: #f3ce8f "><b>SENARAI KILANG AKTIF</b></h4>
                        </div>
                        <br>
                    </div>
                </div>

                <div class="row" style="justify-content: space-around;">

                    <a class="col-lg-4 col-md-6" href="{{ route('senarai_kilang_papan_aktif_ipjpsm') }}"
                        style="color:black;">

                        <div class="card bg-info card-hover" style="border-radius: 25px">
                            <div class="card-body"
                                style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #ee8dcd ;border-radius: 25px;text-align:center;">
                                <div class="d-flex no-block align-items-center">
                                    <div class="text-white">
                                        <b><span style="font-size:40px;">{{ $count_shuttle3 }}</span><span
                                                style="font-size:25px;"> &nbsp aktif</span></b>
                                        <h5>Jumlah Kilang Papan </h5>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><img style="width:60px;height:60px"
                                                src="{{ asset('kilang_kayu_balak.png') }}"></img></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a class="col-lg-4 col-md-6" href="{{ route('senarai_kilang_papan_lapis_aktif_ipjpsm') }}"
                        style="color:black;">

                        <div class="card bg-info card-hover" style="border-radius: 25px">
                            <div class="card-body"
                                style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #f0e10dbd ;border-radius: 25px;text-align:center;">
                                <div class="d-flex no-block align-items-center">
                                    <div class="text-white">
                                        <b><span style="font-size:40px;">{{ $count_shuttle4 }}</span><span
                                                style="font-size:25px;">&nbsp aktif</span></b>
                                        <h5>Jumlah Kilang Papan Lapis/Venir</h5>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><img style="width:50px;height:50px"
                                                src="{{ asset('kilang_kayu_papan_lapis.png') }}"></img></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a class="col-lg-4 col-md-6" href="{{ route('senarai_kilang_kumai_aktif_ipjpsm') }}"
                        style="color:black;">

                        <div class="card bg-info card-hover" style="border-radius: 25px">
                            <div class="card-body"
                                style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #6df173 ;border-radius: 25px;text-align:center;">
                                <div class="d-flex no-block align-items-center">
                                    <div class="text-white">
                                        <b><span style="font-size:40px;">{{ $count_shuttle5 }}</span><span
                                                style="font-size:25px;">&nbsp aktif</span></b>
                                        <h5>Jumlah Kilang Kayu Kumai </h5>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><img style="width:50px;height:50px"
                                                src="{{ asset('kilang_kayu_kumai.png') }}"></img></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-12">

                        <div class="card-header bg-info"
                            style="text-align:center; background-color: #f3ce8f !important; font-size: 130%; font-weight: bold;">
                            <h4 class="text-white m-b-0" style="background-color: #f3ce8f "><b>SENARAI BORANG YANG BELUM DISAHKAN OLEH IPJPSM/BPE</b></h4>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" style="justify-content: space-around;">
                    <a class="col-lg-4 col-md-6" href="{{ route('shuttle-3-listA', date('Y')) }}" style="color:black;">
                        <div class="card bg-info card-hover" style="border-radius: 25px">
                            <div class="card-body"
                                style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #ee8dcd ;border-radius: 25px;text-align:center;">
                                <div class="d-flex no-block align-items-center">
                                    <div class="text-white">
                                        <b><span style="font-size:40px;" id="count_tugasan_shuttle3">0</span></b>
                                        <h5>Kilang Papan</h5>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><i class="fas fa-copy"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="col-lg-4 col-md-6" href="{{ route('shuttle-4-listA', date('Y')) }}" style="color:black;">
                        <div class="card bg-info card-hover" style="border-radius: 25px">
                            <div class="card-body"
                                style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #f0e10dbd ;border-radius: 25px;text-align:center;">
                                <div class="d-flex no-block align-items-center">
                                    <div class="text-white">
                                        <b><span style="font-size:40px;" id="count_tugasan_shuttle4">0</span></b>
                                        <h5>Kilang Papan Lapis/Venir</h5>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><i class="fas fa-copy"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="col-lg-4 col-md-6" href="{{ route('shuttle-5-listA', date('Y')) }}" style="color:black;">
                        <div class="card bg-info card-hover" style="border-radius: 25px">
                            <div class="card-body"
                                style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #6df173 ;border-radius: 25px;text-align:center;">
                                <div class="d-flex no-block align-items-center">
                                    <div class="text-white">
                                        <b><span style="font-size:40px;" id="count_tugasan_shuttle5">0</span></b>
                                        <h5>Kilang Kayu Kumai</h5>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><i class="fas fa-copy"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                {{-- <hr>
            <div class="row" style="justify-content: space-around;">
                <h4>Jumlah borang yang belum lengkap dihantar oleh IBK pada bulan {{ date('m') }}</h4>
            </div>
            <br>
            <div class="row" style="justify-content: space-around;" >
                <a class="col-lg-4 col-md-6" href="{{ route('phd.senarai-tugasan-3A', date("Y")) }}" style="color:black;">
                    <div class="card bg-info card-hover" style="border-radius: 25px">
                        <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #ee8dcd ;border-radius: 25px;text-align:center;">
                            <div class="d-flex no-block align-items-center">
                                <div class="text-white">
                                    <h3 id="count_undeclare_shuttle3">0</h3>
                                    <h5>Kilang Papan</h5>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fas fa-file-excel"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="col-lg-4 col-md-6" href="{{ route('phd.senarai-tugasan-3A', date("Y")) }}" style="color:black;">
                    <div class="card bg-info card-hover" style="border-radius: 25px">
                        <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #f0e10dbd ;border-radius: 25px;text-align:center;">
                            <div class="d-flex no-block align-items-center">
                                <div class="text-white">
                                    <h3 id="count_undeclare_shuttle4">0</h3>
                                    <h5>Kilang Papan Lapis/Venir</h5>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fas fa-file-excel"></i></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="col-lg-4 col-md-6" href="{{ route('phd.senarai-tugasan-3A', date("Y")) }}" style="color:black;">
                    <div class="card bg-info card-hover" style="border-radius: 25px">
                        <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #6df173 ;border-radius: 25px;text-align:center;">
                            <div class="d-flex no-block align-items-center">
                                <div class="text-white">
                                    <h3 id="count_undeclare_shuttle5">0</h3>
                                    <h5>Kilang Kayu Kumai</h5>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fas fa-file-excel"></i></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div> --}}
                <div class="row">
                    <div class="col-md-12">
                        {{-- <div class="card bg-info">
                            <div class="card-body" style="text-align:center;margin-bottom:-1%;margin-top:-1%;">
                                <h4><b>SENARAI STATUS PERMOHONAN PENGGUNA</b></h4>
                            </div>
                        </div> --}}

                        <div class="card-header bg-info"
                            style="text-align:center; background-color: #f3ce8f !important; font-size: 130%; font-weight: bold;">
                            <h4 class="text-white m-b-0" style="background-color: #f3ce8f "><b>SENARAI STATUS PERMOHONAN PENGGUNA</b></h4>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" style="justify-content: space-around;">
                    <a class="col-lg-4 col-md-6" href="{{ route('ipjpsm.status-permohonan-shuttle-3-kilang') }}"
                        style="color:black;">
                        <div class="card bg-info card-hover" style="border-radius: 25px">
                            <div class="card-body"
                                style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #ee8dcd ;border-radius: 25px;text-align:center;">
                                <div class="d-flex no-block align-items-center">
                                    <div class="text-white">
                                        <b><span style="font-size:40px;" id="ibk">0</span></b>
                                        <h5>Industri Berasas Kayu (IBK)</h5>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><i class="fas fa-user"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="col-lg-4 col-md-6" href="{{ route('ipjpsm.status-permohonan-phd') }}" style="color:black;">
                        <div class="card bg-info card-hover" style="border-radius: 25px">
                            <div class="card-body"
                                style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #f0e10dbd ;border-radius: 25px;text-align:center;">
                                <div class="d-flex no-block align-items-center">
                                    <div class="text-white">
                                        <b><span style="font-size:40px;" id="phd">0</span></b>
                                        <h5>Pejabat Hutan Daerah (PHD)</h5>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><i class="fas fa-user"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="col-lg-4 col-md-6" href="{{ route('ipjpsm.status-permohonan-jpn') }}" style="color:black;">
                        <div class="card bg-info card-hover" style="border-radius: 25px">
                            <div class="card-body"
                                style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #6df173 ;border-radius: 25px;text-align:center;">
                                <div class="d-flex no-block align-items-center">
                                    <div class="text-white">
                                        <b><span style="font-size:40px;" id="ipjpsm">0</span></b>
                                        <h5>Jabatan Perhutanan Negeri (JPN)</h5>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><i class="fas fa-user"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="border card-header bg-info ">
                                <h4 class="text-white m-b-0" style="text-align: center;"><b>BILANGAN RESPONDEN</b></h4>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <select name="select_kilang" id="select_kilang" class="form-control" onchange="">
                                        <option value="3" selected>
                                            Kilang Papan
                                        </option>
                                        <option value="4">
                                            Kilang Papan Lapis/Venir
                                        </option>
                                        <option value="5">
                                            Kilang Kayu Kumai
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="border card-body" style="">
                                <div class="chart1 m-t-40" align='center' style="position: relative; height:400px;">
                                    {{-- <div id="barchart_material"></div> --}}
                                    {{-- <div id="top_x_div" style="width: 800px; height: 100%;"></div> --}}
                                    <canvas class="bar-chart" id="bar">
                                    </canvas>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>



                {{-- <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="border card-header bg-info ">
                                <h4 class="text-white m-b-0" style="text-align: center;"><b>BILANGAN RESPONDEN</h4>
                            </div>
                            <div style="col-md-3">
                                IPJPSM <br><br>
                                <img src="{{ asset('calendar.png') }}" height='30px' alt="" style="color: grey; font-size: 20pt;"
                                    data-toggle="tooltip" data-placement="bottom" title="Borang ditutup"></i> Borang
                                ditutup<br><br>

                                <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt="" style="color: red; font-size: 25pt;" data-toggle="tooltip"
                                    data-placement="bottom" title="Borang tidak diisi"></i> Borang tidak diisi<br><br>

                                <i class="fas fa-sync" style="color: yellow; font-size: 25pt;" data-toggle="tooltip"
                                    data-placement="bottom" title="Borang sedang diisi"> </i> Borang sedang diisi<br><br>

                               <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: red; font-size: 20pt;" data-toggle="tooltip"
                                    data-placement="bottom" title="Borang tidak lengkap "></i> Borang tidak lengkap<br><br>

                                <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                    data-toggle="tooltip" data-placement="bottom" title="Borang belum disahkan PHD "></i>
                                Borang belum disahkan PHD
                                <br><br>


                                <img src="{{ asset('tp_logo2.png') }}" height='30px' alt="" data-toggle="tooltip"
                                    data-placement="bottom" title="Borang perlu diperaku - Tiada Pengeluaran"> Borang perlu
                                diperaku - Tiada Pengeluaran <br><br>

                                <a href="#" class="btn btn-primary"> <i class="fas fa-eye"
                                        style="color: white; font-size: 18pt;" data-toggle="tooltip" data-placement="bottom"
                                        title="Borang perlu diperaku"></i></a> Borang perlu diperaku <br><br>

                                <img src="{{ asset('package.png') }}" height='40px' alt="" data-toggle="tooltip"
                                    data-placement="bottom" title="Pakej belum dihantar"> Pakej belum dihantar PHD <br><br>

                                <img src="{{ asset('tp_logo.png') }}" height='30px' alt="" data-toggle="tooltip"
                                    data-placement="bottom" title="Borang telah disahkan"> Borang telah diperaku - TP
                                <br><br>

                                <img src="{{ asset('double_check.png') }}" height='30px' alt="" style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                    data-placement="bottom" title="Borang telah diperaku"></i> Borang telah diperaku
                                <br><br>
                            </div>
                            <hr>



                            <div style="col-md-3">
                                PHD <br><br>
                                <img src="{{ asset('calendar.png') }}" height='30px' alt="" style="color: grey; font-size: 20pt;"
                                    data-toggle="tooltip" data-placement="bottom" title="Borang ditutup"></i> Borang
                                ditutup<br><br>

                                <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt="" style="color: red; font-size: 20pt;" data-toggle="tooltip"
                                    data-placement="bottom" title="Borang belum diisi"></i></i> Borang belum diisi<br><br>

                                <i class="fas fa-sync" style="color: yellow; font-size: 25pt;" data-toggle="tooltip"
                                    data-placement="bottom" title="Borang sedang diisi"> </i> Borang sedang diisi<br><br>

                               <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: red; font-size: 20pt;" data-toggle="tooltip"
                                    data-placement="bottom" title="Borang tidak lengkap "></i> Borang tidak lengkap<br><br>

                                <img src="{{ asset('tp_logo2.png') }}" height='30px' alt="" data-toggle="tooltip"
                                    data-placement="bottom" title="Borang perlu diperaku - Tiada Pengeluaran"> Borang perlu
                                disahkan - Tiada Pengeluaran <br><br>

                                <a href="#" class="btn btn-primary"> <i class="fas fa-eye"
                                        style="color: white; font-size: 18pt;" data-toggle="tooltip" data-placement="bottom"
                                        title="Borang perlu diperaku"></i></a> Borang perlu disahkan <br><br>


                                <img src="{{ asset('tp_logo.png') }}" height='30px' alt="" data-toggle="tooltip"
                                    data-placement="bottom" title="Borang telah disahkan"> Borang telah disahkan - TP
                                <br><br>

                                <img src="{{ asset('double_check.png') }}" height='30px' alt="" style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                    data-placement="bottom" title="Borang telah diperaku"></i> Borang telah diperaku oleh
                                IPJPSM
                                <br><br>
                            </div>
                            <hr>

                            <div style="col-md-3">
                                IBK <br><br>
                                <img src="{{ asset('calendar.png') }}" height='30px' alt="" style="color: grey; font-size: 20pt;"
                                    data-toggle="tooltip" data-placement="bottom" title="Borang ditutup"></i> Borang
                                ditutup<br><br>

                                <a href="#" class="mr-1 btn btn-danger ">
                                    <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt="" style="font-size: 15pt;"></i></a> Borang belum
                                diisi<br><br>

                                <i class="fas fa-sync" style="color: yellow; font-size: 25pt;" data-toggle="tooltip"
                                    data-placement="bottom" title="Borang sedang diisi"> </i> Borang sedang diisi<br><br>

                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="Borang tidak lengkap"
                                    class="mr-1 btn btn-warning"><i class="fas fa-pencil-alt"></i></a> Borang tidak
                                lengkap<br><br>



                                <a href="#">
                                    <img src="{{ asset('circle_check.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom"
                                        title="Borang telah dihantar" style="color: green; font-size: 20pt;"></i></a> Borang
                                telah dihantar<br><br>



                                <a href="#">
                                    <img src="{{ asset('circle_check.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom"
                                        title="Borang telah diluluskan oleh IPJPSM"
                                        style="color: green; font-size: 20pt;"></i></a> Borang telah diperaku oleh IPJPSM
                                <br><br>
                            </div>
                            <hr>

                            <div style="col-md-3">
                                JPN <br><br>
                                <img src="{{ asset('calendar.png') }}" height='30px' alt="" style="color: grey; font-size: 20pt;"
                                    data-toggle="tooltip" data-placement="bottom" title="Borang ditutup"></i> Borang
                                ditutup<br><br>

                                <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt="" style="color: red; font-size: 20pt;" data-toggle="tooltip"
                                    data-placement="bottom" title="Borang belum diisi"></i> Borang belum diisi<br><br>

                                <i class="fas fa-sync" style="color: yellow; font-size: 25pt;" data-toggle="tooltip"
                                    data-placement="bottom" title="Borang sedang diisi"> </i> Borang sedang diisi<br><br>

                                    <a href="#">
                                       <img src="{{ asset('history.png') }}" height='30px' alt=""
                                        style="color: red; font-size: 20pt;"
                                        data-toggle="tooltip" data-placement="bottom"
                                        title="Borang tidak lengkap "></i></a>Borang tidak lengkap <br><br>

                                <a href="#"
                                    class="btn btn-primary"><i class="fas fa-eye"
                                        style="color: white; font-size: 18pt;"
                                        data-toggle="tooltip" data-placement="bottom"
                                        title="Borang perlu disahkan"></i></a>Borang perlu disahkan PHD<br><br>

                                        <img src="{{ asset('check.png') }}" height='30px' alt="" style="color: green; font-size: 20pt;"
                                        data-toggle="tooltip" data-placement="bottom"
                                        title="Borang telah disahkan"></i></a> Borang
                                        telah disahkan PHD<br><br>


                                <img src="{{ asset('double_check.png') }}" height='30px' alt="" style="color: green; font-size: 20pt;" data-toggle="tooltip"
                                data-placement="bottom" title="Borang telah diperaku"></i> Borang telah diperaku oleh
                            IPJPSM
                            <br><br>
                            </div>
                            <hr>




                        </div>
                    </div>


                </div> --}}

            </div>
        </div>

    </div>

    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js">
    </script>

    <script type=text/javascript>
        $(document).ready(function() {
            $.ajax({ //create an ajax request to display.php
                type: "GET",
                url: "{{ route('ajax_count_tugasan_ipjpsm_shuttle3') }}",
                success: function(data) {
                    $("#count_tugasan_shuttle3").html(data);
                }
            });
        });
    </script>

    <script type=text/javascript>
        $(document).ready(function() {
            $.ajax({ //create an ajax request to display.php
                type: "GET",
                url: "{{ route('ajax_count_tugasan_ipjpsm_shuttle4') }}",
                success: function(data) {
                    console.log(data);
                    $("#count_tugasan_shuttle4").html(data);
                }
            });
        });
    </script>

    <script type=text/javascript>
        $(document).ready(function() {
            $.ajax({ //create an ajax request to display.php
                type: "GET",
                url: "{{ route('ajax_count_tugasan_ipjpsm_shuttle5') }}",
                success: function(data) {
                    $("#count_tugasan_shuttle5").html(data);
                }
            });
        });
    </script>

    <script type=text/javascript>
        $(document).ready(function() {
            $.ajax({ //create an ajax request to display.php
                type: "GET",
                url: "{{ route('ajax_count_user_ibk') }}",
                success: function(data) {
                    $("#ibk").html(data);
                }
            });
        });
    </script>

    <script type=text/javascript>
        $(document).ready(function() {
            $.ajax({ //create an ajax request to display.php
                type: "GET",
                url: "{{ route('ajax_count_user_phd') }}",
                success: function(data) {
                    console.log(data);
                    $("#phd").html(data);
                }
            });
        });
    </script>

    <script type=text/javascript>
        $(document).ready(function() {
            $.ajax({ //create an ajax request to display.php
                type: "GET",
                url: "{{ route('ajax_count_user_jpn') }}",
                success: function(data) {
                    $("#ipjpsm").html(data);
                }
            });
        });
    </script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
        window.addEventListener("load", function() {
            $.ajax({
                url: "{{ route('ipjpsm.graph_dashboard.default') }}",
                method: "get",
                dataType: "JSON",
                success: function(data) {
                    ChartResponden(data);
                    console.log(data);
                }
            });
        });

        $(document).ready(function() {
            $('#select_kilang').change(function() {
                var shuttle = $(this).val();
                if (shuttle != '') {
                    load_data(shuttle);
                }
            });
        });

        function load_data(shuttle) {
            $.ajax({
                url: "{{ route('ipjpsm.graph_dashboard') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    shuttle_type: shuttle,
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    ChartResponden(data);
                }
            });
        }
    </script>

<script>
    function ChartResponden(data) {

        var jsonData = data;
        console.log(jsonData);

        var bar = document.getElementById('bar');
        var barConfig = new Chart(bar, {
        type: 'bar',

        data: {
                labels: ['Johor', 'Kedah', 'Kelantan',
                        'Melaka', 'Negeri Sembilan', 'Pahang',
                        'Perak', 'Perlis', 'Pulau Pinang', 'Selangor', 'Terengganu', 'Wilayah Persekutuan'],
                datasets: [{
                    label: 'Bilangan Responden',
                    data: [jsonData.johor,jsonData.kedah,jsonData.kelantan,jsonData.melaka,jsonData.n9,jsonData.pahang,jsonData.perak,jsonData.perlis,jsonData.pinang,jsonData.selangor,jsonData.terengganu,jsonData.wp ],
                    backgroundColor: [

                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(225, 50, 64, 1)',
                        'rgba(64, 159, 64, 1)',
                        'rgba(45, 129, 100, 1)',
                        'rgba(11, 19, 64, 1)',
                        'rgba(99, 59, 64, 1)',
                        'rgba(11, 19, 64, 1)',
                        'rgba(11, 19, 64, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            precision:0

                        }
                    }]
                },
            responsive: true, // Instruct chart js to respond nicely.
            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height
            legend:
                        {
                            display: false
                        }
            }
        })
    }

</script>
@endsection
