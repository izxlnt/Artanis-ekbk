@extends('layouts.layout-phd-nicepage')

@section('content')


    {{-- @livewire('shuttle-three.shuttle3') --}}


    <div>

        <link href="{{ asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css') }}" rel="stylesheet" />


        <script src="{{ asset('https://code.jquery.com/jquery-3.5.1.js') }}"></script>
        <script src="{{ asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js') }}"></script>

        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid" style="width:100%">

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
                        <div class="card-body" style="width: 100%">
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
                                        <a type="button " href="{{ route('phd.senarai-tugasan-5A', date('Y')) }}"
                                            class="btn"
                                            style="background-color:rgb(196, 188, 186);color:black;border-color:black">Borang
                                            5A</a>
                                        <a type="button" href="{{ route('phd.senarai-tugasan-5B', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#ee8dcd">Borang 5B</a>
                                        <a type="button" href="{{ route('phd.senarai-tugasan-5C', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#bbb235f3">Borang 5C</a>
                                        <a type="button" href="{{ route('phd.senarai-tugasan-5D', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#1b9e21f3">Borang 5D</a>
                                        <a type="button" href="{{ route('phd.senarai-tugasan-5E', date('Y')) }}"
                                            class="btn btn-primary"
                                            style="background-color:white;color:black;border-color:rgb(54, 140, 238">Borang
                                            5E</a>

                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div>
                            <h4 class="text-center">PENYATA SHUTTLE 5 - KILANG KAYU KUMAI</h4>

                                <h4 class="text-center">BORANG 5A - MAKLUMAT KILANG KAYU KUMAI</h4>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="text-center display" style="width:100%">
                                    <thead style="background-color:rgb(196, 188, 186);">
                                        <tr>
                                            <th>Bil</th>
                                            <th>Nama Kilang</th>
                                            <th>No. SSM</th>
                                            <th>No. Lesen</th>

                                            <th>Status</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($formA as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td style="text-align:left;">{{ $data->shuttle->nama_kilang }}</td>
                                                <td>{{ $data->shuttle->no_ssm }}</td>
                                                <td>{{ $data->shuttle->no_lesen }}</td>
                                                <td>
                                                    @if ($data->shuttle->id == $data->shuttle_id && $data->tahun == date('Y'))

                                                    @if ($data->status == 'Dihantar ke IPJPSM')
                                                        @php
                                                            foreach ($batch as $checker) {
                                                                //  $suku_tahun == 0;
                                                                if ($data->tahun == date('Y')) {
                                                                    if ($checker->tahun == $year && $checker->shuttle_id == $data->shuttle->id && $checker->bulan == $data->created_at->format('m')) {
                                                                        $current_batch = $checker;
                                                                    }
                                                                }
                                                            }
                                                        @endphp

                                                        @if ($current_batch->status == 'Dihantar ke IPJPSM' && $current_batch->borang_a == 2)
                                                        <span class="label label-success label-rounded"
                                                        style="font-size: 11pt;">Dihantar ke IPJPSM</span>
                                                        @else
                                                        <span class="label label-warning label-rounded"
                                                        style="font-size: 11pt;">Pakej Belum Dihantar</span>
                                                        @endif
                                                    @endif
                                                    @endif
                                                    @if($data->status == "Sedang Diproses")
                                                        <span class="label label-primary label-rounded"
                                                            style="font-size: 11pt;">Borang Perlu Disahkan</span>
                                                    @elseif($data->status == "Tidak Lengkap")
                                                        <span class="label label-danger label-rounded"
                                                            style="font-size: 11pt;">{{ $data->status }}</span>
                                                            @elseif($data->status == 'Lulus')
                                                        <span class="label label-success label-rounded"
                                                            style="font-size: 11pt;">Borang telah diperaku</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data->status == 'Sedang Diproses')
                                                        {{-- <a href="{{ route('phd.shuttle-4-view-formA', $data->id) }}" --}}
                                                        <a href="{{ route('phd.shuttle-3-view-formA', $data->id) }}">
                                                            <img src="{{ asset('eye.png') }}"
                                                                height='30px'
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang perlu disahkan PHD"></i></a>
                                                    @elseif($data->status == "Tidak Lengkap")
                                                    <img src="{{ asset('history.png') }}"
                                                    height='30px'
                                                    data-toggle="tooltip" data-placement="bottom"
                                                    title="Borang tidak lengkap"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM')
                                                    <a href="{{ route('phd.shuttle-3-view-formA-phd', $data->id) }}">
                                                        <img src="{{ asset('check.png') }}" height='30px'
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang telah disahkan PHD">
                                                    </a>
                                                    @elseif($data->status == 'Lulus')
                                                    <a href="{{ route('phd.shuttle-3-view-formA-phd', $data->id) }}">
                                                        <img src="{{ asset('double_check.png') }}" height='30px'
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang telah diperaku"></a>
                                                    @endif
                                                </td>

                                        @endforeach
                                        </tr>


                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <a class="btn btn-primary" href="{{ route('home-phd') }}" style="color:white">Kembali</a>
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

            window.location.href = "<?php echo URL::to('/phd/senarai-tugasan-5A/" + year +"'); ?>";
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
