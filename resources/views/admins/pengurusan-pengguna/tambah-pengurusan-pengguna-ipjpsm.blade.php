@extends('layouts.layout-bpm-nicepage')


@section('content')

    <div>


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

        <div class="rounded-lg card" style="border-color: #000000 !important;">
            <div class="card-header"
                style="text-align:center; background-color: #f3b96c !important; font-size: 130%; font-weight: bold;">
                Tambah Pengguna Modul
            </div>


            <div class="card-body">
                <div class="tab-content">
                    <form wire:submit.prevent='store'>
                        <div class="tab-pane active" id="hotel" role="tabpanel" aria-labelledby="hotel-tab">
                            <br>
                            <div class="">
                                <table class="table table-striped table-bordered" id="" style="width: 100%;">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">

                                                <form action="{{ route('bpm.tambah-pengurusan-pengguna.store') }}"
                                                    class="validation-wizard wizard-circle m-t-40" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="card-body">
                                                        <h4 class="card-title" style="text-align: center">Maklumat
                                                            Pengguna</h4>
                                                        <hr>

                                                        <div class="form-group row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">No.
                                                                Kad Pengenalan
                                                                (pengguna)</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control"
                                                                    name='kad_pengenalan' placeholder="No. Kad Pengenalan"
                                                                    maxlength="12" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                        {{-- <div class="form-group row">
                    <label for="lname" class="text-right col-sm-3 control-label col-form-label">Peranan</label>
                    <div class="col-sm-9">
                        <select class="form-control" name='peranan'>
                            <option disabled selected hidden value="">Pilih Peranan</option>
                            <option>Pentadbir Modul</option>
                            <option>Pengguna Biasa</option>
                        </select>
                    </div>
                </div> --}}

                                                        <div class="form-group row">
                                                            <label for="lname"
                                                                class="text-right col-sm-3 control-label col-form-label">Kategori
                                                                Pengguna</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control" name='kategori_pengguna'>
                                                                    <option disabled selected hidden value="">Pilih Kategori
                                                                        Pengguna</option>
                                                                    <option value="BPE">IPJPSM</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        {{-- <div class="form-group row">
                                        <label for="email1" class="text-right col-sm-3 control-label col-form-label">Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name='status'>
                                                <option disabled  selected hidden value="">Pilih Status</option>
                                                <option value ='1'>Aktif</option>
                                                <option value ='0'>Tak Aktif</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                                        <div class="form-group row">
                                                            <label for="cono1"
                                                                class="text-right col-sm-3 control-label col-form-label">Nama
                                                                Penuh</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="cono1"
                                                                    name='name' placeholder="Nama Penuh">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="cono1"
                                                                class="text-right col-sm-3 control-label col-form-label">Gelaran
                                                                Jawatan</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="cono1"
                                                                    name='jawatan' placeholder="Gelaran Jawatan">
                                                            </div>
                                                        </div>
                                                        {{-- <div class="form-group row">
                    <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Negeri / IPJPSM</label>
                    <div class="col-md-9">
                        <select class="form-control" id="negeri_id" name="negeri_id" onchange="ajax_daerah(this)">
                            <option disabled selected hidden value="">Pilih Negeri
                            </option>
                            @foreach (App\Models\Daerah::distinct()->get('negeri') as $data)
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

                <div class="row">
                    <label for="fname" class="text-right col-sm-3 control-label col-form-label">Daerah</label>
                    <div class="col-md-9">
                        <select class="form-control" id="daerah_id" name='daerah_id' placeholder="Daerah">
                            <option value="" selected hidden disabled>Sila Pilih
                                Daerah</option>


                        </select>
                        @error('daerah_id')
                            <div class="alert alert-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                </div> --}}

                                                        <br>
                                                        <div class="form-group row">
                                                            <label for="cono1"
                                                                class="text-right col-sm-3 control-label col-form-label">Bahagian</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control" name='bahagian'>
                                                                    <option disabled selected hidden value="">Pilih bahagian
                                                                    </option>
                                                                    <option>Bahagian Forest Eco-Park &amp; Hutan Taman
                                                                        Negeri</option>
                                                                    <option>Bahagian Hal Ehwal Antarabangsa</option>
                                                                    <option>Bahagian Kejuruteraan Hutan</option>
                                                                    <option>Bahagian Khidmat Pengurusan</option>
                                                                    <option>Bahagian Ladang Hutan &amp; Perlindungan Hutan
                                                                    </option>
                                                                    <option>Bahagian Latihan Perhutanan</option>
                                                                    <option>Bahagian Penguatkuasaan Hutan</option>
                                                                    <option>Bahagian Pengurusan Hutan</option>
                                                                    <option>Bahagian Pengurusan Maklumat</option>
                                                                    <option>Bahagian Perancangan &amp; Ekonomi Hutan
                                                                    </option>
                                                                    <option>Bahagian Perundangan dan Pendakwaan</option>
                                                                    <option>Bahagian Silvikultur &amp; Pemeliharaan Biologi
                                                                        Hutan</option>
                                                                    <option>Bahagian Teknikal dan Industri Kayu</option>
                                                                    <option>Jabatan Perhutanan Negeri</option>
                                                                    <option>Unit Integriti Perhutanan</option>
                                                                    <option>Unit Komunikasi Korporat &amp; Perhubungan Awam
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="cono1"
                                                                class="text-right col-sm-3 control-label col-form-label">No.
                                                                Telefon</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="cono1"
                                                                    name='no_telefon' placeholder="No. Telefon">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="cono1"
                                                                class="text-right col-sm-3 control-label col-form-label">Email</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="cono1"
                                                                    name='email' placeholder="Email">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>

                                                    <div class="card-body">
                                                        <div class="text-right form-group m-b-0">
                                                            <a href="{{ url()->previous() }}"
                                                                class="btn btn-primary">Batal</a>
                                                            <button type="button" class="btn btn-primary" alt="default"
                                                                data-toggle="modal"
                                                                data-target="#confirmation_borang_a">Tambah</button>
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
                                                                    <span class="text-center"><b>Adakah anda pasti ingin
                                                                        menambah pengguna ini?</span>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-dismiss="modal">Batal</button>
                                                                    <button type="submit"
                                                                        class="btn btn-success">HANTAR</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    </div>
                            </div>
                            </table>

                        </div>
                </div>









            </div>
        </div>


    </div>
    </div>
    </div>





    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable();
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
                        $("#daerah_id").append('<option value="' + respond[x].daerah_sivil + '">' +
                            respond[x]
                            .daerah_sivil + '</option>');
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
