@extends('layouts.layout-ibk-nicepage')
@section('content')

<style>
    .dataTables_wrapper .dataTables_filter {
    float: right;
    text-align: right;
    visibility: hidden;
    }
</style>
    <div class="container-fluid">


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
                                            <a href="{{ $breadcrumb['link'] }}" style="color: white !important;" onMouseOver="this.style.color='lightblue'" onMouseOut="this.style.color='white'"> {{ $breadcrumb['name'] }}
                                            </a>
                                        </li>
                                    @else
                                    <li class="breadcrumb-item active" aria-current="page" style="color: yellow !important;">
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
                        <h4 class="text-center card-title">PENGURUSAN PENGGUNA</h4>
                    </div>
                    {{-- <div class="" style="text-align: center">
                        <a href="{{ route('ShuttleExcel', 'xls') }}"><button class="mdi mdi-file-excel">Jana
                                Laporan</button></a>
                        <button class="mdi mdi-printer" id="print">Print</button>
                    </div> --}}

                    <div class="row">
                        <div class="col-md-1"></div>
                        <a class="btn btn-primary" href="{{ URL::previous() }}" style="color:white">Kembali</a>

                        <div class="col-md-3">
                            {{-- <button type="button" class="btn waves-effect waves-light btn-primary btn-block">Tambah Pengguna</button> --}}
                            <a href="{{ route('home-user.user-management.add') }}"
                                class="btn waves-effect waves-light btn-primary btn-block">Pendaftaran Pengguna Kilang Kedua</a>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 15px;">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="printablearea">
                                <div class="table-responsive">
                                    <table id="example" class="text-center table-bordered">
                                        <thead>

                                            <tr>
                                                <th>Bil</th>
                                                <th>Nama Pengguna</th>
                                                <th>Emel</th>
                                                <th>No. Kad Pengenalan</th>
                                                <th>Status Pengesahan IPJPSM</th>
                                                <th>Status Pengguna</th>
                                                <th>Tindakan</th>

                                            </tr>

                                        </thead>

                                        <tbody>
                                            @foreach ($user as $key => $data)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td align="left">{{ $data->name }}</td>
                                                    <td>{{ $data->email }}</td>
                                                    <td>{{ $data->login_id }}</td>
                                                    <td>
                                                        @if ($data->is_approved == 1)
                                                            <span class="badge badge-pill badge-success"
                                                                style="font-size : 11pt;">Disahkan</span>
                                                        @else
                                                            <span class="badge badge-pill badge-danger"
                                                                style="font-size : 11pt;">Tidak Disahkan</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($data->status == '1')
                                                            <span class="badge badge-pill badge-success"
                                                                style="font-size : 11pt;">Aktif</span>
                                                        @else
                                                            <span class="badge badge-pill badge-danger"
                                                                style="font-size : 11pt;">Tidak Aktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($data->status == '1')
                                                            <button type="button"
                                                                class="btn waves-effect waves-light btn-danger"
                                                                onclick="disable_user({{ $data->id }})"><i
                                                                    class="fas fa-trash-alt"></i></button>
                                                    </td>
                                                @else
                                                    <button type="button" class="btn waves-effect waves-light btn-success"
                                                        onclick="enable_user({{ $data->id }})"><i
                                                            class="fas fa-check-circle"></i></button></td>
                                            @endif
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                    <br><br>



                                </div>

                            </div>


                            <!-- Modal Disable User -->
                            <div class="modal fade" id="disable_user_modal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color:#f3ce8f  !important">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><i
                                                    class="fa fa-exclamation-triangle" style="color:rgb(255, 255, 0)"

                                                    aria-hidden="true"></i>&nbspPENGESAHAN</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body"> <b>
                                            Anda pasti mahu nyahaktif pengguna ini?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('home-user.user-management.user-status.update') }}">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Kembali</button>
                                                <input type="hidden" name="user_id_disable" id="user_id_disable" readonly>
                                                <button type="submit" class="btn btn-success">Nyahaktif Pengguna</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Enable User -->
                            <div class="modal fade" id="enable_user_modal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color:#f3ce8f  !important">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><i
                                                    class="fa fa-exclamation-triangle"
                                                    aria-hidden="true" style="color:rgb(255, 255, 0)"></i>&nbspPENGESAHAN</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Anda pasti mahu aktifkan pengguna ini?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('home-user.user-management.user-status.update') }}">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Kembali</button>
                                                <input type="hidden" name="user_id_enable" id="user_id_enable" readonly>
                                                <button type="submit" class="btn btn-success">Aktifkan Pengguna</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>









                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

    <script>
        function disable_user(user_id) {
            $("#user_id_disable").val(user_id);
            $("#disable_user_modal").modal();
        }

        function enable_user(user_id) {
            $("#user_id_enable").val(user_id);
            $("#enable_user_modal").modal();
        }
        $(document).ready(function() {
            $('#example').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                // "bFilter": false,
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
    </script>


@endsection
