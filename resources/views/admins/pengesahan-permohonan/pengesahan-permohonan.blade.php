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

                            <br><br>
                            <div>
                                <h3 class="text-center">Status Pengurusan Pengguna</h3>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Bil</th>
                                            <th>Kad Pengenalan</th>
                                            <th>Nama Penuh</th>
                                            <th>Gelaran Jawatan</th>
                                            <th>Negeri/Bahagian</th>
                                            <th>Peranan</th>
                                            <th>Kategori Pengguna</th>
                                            {{-- <th>Status Pengguna</th> --}}
                                            <th>Status</th>
                                            <th>Tindakan</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user as $data)
                                            @if ($data->kategori_pengguna == 'PHD' || $data->kategori_pengguna == 'JPN' || $data->kategori_pengguna == 'IPJPSM' || $data->kategori_pengguna == 'BPM' || $data->kategori_pengguna == 'BPE')
                                                <tr class="text-center">
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $data->login_id }}</td>
                                                    <td>{{ $data->name }}</td>
                                                    <td>{{ $data->jawatan }}</td>
                                                    <td>{{ $data->bahagian }}</td>
                                                    <td>{{ $data->peranan }}</td>
                                                    <td>{{ $data->kategori_pengguna }}</td>

                                                    {{-- @if ($data->status == 1)
                                        <td><span class="label label-success label-rounded">Aktif</span></td>
                                        @else
                                        <td><span class="label label-danger label-rounded">Tidak&nbspAktif</span></td>
                                        @endif --}}

                                                    @if ($data->is_approved_ipjpsm == 1)
                                                        <td><span
                                                                class="label label-success label-rounded">Telah&nbspDisahkan</span>
                                                        </td>
                                                    @else
                                                        <td><span
                                                                class="label label-danger label-rounded">Belum&nbspDisahkan</span>
                                                        </td>
                                                    @endif
                                                    <td><a href="{{ route('bpm.lampiran-pengurusan-pengguna', $data->id) }}"
                                                            class="mr-1 btn btn-success"><i class="far fa-eye"></i></a>
                                                        {{-- <button class="btn btn-danger" type="button"><i
                                            class="fas fa-trash-alt"></i></button></td> --}}


                                                </tr>
                                            @endif
                                        @endforeach

                                    </tbody>
                                </table>

                                <div class="text-center form-group m-b-0">
                                    <a href="{{ route('bpm.tambah-pengurusan-pengguna-bpm') }}" type="button"
                                        class="btn btn-primary">Tambah Pengguna</a>

                                </div>

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

    <script>
        @if (Session::get('success'))
            toastr.success('{{ session('success') }}', 'Berjaya', { "progressBar": true });
        @elseif ($message = Session::get('error'))
            toastr.error('{{ session('error') }}', 'Ralat', { "progressBar": true });
        @endif
    </script>

@endsection
