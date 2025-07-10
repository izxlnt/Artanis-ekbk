{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-0 form-group row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn-outline-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

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
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
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
        <divwhats class="auth-wrapper d-flex no-block justify-content-center align-items-center"
            style="background:url({{ asset('/bghutan.png') }});background-size:cover;">
            {{-- <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-6">
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

            </div> --}}

            <div class="row" style="width: 500px;">
                <div class="col-md-12" style="width: 100%">
                    {{-- <div class="card">
                        <div class="card-header" style="background-color:#f3ce8f">
                            <b>Tetapan Semula Kata Laluan</b>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('forget-password.submit') }}">
                            {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md">
                                        <div class="mb-3 input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-envelope"></i></span>
                                            </div>
                                            <input id="email" type="text"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus
                                                placeholder="Emel Berdaftar">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md">
                                        <button class="btn btn-block btn-lg btn-info" type="submit">Hantar Emel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> --}}
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #f3ce8f;">
                            <h3 style="font-weight: 600;">PENDAFTARAN PENGGUNA</h3>
                        </div>
                        <div class="card-body text-center" style="background: #d0edfdcc;">
                            <div class="row pb-3" style="padding-top: 20px;">
                                <div class="col-md">
                                    <style>
                                        .btn-outline-primary:hover,
                                        .btn-outline-primary:focus,
                                        .btn-outline-primary:active,
                                        .btn-outline-primary.active,
                                        .open>.dropdown-toggle.btn-outline-primary {
                                            color: #fff !important;
                                            background-color: #ec920a !important;
                                            /*set the color you want here*/
                                        }
                                    </style>
                                    <a href="{{ route('register') }}" class="btn-outline-primary btn-lg btn-block"
                                        style="border: solid 1px #ec920a; color: #ec920a;">Industri Berasas Kayu
                                        (IBK)</a>
                                </div>
                            </div>

                            <div class="row pb-3">
                                <div class="col-md">
                                    <a href="{{ route('daftar.phd') }}" class="btn-outline-info btn-lg btn-block"
                                        style="border: solid 1px #137eff;">Pejabat Hutan Daerah (PHD)</a>
                                </div>
                            </div>

                            <div class="row pb-3">
                                <div class="col-md">
                                    <a href="{{ route('daftar.jpn') }}" class="btn-outline-success btn-lg btn-block"
                                        style="border: solid 1px #5ac146;">Jabatan Perhutanan Negeri (JPN)</a>
                                </div>
                            </div>

                            <div class="row" style="padding-top: 25px;">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <a href="{{ route('login') }}" class="btn-primary btn-lg"
                                        >Kembali</a>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                        </div>
                    </div>
                    {{-- <a href="{{ route('daftar.phd') }}" class="text-dark">
                        <div class="rounded card card-hover">
                            <div class="text-center box bg-info">
                                <h3>Pejabat Hutan Daerah (PHD)</h3>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('daftar.jpn') }}" class="text-dark">
                        <div class="rounded card card-hover">
                            <div class="text-center box bg-info">
                                <h3>Jabatan Perhutanan Negeri (JPN)</h3>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('login') }}" class="text-dark" style="padding: 25px;">
                        <div class="card card-hover">
                            <div class="text-center box bg-info">
                                <h3><i class="fas fa-arrow-left"></i>&nbspKembali</h3>
                            </div>
                        </div>
                    </a> --}}
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
</body>

</html>
