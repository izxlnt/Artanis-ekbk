@extends('layouts.layout-phd-nicepage')

@section('content')

<link href="{{ asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
<script src="{{ asset('https://code.jquery.com/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js') }}"></script>

{{-- <script class="">
    $(document).ready(function() {
            $('#example').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false
            });
        });
</script> --}}

<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->

<div class="container-fluid" style="width:100%">

    <div class="row">
        <div class="col-12">

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

            <div class="card">
                <div class="card-body">

                    <div class="card-header"
                        style="text-align:center; background-color: #a0e4ff !important; font-size: 130%; font-weight: bold;">
                        KEMASKINI PENGUMUMAN
                    </div>

                    <br>
                    <div class="">

                        <table id="example" class="display" style="width:100%;text-align:center">
                            <thead>
                                <tr>
                                    <th style="width:5%">Bil</th>
                                    <th style="text-align:center;">Tajuk</th>
                                    <th style="text-align:center;">Keterangan</th>

                                    <th style="text-align:center;style=width:20%">Tindakan</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($pengumuman as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $data->tajuk }}</td>
                                    <td>{{ $data->keterangan }}</td>
                                    <form action="{{ route('phd.pengumuman-delete',$data->id) }}" method="post">
                                        @csrf
                                        <td>
                                            <a href="{{ route('phd.pengumuman-kemaskini', $data->id) }}"
                                                class="mr-1 btn btn-success"><i class="fas fa-pencil-alt"
                                                    title="Kemaskini"></i>
                                            </a>

                                            {{-- <button type="btn btn-danger" class="fas fa-trash-alt"
                                                        alt="default" data-toggle="modal" data-target="#confirmation_borang_a" type="button"><i
                                                        class="fas fa-trash-alt"></i>
                                                        Simpan</button> --}}

                                                    <button class="btn btn-danger" data-toggle="modal"
                                                data-target="#confirmation_borang_a{{  $data->id }}" type="button"><i
                                                    class="fas fa-trash-alt"></i></button>

                                            <div class="modal fade" id="confirmation_borang_a{{  $data->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="confirmation_borang_aTitle"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header"
                                                            style="background-color:#f3ce8f  !important">
                                                            <h5 class="modal-title " id="exampleModalLongTitle"><i
                                                                    style="color:rgb(255, 255, 0)"
                                                                    class="fas fa-exclamation-triangle"></i>&nbspPENGESAHAN
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <span class="text-center"><b>Adakah anda pasti ingin menghapuskan
                                                                maklumat ini?</span>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Batal</button>
                                                            <button type="submit"
                                                                class="btn btn-success">Hapus</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </form>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                    </div>

                    <a href="{{ URL::previous() }}" class="btn btn-primary">Kembali</a>
                    <a href="{{ route('phd.pengumuman-tambah') }}" class="btn btn-primary">Tambah</a>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
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

@endsection
