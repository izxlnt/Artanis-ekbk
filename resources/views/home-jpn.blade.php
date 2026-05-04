@extends('layouts.layout-jpn-nicepage')
@section('content')


<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">

    <div class="row">
        {{-- <div class="col-2"></div> --}}
        <div class="col-12">

            {{-- Flash Message --}}
            @if ($message = Session::get('success'))
            <div class="border alert alert-success border-success" style="text-align: center;">{{$message}}</div>
            @elseif ($message = Session::get('error'))
            <div class="border alert alert-danger border-danger" style="text-align: center;">{{$message}}</div>
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
            <div class="row" style="justify-content: space-around;" >

                <a class="col-lg-4 col-md-6" href="{{ route('jpn.senarai_kilang_papan_aktif') }}" style="color:black;">

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

                <a class="col-lg-4 col-md-6" href="{{ route('jpn.senarai_kilang_papan_lapis_aktif') }}" style="color:black;">

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

                <a class="col-lg-4 col-md-6" href="{{ route('jpn.senarai_kilang_kumai_aktif') }}" style="color:black;">

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
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card bg-info card-hover" style="border-radius:25px">
                        <div class="card-body" style="box-shadow:0 4px 8px 0 rgba(0,0,0,0.2);background-color:#ee8dcd;border-radius:25px;text-align:center;">
                            <b><span style="font-size:40px;" id="count_tugasan_shuttle3">0</span></b>
                            <h5 class="text-white">Kilang Papan</h5>
                            <div class="mt-2" id="jpn_detail_s3" style="display:flex;flex-wrap:wrap;justify-content:center;gap:6px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card bg-info card-hover" style="border-radius:25px">
                        <div class="card-body" style="box-shadow:0 4px 8px 0 rgba(0,0,0,0.2);background-color:#f0e10dbd;border-radius:25px;text-align:center;">
                            <b><span style="font-size:40px;" id="count_tugasan_shuttle4">0</span></b>
                            <h5 class="text-white">Kilang Papan Lapis/Venir</h5>
                            <div class="mt-2" id="jpn_detail_s4" style="display:flex;flex-wrap:wrap;justify-content:center;gap:6px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card bg-info card-hover" style="border-radius:25px">
                        <div class="card-body" style="box-shadow:0 4px 8px 0 rgba(0,0,0,0.2);background-color:#6df173;border-radius:25px;text-align:center;">
                            <b><span style="font-size:40px;" id="count_tugasan_shuttle5">0</span></b>
                            <h5 class="text-white">Kilang Kayu Kumai</h5>
                            <div class="mt-2" id="jpn_detail_s5" style="display:flex;flex-wrap:wrap;justify-content:center;gap:6px"></div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            (function(){
                var detailUrl = "{{ route('ajax.count.jpn.detail') }}";
                var formLinks = {
                    3: {
                        A: "{{ route('jpn.shuttle-3-listA-jpn', date('Y')) }}",
                        B: "{{ route('jpn.shuttle-3-listB-jpn', date('Y')) }}",
                        C: "{{ route('jpn.shuttle-3-listC-jpn', date('Y')) }}",
                        D: "{{ route('jpn.shuttle-3-listD-jpn', date('Y')) }}"
                    },
                    4: {
                        A: "{{ route('jpn.shuttle-4-listA-jpn', date('Y')) }}",
                        B: "{{ route('jpn.shuttle-4-listB-jpn', date('Y')) }}",
                        C: "{{ route('jpn.shuttle-4-listC-jpn', date('Y')) }}",
                        D: "{{ route('jpn.shuttle-4-listD-jpn', date('Y')) }}"
                    },
                    5: {
                        A: "{{ route('jpn.shuttle-5-listA-jpn', date('Y')) }}",
                        B: "{{ route('jpn.shuttle-5-listB-jpn', date('Y')) }}",
                        C: "{{ route('jpn.shuttle-5-listC-jpn', date('Y')) }}",
                        D: "{{ route('jpn.shuttle-5-listD-jpn', date('Y')) }}"
                    }
                };
                var colors = {A:'#555',B:'#c9559e',C:'#8a7e00',D:'#0e7012'};
                [3,4,5].forEach(function(s){
                    $.get(detailUrl, {shuttle_type: s}, function(data){
                        var container = $('#jpn_detail_s'+s);
                        container.empty();
                        Object.keys(data).forEach(function(key){
                            var form = key.replace('form','');
                            var count = data[key];
                            var link = formLinks[s] && formLinks[s][form] ? formLinks[s][form] : '#';
                            var btn = $('<a>')
                                .attr('href', link)
                                .css({
                                    display:'inline-flex', alignItems:'center', gap:'4px',
                                    background:'rgba(255,255,255,0.85)', color:'#222',
                                    borderRadius:'20px', padding:'3px 10px', fontSize:'13px',
                                    fontWeight:'600', textDecoration:'none', border:'2px solid '+(colors[form]||'#555')
                                })
                                .text('Borang '+s+form+' ');
                            if(count > 0){
                                btn.append($('<span>').css({
                                    background:'#e53935', color:'#fff',
                                    borderRadius:'50%', padding:'1px 6px', fontSize:'11px'
                                }).text(count));
                            }
                            container.append(btn);
                        });
                    });
                });
            })();
            </script>

            <div class="row">

                    <div class="col-md-12">
                        <div class="border card" style="border-radius: 5px;">
                            <div class="border card-header bg-info">
                                <h3 class="text-white m-b-0" style="text-align: center;font-size: 20px;font-weight: bold;">
                                    PENGUMUMAN</h3>
                            </div>
                            <div class="border card-body">
                                <div class="list-group"
                                    style="overflow:auto;height:300px;width:100%;border:1px solid #ccc">
                                    <!-- <a href="#" class="list-group-item list-group-item-action flex-column align-items-start"> -->
                                    @if ($pengumuman_ipjpsm)
                                        @foreach ($pengumuman_ipjpsm as $data)
                                            <div
                                                class="list-group-item list-group-item-action flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="mb-1 card-title" style="font-size: 20px; font-weight: bold;">
                                                        {{ $data->tajuk }}</h6>
                                                    <small class="text-muted"
                                                        style="font-size: 110%;">{{ date('d-m-Y', strtotime($data->created_at)) }}</small>
                                                </div>
                                                <p class="my-1" style="font-size: 15px; text-align:left;">
                                                    {{ $data->keterangan }}</p>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="list-group-item list-group-item-action flex-column align-items-start">
                                            <div class="d-flex w-100 justify-content-between">
                                                {{-- <h6 class="mb-1 card-title" style="font-size: 20px; font-weight: bold;">{{ $data->tajuk }}</h6> --}}
                                                {{-- <small class="text-muted" style="font-size: 110%;">{{ $data->created_at->toDateString() }}</small> --}}
                                            </div>
                                            <p class="my-1" style="font-size: 30px; text-align:center;">Tiada
                                                Pengumuman</p>
                                        </div>
                                    @endif


                                </div>
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


<script type=text/javascript>
      $(document).ready(function() {
         $.ajax({  //create an ajax request to display.php
          type: "GET",
          url: "{{ route('ajax_count_tugasan_jpn_shuttle3') }}",
          success: function (data) {
            $("#count_tugasan_shuttle3").html(data);
          }
        });
      });
</script>

<script type=text/javascript>
    $(document).ready(function() {
       $.ajax({  //create an ajax request to display.php
        type: "GET",
        url: "{{ route('ajax_count_tugasan_jpn_shuttle4') }}",
        success: function (data) {
            console.log(data);
          $("#count_tugasan_shuttle4").html(data);
        }
      });
    });
</script>

<script type=text/javascript>
    $(document).ready(function() {
       $.ajax({  //create an ajax request to display.php
        type: "GET",
        url: "{{ route('ajax_count_tugasan_jpn_shuttle5') }}",
        success: function (data) {
          $("#count_tugasan_shuttle5").html(data);
        }
      });
    });
</script>


@endsection
