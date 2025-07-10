@extends($layout)

@section('content')


    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">

        <div class="row">
            {{-- <div class="col-2"></div> --}}
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
                    <form method="POST" enctype="multipart/form-data"
                        action="{{ route('sahkan_permohonan_phd_ipjpsm', $user->id) }}">
                        @csrf

                        <div class="border card-body border-dark">

                            {{-- Flash Message --}}
                            @if ($message = Session::get('success'))
                                <div class="border alert alert-success border-success" style="text-align: center;">
                                    {{ $message }}</div>
                            @elseif ($message = Session::get('error'))
                                <div class="border alert alert-danger border-danger" style="text-align: center;">
                                    {{ $message }}</div>
                            @else
                                {{-- Hidden Gap - Just Ignore --}}
                                <div class="alert alert-white" style="text-align: center;"></div>
                                {{-- <div style="padding: 23px;"></div> --}}
                            @endif

                            <div class="row">
                                <label for="fname" class="text-right col-sm-3 control-label col-form-label">
                                    Nama Pengguna</label>
                                <div class="col-md-6">
                                    <input readonly type="text" class="form-control" name="tarikh_operasi"
                                        value="{{ $user->name }} " readonly>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label for="fname" class="text-right col-sm-3 control-label col-form-label">
                                    Negeri</label>
                                <div class="col-md-6">
                                    <input readonly type="text" class="form-control" name="tarikh_operasi"
                                        value="{{ $user->negeri }} " readonly>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label for="fname" class="text-right col-sm-3 control-label col-form-label">
                                    Daerah Hutan</label>
                                <div class="col-md-6">
                                    <input readonly type="text" class="form-control" name="tarikh_operasi"
                                        value="{{ $user->daerah }} " readonly>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label for="fname" class="text-right col-sm-3 control-label col-form-label">
                                    No. Kad Pengenalan</label>
                                <div class="col-md-6">
                                    <input readonly type="text" class="form-control" name="tarikh_operasi"
                                        value="{{ $user->login_id }} " readonly>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label for="fname" class="text-right col-sm-3 control-label col-form-label">
                                    Jawatan</label>
                                <div class="col-md-6">
                                    <input readonly type="text" class="form-control" name="tarikh_operasi"
                                        value="{{ $user->jawatan }} " readonly>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label for="fname" class="text-right col-sm-3 control-label col-form-label">
                                    Emel Pengguna</label>
                                <div class="col-md-6">
                                    <input readonly type="text" class="form-control" name="tarikh_operasi"
                                        value="{{ $user->email }} " readonly>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="row" style="padding-top: 15px;">
                                <div class="col-md-2"></div>
                                <div class="col-md" style="text-align: center;">
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#confirmation">Sahkan</button>
                                </div>
                                <div class="col-md-2"></div>
                            </div>

                            {{-- Hidden Gap - Just Ignore --}}
                            <div class="alert alert-white" style="text-align: center;"></div>
                            {{-- <div style="padding: 25px;"></div> --}}
                        </div>

                        <!-- Modal Confirmation -->
                        <div class="modal fade" id="confirmation" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                            mengesahkan pengguna ini?</b></span>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">SAHKAN</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
