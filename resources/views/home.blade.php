@extends('layouts.layout-ipjpsm-nicepage')
@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" rel="stylesheet" type="text/css">
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/my/my-all.js"></script>

<style>
    .shadow-lg {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
    }

    .card {
        border-radius: 15px !important;
        border: none !important;
    }

    .card-header {
        border-radius: 15px 15px 0 0 !important;
        border-bottom: none !important;
    }

    .form-control-lg {
        border-radius: 10px !important;
        border: 2px solid #e9ecef !important;
        transition: all 0.3s ease !important;
    }

    .form-control-lg:focus {
        border-color: #17a2b8 !important;
        box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.25) !important;
    }

    .chart-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%) !important;
        border: 1px solid #e9ecef !important;
        border-radius: 15px !important;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05) !important;
    }

    .alert-info {
        background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%) !important;
        border: 1px solid #b6d7de !important;
        border-radius: 10px !important;
    }

    .card-hover:hover {
        transform: translateY(-2px) !important;
        transition: all 0.3s ease !important;
    }

    .form-label {
        color: #495057 !important;
        margin-bottom: 8px !important;
    }

    #select_kilang {
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        appearance: none !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") !important;
        background-position: right 12px center !important;
        background-repeat: no-repeat !important;
        background-size: 16px 16px !important;
        padding-right: 40px !important;
    }
</style>
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

                {{-- Maintenance Mode Quick Access (IPJPSM/BPE only) --}}
                @php $__maint = \App\Models\MaintenanceSetting::first(); @endphp
                <div class="card mb-3" style="border-radius:12px; border: 2px solid {{ ($__maint && $__maint->is_active) ? '#ffc107' : '#d4edda' }}; background: {{ ($__maint && $__maint->is_active) ? '#fff8e1' : '#f6fffa' }};">
                    <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between flex-wrap" style="gap:12px;">
                        <div class="d-flex align-items-center" style="gap:14px;">
                            <div style="width:44px;height:44px;border-radius:50%;background:{{ ($__maint && $__maint->is_active) ? '#ffc107' : '#28a745' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-tools text-white" style="font-size:18px;"></i>
                            </div>
                            <div>
                                <div style="font-weight:700;font-size:14px;color:#333;">
                                    Mod Penyelenggaraan Sistem
                                    @if($__maint && $__maint->is_active)
                                        <span class="badge badge-warning ml-1" style="font-size:10px;vertical-align:middle;">AKTIF SEKARANG</span>
                                    @else
                                        <span class="badge badge-success ml-1" style="font-size:10px;vertical-align:middle;">TIDAK AKTIF</span>
                                    @endif
                                </div>
                                <div style="font-size:12px;color:#666;margin-top:2px;">
                                    @if($__maint && $__maint->is_active)
                                        Hanya pentadbir IPJPSM/BPE yang boleh mengakses sistem pada masa ini.
                                        @if($__maint->end_date)
                                            Dijangka selesai: <strong>{{ $__maint->end_date->format('d/m/Y, h:i A') }}</strong>
                                        @endif
                                    @else
                                        Sistem beroperasi seperti biasa. Klik untuk urus tetapan penyelenggaraan.
                                    @endif
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('tetapan.penyelenggaraan.papar') }}" class="btn btn-sm {{ ($__maint && $__maint->is_active) ? 'btn-warning' : 'btn-outline-success' }}" style="white-space:nowrap;">
                            <i class="fas fa-sliders-h mr-1"></i> Urus Tetapan
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        {{-- SECTION 1: Shows total count of active registered factories (approved users) --}}
                        <div class="card-header bg-info"
                            style="text-align:center; background-color: #f3ce8f !important; font-size: 130%; font-weight: bold;">
                            <h4 class="text-white m-b-0" style="background-color: #f3ce8f "><b>JUMLAH KILANG AKTIF BERDAFTAR</b></h4>
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

                        {{-- IPJPSM: Shows count of forms with 'Dihantar ke IPJPSM' OR 'Lulus' status for current year (dynamically loaded via AJAX) --}}
                        <div class="card-header bg-info"
                            style="text-align:center; background-color: #f3ce8f !important; font-size: 130%; font-weight: bold;">
                            <h4 class="text-white m-b-0" style="background-color: #f3ce8f "><b>JUMLAH BORANG MENUNGGU PENGESAHAN IPJPSM/BPE ({{ date('Y') }})</b></h4>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" style="justify-content: space-around;">
                    {{-- Shuttle 3 --}}
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card bg-info card-hover" style="border-radius:25px">
                            <div class="card-body" style="box-shadow:0 4px 8px 0 rgba(0,0,0,0.2);background-color:#ee8dcd;border-radius:25px;text-align:center;">
                                <b><span style="font-size:40px;" id="count_tugasan_shuttle3">0</span></b>
                                <h5 class="text-white">Kilang Papan</h5>
                                <div class="mt-2" id="detail_s3" style="display:flex;flex-wrap:wrap;justify-content:center;gap:6px"></div>
                            </div>
                        </div>
                    </div>
                    {{-- Shuttle 4 --}}
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card bg-info card-hover" style="border-radius:25px">
                            <div class="card-body" style="box-shadow:0 4px 8px 0 rgba(0,0,0,0.2);background-color:#f0e10dbd;border-radius:25px;text-align:center;">
                                <b><span style="font-size:40px;" id="count_tugasan_shuttle4">0</span></b>
                                <h5 class="text-white">Kilang Papan Lapis/Venir</h5>
                                <div class="mt-2" id="detail_s4" style="display:flex;flex-wrap:wrap;justify-content:center;gap:6px"></div>
                            </div>
                        </div>
                    </div>
                    {{-- Shuttle 5 --}}
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card bg-info card-hover" style="border-radius:25px">
                            <div class="card-body" style="box-shadow:0 4px 8px 0 rgba(0,0,0,0.2);background-color:#6df173;border-radius:25px;text-align:center;">
                                <b><span style="font-size:40px;" id="count_tugasan_shuttle5">0</span></b>
                                <h5 class="text-white">Kilang Kayu Kumai</h5>
                                <div class="mt-2" id="detail_s5" style="display:flex;flex-wrap:wrap;justify-content:center;gap:6px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                (function(){
                    var detailUrl = "{{ route('ajax.count.ipjpsm.detail') }}";
                    var formLinks = {
                        3: {
                            A: "{{ route('shuttle-3-listA', date('Y')) }}",
                            B: "{{ route('shuttle-3-listB', date('Y')) }}",
                            C: "{{ route('shuttle-3-listC', date('Y')) }}",
                            D: "{{ route('shuttle-3-listD', date('Y')) }}"
                        },
                        4: {
                            A: "{{ route('shuttle-4-listA', date('Y')) }}",
                            B: "{{ route('shuttle-4-listB', date('Y')) }}",
                            C: "{{ route('shuttle-4-listC', date('Y')) }}",
                            D: "{{ route('shuttle-4-listD', date('Y')) }}",
                            E: "{{ route('shuttle-4-listE', date('Y')) }}"
                        },
                        5: {
                            A: "{{ route('shuttle-5-listA', date('Y')) }}",
                            B: "{{ route('shuttle-5-listB', date('Y')) }}",
                            C: "{{ route('shuttle-5-listC', date('Y')) }}",
                            D: "{{ route('shuttle-5-listD', date('Y')) }}",
                            E: "{{ route('shuttle-5-listE', date('Y')) }}"
                        }
                    };
                    var kesLinks = {
                        3: {
                            A: "{{ route('ipjpsm.borang-keseluruhan.shuttle3.borangA', date('Y')) }}",
                            B: "{{ route('ipjpsm.borang-keseluruhan.shuttle3.borangB', date('Y')) }}",
                            C: "{{ route('ipjpsm.borang-keseluruhan.shuttle3.borangC', date('Y')) }}",
                            D: "{{ route('ipjpsm.borang-keseluruhan.shuttle3.borangD', date('Y')) }}"
                        },
                        4: {
                            A: "{{ route('ipjpsm.borang-keseluruhan.shuttle4.borangA', date('Y')) }}",
                            B: "{{ route('ipjpsm.borang-keseluruhan.shuttle4.borangB', date('Y')) }}",
                            C: "{{ route('ipjpsm.borang-keseluruhan.shuttle4.borangC', date('Y')) }}",
                            D: "{{ route('ipjpsm.borang-keseluruhan.shuttle4.borangD', date('Y')) }}",
                            E: "{{ route('ipjpsm.borang-keseluruhan.shuttle4.borangE', date('Y')) }}"
                        },
                        5: {
                            A: "{{ route('ipjpsm.borang-keseluruhan.shuttle5.borangA', date('Y')) }}",
                            B: "{{ route('ipjpsm.borang-keseluruhan.shuttle5.borangB', date('Y')) }}",
                            C: "{{ route('ipjpsm.borang-keseluruhan.shuttle5.borangC', date('Y')) }}",
                            D: "{{ route('ipjpsm.borang-keseluruhan.shuttle5.borangD', date('Y')) }}",
                            E: "{{ route('ipjpsm.borang-keseluruhan.shuttle5.borangE', date('Y')) }}"
                        }
                    };
                    var colors = {A:'#555',B:'#c9559e',C:'#8a7e00',D:'#0e7012',E:'#0a5da8'};
                    [3,4,5].forEach(function(s){
                        $.get(detailUrl, {shuttle_type: s}, function(data){
                            var total = Object.values(data).reduce(function(sum, v){ return sum + (parseInt(v) || 0); }, 0);
                            $('#count_tugasan_shuttle'+s).text(total);

                            var container = $('#detail_s'+s);
                            container.empty();
                            Object.keys(data).forEach(function(key){
                                var form = key.replace('form','');
                                var count = data[key];
                                var color = colors[form];

                                // Wrapper group
                                var group = $('<div>').css({
                                    display:'inline-flex', alignItems:'stretch',
                                    borderRadius:'20px', overflow:'hidden',
                                    border:'2px solid '+color, fontSize:'13px', fontWeight:'600'
                                });

                                // Left: list button (with count badge)
                                var listBtn = $('<a>')
                                    .attr('href', formLinks[s][form])
                                    .attr('title', 'Senarai')
                                    .css({
                                        display:'inline-flex', alignItems:'center', gap:'4px',
                                        background:'rgba(255,255,255,0.85)', color:'#222',
                                        padding:'3px 10px', textDecoration:'none'
                                    })
                                    .text('Borang '+s+form+' ');
                                if(count > 0){
                                    listBtn.append($('<span>').css({
                                        background:'#e53935', color:'#fff',
                                        borderRadius:'50%', padding:'1px 6px', fontSize:'11px'
                                    }).text(count));
                                }

                                // Divider
                                var divider = $('<span>').css({
                                    width:'1px', background: color, opacity:'0.5'
                                });

                                // Right: keseluruhan button
                                var kesBtn = $('<a>')
                                    .attr('href', kesLinks[s][form])
                                    .attr('title', 'Borang Keseluruhan')
                                    .css({
                                        display:'inline-flex', alignItems:'center',
                                        background: color, color:'#fff',
                                        padding:'3px 8px', textDecoration:'none', fontSize:'12px'
                                    })
                                    .html('<i class="fas fa-list-alt"></i>');

                                group.append(listBtn).append(divider).append(kesBtn);
                                container.append(group);
                            });
                        });
                    });
                })();
                </script>

                {{-- ── Prev Year Section ──────────────────────────────────────────────── --}}
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-header bg-info"
                            style="text-align:center; background-color: #b0c4de !important; font-size: 130%; font-weight: bold;">
                            <h4 class="text-white m-b-0" style="background-color: #b0c4de"><b>JUMLAH BORANG MENUNGGU PENGESAHAN IPJPSM/BPE ({{ date('Y') - 1 }})</b></h4>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" style="justify-content: space-around;">
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card bg-info card-hover" style="border-radius:25px">
                            <div class="card-body" style="box-shadow:0 4px 8px 0 rgba(0,0,0,0.2);background-color:#ee8dcd;border-radius:25px;text-align:center;">
                                <b><span style="font-size:40px;" id="count_prev_shuttle3">0</span></b>
                                <h5 class="text-white">Kilang Papan</h5>
                                <div class="mt-2" id="detail_prev_s3" style="display:flex;flex-wrap:wrap;justify-content:center;gap:6px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card bg-info card-hover" style="border-radius:25px">
                            <div class="card-body" style="box-shadow:0 4px 8px 0 rgba(0,0,0,0.2);background-color:#f0e10dbd;border-radius:25px;text-align:center;">
                                <b><span style="font-size:40px;" id="count_prev_shuttle4">0</span></b>
                                <h5 class="text-white">Kilang Papan Lapis/Venir</h5>
                                <div class="mt-2" id="detail_prev_s4" style="display:flex;flex-wrap:wrap;justify-content:center;gap:6px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card bg-info card-hover" style="border-radius:25px">
                            <div class="card-body" style="box-shadow:0 4px 8px 0 rgba(0,0,0,0.2);background-color:#6df173;border-radius:25px;text-align:center;">
                                <b><span style="font-size:40px;" id="count_prev_shuttle5">0</span></b>
                                <h5 class="text-white">Kilang Kayu Kumai</h5>
                                <div class="mt-2" id="detail_prev_s5" style="display:flex;flex-wrap:wrap;justify-content:center;gap:6px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                (function(){
                    var detailUrlPrev = "{{ route('ajax.count.ipjpsm.detail') }}";
                    var formLinksPrev = {
                        3: {
                            A: "{{ route('shuttle-3-listA', date('Y') - 1) }}",
                            B: "{{ route('shuttle-3-listB', date('Y') - 1) }}",
                            C: "{{ route('shuttle-3-listC', date('Y') - 1) }}",
                            D: "{{ route('shuttle-3-listD', date('Y') - 1) }}"
                        },
                        4: {
                            A: "{{ route('shuttle-4-listA', date('Y') - 1) }}",
                            B: "{{ route('shuttle-4-listB', date('Y') - 1) }}",
                            C: "{{ route('shuttle-4-listC', date('Y') - 1) }}",
                            D: "{{ route('shuttle-4-listD', date('Y') - 1) }}",
                            E: "{{ route('shuttle-4-listE', date('Y') - 1) }}"
                        },
                        5: {
                            A: "{{ route('shuttle-5-listA', date('Y') - 1) }}",
                            B: "{{ route('shuttle-5-listB', date('Y') - 1) }}",
                            C: "{{ route('shuttle-5-listC', date('Y') - 1) }}",
                            D: "{{ route('shuttle-5-listD', date('Y') - 1) }}",
                            E: "{{ route('shuttle-5-listE', date('Y') - 1) }}"
                        }
                    };
                    var kesLinksPrev = {
                        3: {
                            A: "{{ route('ipjpsm.borang-keseluruhan.shuttle3.borangA', date('Y') - 1) }}",
                            B: "{{ route('ipjpsm.borang-keseluruhan.shuttle3.borangB', date('Y') - 1) }}",
                            C: "{{ route('ipjpsm.borang-keseluruhan.shuttle3.borangC', date('Y') - 1) }}",
                            D: "{{ route('ipjpsm.borang-keseluruhan.shuttle3.borangD', date('Y') - 1) }}"
                        },
                        4: {
                            A: "{{ route('ipjpsm.borang-keseluruhan.shuttle4.borangA', date('Y') - 1) }}",
                            B: "{{ route('ipjpsm.borang-keseluruhan.shuttle4.borangB', date('Y') - 1) }}",
                            C: "{{ route('ipjpsm.borang-keseluruhan.shuttle4.borangC', date('Y') - 1) }}",
                            D: "{{ route('ipjpsm.borang-keseluruhan.shuttle4.borangD', date('Y') - 1) }}",
                            E: "{{ route('ipjpsm.borang-keseluruhan.shuttle4.borangE', date('Y') - 1) }}"
                        },
                        5: {
                            A: "{{ route('ipjpsm.borang-keseluruhan.shuttle5.borangA', date('Y') - 1) }}",
                            B: "{{ route('ipjpsm.borang-keseluruhan.shuttle5.borangB', date('Y') - 1) }}",
                            C: "{{ route('ipjpsm.borang-keseluruhan.shuttle5.borangC', date('Y') - 1) }}",
                            D: "{{ route('ipjpsm.borang-keseluruhan.shuttle5.borangD', date('Y') - 1) }}",
                            E: "{{ route('ipjpsm.borang-keseluruhan.shuttle5.borangE', date('Y') - 1) }}"
                        }
                    };
                    var colorsPrev = {A:'#555',B:'#c9559e',C:'#8a7e00',D:'#0e7012',E:'#0a5da8'};
                    [3,4,5].forEach(function(s){
                        $.get(detailUrlPrev, {shuttle_type: s, year: {{ date('Y') - 1 }}}, function(data){
                            var total = Object.values(data).reduce(function(sum, v){ return sum + (parseInt(v) || 0); }, 0);
                            $('#count_prev_shuttle'+s).text(total);

                            var container = $('#detail_prev_s'+s);
                            container.empty();
                            Object.keys(data).forEach(function(key){
                                var form = key.replace('form','');
                                var count = data[key];
                                var color = colorsPrev[form];

                                var group = $('<div>').css({
                                    display:'inline-flex', alignItems:'stretch',
                                    borderRadius:'20px', overflow:'hidden',
                                    border:'2px solid '+color, fontSize:'13px', fontWeight:'600'
                                });

                                var listBtn = $('<a>')
                                    .attr('href', formLinksPrev[s][form])
                                    .attr('title', 'Senarai')
                                    .css({
                                        display:'inline-flex', alignItems:'center', gap:'4px',
                                        background:'rgba(255,255,255,0.85)', color:'#222',
                                        padding:'3px 10px', textDecoration:'none'
                                    })
                                    .text('Borang '+s+form+' ');
                                if(count > 0){
                                    listBtn.append($('<span>').css({
                                        background:'#e53935', color:'#fff',
                                        borderRadius:'50%', padding:'1px 6px', fontSize:'11px'
                                    }).text(count));
                                }

                                var divider = $('<span>').css({
                                    width:'1px', background: color, opacity:'0.5'
                                });

                                var kesBtn = $('<a>')
                                    .attr('href', kesLinksPrev[s][form])
                                    .attr('title', 'Borang Keseluruhan')
                                    .css({
                                        display:'inline-flex', alignItems:'center',
                                        background: color, color:'#fff',
                                        padding:'3px 8px', textDecoration:'none', fontSize:'12px'
                                    })
                                    .html('<i class="fas fa-list-alt"></i>');

                                group.append(listBtn).append(divider).append(kesBtn);
                                container.append(group);
                            });
                        });
                    });
                })();
                </script>

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
                    <a class="col-lg-4 col-md-6" href="{{ route('ipjpsm.status-permohonan-ibk') }}"
                        style="color:black;"
                        data-toggle="tooltip" 
                        data-placement="top" 
                        title="Lihat semua permohonan IBK (Kilang Papan, Papan Lapis/Venir, Kayu Kumai)">
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
                        <div class="card shadow-lg">
                            <div class="card-header bg-gradient-info text-white">
                                <h4 class="mb-0 text-center font-weight-bold">
                                    <i class="fas fa-chart-bar mr-2"></i>BILANGAN RESPONDEN MENGIKUT NEGERI
                                </h4>
                            </div>
                            <div class="card-body p-4">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="select_kilang" class="form-label font-weight-bold">
                                            <i class="fas fa-filter mr-2"></i>Pilih Jenis Kilang:
                                        </label>
                                        <select name="select_kilang" id="select_kilang" class="form-control form-control-lg shadow-sm">
                                            <option value="3" selected>Kilang Papan</option>
                                            <option value="4">Kilang Papan Lapis/Venir</option>
                                            <option value="5">Kilang Kayu Kumai</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="select_year_graph" class="form-label font-weight-bold">
                                            <i class="fas fa-calendar mr-2"></i>Pilih Tahun:
                                        </label>
                                        <select name="select_year_graph" id="select_year_graph" class="form-control form-control-lg shadow-sm">
                                            @for ($y = date('Y'); $y >= 2025; $y--)
                                                <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-info mb-0" style="margin-top:32px">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            <strong>Info:</strong> Nilai ditunjukkan di atas setiap bar. Hover untuk maklumat lanjut.
                                        </div>
                                    </div>
                                </div>
                                <div class="chart-container" style="position: relative; height: 450px; background: #f8f9fa; border-radius: 10px; padding: 20px;">
                                    <canvas class="bar-chart" id="bar"></canvas>
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

                                        <img src="{{ asset('circle_check_yellow.png') }}" height='30px' alt="" style="color: green; font-size: 20pt;"
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
        let currentChart = null; // Store current chart instance

        window.addEventListener("load", function() {
            load_data($('#select_kilang').val(), $('#select_year_graph').val());
        });

        $(document).ready(function() {
            $('#select_kilang, #select_year_graph').change(function() {
                load_data($('#select_kilang').val(), $('#select_year_graph').val());
            });
        });

        function load_data(shuttle, year) {
            $('#select_kilang').prop('disabled', true);
            $('#select_year_graph').prop('disabled', true);
            $('.chart-container').css('opacity', '0.5');

            $.ajax({
                url: "{{ route('ipjpsm.graph_dashboard') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    shuttle_type: shuttle,
                    year: year,
                },
                dataType: "JSON",
                success: function(data) {
                    $('#select_kilang').val(shuttle);
                    ChartResponden(data);
                    $('#select_kilang').prop('disabled', false);
                    $('#select_year_graph').prop('disabled', false);
                    $('.chart-container').css('opacity', '1');
                },
                error: function() {
                    $('#select_kilang').prop('disabled', false);
                    $('#select_year_graph').prop('disabled', false);
                    $('.chart-container').css('opacity', '1');
                    alert('Error loading data. Please try again.');
                }
            });
        }
    </script>

<script>
    function ChartResponden(data) {
        var jsonData = data;
        console.log(jsonData);

        var selectedKilang = $('#select_kilang').val();
        var selectedYear = jsonData.year || $('#select_year_graph').val();
        var kilangTypes = {
            '3': 'Kilang Papan',
            '4': 'Kilang Papan Lapis/Venir',
            '5': 'Kilang Kayu Kumai'
        };

        // Destroy existing chart if it exists
        if (currentChart) {
            currentChart.destroy();
        }

        var bar = document.getElementById('bar');
        var ctx = bar.getContext('2d');

        // Clear the canvas
        ctx.clearRect(0, 0, bar.width, bar.height);

        currentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Johor', 'Kedah', 'Kelantan',
                        'Melaka', 'Negeri Sembilan', 'Pahang',
                        'Perak', 'Perlis', 'Pulau Pinang', 'Selangor', 'Terengganu', 'Wilayah Persekutuan'],
                datasets: [{
                    label: (kilangTypes[selectedKilang] || 'Bilangan Responden') + ' (' + selectedYear + ')',
                    data: [jsonData.johor, jsonData.kedah, jsonData.kelantan, jsonData.melaka, jsonData.n9, jsonData.pahang, jsonData.perak, jsonData.perlis, jsonData.pinang, jsonData.selangor, jsonData.terengganu, jsonData.wp],
                    backgroundColor: [
                        'rgba(52, 152, 219, 0.8)',   // Blue
                        'rgba(46, 204, 113, 0.8)',   // Green
                        'rgba(241, 196, 15, 0.8)',   // Yellow
                        'rgba(231, 76, 60, 0.8)',    // Red
                        'rgba(155, 89, 182, 0.8)',   // Purple
                        'rgba(230, 126, 34, 0.8)',   // Orange
                        'rgba(26, 188, 156, 0.8)',   // Teal
                        'rgba(52, 73, 94, 0.8)',     // Dark Blue
                        'rgba(243, 156, 18, 0.8)',   // Orange
                        'rgba(142, 68, 173, 0.8)',   // Purple
                        'rgba(39, 174, 96, 0.8)',    // Green
                        'rgba(192, 57, 43, 0.8)',    // Red
                    ],
                    borderColor: [
                        'rgba(52, 152, 219, 1)',
                        'rgba(46, 204, 113, 1)',
                        'rgba(241, 196, 15, 1)',
                        'rgba(231, 76, 60, 1)',
                        'rgba(155, 89, 182, 1)',
                        'rgba(230, 126, 34, 1)',
                        'rgba(26, 188, 156, 1)',
                        'rgba(52, 73, 94, 1)',
                        'rgba(243, 156, 18, 1)',
                        'rgba(142, 68, 173, 1)',
                        'rgba(39, 174, 96, 1)',
                        'rgba(192, 57, 43, 1)',
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 40,
                        bottom: 20,
                        left: 10,
                        right: 10
                    }
                },
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: true,
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0, 0, 0, 0.9)',
                    titleFontColor: 'white',
                    bodyFontColor: 'white',
                    titleFontSize: 14,
                    bodyFontSize: 13,
                    cornerRadius: 8,
                    displayColors: false,
                    xPadding: 12,
                    yPadding: 12,
                    callbacks: {
                        title: function(tooltipItems, data) {
                            return 'Negeri: ' + tooltipItems[0].label;
                        },
                        label: function(tooltipItem, data) {
                            var kilangType = kilangTypes[selectedKilang] || 'Bilangan Responden';
                            return kilangType + ': ' + tooltipItem.value + ' responden';
                        }
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            precision: 0,
                            fontSize: 12,
                            fontColor: '#666',
                            callback: function(value) {
                                return value + ' responden';
                            }
                        },
                        gridLines: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.1)',
                            lineWidth: 1
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Bilangan Responden',
                            fontColor: '#666',
                            fontSize: 14,
                            fontStyle: 'bold'
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            fontSize: 11,
                            fontColor: '#666',
                            maxRotation: 45,
                            minRotation: 0
                        },
                        gridLines: {
                            display: false
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Negeri',
                            fontColor: '#666',
                            fontSize: 14,
                            fontStyle: 'bold'
                        }
                    }]
                },
                animation: {
                    duration: 1200,
                    easing: 'easeInOutQuart'
                },
                hover: {
                    mode: 'nearest',
                    intersect: true,
                    animationDuration: 200,
                    onHover: function(event, elements) {
                        event.target.style.cursor = elements.length > 0 ? 'pointer' : 'default';
                    }
                }
            },
            plugins: [{
                afterDatasetsDraw: function(chart) {
                    var ctx = chart.ctx;
                    chart.data.datasets.forEach(function(dataset, i) {
                        var meta = chart.getDatasetMeta(i);
                        if (!meta.hidden) {
                            meta.data.forEach(function(element, index) {
                                var value = dataset.data[index];

                                // Only show value if it's greater than 0
                                if (value > 0) {
                                    var position = element.tooltipPosition();

                                    // Add background box for better readability
                                    ctx.fillStyle = 'rgba(255, 255, 255, 0.9)';
                                    ctx.strokeStyle = 'rgba(0, 0, 0, 0.2)';
                                    ctx.lineWidth = 1;

                                    var textWidth = ctx.measureText(value).width;
                                    var padding = 6;
                                    var boxWidth = textWidth + padding * 2;
                                    var boxHeight = 20;

                                    // Draw background box
                                    ctx.fillRect(position.x - boxWidth/2, position.y - boxHeight - 10, boxWidth, boxHeight);
                                    ctx.strokeRect(position.x - boxWidth/2, position.y - boxHeight - 10, boxWidth, boxHeight);

                                    // Draw the text
                                    ctx.fillStyle = '#333';
                                    ctx.font = 'bold 12px Arial';
                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'middle';
                                    ctx.fillText(value, position.x, position.y - boxHeight/2 - 10);
                                }
                            });
                        }
                    });
                }
            }]
        });
    }
</script>
@endsection
