@extends('layouts.layout-ipjpsm-nicepage')

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
                                        <a type="button " href="{{ route('shuttle-3-listA', date('Y')) }}"
                                            class="btn"
                                            style="background-color:rgb(196, 188, 186);color:black;border-color:black">Borang
                                            3A</a>
                                        <a type="button" href="{{ route('shuttle-3-listB', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#ee8dcd">Borang 3B</a>
                                        <a type="button" href="{{ route('shuttle-3-listC', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#bbb235f3">Borang 3C</a>
                                        <a type="button" href="{{ route('shuttle-3-listD', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#1b9e21f3">Borang 3D</a>

                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div>
                                <h4 class="text-center">PENYATA SHUTTLE 3 - KILANG PAPAN</h4>
                                <h4 class="text-center">PERAKUAN MAKLUMAT BORANG 3A - MAKLUMAT KILANG PAPAN</h4>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="text-center display" style="width:100%">
                                    <thead style="background-color:rgb(196, 188, 186);">
                                        <tr>

                                            <th>Bil</th>
                                            <th>Nama Kilang</th>
                                            <th>Negeri</th>
                                            <th>Daerah Hutan</th>
                                            <th>No. SSM</th>
                                            <th>No. Lesen</th>
                                            <th>Tahunan</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($formA_kilang as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td style="text-align:left">{{ $data->nama_kilang }}</td>
                                                <td>{{ $data->negeri_id }}</td>
                                                <td>{{ $data->daerah_id }}</td>
                                                <td>{{ $data->no_ssm }}</td>
                                                <td>{{ $data->no_lesen ?? 'Tiada' }}</td>

                                                <td>
                                                    @foreach ($formA as $form)
                                                        @if ($data->id == $form->shuttle_id)
                                                            @if ($form->status == 'Sedang Diproses')
                                                                <i class="fas fa-tasks"
                                                                    style="color: #dbd400; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan PHD "></i>
                                                            @elseif($form->status == 'Tidak Lengkap')
                                                               <img src="{{ asset('history.png') }}" height='30px' alt=""
                                                                    style="color: #dbd400; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang tidak lengkap "></i>
                                                            @elseif($form->status == 'Dihantar ke IPJPSM')
                                                                <a
                                                                    href="{{ route('ipjpsm.shuttle-3-view-formA', $data->id) }}">
                                                                    <img src="{{ asset('circle_check_yellow.png') }}"
                                                                        height='30px' alt=""
                                                                        style="color: white; font-size: 18pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang perlu diperaku"></i></a>
                                                            @elseif($form->status == 'Lulus')
                                                                <img src="{{ asset('double_check.png') }}" height='30px' alt=""
                                                                    style="color: green; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah diperaku "></i>
                                                            @endif
                                                        @endif
                                                    @endforeach

                                                </td>
                                        @endforeach
                                        </tr>
                                    </tbody>
                                </table>

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
        function changePage() {

            var year = $("#select_year").val();

            window.location.href = "<?php echo URL::to('/admin/shuttle-3-listA/" + year +"'); ?>";
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
