<!DOCTYPE html>
<html>

<head>
    <meta name="google" content="notranslate">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="target-densitydpi=device-dpi">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <title>SISTEM eSHUTTLE</title>

    {{-- <title>Nice admin Template - The Ultimate Multipurpose admin template</title> --}}
    <!-- This page CSS -->
    {{-- <link href="../../assets/libs/jquery-steps/jquery.steps.css" rel="stylesheet">
    <link href="../../assets/libs/jquery-steps/steps.css" rel="stylesheet"> --}}
    <link href="{{ asset('nice-admin/assets/libs/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
    <link href="{{ asset('nice-admin/assets/libs/jquery-steps/steps.css') }}" rel="stylesheet" />
    <!-- Custom CSS -->
    {{-- <link href="../../dist/css/style.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('nice-admin/dist/css/style.min.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css"
        rel="stylesheet" type="text/css" />
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <meta charset=utf-8 />

    <!--[if IE]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
    <style>
        article,
        aside,
        figure,
        footer,
        header,
        hgroup,
        menu,
        nav,
        section {
            display: block;
        }

    </style>
    <style>
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;

        }

        .captcha {
            /* margin:20px; */
            background-color: #f9f9f9;
            /* border:2px solid #d3d3d3; */
            border-radius: 5px;
            color: #4c4a4b;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @media screen and (max-width: 500px) {
            .captcha {
                flex-direction: column;
            }

            .text {
                margin: .5em !important;
                text-align: center;
            }

            .logo {
                align-self: center !important;
            }

            .spinner {
                margin: 2em .5em .5em .5em !important;
            }
        }

        .text {
            /* font-size:1.75em; */
            /* font-weight:500; */
            margin-right: 1em;
        }

        .spinner {
            position: relative;
            width: 2em;
            height: 2em;
            display: flex;
            margin: 2em 1em;
            align-items: center;
            justify-content: center;
        }

        input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            z-index: -1;
        }

        input[type="checkbox"]+.checkmark {
            display: inline-block;
            width: 2em;
            height: 2em;
            background-color: #fcfcfc;
            border: 2.5px solid #c3c3c3;
            border-radius: 3px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        input[type="checkbox"]+.checkmark span {
            content: '';
            position: relative;
            /*
        position:absolute;
        border-bottom:3px solid;
        border-right:3px solid;
        border-color:#029f56;*/
            margin-top: -3px;
            transform: rotate(45deg);
            width: .75em;
            height: 1.2em;
            opacity: 0;
        }

        input[type="checkbox"]+.checkmark>span:after {
            content: '';
            position: absolute;
            display: block;
            height: 3px;
            bottom: 0;
            left: 0;
            background-color: #029f56;
        }

        input[type="checkbox"]+.checkmark>span:before {
            content: '';
            position: absolute;
            display: block;
            width: 3px;
            bottom: 0;
            right: 0;
            background-color: #029f56;
        }

        input[type="checkbox"]:checked+.checkmark {
            animation: 2s spin forwards;
        }

        input[type="checkbox"]:checked+.checkmark>span {
            animation: 1s fadein 1.9s forwards;
        }

        input[type="checkbox"]:checked+.checkmark>span:after {
            animation: .3s bottomslide 2s forwards;
        }

        input[type="checkbox"]:checked+.checkmark>span:before {
            animation: .5s rightslide 2.2s forwards;
        }

        @keyframes fadein {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes bottomslide {
            0% {
                width: 0;
            }

            100% {
                width: 100%;
            }
        }

        @keyframes rightslide {
            0% {
                height: 0;
            }

            100% {
                height: 100%;
            }
        }

        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
            align-self: flex-end;
            margin: 0.5em 1em;
        }

        .logo img {
            height: 2em;
            width: 2em;
        }

        .logo p {
            color: #9d9ba7;
            margin: 0;
            /* font-size:1em; */
            /* font-weight:700; */
            margin: .4em 0 .2em 0;
        }

        .logo small {
            color: #9d9ba7;
            margin: 0;
            font-size: .8em;
        }

        @keyframes spin {
            10% {
                width: 0;
                height: 0;
                border-width: 6px;
            }

            30% {
                width: 0;
                height: 0;
                border-radius: 50%;
                border-width: 1em;
                transform: rotate(0deg);
                border-color: rgb(199, 218, 245);
            }

            50% {
                width: 2em;
                height: 2em;
                border-radius: 50%;
                border-width: 4px;
                border-color: rgb(199, 218, 245);
                border-right-color: rgb(89, 152, 239);
            }

            70% {
                border-width: 4px;
                border-color: rgb(199, 218, 245);
                border-right-color: rgb(89, 152, 239);
            }

            90% {
                border-width: 4px;
            }

            100% {
                width: 2em;
                height: 2em;
                border-radius: 50%;
                transform: rotate(720deg);
                border-color: transparent;
            }
        }

        ::selection {
            background-color: transparent;
            color: teal;
        }

        ::-moz-selection {
            background-color: transparent;
            color: teal;
        }

        .desg-name {
            color: red;
            font-weight: bold;
            font-size: 20px;
        }

        .required:after {
            content: " *";
            color: red;
        }

    </style>
</head>

<body>
    <div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <section>
        <div class="">
            <div class=" row justify-content-center">
                <div class="col-md-12 col-lg">
                    <div class="d-md-flex">
                        <div class="p-1 text-center text-wrap p-lg-5 d-flex align-items-center"
                            style="background-image: linear-gradient(to right top, #f3ce8f, #f5d296, #f7d79d, #f9dba5, #fbdfac, #fce2b2, #fde6b7, #fee9bd, #feecc3, #feefc8, #fff1ce, #fff4d4);">
                            <div class="text w-200">
                                <span class="db"><img src="{{ asset('/jata.png') }}" style="width:30%"
                                        alt="logo" /></span>
                                <span class="db"><img src="{{ asset('/logo.png') }}" style="width:30%"
                                        alt="logo" /></span>

                                <h3 class="text-center">SISTEM</h3>
                                <h1 class="text-center">eSHUTTLE</h1>
                                <br>
                            </div>
                        </div>

                        <div class="p-4 login-wrap p-lg-5" >
                            {{-- Flash Message --}}
                            @if ($message = Session::get('success'))
                                <div class="border alert alert-success border-success" style="text-align: center;">
                                    {{ $message }}</div>
                            @elseif ($message = Session::get('error'))
                                <div class="border alert alert-danger border-danger" style="text-align: center;">
                                    {{ $message }}</div>
                            @else

                            @endif

                            {{-- <div class="page-wrapper"> --}}
                            <div class="container-fluid">
                                <div class="row">
                                    {{-- <div class="col-md">
                                        <h2 class="text-center">Pendaftaran Pengguna Kilang</h2>
                                    </div> --}}
                                </div>
                                <div class="row">

                                    <!-- ============================================================== -->
                                    <!-- Example -->
                                    <!-- ============================================================== -->
                                    <div class="col-12">
                                        <div class="card" style="background: #d0edfdcc;">
                                            <div class="text-center card-header bg-info" style="font-weight: bold;"><h3><b>Pendaftaran Industri Berasas Kayu (IBK)</b><h3></div>
                                            <div class="card-body wizard-content" style="padding-top:0">
                                                {{-- <div class="col-md-12"> --}}
                                                    {{-- <h2 class="text-center">Pendaftaran Pengguna Kilang</h2> --}}
                                                {{-- </div> --}}
                                                {{-- <h4 class="card-title">Step wizard with validation</h4>
                                                    <h6 class="card-subtitle">You can us the validation like what we did
                                                    </h6> --}}
                                                <form action="{{ route('register') }}"
                                                    class="validation-wizard wizard-circle m-t-40" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <!-- Step 1 -->
                                                    <h6><b><h4>Maklumat Kilang<br>(Bahagian A)</h4></b></h6>
                                                    <section>
                                                        <h4 class="card-title" style="text-align: center">Maklumat
                                                            Kilang<br> (Bahagian A)</h4>
                                                            <div class="row">
                                                                <div class="col-md"></div>
                                                                <div class="col-md-6">
                                                                    <div class="legend" style="border:2px solid; text-align:center;">

                                                                       <b> Medan-medan bertanda<span style="color:red"> <b> * </b></span>adalah wajib diisi</b>


                                                                    </div>
                                                                </div>
                                                                <div class="col-md"></div>

                                                            </div>
                                                            <br>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label ">Tahun</label>
                                                            <div class="col-md-6">

                                                                <input readonly type="text" class="form-control required" title="Sila isikan butiran ini."
                                                                    name='tahun' placeholder="Tahun" maxlength="4"
                                                                    onkeypress="return isNumberKey(event)" value="{{ date("Y") }}">
                                                                @error('tahun')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required" >Negeri</label>
                                                            <div class="col-md-6">
                                                                <select class="form-control required" id="negeri_id" title="Sila isikan butiran ini."
                                                                    name="negeri_id" onchange="ajax_daerah(this)">
                                                                    <option disabled selected hidden> Sila Pilih
                                                                        Negeri
                                                                    </option>
                                                                    @foreach (App\Models\Daerah::select('negeri','id')->distinct()->orderBy('negeri')->get()->unique('negeri') as $data)
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->negeri }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('negeri_id')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">Daerah
                                                                Hutan</label>
                                                            <div class="col-md-6">
                                                                <select class="form-control required" id="daerah_id" title="Sila isikan butiran ini."
                                                                    name='daerah_id' placeholder="Daerah" onchange="ajax_poskod(this)">
                                                                    <option value="" selected hidden disabled>Sila Pilih
                                                                        Daerah</option>


                                                                </select>
                                                                @error('daerah_id')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required"
                                                                class="required">Pilihan
                                                                Kilang</label>
                                                            <div class="col-md-6">
                                                                <select type="text" class="form-control required" title="Sila isikan butiran ini."
                                                                    name='shuttle_type'>
                                                                    <option value="" selected hidden disabled
                                                                        value="{{ old('shuttle_type') }}"">Sila Pilih
                                                                    Kilang</option>
                                                                <option value=" 3"
                                                                        {{ old('shuttle_type') == '3' ? 'selected' : '' }}>
                                                                        Kilang Papan</option>
                                                                    <option value="4"
                                                                        {{ old('shuttle_type') == '4' ? 'selected' : '' }}>
                                                                        Kilang Papan Lapis/Venir</option>
                                                                    <option value="5"
                                                                        {{ old('shuttle_type') == '5' ? 'selected' : '' }}>
                                                                        Kilang Kayu Kumai</option>
                                                                </select>
                                                                @error('shuttle_type')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">Nama
                                                                Kilang</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control"
                                                                    name='nama_kilang' placeholder="Nama Kilang"
                                                                    value="{{ old('nama_kilang') }}" required title="Sila isikan butiran ini." >
                                                                @error('nama_kilang')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>



                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">Alamat
                                                                Kilang</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control"
                                                                    name='alamat_kilang_1' id="alamat_kilang_1" autocomplete="off"
                                                                    placeholder="Alamat Kilang 1"
                                                                    value="{{ old('alamat_kilang_1') }}" required title="Sila isikan butiran ini.">
                                                                @error('alamat_kilang_1')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label "></label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control"
                                                                    name='alamat_kilang_2' id="alamat_kilang_2" autocomplete="off"
                                                                    placeholder="Alamat Kilang 2"
                                                                    value="{{ old('alamat_kilang_2') }}" required title="Sila isikan butiran ini.">
                                                                @error('alamat_kilang_2')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div><br>
                                                        <div class="row">
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-3 ">
                                                                <div class="form-group">
                                                                    <label for="wphoneNumber2"
                                                                        class="required">Poskod</label>
                                                                    <input type="text" class="form-control"
                                                                        name="alamat_kilang_poskod"
                                                                        id="alamat_kilang_poskod" autocomplete="off"
                                                                         maxlength="5"
                                                                        onkeypress="return isNumberKey(event)"
                                                                        value="{{ old('alamat_kilang_poskod') }}"" required title="Sila isikan butiran ini."
                                                                        placeholder="Poskod">
                                                                    @error('nama_kilang')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="daerah" class="required">Daerah
                                                                        Sivil</label>
                                                                    <select class="form-control" required title="Sila isikan butiran ini."
                                                                        id="alamat_kilang_daerah"
                                                                        name='alamat_kilang_daerah'
                                                                        placeholder="alamat_kilang_daerah" >
                                                                        <option value="" selected hidden disabled>Sila
                                                                            Pilih Daerah Hutan Terlebih Dahulu</option>
                                                                    </select>
                                                                    @error('alamat_kilang_daerah')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>

                                                        <div class="row">
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-6">

                                                                <label class="">
                                                                    <div class="custom-control custom-checkbox mr-sm-2">
                                                                        <input onchange="alamat();"
                                                                            type="checkbox" class="custom-control-input"
                                                                            id="alamat_sama" name="alamat_sama" {{ old('alamat_sama') == 'on' ? 'checked' : '' }}>
                                                                        <label class="custom-control-label"
                                                                            for="alamat_sama">Alamat sama seperti di
                                                                            atas</label>
                                                                    </div>
                                                                </label>
                                                            </div>

                                                        </div>



                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">Alamat
                                                                Surat Menyurat</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" required title="Sila isikan butiran ini."
                                                                    name='alamat_surat_menyurat_1'
                                                                    id="alamat_surat_menyurat_1"
                                                                    placeholder="Alamat Surat Menyurat 1"autocomplete="off"
                                                                    value="{{ old('alamat_surat_menyurat_1') }}">
                                                                @error('alamat_surat_menyurat_1')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label "></label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" required title="Sila isikan butiran ini."
                                                                    name='alamat_surat_menyurat_2'
                                                                    id="alamat_surat_menyurat_2"
                                                                    placeholder="Alamat Surat Menyurat 2" autocomplete="off"
                                                                    value="{{ old('alamat_surat_menyurat_2') }}">
                                                                @error('alamat_surat_menyurat_2')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div><br>
                                                        <div class="row">
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="wphoneNumber2"
                                                                        class="required">Poskod</label>
                                                                    <input type="text" class="form-control" required title="Sila isikan butiran ini."
                                                                        name="alamat_surat_menyurat_poskod" autocomplete="off"
                                                                        id="alamat_surat_menyurat_poskod"
                                                                        maxlength="5"
                                                                        onkeypress="return isNumberKey(event)"
                                                                        value="{{ old('alamat_surat_menyurat_poskod') }}"
                                                                        onchange="ajax_poskod_surat_menyurat(this);"
                                                                        placeholder="Poskod">
                                                                    @error('alamat_surat_menyurat_poskod')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group" id="test1">
                                                                    <label for="wphoneNumber2"
                                                                        class="required">Daerah Sivil</label>
                                                                    <select class="form-control" id="alamat_surat_menyurat_daerah"
                                                                         required title="Sila isikan butiran ini."
                                                                        name='alamat_surat_menyurat_daerah'
                                                                        placeholder="alamat_surat_menyurat_daerah">
                                                                        <option value=""  selected hidden disabled>Sila
                                                                            Masukkan Poskod Terlebih Dahulu</option>
                                                                    </select>
                                                                    @error('alamat_surat_menyurat_daerah')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <script>
                                                            function alamat() {
                                                                var x = $("#alamat_sama").is(":checked");

                                                                if (x == true) {
                                                                    //Get
                                                                    var bla = $('#alamat_kilang_1').val();
                                                                    //Set
                                                                    $('#alamat_surat_menyurat_1').val(bla).attr("disabled", "disabled");
                                                                    $('#alamat_surat_menyurat_1').val("");
                                                                    //get
                                                                    var bla = $('#alamat_kilang_2').val();
                                                                    //Set
                                                                    $('#alamat_surat_menyurat_2').val(bla).attr("disabled", "disabled");
                                                                    $('#alamat_surat_menyurat_2').val("");

                                                                    //get
                                                                    var bla = $('#alamat_kilang_poskod').val();
                                                                    //Set
                                                                    $('#alamat_surat_menyurat_poskod').val(bla).attr("disabled", "disabled");
                                                                    $('#alamat_surat_menyurat_poskod').val("");

                                                                    //get

                                                                    var conceptName = $('#alamat_kilang_daerah').find(":selected").text();
                                                                    // console.log(conceptName)

                                                                    //Set
                                                                    // $("#alamat_surat_menyurat_daerah option[value='Gateway 2']").prop('selected', true);
                                                                    // var html = '<input id="stuff" type="input"  class="form-control" readOnly value='
                                                                    //             + conceptName +' />';
                                                                    $('#alamat_surat_menyurat_daerah').val(bla).attr("disabled", "disabled");
                                                                    $('#alamat_surat_menyurat_daerah').val("");

                                                                    // $("#alamat_surat_menyurat_daerah").remove();
                                                                    // $("#test1").append(html);

                                                                } else {
                                                                    // document.getElementById("#alamat_surat_menyurat_1").readOnly = false;

                                                                    $('#alamat_surat_menyurat_1').attr("disabled", false)
                                                                    $('#alamat_surat_menyurat_2').attr("disabled", false)
                                                                    $('#alamat_surat_menyurat_poskod').attr("disabled", false)
                                                                    $('#alamat_surat_menyurat_daerah').attr("disabled", false)

                                                                }
                                                                    var alamat_kilang_1 = document.getElementById("alamat_kilang_1"),
                                                                    alamat_surat_menyurat_1 = document.getElementById("alamat_surat_menyurat_1");
                                                                    alamat_surat_menyurat_1.value = alamat_kilang_1.value;

                                                                    var alamat_kilang_2 = document.getElementById("alamat_kilang_2"),
                                                                    alamat_surat_menyurat_2 = document.getElementById("alamat_surat_menyurat_2");
                                                                    alamat_surat_menyurat_2.value = alamat_kilang_2.value;

                                                                    var alamat_kilang_poskod = document.getElementById("alamat_kilang_poskod"),
                                                                    alamat_surat_menyurat_poskod = document.getElementById("alamat_surat_menyurat_poskod");
                                                                    alamat_surat_menyurat_poskod.setAttribute("value", alamat_kilang_poskod.value);
                                                                    alamat_surat_menyurat_poskod.value = alamat_kilang_poskod.value;

                                                                    var alamat_kilang_daerah = document.getElementById("alamat_kilang_daerah"),
                                                                    alamat_surat_menyurat_daerah = document.getElementById("alamat_surat_menyurat_daerah");
                                                                    alamat_surat_menyurat_daerah.value = alamat_kilang_daerah.value;
                                                            }
                                                        </script>
                                                        <hr>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">No.
                                                                Pendaftaran Syarikat (SSM)</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name='no_ssm' required title="Sila isikan butiran ini."
                                                                    placeholder="No. Pendaftaran Syarikat (SSM)"
                                                                    value="{{ old('no_ssm') }}" id="no_ssm">
                                                                @error('no_ssm')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        {{-- <div class="row">
                                                        <div class="col-md-3"></div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="wphoneNumber2" class="required">Latitude</label>
                                                                <input type="text" class="form-control"
                                                                    name="longtitude_x" id="Latitude"
                                                                    onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="wphoneNumber2" class="required">Longitude</label>
                                                                <input type="text" class="form-control"
                                                                    name="langtitude_y" id="Longitude"
                                                                    onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    </section>
                                                    <!-- Step 2 -->
                                                    <h6><b><h4>Maklumat Kilang<br>(Bahagian B)</h4></b></h6>
                                                    {{-- <h6><b><h4>Maklumat Kilang <br>(Bahagian B)</h4></b></h6> --}}
                                                    <section>
                                                        <h4 class="card-title" style="text-align: center">Maklumat
                                                            Kilang <br> (Bahagian B)</h4>
                                                            <div class="row">
                                                                <div class="col-md"></div>
                                                                <div class="col-md-6">
                                                                    <div class="legend" style="border:2px solid; text-align:center;">

                                                                       <b> Medan-medan bertanda<span style="color:red"> <b> * </b></span>adalah wajib diisi</b>


                                                                    </div>
                                                                </div>
                                                                <div class="col-md"></div>

                                                            </div> <br>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">No. Telefon</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" required title="Sila isikan butiran ini."
                                                                    name='no_telefon' placeholder="No. Telefon" maxlength="11"
                                                                    onkeypress="return isNumberKey(event)"
                                                                    value="{{ old('no_telefon') }}">
                                                                @error('no_telefon')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label ">No. Faks</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control"
                                                                    name='no_faks' placeholder="No. Faks" maxlength="11"
                                                                    onkeypress="return isNumberKey(event)"
                                                                    value="{{ old('no_faks') }}" maxlength="11">
                                                                @error('no_faks')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="fname"

                                                                class="text-right col-sm-3 control-label col-form-label required">Emel Kilang</label>

                                                            <div class="col-md-6">
                                                                <input type="email" class="form-control"
                                                                    name='email_kilang' placeholder="Emel Kilang"
                                                                    value="{{ old('email') }}">
                                                                @error('email_kilang')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Laman
                                                                Sesawang (Website)</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control"
                                                                    name='website'
                                                                    placeholder="Laman Sesawang (Website)"
                                                                    value="{{ old('website') }}">
                                                                @error('website')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">No. Lesen</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" required title="Sila isikan butiran ini."
                                                                    name='no_lesen' placeholder="No. Lesen"
                                                                    value="{{ old('no_lesen') }}">
                                                                @error('no_lesen')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">Tarikh
                                                                Kilang Ditubuhkan</label>
                                                            <div class="col-md-6">
                                                                <input type="date" class="form-control" required title="Sila isikan butiran ini."
                                                                    name="tarikh_tubuh" id="from" onchange="getDate()"
                                                                    value="{{ old('tarikh_tubuh') }}">
                                                                @error('tarikh_tubuh')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">Tarikh
                                                                Kilang Mula Beroperasi</label>
                                                            <div class="col-md-6">
                                                                <input type="date" class="form-control" required title="Sila isikan butiran ini."
                                                                    name="tarikh_operasi" id="to"
                                                                    value="{{ old('tarikh_operasi') }}">
                                                                @error('tarikh_operasi')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">Taraf
                                                                Sah Syarikat</label>
                                                            <div class="col-md-6">
                                                                <select type="text" class="form-control" required title="Sila isikan butiran ini."
                                                                    name='taraf_syarikat_catatan'>
                                                                    <option value="" selected disabled>Sila Pilih Taraf
                                                                        Sah
                                                                        Syarikat</option>
                                                                    @forelse(App\Models\TarafSyarikat::get() as $data )
                                                                        <option value="{{ $data->keterangan }}"
                                                                            {{ old('taraf_syarikat_catatan') == "$data->keterangan " ? 'selected' : '' }}>
                                                                            {{ $data->keterangan }}</option>
                                                                    @empty

                                                                    @endforelse
                                                                </select>
                                                                @error('taraf_syarikat_catatan')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">Status
                                                                Hak Milik Syarikat</label>
                                                            <div class="col-md-6">
                                                                <select type="text" class="form-control" required title="Sila isikan butiran ini." onchange="ajax_warganegara(this)"
                                                                    name='status_hak_milik'>
                                                                    <option value="" selected disabled>Sila Pilih Status
                                                                        Hak
                                                                        Milik Syarikat</option>
                                                                    @forelse(App\Models\HakMilik::get() as $data )
                                                                        <option value="{{ $data->id }}"
                                                                            {{ old('status_hak_milik') == "$data->id " ? 'selected' : '' }}>
                                                                            {{ $data->keterangan }}</option>
                                                                    @empty

                                                                    @endforelse
                                                                </select>
                                                                @error('status_hak_milik')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">Status
                                                                Warganegara</label>
                                                            <div class="col-md-6">
                                                                <select type="text" class="form-control" required title="Sila isikan butiran ini."
                                                                    name='status_warganegara' id="status_warganegara">
                                                                    <option value="" selected disabled>Sila Pilih Status
                                                                        Warganegara</option>
                                                                    {{-- @forelse(App\Models\Warganegara::get() as $data )
                                                                        <option value="{{ $data->keterangan }}">
                                                                            {{ $data->keterangan }}</option>
                                                                    @empty

                                                                    @endforelse --}}
                                                                </select>
                                                                @error('status_warganegara')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <script>
                                                            function ajax_warganegara(select) {
                                                                status_warganegara = select.value;
                                                                // console.log(negeri);

                                                                //clear jenis_data selection
                                                                $("#status_warganegara").empty();
                                                                //initialize selection
                                                                $("#status_warganegara").append('<option value="" selected disabled hidden>Sila Pilih Status Warganegara</option>');

                                                                $.ajax({
                                                                    type: "get",
                                                                    // url:"/permohonan/fetchSenaraiHargaIdByTahun/jenisDokumen/"+jenis_dokumen+"/jenisData/"+jenis_data+"/tahun/"+tahun+"/negeri/" + negeri + "/jenisKertas/" + jenis_kertas,
                                                                    url: "/register/ajax/fetch-warganegara/" + status_warganegara, //penting

                                                                    //url:"/JPSM/permohonan/fetchSenaraiHargaIdByTahun/jenisDokumen/"+jenis_dokumen+"/jenisData/"+jenis_data+"/tahun/"+tahun+"/negeri/" + negeri,
                                                                    success: function(respond) {
                                                                        //fetch data (id) from DB Senarai Harga
                                                                        //   var data = JSON.parse(respond);
                                                                        // console.log(respond);
                                                                        //loop for data
                                                                        var x = 0;

                                                                        respond.forEach(function() { //penting

                                                                            // console.log(respond[x]);
                                                                            $("#status_warganegara").append('<option value="' + respond[x].keterangan + '">' +
                                                                                respond[x]
                                                                                .keterangan + '</option>');
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

                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">Nilai
                                                                Harta - harta Tetap (RM)</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" required title="Sila isikan butiran ini."
                                                                    name='nilai_harta' placeholder="Nilai Harta - harta Tetap (RM)"
                                                                    value="{{ old('nilai_harta') }}" onkeypress="return isNumberKey(event)" oninput="validate(this)">
                                                                @error('nilai_harta')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <script>
                                                            var validate = function(e) {
                                                            var t = e.value;
                                                            e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
                                                            }

                                                        </script>
                                                        <div class="row">
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="wphoneNumber2"
                                                                        class="required">Muat Naik Sijil
                                                                        SSM</label>
                                                                    {{-- <input type="file" class="form-control"
                                                                    name="sijil_ssm"> --}}
                                                                    <label for="ssm" class="form-control">PILIH FAIL</label>
                                                                    <input type="file" id="ssm" name="sijil_ssm" accept="*" style="display: none" required title="Sila isikan butiran ini.">


                                                                    @error('sijil_ssm')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="wphoneNumber2"
                                                                        class="required">Muat Naik Lesen
                                                                        Kilang</label>

                                                                        <label for="lesenkilang" class="form-control">PILIH FAIL</label>
                                                                        <input type="file" id="lesenkilang" name="lesen_kilang" accept="*" style="display: none" required title="Sila isikan butiran ini.">
                                                                    {{-- <input type="file" class="form-control"
                                                                        name="lesen_kilang" id="lesenkilang"> --}}
                                                                    @error('lesen_kilang')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-3">
                                                                <p>Gambar Dimuat Naik:</p>
                                                                <img src="" alt="Sila Muatnaik Gambar Sijil SSM"
                                                                    id="category-img-ssm"
                                                                    style="width:100%;height:30vh;display: none;">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <p>Gambar Dimuat Naik:</p>
                                                                <img src="" alt="Sila Muatnaik Gambar Lesen Kilang"
                                                                    id="category-img-tag-lesenkilang"
                                                                    style="width:100%;height:30vh;display: none;">
                                                            </div>
                                                        </div>
                                                    </section>

                                                    <!-- Step 3 -->
                                                    <h6><b><h4>Pendaftaran<br> Pengguna Kilang</h4></b></h6>
                                                    {{-- <h6><b><h4>Pendaftaran Pengguna Kilang</h4><b></h6> --}}
                                                    <section>
                                                        <h4 class="card-title" style="text-align: center">
                                                            Pendaftaran <br>
                                                            Pengguna Kilang</h4>

                                                            <div class="row">
                                                                <div class="col-md"></div>
                                                                <div class="col-md-6">
                                                                    <div class="legend" style="border:2px solid; text-align:center;">

                                                                       <b> Medan-medan bertanda<span style="color:red"> <b> * </b></span>adalah wajib diisi</b>


                                                                    </div>
                                                                </div>
                                                                <div class="col-md"></div>

                                                            </div> <br>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">Nama
                                                                Pengguna</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name='name' required title="Sila isikan butiran ini."
                                                                    placeholder="Nama Pengguna"
                                                                    value="{{ old('name') }}">
                                                                @error('name')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">Jantina</label>
                                                            <div class="col-md-6">
                                                                <select type="text" class="form-control" required title="Sila isikan butiran ini."
                                                                    name='jantina'>
                                                                    <option value="" selected hidden disabled>Sila Pilih
                                                                        Jantina</option>
                                                                    <option value="Lelaki">Lelaki</option>
                                                                    <option value="Perempuan">Perempuan</option>
                                                                </select>
                                                                @error('jantina')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">Warganegara</label>
                                                            <div class="col-md-6">
                                                                <select type="text" class="form-control" required title="Sila isikan butiran ini."
                                                                    name='warganegara'>
                                                                    <option value="" selected hidden disabled>Sila Pilih
                                                                        Status Warganegara</option>
                                                                    @forelse(App\Models\Warganegara::get() as $data )
                                                                        <option value="{{ $data->keterangan }}">
                                                                            {{ $data->keterangan }}</option>
                                                                    @empty

                                                                    @endforelse
                                                                </select>
                                                                @error('warganegara')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">Kaum</label>
                                                            <div class="col-md-6">
                                                                <select type="text" class="form-control" required title="Sila isikan butiran ini." name='kaum'>
                                                                    <option value="" selected hidden disabled>Sila Pilih
                                                                        Kaum</option>
                                                                    <option value="Melayu">Melayu</option>
                                                                    <option value="Cina">Cina</option>
                                                                    <option value="India">India</option>
                                                                    <option value="Lain-lain">Lain-lain</option>
                                                                </select>
                                                                @error('kaum')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">Emel</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name='email' required title="Sila isikan butiran ini."
                                                                    placeholder="Emel" value="{{ old('email') }}">
                                                                @error('email')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">
                                                               No. Kad Pengenalan
                                                            </label>

                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" required title="Sila isikan butiran ini."
                                                                    name='no_kad_pengenalan'
                                                                    placeholder="No. Kad Pengenalan" maxlength="12"
                                                                    onkeypress="return isNumberKey(event)"
                                                                    value="{{ old('no_kad_pengenalan') }}">
                                                                <p>
                                                                    <medium>* Sila masukkan nombor sahaja.</medium>
                                                                </p>
                                                                @error('no_kad_pengenalan')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="gambar_ic_hadapan"
                                                                        class="required">Muat Naik Gambar Hadapan<br>
                                                                        Kad
                                                                        Pengenalan</label>
                                                                        <label for="icfront" class="form-control">PILIH FAIL</label>
                                                                        <input type="file" id="icfront" name="gambar_ic_hadapan" accept="*" style="display: none" required title="Sila isikan butiran ini.">

                                                                    {{-- <input type="file" class="form-control"
                                                                        name="gambar_ic_hadapan" id="icfront"> --}}
                                                                    @error('gambar_ic_hadapan')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="gambar_ic_belakang"
                                                                        class="required">Muat Naik Gambar
                                                                        Belakang <br> Kad
                                                                        Pengenalan</label>

                                                                        <label for="icback" class="form-control">PILIH FAIL</label>
                                                                        <input type="file" id="icback" name="gambar_ic_belakang" accept="*" style="display: none" required title="Sila isikan butiran ini.">
                                                                    {{-- <input type="file" class="form-control"
                                                                        name="gambar_ic_belakang" id="icback"> --}}
                                                                    @error('gambar_ic_belakang')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="gambar_passport"
                                                                        class="required">Muat Naik Gambar<br>
                                                                        Berukuran Passport</label>

                                                                        <label for="passport" class="form-control">PILIH FAIL</label>
                                                                        <input type="file" id="passport" name="gambar_passport" accept="*" style="display: none" required title="Sila isikan butiran ini.">
                                                                    {{-- <input type="file" class="form-control"
                                                                        name="gambar_passport" id="passport"> --}}
                                                                    @error('gambar_passport')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-2">
                                                                <p>Gambar Dimuat Naik:</p>
                                                                <img src=""
                                                                    alt="Sila Muatnaik Gambar Hadapan Kad Pengenalan"
                                                                    id="category-img-tag-icfront"
                                                                    style="width:100%;height:30vh;display: none;">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <p>Gambar Dimuat Naik:</p>
                                                                <img src=""
                                                                    alt="Sila Muatnaik Gambar Belakang Kad Pengenalan"
                                                                    id="category-img-tag-icback"
                                                                    style="width:100%;height:30vh;display: none;">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <p>Gambar Dimuat Naik:</p>
                                                                <img src=""
                                                                    alt="Sila Muatnaik Gambar Berukuran Passport"
                                                                    id="category-img-tag-passport"
                                                                    style="width:100%;height:30vh;display: none;">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label required">Jawatan</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control"
                                                                    name='jawatan' placeholder="Jawatan" required title="Sila isikan butiran ini."
                                                                    value="{{ old('jawatan') }}">
                                                                @error('jawatan')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-3">
                                                                <label for="wphoneNumber2" class="">No.
                                                                    Pekerja</label>
                                                                <input type="text" class="form-control"
                                                                    name='no_pekerja' placeholder="No Pekerja"
                                                                    value="{{ old('no_pekerja') }}">
                                                                @error('no_pekerja')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="wphoneNumber2"
                                                                        class="">Muat Naik Gambar Kad
                                                                        Pekerja</label>

                                                                        <label for="kad_pekerja" class="form-control">PILIH FAIL</label>
                                                                        <input type="file" id="kad_pekerja" name="gambar_kad_pekerja" accept="*" style="display: none">

                                                                    {{-- <input type="file" class="form-control"
                                                                        name="gambar_kad_pekerja" id="kad_pekerja"> --}}
                                                                    @error('gambar_kad_pekerja')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-3">
                                                                <p>Gambar Dimuat Naik:</p>
                                                                <img src="" alt="Sila Muatnaik Gambar Kad Pekerja"
                                                                    id="category-img-tag-kad_pekerja"
                                                                    style="width:100%;height:30vh;display: none;">
                                                            </div>

                                                        </div>
                                                        {{-- <div class="row">
                                                        <label for="fname"
                                                            class="text-right col-sm-3 control-label col-form-label" class="required">Pilihan
                                                            Kilang</label>
                                                        <div class="col-md-6">
                                                            <select type="text" class="form-control"
                                                                name='shuttle_type'>
                                                                <option value="" selected hidden disabled>Sila Pilih
                                                                    Kilang</option>
                                                                <option value="3">Kilang Papan</option>
                                                                <option value="4">Kilang Papan Lapis/Venir</option>
                                                                <option value="5">Kilang Kayu Kumai</option>
                                                            </select>
                                                            @error('shuttle_type')
                                                                <div class="alert alert-danger">
                                                                    <strong>{{ $message }}</strong>
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div> --}}
                                                    </section>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    {{-- <div id="main-wrapper"> --}}
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->

    <!-- End Wrapper -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('nice-admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    {{-- <script src="../../assets/libs/jquery/dist/jquery.min.js"></script> --}}
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('nice-admin/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('nice-admin/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    {{-- <script src="../../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script> --}}
    <!-- apps -->
    <script src="{{ asset('nice-admin/dist/js/app.min.js') }}"></script>
    <script src="{{ asset('nice-admin/dist/js/app.init.horizontal.js') }}"></script>
    <script src="{{ asset('nice-admin/dist/js/app-style-switcher.horizontal.js') }}"></script>
    {{-- <script src="../../dist/js/app.min.js"></script>
    <script src="../../dist/js/app.init.horizontal.js"></script>
    <script src="../../dist/js/app-style-switcher.horizontal.js"></script> --}}
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('nice-admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('nice-admin/assets/extra-libs/sparkline/sparkline.js') }}"></script>

    {{-- <script src="../../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../../assets/extra-libs/sparkline/sparkline.js"></script> --}}
    <!--Wave Effects -->
    <script src="{{ asset('nice-admin/dist/js/waves.js') }}"></script>
    <script src="{{ asset('nice-admin/dist/js/sidebarmenu.js') }}"></script>

    {{-- <script src="../../dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../../dist/js/sidebarmenu.js"></script> --}}
    <!--Custom JavaScript -->
    <script src="{{ asset('nice-admin/dist/js/custom.js') }}"></script>
    <script src="{{ asset('nice-admin/assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('nice-admin/assets/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>

    {{-- <script src="../../dist/js/custom.js"></script>
    <script src="../../assets/libs/jquery-steps/build/jquery.steps.min.js"></script>
    <script src="../../assets/libs/jquery-validation/dist/jquery.validate.min.js"></script> --}}
    <script>
        var form = $(".validation-wizard").show();

        $(".validation-wizard").steps({
                headerTag: "h6",
                bodyTag: "section",
                transitionEffect: "fade",
                titleTemplate: '<span class="step">#index#</span> #title#',
                labels: {
                    finish: "HANTAR",
                    next: "Seterusnya",
                    previous: "Sebelumnya",
                },
                onStepChanging: function(event, currentIndex, newIndex) {
                    return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (
                        currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error")
                            .remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")),
                        form
                        .validate().settings.ignore = ":disabled,:hidden", form.valid())
                },
                onFinishing: function(event, currentIndex) {
                    return form.validate().settings.ignore = ":disabled", form.valid()
                },
                onFinished: function(event, currentIndex) {
                    // swal("Form Submitted!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.");
                    form.submit();
                }
            }),

            $(".validation-wizard").validate({
                ignore: "input[type=hidden]",
                errorClass: "text-danger",
                successClass: "text-success",
                highlight: function(element, errorClass) {
                    $(element).removeClass(errorClass)
                },
                unhighlight: function(element, errorClass) {
                    $(element).removeClass(errorClass)
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element)
                },
                rules: {
                    email: {
                        email: !0
                    }
                }
            })
    </script>

    <script>
        function ajax_daerah(select) {
            negeri = select.value;
            console.log(negeri);

            //clear jenis_data selection
            $("#daerah_id").empty();
            //initialize selection
            $("#daerah_id").append('<option value="" selected disabled hidden>Sila Pilih Daerah</option>');

            $.ajax({
                type: "get",
                url: "/register/ajax/fetch-daerah/" + negeri, //penting
                success: function(respond) {
                    Object.entries(respond).forEach(([key, val]) => {
                        $("#daerah_id").append('<option value="' + val.id + '">' +
                            val.daerah_hutan + '</option>');
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
        function ajax_poskod(select) {
            poskod = select.value;
            console.log(poskod);

            //clear jenis_data selection
            $("#alamat_kilang_daerah").empty();
            //initialize selection
            $("#alamat_kilang_daerah").append('<option value="" selected disabled hidden>Sila Pilih Daerah</option>');

            //clear jenis_data selection
            $("#alamat_surat_menyurat_daerah").empty();
            //initialize selection
            $("#alamat_surat_menyurat_daerah").append(
                '<option value="" selected disabled hidden>Sila Pilih Daerah</option>');

            $.ajax({
                type: "get",
                url: "/register/ajax/fetch-poskod/" + poskod, //penting

                //url:"/JPSM/permohonan/fetchSenaraiHargaIdByTahun/jenisDokumen/"+jenis_dokumen+"/jenisData/"+jenis_data+"/tahun/"+tahun+"/negeri/" + negeri,
                success: function(respond) {
                    //fetch data (id) from DB Senarai Harga
                    //   var data = JSON.parse(respond);
                    console.log(respond);
                    //loop for data

                    var counter = 0;

                    respond.forEach(function() { //penting

                        counter++;

                    });

                    console.log("Kira array : " + counter);

                    if (counter != 0) {
                        var x = 0;


                        respond.forEach(function() { //penting

                            // console.log(respond[x]);
                            $("#alamat_kilang_daerah").append('<option value="' + respond[x].daerah_sivil +
                                '">' +
                                respond[x].daerah_sivil + '</option>');

                            $("#alamat_surat_menyurat_daerah").append('<option value="' + respond[x].daerah_sivil +
                            '">' +
                            respond[x].daerah_sivil + '</option>');

                            // console.log(respond[x]);
                            // $("#alamat_surat_menyurat_daerah").append('<option value="' + respond[x]
                            //     .daerah_sivil +
                            //     '" {{ old('alamat_surat_menyurat_poskod') == "' + respond[x].daerah_sivil +'" ? 'selected' : '' }}>' +
                            //     respond[x].daerah_sivil + '</option>');
                            x++;

                        });
                    } else {
                        //clear jenis_data selection
                        $("#alamat_kilang_daerah").empty();
                        //initialize selection
                        $("#alamat_kilang_daerah").append(
                            '<option value="" selected disabled hidden>Sila Pilih Daerah Yang Betul</option>'
                        );

                        // //clear jenis_data selection
                        // $("#alamat_surat_menyurat_daerah").empty();
                        // //initialize selection
                        // $("#alamat_surat_menyurat_daerah").append(
                        //     '<option value="" selected disabled hidden>Sila Pilih Daerah Yang Betul</option>'
                        // );
                    }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("Status: " + textStatus);
                    console.log("Error: " + errorThrown);
                }
            });
        }
    </script>


    <script>
        function ajax_poskod_surat_menyurat(select) {
            poskod_surat = select.value;
            console.log(select);
            alert(select);

            //clear jenis_data selection
            $("#alamat_surat_menyurat_daerah").empty();
            //initialize selection
            $("#alamat_surat_menyurat_daerah").append(
                '<option value="" selected disabled hidden>Sila Pilih Daerah</option>');

            $.ajax({
                type: "get",
                url: "/register/ajax/fetch-poskod-surat-menyurat/" + poskod_surat, //penting

                //url:"/JPSM/permohonan/fetchSenaraiHargaIdByTahun/jenisDokumen/"+jenis_dokumen+"/jenisData/"+jenis_data+"/tahun/"+tahun+"/negeri/" + negeri,
                success: function(respond) {
                    //fetch data (id) from DB Senarai Harga
                    //   var data = JSON.parse(respond);
                    console.log(respond);
                    //loop for data

                    var counter = 0;
                    respond.forEach(function() { //penting

                        counter++;

                    });

                    // console.log("Kira array : " + counter);

                    if (counter != 0) {
                        var x = 0;


                        respond.forEach(function() { //penting

                            // console.log(respond[x]);
                            $("#alamat_surat_menyurat_daerah").append('<option value="' + respond[x]
                                .bandar +
                                '" {{ old('alamat_surat_menyurat_poskod') == "' + respond[x].bandar +'" ? 'selected' : '' }}>' +
                                respond[x].bandar + '</option>');
                            x++;

                        });
                    } else {
                        //clear jenis_data selection
                        $("#alamat_surat_menyurat_daerah").empty();
                        //initialize selection
                        $("#alamat_surat_menyurat_daerah").append(
                            '<option value="" selected disabled hidden>Sila Masukkan Poskod Yang Betul</option>'
                        );
                    }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("Status: " + textStatus);
                    console.log("Error: " + errorThrown);
                }
            });
        }
    </script>

    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode != 46 && (charCode < 48 || charCode > 57)))
                return false;
            return true;
        }
    </script>


    {{-- select address from the above --}}
    <script>
        function readonlyalamat() {
            // var checkedValue = $('#alamat_sama').val();
            var x = $("#alamat_sama").is(":checked");

            if (x == true) {

                //Get
                var bla = $('#alamat_kilang_1').val();
                //Set
                $('#alamat_surat_menyurat_1').val(bla).attr("disabled", "disabled");
                $('#alamat_surat_menyurat_1').val("");
                //get
                var bla = $('#alamat_kilang_2').val();
                //Set
                $('#alamat_surat_menyurat_2').val(bla).attr("disabled", "disabled");
                $('#alamat_surat_menyurat_2').val("");

                //get
                var bla = $('#alamat_kilang_poskod').val();
                //Set
                $('#alamat_surat_menyurat_poskod').val(bla).attr("disabled", "disabled");
                $('#alamat_surat_menyurat_poskod').val("");



                //get

                var conceptName = $('#alamat_kilang_daerah').find(":selected").text();
                // console.log(conceptName)

                //Set
                // $("#alamat_surat_menyurat_daerah option[value='Gateway 2']").prop('selected', true);
                // var html = '<input id="stuff" type="input"  class="form-control" readOnly value='
                //             + conceptName +' />';
                $('#alamat_surat_menyurat_daerah').val(bla).attr("disabled", "disabled");
                $('#alamat_surat_menyurat_daerah').val("");

                // $("#alamat_surat_menyurat_daerah").remove();
                // $("#test1").append(html);


            } else {
                // document.getElementById("#alamat_surat_menyurat_1").readOnly = false;
                $('#alamat_surat_menyurat_1').attr("disabled", false)
                $('#alamat_surat_menyurat_2').attr("disabled", false)
                $('#alamat_surat_menyurat_poskod').attr("disabled", false)
                $('#alamat_surat_menyurat_daerah').attr("disabled", false)



            }
        }
    </script>
    <script>
        var uploadField = document.getElementById("ssm");
        // console.log(uploadField);
        uploadField.onchange = function() {
        if(this.files[0].size >8388608){
            alert("Fail dimuatnaik terlalu besar! Sila muatnaik fail tidak melebihi 8mb");
            this.value = "";
            };
        };
    </script>
    <script>
        var uploadField = document.getElementById("lesenkilang");
        // console.log(uploadField);
        uploadField.onchange = function() {
        if(this.files[0].size >8388608){
            alert("Fail dimuatnaik terlalu besar! Sila muatnaik fail tidak melebihi 8mb");
            this.value = "";
            };
        };
    </script>
    <script>
        var uploadField = document.getElementById("icfront");
        // console.log(uploadField);
        uploadField.onchange = function() {
        if(this.files[0].size >8388608){
            alert("Fail dimuatnaik terlalu besar! Sila muatnaik fail tidak melebihi 8mb");
            this.value = "";
            };
        };
    </script>
    <script>
        var uploadField = document.getElementById("icback");
        // console.log(uploadField);
        uploadField.onchange = function() {
        if(this.files[0].size >8388608){
            alert("Fail dimuatnaik terlalu besar! Sila muatnaik fail tidak melebihi 8mb");
            this.value = "";
            };
        };
    </script>
    <script>
        var uploadField = document.getElementById("passport");
        // console.log(uploadField);
        uploadField.onchange = function() {
        if(this.files[0].size >8388608){
            alert("Fail dimuatnaik terlalu besar! Sila muatnaik fail tidak melebihi 8mb");
            this.value = "";
            };
        };
    </script>
    <script>
        var uploadField = document.getElementById("kad_pekerja");
        // console.log(uploadField);
        uploadField.onchange = function() {
        if(this.files[0].size >8388608){
            alert("Fail dimuatnaik terlalu besar! Sila muatnaik fail tidak melebihi 8mb");
            this.value = "";
            };
        };
    </script>

    {{-- show uploaded image --}}
    <script>
        $("#ssm").change(function() {
            // readURL(this);
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#category-img-ssm').attr('src', e.target.result);
                    $('#category-img-ssm').css("display", "block");
                }

                reader.readAsDataURL(this.files[0]);
            }


        });

        $("#lesenkilang").change(function() {
            // readURL(this);
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#category-img-tag-lesenkilang').attr('src', e.target.result);
                    $('#category-img-tag-lesenkilang').css("display", "block");


                }

                reader.readAsDataURL(this.files[0]);
            }


        });

        $("#icfront").change(function() {
            // readURL(this);
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#category-img-tag-icfront').attr('src', e.target.result);
                    $('#category-img-tag-icfront').css("display", "block");
                }

                reader.readAsDataURL(this.files[0]);
            }


        });

        $("#icback").change(function() {
            // readURL(this);
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#category-img-tag-icback').attr('src', e.target.result);
                    $('#category-img-tag-icback').css("display", "block");
                }

                reader.readAsDataURL(this.files[0]);
            }


        });

        $("#passport").change(function() {
            // readURL(this);
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#category-img-tag-passport').attr('src', e.target.result);
                    $('#category-img-tag-passport').css("display", "block");
                }

                reader.readAsDataURL(this.files[0]);
            }


        });

        $("#kad_pekerja").change(function() {
            // readURL(this);
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#category-img-tag-kad_pekerja').attr('src', e.target.result);
                    $('#category-img-tag-kad_pekerja').css("display", "block");
                }

                reader.readAsDataURL(this.files[0]);
            }


        });
    </script>

    <script>
        $('#no_ssm').keypress(function (e) {
    var txt = String.fromCharCode(e.which);
    if (!txt.match(/[A-Za-z0-9&. ]/)) {
        return false;
    }
});


    </script>
 <script>
     $("input#no_ssm").on({
  keydown: function(e) {
    if (e.which === 32)
      return false;
  },
  change: function() {
    this.value = this.value.replace(/\s/g, "");
  }
});
 </script>

<script type="text/javascript">
    function fun_AllowOnlyAmountAndDot(txt) {

        if (event.keyCode > 47 && event.keyCode < 58 || event.keyCode == 46) {
            var txtbx = document.getElementById(txt);
            var amount = document.getElementById(txt).value;
            var present = 0;
            var count = 0;



            if (amount.indexOf(".", present) || amount.indexOf(".", present + 1)); {
                // alert('0');
            }

            /*if(amount.length==2)
            {
              if(event.keyCode != 46)
              return false;
            }*/
            do {
                present = amount.indexOf(".", present);
                if (present != -1) {
                    count++;
                    present++;
                }
            }
            while (present != -1);
            if (present == -1 && amount.length == 0 && event.keyCode == 46) {
                event.keyCode = 0;
                //alert("Wrong position of decimal point not  allowed !!");
                return false;
            }

            if (count >= 1 && event.keyCode == 46) {

                event.keyCode = 0;
                //alert("Only one decimal point is allowed !!");
                return false;
            }
            if (count == 1) {
                var lastdigits = amount.substring(amount.indexOf(".") + 1, amount.length);
                if (lastdigits.length >= 2) {
                    //alert("Two decimal places only allowed");
                    event.keyCode = 0;
                    return false;
                }
            }
            return true;
        } else {
            event.keyCode = 0;
            //alert("Only Numbers with dot allowed !!");
            return false;
        }

    }
</script>

<script>
    function getDate() {

    var date = document.getElementById("from").value;
    // console.log(date);

    document.getElementById("to").setAttribute("min", date);
    }
</script>
<script>
$( document ).ready(function() {
    $('input').attr('autocomplete','off');
});
</script>





</body>
</div>

</html>
