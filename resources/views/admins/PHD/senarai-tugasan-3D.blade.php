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
                                        <a type="button " href="{{ route('phd.senarai-tugasan-3A', date('Y')) }}"
                                        class="btn" style="background-color:white;color:black;border-color:black">Borang 3A</a>
                                    <a type="button" href="{{ route('phd.senarai-tugasan-3B', date('Y')) }}"
                                        class="btn" style="background-color:white;color:black;border-color:#ee8dcd">Borang 3B</a>
                                    <a type="button" href="{{ route('phd.senarai-tugasan-3C', date('Y')) }}"
                                        class="btn" style="background-color:white;color:black;border-color:#bbb235f3">Borang 3C</a>
                                    <a type="button" href="{{ route('phd.senarai-tugasan-3D', date('Y')) }}"
                                        class="btn" style="background-color:rgb(33, 235, 77);color:black;border-color:#1b9e21f3">Borang 3D</a>

                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div>
                            <h4 class="text-center">PENYATA SHUTTLE 3 - KILANG PAPAN</h4>

                                <h4 class="text-center">BORANG 3D - PENYATA PENJUALAN KAYU GERGAJI DALAM PASARAN TEMPATAN DAN EKSPORT</h4>
                            </div>
                            <div class="">
                                <table id="example" class="display text-center" style="width:100%">
                                    <thead style="background-color:rgb(33, 235, 77);">
                                        <tr>
                                            <th>Bil</th>
                                            <th>Nama Kilang</th>
                                            <th>No. SSM</th>
                                            <th>No.Lesen</th>

                                            <th>Tahun</th>
                                            <th>Bulan</th>

                                            <th>Status</th>
                                            <th>Tindakan</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($formD as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->nama_kilang }}</td>
                                                <td>{{ $data->no_ssm }}</td>
                                                <td>{{ $data->no_lesen }}</td>

                                                <td>{{ $data->tahun }}</td>
                                                <td>{{ $data->bulan }}</td>

                                                <td>
                                                    @if ($data->shuttle->id == $data->shuttle_id && $data->tahun == date('Y'))

                                                        @if ($data->status == 'Dihantar ke IPJPSM')
                                                        @php
                                                        foreach ($batch as $checker) {
                                                            if ($checker->tahun == $year && $checker->bulan == $data->bulan && $checker->shuttle_id == $data->shuttle->id) {
                                                                $current_batch = $checker;
                                                            }
                                                        }
                                                    @endphp

                                                            @if ($current_batch->status == 'Dihantar ke IPJPSM' && $current_batch->borang_d == 2)
                                                                <span class="label label-success label-rounded"
                                                                    style="font-size: 11pt;">Dihantar ke IPJPSM</span>
                                                            @else
                                                                <span class="label label-warning label-rounded"
                                                                    style="font-size: 11pt;">Pakej Belum Dihantar</span>
                                                            @endif
                                                        @endif
                                                    @endif

                                                    @if ($data->status == 'Sedang Diproses')
                                                        <span class="label label-primary label-rounded"
                                                            style="font-size: 11pt;">Borang Perlu Disahkan</span>
                                                    @elseif($data->status =="Tiada Pengeluaran")
                                                        <span class="label label-other bg-dark label-rounded"
                                                            style="font-size: 11pt;">{{ $data->status }}</span>
                                                            @elseif($data->status == 'Lulus')
                                                        <span class="label label-success label-rounded"
                                                            style="font-size: 11pt;">Borang telah diperaku</span>


                                                    @elseif($data->status =="Tidak Lengkap")
                                                        <span class="label label-danger label-rounded"
                                                            style="font-size: 11pt;">{{ $data->status }}</span>
                                                    @endif
                                                </td>
                                                <td>

                                                    @if ($data->status == 'Sedang Diproses')
                                                        <a href="{{ route('phd.shuttle-3-view-formD', $data->id) }}">
                                                            <img src="{{ asset('eye.png') }}" height='30px'
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang perlu disahkan PHD"></i></a>
                                                            @elseif($data->status == 'Dihantar ke IPJPSM')
                                                            <a href="{{ route('phd.shuttle-3-view-formD-phd', $data->id) }}">
                                                            <img src="{{ asset('check.png') }}" height='30px'
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah disahkan PHD">
                                                            </a>
                                                        @elseif($data->status == 'Lulus')
                                                        <a href="{{ route('phd.shuttle-3-view-formD-phd', $data->id) }}">
                                                            <img src="{{ asset('double_check.png') }}" height='30px'
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang telah diperaku">
                                                        </a>
                                                @endif

                                                </td>




                                        @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                                <br>

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

            window.location.href = "<?php echo URL::to('/phd/senarai-tugasan-3D/" + year +"'); ?>";
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

    {{-- <style >

    table, th, td {
      border: 1px solid black;
    }
    </style> --}}



@endsection
