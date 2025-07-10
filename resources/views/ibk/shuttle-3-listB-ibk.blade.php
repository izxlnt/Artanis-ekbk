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
                                        <a type="button " href="{{ route('user.shuttle-3-listA', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:black">Borang 3A</a>
                                        <a type="button" href="{{ route('user.shuttle-3-listB', date('Y')) }}"
                                            class="btn"
                                            style="background-color:#ee8dcd;color:black;border-color:#ee8dcd">Borang 3B</a>
                                        <a type="button" href="{{ route('user.shuttle-3-listC', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#bbb235f3">Borang 3C</a>
                                        <a type="button" href="{{ route('user.shuttle-3-listD', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#1b9e21f3">Borang 3D</a>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div>
                                <h4 class="text-center">PENYATA SHUTTLE 3 - KILANG PAPAN</h4>

                                <h4 class="text-center">BORANG 3B - JUMLAH GUNA TENAGA PADA AKHIR BULAN</h4>
                            </div>
                            <br>
                            <div class="">
                                <table class="text-center table-bordered" style="width:100%;">
                                    <thead style="background-color:#ee8dcd">
                                        <tr>
                                            <th>Bil</th>
                                            <th>Nama Kilang</th>
                                            <th>No. SSM</th>
                                            <th>No. Lesen</th>
                                            <th>Suku</th>
                                            <th>Status</th>
                                            <th>Tindakan</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($list as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td style="text-align:left">{{ $data->nama_kilang }}</td>
                                                <td>{{ $data->no_ssm }}</td>
                                                <td>{{ $data->no_lesen }}</td>
                                                <td>
                                                    @if ($data->suku_tahun == 1)
                                                        Pertama (Mac)
                                                    @elseif($data->suku_tahun == 2)
                                                        Kedua (Jun)
                                                    @elseif($data->suku_tahun == 3)
                                                        Ketiga (September)
                                                    @elseif($data->suku_tahun == 4)
                                                        Keempat (Disember)
                                                    @endif

                                                </td>
                                                <td>
                                                    @if ($data->status == 'Sedang Diproses')
                                                        <span
                                                            class="label label-warning label-rounded">{{ $data->status }}</span>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM')
                                                        <span class="label label-warning label-rounded">Sedang
                                                            Diproses</span>
                                                    @elseif($data->status == 'Tidak Lengkap')
                                                        <span
                                                            class="label label-danger label-rounded">{{ $data->status }}</span>
                                                    @elseif($data->status == 'Lulus')
                                                        <span class="label label-success label-rounded">Disahkan</span>
                                                    @else
                                                        <span
                                                            class="label label-success label-rounded">{{ $data->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data->status == 'Sedang Diproses')
                                                        <a href="" class="mr-1 btn btn-dark disabled"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @elseif($data->status == 'Dihantar ke IPJPSM')
                                                        <a href="" class="mr-1 btn btn-dark disabled"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @elseif($data->status == 'Tidak Lengkap')
                                                        <a href="{{ route('edit-form3b', $data->id) }}"><img
                                                                src="{{ asset('pencil.png') }}" height='30px' alt=""
                                                                style="font-size: 15pt;" data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Borang Tidak Lengkap"></i></a>
                                                    @else
                                                        <a href="" class="mr-1 btn btn-dark disabled"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                </td>



                                            @empty
                                            <tr>
                                                <td colspan="7">
                                                    {{-- <img src="https://cdn-icons-png.flaticon.com/512/1380/1380641.png" alt="" height="100px"><br> --}}

                                                    Tiada Data
                                                </td>
                                            </tr>
                                        @endforelse
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

            window.location.href = "<?php echo URL::to('/pengguna/shuttle-3-listB/" + year +"'); ?>";
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
                ordering: false,
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

    {{-- <style >

    table, th, td {
      border: 1px solid black;
    }
    </style> --}}
@endsection
