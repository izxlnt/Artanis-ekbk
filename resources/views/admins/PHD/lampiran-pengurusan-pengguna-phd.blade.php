@extends('layouts.layout-phd-nicepage')


@section('content')

<div>
                            <div class="card-header"
                            style="text-align:center; background-color: #e9cac2 !important; font-size: 130%; font-weight: bold;">
                            Maklumat Pengguna Modul
                            </div>

                            <form action="{{  route('sahkan-permohonan-phd',$users->id) }}" class="validation-wizard wizard-circle m-t-40" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    {{-- <h4 class="card-title">Maklumat Pengguna</h4>
                                <hr> --}}

                                    <div class="form-group row">
                                        <label for="fname" class="text-right col-sm-3 control-label col-form-label">No. Kad Pengenalan (pengguna)</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name='kad_pengenalan' value="{{ $users->login_id }}" placeholder="No. Kad Pengenalan" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lname" class="text-right col-sm-3 control-label col-form-label">Peranan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name='peranan' value="{{ $users->peranan }}" placeholder="No. Kad Pengenalan" readonly>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Nama Penuh</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="cono1" name='name' value="{{ $users->name }}" laceholder="Nama Penuh" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Gelaran Jawatan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="cono1" name='jawatan' value="{{ $users->jawatan }}" placeholder="Gelaran Jawatan" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Negeri / IPJPSM</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="cono1" name='negeri' value="{{ $users->negeri }}" placeholder="negeri" readonly>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Bahagian (Sekiranya IPJPSM)</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="cono1" name='bahagian' value="{{ $users->bahagian }}" placeholder="negeri" readonly>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cono1" class="text-right col-sm-3 control-label col-form-label">No. Telefon</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="cono1" name='no_telefon' value="{{ $users->no_telefon }}" placeholder="No. Telefon" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="cono1" name='email'  value="{{ $users->email }}"placeholder="Email" readonly>
                                        </div>
                                    </div>

                                    {{-- <div class="form-group row">
                                        <label for="status" class="text-right col-sm-3 control-label col-form-label">Status</label>
                                        <div class="col-sm-9">
                                            @if($users->status =='1')
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
                                </div>
                                <hr>

                                {{-- <div class="card-body">
                                    <div class="text-right form-group m-b-0">
                                        <button type="button" class="btn btn-danger"><i class="fas fa-times"></i>
                                            Batal</button> &nbsp
                                        <button type="button" class="btn btn-success" alt="default" data-toggle="modal" data-target="#responsive-modal" class="model_img img-fluid"><i class="fa fa-check" class="img-fluid model_img"></i>
                                            Sahkan</button>
                                    </div>
                                </div> --}}

                                <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body" style="text-align: center">
                                            <h4>Adakah anda ingin mengesahkan pengguna?</h4><br>
                                            {{-- <button type="submit" class="btn btn-primary waves-effect waves-light">Sahkan</button> --}}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Sahkan</button>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            </form>

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
