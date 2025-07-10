@extends('layouts.layout-phd-nicepage')
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

                        {{-- <div class="card-header" style="text-align:center;margin-bottom:-1%;margin-top:-1%;">
                            <h4 style="background-color: #f3ce8f "><b>SENARAI KILANG AKTIF</b></h4>
                        </div> --}}

                        <div class="card-header bg-info"
                            style="text-align:center; background-color: #f3ce8f !important; font-size: 130%; font-weight: bold;">
                            <h4 class="text-white m-b-0" style="background-color: #f3ce8f "><b>SENARAI KILANG AKTIF</b></h4>
                        </div>
                        <br>

                    </div>
                </div>
                <div class="row" style="justify-content: space-around;">

                    <a class="col-lg-4 col-md-6" href="{{ route('senarai_kilang_papan_aktif') }}" style="color:black;">

                        <div class="card bg-info card-hover" style="border-radius: 25px">
                            <div class="card-body"
                                style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #ee8dcd ;border-radius: 25px;text-align:center;">
                                <div class="d-flex no-block align-items-center">
                                    <div class="text-white">
                                        <b><span style="font-size:40px;">{{ $count_shuttle3 }}</span><span
                                                style="font-size:25px;">&nbsp aktif</span></b>
                                        <h4>Jumlah Kilang Papan </h4>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><img style="width:60px;height:60px"
                                                src="{{ asset('kilang_kayu_balak.png') }}"></img></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a class="col-lg-4 col-md-6" href="{{ route('senarai_kilang_papan_lapis_aktif') }}"
                        style="color:black;">

                        <div class="card bg-info card-hover" style="border-radius: 25px">
                            <div class="card-body"
                                style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #f0e10dbd ;border-radius: 25px;text-align:center;">
                                <div class="d-flex no-block align-items-center">
                                    <div class="text-white">
                                        <b><span style="font-size:40px;">{{ $count_shuttle4 }}</span><span
                                                style="font-size:25px;">&nbsp aktif</span></b>
                                        <h4>Jumlah Kilang Papan Lapis/Venir</h4>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><img style="width:50px;height:50px"
                                                src="{{ asset('kilang_kayu_papan_lapis.png') }}"></img></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a class="col-lg-4 col-md-6" href="{{ route('senarai_kilang_kumai_aktif') }}" style="color:black;">

                        <div class="card bg-info card-hover" style="border-radius: 25px">
                            <div class="card-body"
                                style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #6df173 ;border-radius: 25px;text-align:center;">
                                <div class="d-flex no-block align-items-center">
                                    <div class="text-white">
                                        <b><span style="font-size:40px;">{{ $count_shuttle5 }}</span><span
                                                style="font-size:25px;">&nbsp aktif</span></b>
                                        <h4>Jumlah Kilang Kayu Kumai </h4>
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
                            <h4 class="text-white m-b-0" style="background-color: #f3ce8f "><b>SENARAI BORANG YANG BELUM DISAHKAN PEGAWAI HUTAN
                                DAERAH</b></h4>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" style="justify-content: space-around;">
                    <a class="col-lg-4 col-md-6" href="{{ route('phd.shuttle-3-listA', date('Y')) }}"
                        style="color:black;">
                        <div class="card bg-info card-hover" style="border-radius: 25px">
                            <div class="card-body"
                                style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #ee8dcd ;border-radius: 25px;text-align:center;">
                                <div class="d-flex no-block align-items-center">
                                    <div class="text-white">
                                        <b><span style="font-size:40px;" id="count_tugasan_shuttle3">0</span></b>
                                        <h4>Kilang Papan</h4>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><i class="fas fa-copy"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a class="col-lg-4 col-md-6" href="{{ route('phd.shuttle-4-listA', date('Y')) }}"
                        style="color:black;">
                        <div class="card bg-info card-hover" style="border-radius: 25px">
                            <div class="card-body"
                                style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #f0e10dbd ;border-radius: 25px;text-align:center;">
                                <div class="d-flex no-block align-items-center">
                                    <div class="text-white">
                                        <b><span style="font-size:40px;" id="count_tugasan_shuttle4">0</span></b>
                                        <h4>Kilang Papan Lapis/Venir</h4>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><i class="fas fa-copy"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a class="col-lg-4 col-md-6" href="{{ route('phd.shuttle-5-listA', date('Y')) }}"
                        style="color:black;">
                        <div class="card bg-info card-hover" style="border-radius: 25px">
                            <div class="card-body"
                                style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #6df173 ;border-radius: 25px;text-align:center;">
                                <div class="d-flex no-block align-items-center">
                                    <div class="text-white">
                                        <b><span style="font-size:40px;" id="count_tugasan_shuttle5">0</span></b>
                                        <h4>Kilang Kayu Kumai</h4>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-white display-6"><i class="fas fa-copy"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="row">

                    <div class="col-md-6">
                      <div class="card">
                        <div class="border card-header bg-info">
                          <h3 class="text-white m-b-0" style="text-align: center;font-size: 20px;font-weight: bold;">PENGUMUMAN</h3>
                        </div>
                        <div class="border card-body" style="height: 442px">
                            <div class="list-group" style="overflow:auto;height:300px;width:100%;border:1px solid #ccc">
                                    <!-- <a href="#" class="list-group-item list-group-item-action flex-column align-items-start"> -->
                                @if($pengumuman_jpn)
                                    @foreach($pengumuman_jpn as $data)
                                    <div class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 card-title" style="font-size: 20px; font-weight: bold;">{{ $data->tajuk }}</h6>
                                        <small class="text-muted" style="font-size: 110%;">{{ date('d-m-Y', strtotime($data->created_at)) }}</small>
                                        </div>
                                        <p class="my-1" style="font-size: 15px; text-align:left;">{{ $data->keterangan }}</p>
                                      </div>
                                    @endforeach
                                    @else
                                    <div class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                        {{-- <h6 class="mb-1 card-title" style="font-size: 20px; font-weight: bold;">{{ $data->tajuk }}</h6> --}}
                                        {{-- <small class="text-muted" style="font-size: 110%;">{{ $data->created_at->toDateString() }}</small> --}}
                                        </div>
                                        <p class="my-1" style="font-size: 30px; text-align:center;">Tiada Pengumuman</p>
                                      </div>
                                    @endif


                                    {{-- <div class="list-group-item list-group-item-action flex-column align-items-start">
                                      <div class="d-flex w-100 justify-content-between">
                                      <h6 class="mb-1 card-title" style="font-size: 20px; font-weight: bold;">Pengumuman</h6>
                                      <small class="text-muted" style="font-size: 110%;">26-01-2021</small>
                                      </div>
                                      <p class="my-1" style="font-size: 15px; text-align:justify;">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    </div>

                                    <div class="list-group-item list-group-item-action flex-column align-items-start">
                                      <div class="d-flex w-100 justify-content-between">
                                      <h6 class="mb-1 card-title" style="font-size: 20px; font-weight: bold;">Pengumuman</h6>
                                      <small class="text-muted" style="font-size: 110%;">05-01-2021</small>
                                      </div>
                                      <p class="my-1" style="font-size: 15px; text-align:justify;">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    </div>

                                    <div class="list-group-item list-group-item-action flex-column align-items-start">
                                      <div class="d-flex w-100 justify-content-between">
                                      <h6 class="mb-1 card-title" style="font-size: 20px; font-weight: bold;">Pengumuman</h6>
                                      <small class="text-muted" style="font-size: 110%;">01-01-2021</small>
                                      </div>
                                      <p class="my-1" style="font-size: 15px; text-align:justify;">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    </div> --}}

                                    <!-- </a> -->

                                </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card" style="height: 500px">
                            <div class="border card-header bg-info ">
                                <h4 class="text-white m-b-0" style="text-align: center; background-color: #f3ce8f "><b>BILANGAN RESPONDEN</b></h4>
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
                                <h4 class="text-white m-b-0" style="text-align: center; background-color: #f3ce8f "><b>BILANGAN RESPONDEN</b></h4>
                            </div>
                            <div class="border card-body" style="">
                                <div class="chart1 m-t-40" align='center' style="position: relative; height:400px;">

                                    <canvas class="bar-chart" id="bar">
                                    </canvas>

                                </div>
                            </div>
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
    {{-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> --}}


    {{-- <script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(Chart);

    function Chart(data_graph) {
        var jsonData = data_graph;
        console.log(jsonData);

        var data = new google.visualization.arrayToDataTable([
        ['Negeri', 'Responden'],
        ["Johor", jsonData.johor],
        ["Kedah", jsonData.kedah],
        ["Kelantan", jsonData.kelantan],
        ["Melaka", jsonData.melaka],
        ["Negeri Sembilan", jsonData.n9],
        ["Pahang", jsonData.pahang],
        ["Perak", jsonData.perak],
        ["Perlis", jsonData.perlis],
        ["Pulau Pinang", jsonData.pinang],
        ["Selangor", jsonData.selangor],
        ['Terengganu', jsonData.terengganu],
        ['W.P', 4]
        ]);
        // data.setView({columns:[0,1,2]});


        var options = {
        width: 1000,
        legend: { position: 'none' },
        chart: {
            title: 'Bilangan Responden',
            subtitle: '' },
        axes: {
            x: {
            0: { side: 'bottom', label: 'Negeri'} // Top x-axis.
            }
        },
        bar: { groupWidth: "90%" },

         vAxis: { gridlines: { count: 1 } }


        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        // Convert the Classic options to Material options.
        chart.draw(data, google.charts.Bar.convertOptions( options));
    };

</script> --}}

<script>
    function ChartResponden(data) {
        var jsonData = data;
        console.log(jsonData);
        var bar = document.getElementById('bar');
        var barConfig = new Chart(bar, {
            type: 'bar',
            data: {
                labels: ['Shuttle 3- Kilang Papan', 'Shuttle 4- Kilang Papan Lapis/Venir',
                    'Shuttle 5- Kilang Kayu Kumai'
                ],
                datasets: [{
                    label: 'Bilangan Responden',
                    data: [{{ $s3[0]->total_kilang ?? 0 }}, {{ $s4[0]->total_kilang ?? 0 }},
                        {{ $s5[0]->total_kilang ?? 0 }}
                    ],
                    backgroundColor: [

                        '#ee8dcd',
                        '#f0e10dbd',
                        '#6df173',
                        // 'rgba(75, 192, 192, 1)',
                        // 'rgba(153, 102, 255, 1)',
                        // 'rgba(225, 50, 64, 1)',
                        // 'rgba(64, 159, 64, 1)',
                        // 'rgba(45, 129, 100, 1)',
                        // 'rgba(11, 19, 64, 1)',
                        // 'rgba(99, 59, 64, 1)',
                        // 'rgba(11, 19, 64, 1)',
                        // 'rgba(11, 19, 64, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }]
                },
                responsive: true, // Instruct chart js to respond nicely.
                maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height
                legend: {
                    display: false
                }
            }
        })
    }
</script>

    <script type="text/javascript">
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

    <script type=text/javascript>
        $(document).ready(function() {
            $.ajax({ //create an ajax request to display.php
                type: "GET",
                url: "{{ route('ajax_count_tugasan_phd_shuttle3') }}",
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
                url: "{{ route('ajax_count_tugasan_phd_shuttle4') }}",
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
                url: "{{ route('ajax_count_tugasan_phd_shuttle5') }}",
                success: function(data) {
                    $("#count_tugasan_shuttle5").html(data);
                }
            });
        });
    </script>
@endsection
