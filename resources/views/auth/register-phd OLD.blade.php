<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <title>Sistem e-KBK</title>
    <!-- Custom CSS -->
    <link href="{{ asset('nice-admin/dist/css/style.min.css') }}" rel="stylesheet">
    <!-- Toaster CSS -->
    <link href="{{ asset('nice-admin/assets/libs/toastr/build/toastr.min.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <style>
        .required:after {
            content: " *";
            color: red;
        }

    </style>
</head>

<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <divwhats class="auth-wrapper d-flex no-block justify-content-center align-items-center"
            style="background:url({{ asset('/bghutan.png') }});background-size:cover;">

            <div class="row" style="width: 1000px;">
                <div class="col-md-12">

                    <div class="card" style="background: #d0edfdcc;">
                        <div class="card-header text-center bg-info" style="font-weight: bold;">Pendaftaran Pejabat Hutan
                            Daerah (PHD)</div>
                        <div class="card-body">
                            <form action="{{ route('daftar.phd.create') }}">
                            @csrf

                                <input type="hidden" name="jenis_pengguna" value="PHD">
                                <div class="form-group row">
                                    <label for="cono1"
                                        class="text-right col-sm-3 control-label col-form-label required">Negeri</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="negeri_id" name="negeri_id"
                                            onchange="ajax_daerah(this)" required>
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
                                    <label for="fname"
                                        class="text-right col-sm-3 control-label col-form-label required">Daerah Hutan</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="daerah_id" name='daerah_id'
                                            placeholder="Daerah" required>
                                            <option value="" selected hidden disabled>Sila Pilih
                                                Daerah Hutan</option>


                                        </select>
                                        @error('daerah_id')
                                            <div class="alert alert-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label for="cono1"
                                        class="text-right col-sm-3 control-label col-form-label required">Nama Pengguna</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Nama" value="{{ old('name') }}" required>
                                    </div>
                                    @error('name')
                                        <div class="alert alert-danger">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label for="fname"
                                        class="text-right col-sm-3 control-label col-form-label required"> No. Kad
                                        Pengenalan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="kad_pengenalan"
                                            name='kad_pengenalan' placeholder="No. Kad Pengenalan" maxlength="12"
                                            minlength="12" onkeypress="return onlyNumberKey(event)" value="{{ old('kad_pengenalan') }}" required>
                                    </div>
                                    @error('kad_pengenalan')
                                        <div class="alert alert-danger">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="cono1"
                                        class="text-right col-sm-3 control-label col-form-label required">Jawatan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="jawatan" name='jawatan'
                                            placeholder="Jawatan" value="{{ old('jawatan') }}" required>
                                    </div>
                                    @error('jawatan')
                                        <div class="alert alert-danger">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>


                                <div class="form-group row">
                                    <label for="cono1"
                                        class="text-right col-sm-3 control-label col-form-label required">Emel</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="email" name='email'
                                            placeholder="Emel" value="{{ old('email') }}" required>
                                    </div>
                                    @error('email')
                                        <div class="alert alert-danger">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label for="cono1"
                                        class="text-right col-sm-3 control-label col-form-label required">No.
                                        Telefon</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="no_telefon" name='no_telefon'
                                            placeholder="No. Telefon" maxlength="11" minlength="10"
                                            onkeypress="return onlyNumberKey(event)" value="{{ old('no_telefon') }}" required>
                                    </div>
                                    @error('no_telefon')
                                        <div class="alert alert-danger">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <hr>



                                <br>
                                <div class="row" style="padding-top: 15px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <button class="btn btn-dark btn-block" type="button" data-toggle="modal" data-target="#confirmation_daftar_phd_modal">Daftar</button>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="confirmation_daftar_phd_modal" tabindex="-1" role="dialog"
                                    aria-labelledby="confirmation_daftar_phd_modalTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info">
                                                <h5 class="modal-title " id="exampleModalLongTitle"><i class="fas fa-exclamation-triangle"></i>&nbspPengesahan</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <span class="text-center">Anda pasti maklumat ini tepat?</span>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Kembali</button>
                                                <button type="submit" class="btn btn-success">Daftar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="form-group row">
                                    <label for="lname"
                                        class="text-right col-sm-3 control-label col-form-label">Peranan</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name='peranan'>
                                            <option disabled selected hidden value="">Pilih Peranan</option>
                                            <option>Pentadbir Modul</option>
                                            <option>Pengguna Biasa</option>
                                        </select>
                                    </div>
                                </div> --}}

                                {{-- <div class="form-group row">
                                    <label for="lname" class="text-right col-sm-3 control-label col-form-label">Kategori
                                        Pengguna</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name='kategori_pengguna'>
                                            <option disabled selected hidden value="">Pilih Kategori Pengguna</option>
                                            <option>BPM</option>
                                            <option>IPJPSM</option>
                                            <option>PHD</option>
                                            <option>JPN</option>
                                        </select>
                                    </div>
                                </div> --}}

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







                                {{-- <br>
                                <div class="form-group row">
                                    <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Bahagian
                                        (Sekiranya
                                        IPJPSM)</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name='bahagian'>
                                            <option disabled selected hidden value="">Pilih bahagian</option>
                                            <option>Bahagian Forest Eco-Park &amp; Hutan Taman Negeri</option>
                                            <option>Bahagian Hal Ehwal Antarabangsa</option>
                                            <option>Bahagian Kejuruteraan Hutan</option>
                                            <option>Bahagian Khidmat Pengurusan</option>
                                            <option>Bahagian Ladang Hutan &amp; Perlindungan Hutan</option>
                                            <option>Bahagian Latihan Perhutanan</option>
                                            <option>Bahagian Penguatkuasaan Hutan</option>
                                            <option>Bahagian Pengurusan Hutan</option>
                                            <option>Bahagian Pengurusan Maklumat</option>
                                            <option>Bahagian Perancangan &amp; Ekonomi Hutan</option>
                                            <option>Bahagian Perundangan dan Pendakwaan</option>
                                            <option>Bahagian Silvikultur &amp; Pemeliharaan Biologi Hutan</option>
                                            <option>Bahagian Teknikal dan Industri Kayu</option>
                                            <option>Jabatan Perhutanan Negeri</option>
                                            <option>Unit Integriti Perhutanan</option>
                                            <option>Unit Komunikasi Korporat &amp; Perhubungan Awam</option>
                                        </select>
                                    </div>
                                </div> --}}




                            </form>
                        </div>
                    </div>

                </div>
            </div>
    </div>
    <!-- ============================================================== -->
    <!-- Login box.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper scss in scafholding.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper scss in scafholding.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right Sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right Sidebar -->
    <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="{{ asset('nice-admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>

    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('nice-admin/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>


    <script src="{{ asset('nice-admin/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();
        // ==============================================================
        // Login and Recover Password
        // ==============================================================
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
    </script>

    {{-- toaster --}}
    <script src="{{ asset('nice-admin/assets/libs/toastr/build/toastr.min.js') }}"></script>
    <script src="{{ asset('nice-admin/assets/extra-libs/toastr/toastr-init.js') }}"></script>

    {{-- toaster display --}}
    <script>
        @if (Session::get('success'))
            toastr.success('{{ session('success') }}', 'Berjaya', { "progressBar": true });
        @elseif ($message = Session::get('error'))
            toastr.error('{{ session('error') }}', 'Ralat', { "progressBar": true });
        @endif
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
</body>

</html>
