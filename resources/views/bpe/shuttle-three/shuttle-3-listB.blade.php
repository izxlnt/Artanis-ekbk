@extends('layouts.layout-bpm-nicepage')

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
                                    <select name="form_type" class="form-control">
                                        <option value="3A">2021</option>
                                        <option value="3B">2020</option>
                                        <option value="3C">2019</option>
                                        <option value="3D">2018</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a type="button" href="{{ route('bpm.shuttle-3-listB') }}"
                                            class="btn waves-effect waves-light btn-outline-info active">Borang 3B</a>
                                        <a type="button" href="{{ route('bpm.shuttle-3-listC') }}"
                                            class="btn waves-effect waves-light btn-outline-info">Borang 3C</a>
                                        <a type="button" href="{{ route('bpm.shuttle-3-listD') }}"
                                            class="btn waves-effect waves-light btn-outline-info">Borang 3D</a>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div>
                                <h4 class="text-center">BORANG 3B - JUMLAH GUNA TENAGA PADA AKHIR BULAN</h4>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Bil</th>
                                            <th>Negeri</th>
                                            <th>Daerah</th>
                                            <th>Nama Kilang</th>
                                            <th>No. SSM</th>
                                            <th>No.Lesen</th>
                                            <th>Suku 1</th>
                                            <th>Suku 2</th>
                                            <th>Suku 3</th>
                                            <th>Suku 4</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shuttle_listB as $shuttle)
                                            <tr class="text-center">
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $shuttle->daerah_id }}</td>
                                                <td>{{ $shuttle->alamat_kilang_daerah }}</td>
                                                <td>{{ $shuttle->nama_kilang }}</td>
                                                <td>{{ $shuttle->no_ssm }}</td>
                                                <td>{{ $shuttle->no_lesen ?? 'Tiada' }}</td>
                                                <td> <a href="{{ route('shuttle-3-view-formB', $shuttle->id) }}"
                                                        class="mr-1 btn btn-success"><i class="fas fa-pencil-alt"></i></a>
                                                </td>
                                                <td> <a href="{{ route('shuttle-3-formB') }}"
                                                        class="mr-1 btn btn-secondary"><i
                                                            class="mdi mdi-folder-plus"></i></a></td>
                                                <td> <a href="{{ route('shuttle-3-formB') }}"
                                                        class="mr-1 btn btn-danger"><i class="mdi mdi-folder-plus"></i></a>
                                                </td>
                                                <td> <a href="{{ route('shuttle-3-formB') }}"
                                                        class="mr-1 btn btn-success"><i class="fas fa-pencil-alt"></i></a>
                                                </td>

                                        @endforeach
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
