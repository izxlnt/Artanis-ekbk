<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="target-densitydpi=device-dpi">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href={{ asset('logo.png') }}>
    <title>SISTEM eSHUTTLE</title>
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
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center"
            style="background:url({{ asset('/bglogin.png') }});background-size:cover;">
            <div class="row" style="justify-content: left;">
                {{-- <div class="col-md-1"></div> --}}
                <div class="col-md-8">
                    <div class="border card-header" style="background-color:#f3ce8f">
                        <h3 class="text-white m-b-0" style="text-align: center"><b>Pengumuman</b></h3>
                    </div>
                    <div class="container" style="opacity: 0.7;background: linear-gradient(135deg, #ffffff 0%, #ffffff 100%); height: 650px;">
                        <div class="card-body">
                            <h3 class="card-title">Nota Arahan:</h3>
                            <p class="card-text" style="text-align: justify;"><br>
                                a. Ibu Pejabat Jabatan Perhutanan Semenanjung Malaysia (IPJPSM) bertanggungjawab untuk
                                mengumpul, memproses dan menganalisa data bagi Industri Berasas Kayu (IBK) melibatkan
                                Kilang Papan, Kilang Papan Lapis/Venir dan Kilang Kayu Kumai dibawah Penyata Shuttle 3,
                                4 dan 5.<br>

                                <br> b. Maklumat yang dikumpul adalah mengikut peruntukan yang tertakluk kepada Seksyen
                                7, Enakmen Industri Berasas Kayu (EIBK) dan Kaedah 13, Kaedah-Kaedah Industri Berasas
                                Kayu (KKIBK) 1989 dimana telah menggariskan kewajipan IBK untuk melaporkan data-data
                                yang telah dinyatakan di dalam EIBK dan KKIBK tersebut.<br>

                                <br> c. Tuan/Puan diminta melaporkan data-data dengan lengkap yang berkaitan dengan
                                pertubuhan tuan/puan seperti pada borang penyata shuttle ini dan menghantar ke Jabatan
                                ini.<br>

                                <br> d. Sila baca dan rujuk "PANDUAN MENGISI BORANG" sebagai panduan tuan/puan
                                melengkapkan penyata shuttle ini.<br>

                                <br> e. Kerjasama tuan/puan dalam menjayakan penyata shuttle ini amatlah dihargai.<br>

                                <br> Terima kasih.<br><br>
                                <b>Ketua Pengarah Perhutanan Semenanjung Malaysia</b>
                            </p>
                            <span>  <b>Jabatan Perhutanan Semenanjung Malaysia</b></span>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-2"> --}}
                <div class="auth-box on-sidebar"
                    style="padding-top:10% ;background-image: linear-gradient(to right top, #f3ce8f, #f5d296, #f7d79d, #f9dba5, #fbdfac, #fce2b2, #fde6b7, #fee9bd, #feecc3, #feefc8, #fff1ce, #fff4d4);">
                    <div id="loginform">
                        <div class="logo">
                            <span class="db"><img src="{{ asset('/jata.png') }}" style="width:30%"
                                alt="logo" /></span>
                            <span class="db"><img src="{{ asset('/logo.png') }}" style="width:30%"
                                    alt="logo" /></span>
                            <h3 class="font-medium m-b-20">Log Masuk</h3>

                            <h6 class=""><b>ID Kilang (No. SSM) hanya untuk kegunaan Industri Berasas Kayu bagi tujuan pendaftaran pengguna kedua.<b></h6>
                        </div>
                        <!-- Form -->
                        <div class="row">
                            <div class="col-12">
                                <form method="POST" action="{{ route('login') }}" class="form-horizontal m-t-20">
                                    {{-- <form method="POST" action="{{ route('login') }}"> --}}

                                    @csrf
                                    <div class="mb-3 input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                    class="ti-user"></i></span>
                                        </div>
                                        <input id="login_id" type="text"
                                            class="form-control @error('login_id') is-invalid @enderror" name="login_id"
                                            value="{{ old('login_id') }}" required autocomplete="login_id"
                                            placeholder="No. SSM / No. KP">

                                            @error('login_id')
                                            <div class="alert alert-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        {{-- <input type="text" class="form-control form-control-lg" placeholder="ID KILANG (No.SSM)" name="email" aria-label="Username" aria-describedby="basic-addon1"> --}}
                                    </div>
                                    <div class="mb-3 input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon2"><i
                                                    class="ti-key"></i></span>
                                        </div>
                                        {{-- <input type="text" class="form-control form-control-lg" placeholder="KATA LALUAN" aria-label="Password" name="password" aria-describedby="basic-addon1"> --}}
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password" placeholder="Kata Laluan">

                                            @error('password')
                                            <div class="alert alert-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                {{-- <label class="custom-control-label" for="customCheck1">Remember me</label> --}}
                                                {{-- <a href="javascript:void(0)" id="to-recover" class="float-right text-dark"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center form-group">
                                        <div class="col-xs-12 p-b-20">
                                            <button class="btn btn-block btn-lg btn-info" type="submit">Log
                                                Masuk</button>
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                        <div class="text-center col-xs-12 col-sm-12 col-md-12 m-t-10">
                                            <div class="social">
                                                <a href="javascript:void(0)" class="btn btn-facebook" data-toggle="tooltip" title="" data-original-title="Login with Facebook"> <i aria-hidden="true" class="fab fa-facebook"></i> </a>
                                                <a href="javascript:void(0)" class="btn btn-googleplus" data-toggle="tooltip" title="" data-original-title="Login with Google"> <i aria-hidden="true" class="fab fa-google-plus"></i> </a>
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="form-group m-b-0 m-t-10"> --}}
                                    <div class="row">
                                        <div class="col-md">
                                            <div class="text-center ">
                                                <span>Tidak Mempunyai Akaun? &nbsp<a href="{{ route('daftar.pilih') }}"style="font-size:15px"><b>Daftar Disini</b></a></span>
                                            </div>


                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md">
                                            <div class="text-center ">
                                                <a href="{{ route('forget-password.show') }}"><b>Terlupa Kata
                                                        Laluan</b></a>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- </div> --}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- </div> --}}
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
</body>

</html>
