@extends('layouts.layout-ipjpsm-nicepage')

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
                        <div class="card-header"
                            style="text-align:center; background-color: #a0e4ff !important; font-size: 130%; font-weight: bold;">
                            Kemaskini Daerah
                        </div>

                        <br>
                        <form action="{{ route('daerah-add') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">

                                        <form class="form-horizontal">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="cono1"
                                                        class="text-right col-sm-3 control-label col-form-label required">Negeri</label>
                                                    <div class="col-md-9">
                                                        <select class="form-control" id="negeri_id" name="negeri"
                                                            onchange="ajax_daerah(this)" required>
                                                            <option disabled selected hidden value="">Pilih Negeri
                                                            </option>
                                                            @foreach (App\Models\Daerah::distinct()->orderby('negeri')->get('negeri')
        as $data)
                                                                <option value="{{ $data->negeri }}">{{ $data->negeri }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('negeri')
                                                            <div class="alert alert-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname"
                                                        class="text-right col-sm-3 control-label col-form-label">Daerah
                                                        Hutan</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="daerah_hutan"
                                                            placeholder="Daerah Hutan" value="">
                                                        @error('daerah_hutan')
                                                            <div class="alert alert-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="fname"
                                                        class="text-right col-sm-3 control-label col-form-label">Daerah
                                                        Sivil</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="daerah_sivil"
                                                            placeholder="Daerah Sivil" value="">
                                                        @error('daerah_sivil')
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
                                                    <a href="{{ route('daerah') }}" type="button"
                                                        class="btn btn-primary">Kembali</a>
                                                    <button type="button" class="btn btn-primary" alt="default"
                                                        data-toggle="modal" data-target="#confirmation_borang_a">
                                                        Simpan</button>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="confirmation_borang_a" tabindex="-1"
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
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <span class="text-center"><b>Adakah anda pasti ingin menambah
                                                                    maklumat ini?</b></span>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-success">Kemaskini</button>
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

    <script>
        function ajax_daerah(select) {
            negeri = select.value;
            // console.log(negeri);

            //clear jenis_data selection
            $("#daerah_id").empty();
            //initialize selection
            $("#daerah_id").append('<option value="" selected disabled hidden>Sila Pilih Daerah</option>');

            $.ajax({
                type: "get",
                // url:"/permohonan/fetchSenaraiHargaIdByTahun/jenisDokumen/"+jenis_dokumen+"/jenisData/"+jenis_data+"/tahun/"+tahun+"/negeri/" + negeri + "/jenisKertas/" + jenis_kertas,
                url: "/register/ajax/fetch-daerah/" + negeri, //penting

                //url:"/JPSM/permohonan/fetchSenaraiHargaIdByTahun/jenisDokumen/"+jenis_dokumen+"/jenisData/"+jenis_data+"/tahun/"+tahun+"/negeri/" + negeri,
                success: function(respond) {
                    //fetch data (id) from DB Senarai Harga
                    //   var data = JSON.parse(respond);
                    console.log(respond);
                    //loop for data
                    var x = 0;

                    respond.forEach(function() { //penting

                        // console.log(respond[x]);
                        $("#daerah_id").append('<option value="' + respond[x].daerah_hutan + '">' +
                            respond[x]
                            .daerah_hutan + '</option>');
                        x++;

                    });
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("Status: " + textStatus);
                    console.log("Error: " + errorThrown);
                }
            });
        }
    </script>

@endsection
