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
                Maklumat Pengguna Modul
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
                                                <form action="{{ route('bpm.sahkan-permohonan-ipjpsm', $users->id) }}"
                                                    class="validation-wizard wizard-circle m-t-40" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="card-body">
                                                        {{-- <h4 class="card-title">Maklumat Pengguna</h4>
                                <hr> --}}
                                                        <br>
                                                        <div class="form-group row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Nama
                                                                Pengguna (No. Kad Pengenalan)</label>
                                                            <div class="col-sm-7">
                                                                <input type="text" class="form-control"
                                                                    name='kad_pengenalan' value="{{ $users->login_id }}"
                                                                    placeholder="No. Kad Pengenalan" readonly>
                                                            </div>
                                                        </div>

                                                        {{-- <div class="form-group row">
                    <label for="lname" class="text-right col-sm-3 control-label col-form-label"></label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name='peranan' value="{{ $users->peranan }}"
                            placeholder="No. Kad Pengenalan" readonly>

                    </div>
                </div> --}}
                                                        {{-- <div class="form-group row">
                    <label for="email1" class="text-right col-sm-3 control-label col-form-label">Status</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name='status' value="{{ $users->status }}"
                            placeholder="No. Kad Pengenalan" readonly>

                    </div>
                </div> --}}
                                                        <div class="form-group row">
                                                            <label for="cono1"
                                                                class="text-right col-sm-3 control-label col-form-label">Nama
                                                                Penuh</label>
                                                            <div class="col-sm-7">
                                                                <input type="text" class="form-control" id="cono1"
                                                                    name='name' value="{{ $users->name }}"
                                                                    laceholder="Nama Penuh" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="cono1"
                                                                class="text-right col-sm-3 control-label col-form-label">Gelaran
                                                                Jawatan</label>
                                                            <div class="col-sm-7">
                                                                <input type="text" class="form-control" id="cono1"
                                                                    name='jawatan' value="{{ $users->jawatan }}"
                                                                    placeholder="Gelaran Jawatan" readonly>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="form-group row">
                    <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Negeri / IPJPSM</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="cono1" name='negeri' value="{{ $users->negeri }}"
                            placeholder="negeri" readonly>

                    </div>
                </div> --}}
                                                        <div class="form-group row">
                                                            <label for="cono1"
                                                                class="text-right col-sm-3 control-label col-form-label">Bahagian</label>
                                                            <div class="col-sm-7">
                                                                <input type="text" class="form-control" id="cono1"
                                                                    name='bahagian' value="{{ $users->bahagian }}"
                                                                    placeholder="negeri" readonly>

                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="cono1"
                                                                class="text-right col-sm-3 control-label col-form-label">No.
                                                                Telefon</label>
                                                            <div class="col-sm-7">
                                                                <input type="text" class="form-control" id="cono1"
                                                                    name='no_telefon' value="{{ $users->no_telefon }}"
                                                                    placeholder="No. Telefon" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="cono1"
                                                                class="text-right col-sm-3 control-label col-form-label">Emel</label>
                                                            <div class="col-sm-7">
                                                                <input type="text" class="form-control" id="cono1"
                                                                    name='email' value="{{ $users->email }}"
                                                                    placeholder="Email" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- <div class="form-group row">
                <label for="status" class="text-right col-sm-3 control-label col-form-label">Status</label>
                <div class="col-sm-6">
                    @if ($users->status == '1')
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio2" name="status" class="custom-control-input" checked>
                            <label class="custom-control-label" for="customRadio2">Aktif</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio1" name="status" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio1">Tidak Aktif</label>
                        </div>
                    @else
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio1" name="status" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio1">Aktif</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio2" name="status" class="custom-control-input" checked>
                            <label class="custom-control-label" for="customRadio2">Tidak Aktif</label>
                        </div>
                    @endif


                </div>
            </div> --}}
                                                    {{-- <hr> --}}

                                                    <div class="row">
                                                        <div class="col-md-6"></div>

                                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                                            data-target="#confirmation_borang_a"><i class=""
                                                                class=" img-fluid model_img"></i>SAHKAN</button>

                                                        <div class="col-md-6"></div>
                                                    </div>

                                                    {{-- <div class="card-body">
                <div class="text-center form-group m-b-0">
                    <button type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#responsive-modal"><i class=""
                            class="img-fluid model_img"></i>Kemaskini</button>
                </div>
            </div> --}}

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
                                                                        mengesahkan maklumat pengguna ini?</span>
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

                                                    {{-- <div class="modal fade" id="#responsive-modal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-exclamation-triangle"
                                    aria-hidden="true"></i>&nbspPengesahan!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Anda pasti mahu log keluar sistem?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>

                        </div>
                    </div>
                </div>
            </div> --}}
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
        function onlyNumberKey(evt) {

            // Only ASCII charactar in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
    </script>

@endsection
