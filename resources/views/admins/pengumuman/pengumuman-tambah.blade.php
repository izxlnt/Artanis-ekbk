@extends('layouts.layout-phd-nicepage')

@section('content')

    <link href="{{ asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('https://code.jquery.com/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js') }}"></script>

    <script class="">
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>

    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->

    <div class="container-fluid" style="width:100%">

        <div class="row">
            <div class="col-12">



                <div class="card">
                    <div class="card-body">
                        <div class="card-header"
                            style="text-align:center; background-color: #a0e4ff !important; font-size: 130%; font-weight: bold;">
                            Tambah Pengumuman
                        </div>

                        <br>
                        <form action="{{ route('phd.pengumuman-add') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">

                                        <form class="form-horizontal">
                                            <div class="card-body">

                                                <div class="form-group row">
                                                    <label for="fname"
                                                        class="text-right col-sm-3 control-label col-form-label">Tajuk</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                            name="tajuk"
                                                            placeholder="Tajuk"
                                                            value="">
                                                            @error('tajuk')
                                                                <div class="alert alert-danger">
                                                                    <strong>{{ $message }}</strong>
                                                                </div>
                                                            @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname"
                                                        class="text-right col-sm-3 control-label col-form-label">Keterangan</label>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control"
                                                            name="keterangan"
                                                            placeholder="keterangan"
                                                            value=""> </textarea>

                                                            @error('keterangan')
                                                            <div class="alert alert-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="card-body">
                                                <div class="text-right form-group m-b-0">
                                                    <a href="{{ route('recovery-rate') }}" type="button"
                                                        class="btn btn-primary">Kembali</a>
                                                        <button type="button" class="btn btn-primary"
                                                        alt="default" data-toggle="modal" data-target="#confirmation_borang_a">
                                                        Simpan</button>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="confirmation_borang_a"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="confirmation_borang_aTitle"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header" style="background-color:#f3ce8f  !important">
                                                                    <h5 class="modal-title "
                                                                        id="exampleModalLongTitle"><i style="color:rgb(255, 255, 0)"
                                                                            class="fas fa-exclamation-triangle"></i>&nbspPENGESAHAN
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <span class="text-center"><b>Adakah anda pasti ingin menambah maklumat ini?</span>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-dismiss="modal">Batal</button>
                                                                    <button type="submit"
                                                                        class="btn btn-success">Kemaskini</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </form>
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

@endsection
