@extends('layouts.layout-ibk-nicepage')

@section('content')
    <style>
        .required:after {
            content: " *";
            color: red;
        }
    </style>
    <div>
        <style>
            .required:after {
                content: " *";
                color: red;
            }
        </style>

        <div class="container-fluid">

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

                <div class="col-md-12">
                    <div class="rounded-lg card" style="border-color: #000000 !important;">
                        <div class="card-header"
                            style="text-align:center; background-color: #c5d6eb !important; font-size: 130%; font-weight: bold; ">
                            BORANG 5A - MAKLUMAT KILANG KAYU KUMAI
                        </div>
                        <div class="card-body">
                            <form action="{{ route('update.form5A', $kilang_info->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="">
                                    <table class="table table-striped table-bordered" id="" style="width: 100%;">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">

                                                    <form class="form-horizontal">
                                                        <div class="card-body">
                                                            <br>
                                                            <h4 class="card-title" style="text-align: center">Bahagian A
                                                            </h4>

                                                            <div class="form-group row">
                                                                <div class="col-sm-2"></div>
                                                                <div class="col-sm-8">

                                                                    <div class="legend"
                                                                        style="border:2px solid; text-align:center;">

                                                                        <b> Medan-medan bertanda<span style="color:red"> <b>
                                                                                    *
                                                                                </b></span>adalah wajib diisi</b>


                                                                    </div> <br>
                                                                </div>
                                                            </div>

                                                            <hr>
                                                            <div class="form-group row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label">Tahun</label>
                                                                <div class="col-sm-8">
                                                                    <input readonly type="text" class="form-control"
                                                                        name='tahun'
                                                                        onkeypress="return isNumberKey(event)"
                                                                        value="{{ $kilang_info->tahun }}"
                                                                        placeholder="Tahun"> </input>
                                                                    @error('tahun')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label">Negeri</label>
                                                                <div class="col-md-8">

                                                                    <input readonly type="text" class="form-control"
                                                                        name='negeri' placeholder="negeri"
                                                                        value="{{ $kilang_info->negeri_id }}">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label">Daerah
                                                                    Hutan</label>
                                                                <div class="col-md-8">
                                                                    <input readonly type="text" class="form-control"
                                                                        name='daerah' placeholder="Daerah"
                                                                        value="{{ $kilang_info->daerah_id }}">

                                                                    @error('daerah_id')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label">Nama
                                                                    Kilang</label>
                                                                <div class="col-md-8">
                                                                    <input readonly type="text" class="form-control"
                                                                        name='nama_kilang' placeholder="Nama Kilang"
                                                                        value="{{ $kilang_info->nama_kilang }}">
                                                                    @error('nama_kilang')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <br>

                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label">Alamat
                                                                    Kilang</label>
                                                                <div class="col-md-8">
                                                                    <input readonly type="text" class="form-control"
                                                                        id="alamat_kilang_1" name='alamat_kilang_1'
                                                                        placeholder="Alamat Kilang"
                                                                        value="{{ $kilang_info->alamat_kilang_1 }}">
                                                                    @error('alamat_kilang_1')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div> <br>

                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label"></label>
                                                                <div class="col-md-8">
                                                                    <input readonly type="text" class="form-control"
                                                                        id="alamat_kilang_2" name='alamat_kilang_2'
                                                                        placeholder="Alamat Kilang"
                                                                        value="{{ $kilang_info->alamat_kilang_2 }}">
                                                                    @error('alamat_kilang_2')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div><br>

                                                            <div class="form-group row">
                                                                <label for="com1"
                                                                    class="text-right col-sm-4 control-label col-form-label">Poskod</label>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <input readonly type="text"
                                                                            class="form-control"
                                                                            name="alamat_kilang_poskod"
                                                                            id="alamat_kilang_poskod"
                                                                            value="{{ $kilang_info->alamat_kilang_poskod }}">
                                                                        @error('alamat_kilang_poskod')
                                                                            <div class="alert alert-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <label for="com1"
                                                                    class="text-right col-sm-1 control-label col-form-label">Daerah
                                                                    Sivil</label>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <input readonly type="text"
                                                                            class="form-control"
                                                                            name="alamat_kilang_daerah"
                                                                            id="alamat_kilang_daerah"
                                                                            value="{{ $kilang_info->alamat_kilang_daerah }}">
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
                                                                        <div
                                                                            class="custom-control custom-checkbox mr-sm-2">
                                                                            <input onchange="alamat();" type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="alamat_sama" name="alamat_sama"
                                                                                {{ old('alamat_sama') == 'on' ? 'checked' : '' }}>
                                                                            <label class="custom-control-label"
                                                                                for="alamat_sama">Alamat sama seperti di
                                                                                atas</label>
                                                                        </div>
                                                                    </label>
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


                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label required">Alamat
                                                                    Surat Menyurat</label>
                                                                <div class="col-md-8 ">
                                                                    <input type="text" class="form-control"
                                                                        name='alamat_surat_menyurat_1'
                                                                        id="alamat_surat_menyurat_1"
                                                                        placeholder="Alamat Surat Menyurat"
                                                                        value="{{ $kilang_info->alamat_surat_menyurat_1 }}">
                                                                    @error('alamat_surat_menyurat_1')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div> <br>
                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label"></label>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control"
                                                                        name='alamat_surat_menyurat_2'
                                                                        id="alamat_surat_menyurat_2"
                                                                        placeholder="Alamat Surat Menyurat"
                                                                        value="{{ $kilang_info->alamat_surat_menyurat_2 }}">
                                                                    @error('alamat_surat_menyurat_2')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div><br>

                                                            <div class="form-group row">
                                                                <label for="com1"
                                                                    class="text-right col-sm-4 control-label col-form-label required">Poskod</label>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control"
                                                                            name="alamat_surat_menyurat_poskod"
                                                                            id="alamat_surat_menyurat_poskod"
                                                                            onchange="ajax_poskod_surat_menyurat(this)"
                                                                            maxlength="5"
                                                                            onkeypress="return isNumberKey(event)"
                                                                            placeholder="Sila Masukkan Poskod"
                                                                            value="{{ $kilang_info->alamat_surat_menyurat_poskod }}">
                                                                        @error('alamat_surat_menyurat_poskod')
                                                                            <div class="alert alert-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <label for="com1"
                                                                    class="text-right col-sm-1 control-label col-form-label required">Daerah
                                                                    Sivil</label>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <select class="form-control"
                                                                            id="alamat_surat_menyurat_daerah"
                                                                            name='alamat_surat_menyurat_daerah'
                                                                            placeholder="alamat_surat_menyurat_daerah">
                                                                            <option value="" selected hidden
                                                                                disabled>Sila
                                                                                Masukkan Poskod Terlebih Dahulu</option>

                                                                            <option
                                                                                value="{{ $kilang_info->alamat_surat_menyurat_daerah }}"
                                                                                selected>
                                                                                {{ $kilang_info->alamat_surat_menyurat_daerah }}
                                                                            </option>
                                                                        </select>
                                                                        @error('alamat_surat_menyurat_daerah')
                                                                            <div class="alert alert-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- <hr> --}}
                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label">No.
                                                                    Pendaftaran Syarikat (SSM)</label>
                                                                <div class="col-md-8">
                                                                    <input readonly type="text" class="form-control"
                                                                        name='no_ssm'
                                                                        placeholder="No. Pendaftaran Syarikat(SSM)"
                                                                        value="{{ $kilang_info->no_ssm }}">
                                                                    @error('no_ssm')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div> <br>

                                                            {{-- <div class="form-group row">
                                                            <label for="com1"
                                                                class="text-right col-sm-4 control-label col-form-label">Latitude</label>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <input readonly type="text" class="form-control"
                                                                            name="alamat_kilang_poskod"
                                                                            value="{{ $kilang_info->longtitude_x }}">
                                                                        @error('nama_kilang')
                                                                            <div class="alert alert-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            <label for="com1"
                                                                class="text-right col-sm-1 control-label col-form-label">Longitude</label>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <input readonly type="text" class="form-control"
                                                                            name="alamat_kilang_poskod"
                                                                            value="{{ $kilang_info->langtitude_y }}">
                                                                        @error('nama_kilang')
                                                                            <div class="alert alert-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                        </div> --}}
                                                        </div>
                                                        <hr>
                                                </div>
                                            </div>
                                        </div>

                                        <h4 class="card-title" style="text-align: center">Bahagian B </h4>

                                        <div class="row">

                                            <div class="col-12">
                                                <div class="card">

                                                    <form class="form-horizontal">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label required">No.
                                                                    Telefon</label>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control"
                                                                        name='no_telefon' placeholder="No.Telefon"
                                                                        onkeypress="return isNumberKey(event)"
                                                                        value="{{ $kilang_info->no_telefon }}">
                                                                    @error('no_telefon')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div> <br>
                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label">No.
                                                                    Faks</label>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control"
                                                                        name='no_faks'
                                                                        onkeypress="return isNumberKey(event)"
                                                                        placeholder="No. Faks"
                                                                        value="{{ $kilang_info->no_faks }}">
                                                                    @error('no_faks')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div> <br>
                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label required">Emel</label>
                                                                <div class="col-md-8">
                                                                    <input type="email" class="form-control"
                                                                        name='email_kilang' placeholder="Emel"
                                                                        value="{{ $kilang_info->email }}">
                                                                    @error('email_kilang')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div> <br>
                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label">Laman
                                                                    Sesawang (Website)</label>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control"
                                                                        name='website'
                                                                        placeholder="Laman Sesawang (Website)"
                                                                        value="{{ $kilang_info->website }}">
                                                                    @error('website')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div><br>
                                                            <hr>

                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label required">No.
                                                                    Lesen</label>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control"
                                                                        name='no_lesen' placeholder="No.Lesen"
                                                                        value="{{ $kilang_info->no_lesen }}">
                                                                    @error('no_lesen')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div><br>

                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label required">Tarikh
                                                                    Kilang Ditubuhkan</label>
                                                                <div class="col-md-8">
                                                                    <input type="date" class="form-control"
                                                                        name="tarikh_tubuh"
                                                                        value="{{ $kilang_info->tarikh_tubuh }}">
                                                                    @error('tarikh_tubuh')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div><br>

                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label required">Tarikh
                                                                    Kilang Mula Beroperasi</label>
                                                                <div class="col-md-8">
                                                                    <input type="date" class="form-control"
                                                                        name="tarikh_operasi"
                                                                        value="{{ $kilang_info->tarikh_operasi }}">
                                                                    @error('tarikh_operasi')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div><br>

                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label required">Taraf
                                                                    Sah Syarikat</label>
                                                                <div class="col-md-8">
                                                                    <select type="text" class="form-control"
                                                                        name='taraf_syarikat_catatan'>
                                                                        <option value="" selected disabled>Sila Pilih
                                                                            Taraf
                                                                            Sah
                                                                            Syarikat</option>
                                                                        @forelse(App\Models\TarafSyarikat::get() as $data)
                                                                            <option value="{{ $data->keterangan }}"
                                                                                {{ $kilang_info->taraf_syarikat_catatan == $data->keterangan ? 'selected' : '' }}>
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
                                                            <br>

                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label required">Status
                                                                    Hak Milik Syarikat</label>
                                                                <div class="col-md-8">
                                                                    <select type="text" class="form-control"
                                                                        onchange="ajax_warganegara(this)"
                                                                        name='status_hak_milik'>
                                                                        <option value="" selected disabled>Sila Pilih
                                                                            Status
                                                                            Hak
                                                                            Milik Syarikat</option>
                                                                        @forelse(App\Models\HakMilik::get() as $data)
                                                                            <option value="{{ $data->keterangan }}"
                                                                                {{ $kilang_info->status_hak_milik == $data->keterangan ? 'selected' : '' }}>
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
                                                            </div><br>

                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label required">Status
                                                                    Warganegara</label>
                                                                <div class="col-md-8">
                                                                    <select type="text" class="form-control"
                                                                        name='status_warganegara' id="status_warganegara">
                                                                        <option value="" selected disabled>Sila Pilih
                                                                            Status
                                                                            Warganegara</option>
                                                                        @forelse(App\Models\Warganegara::get() as $data)
                                                                            <option value="{{ $data->keterangan }}"
                                                                                {{ $kilang_info->status_warganegara == $data->keterangan ? 'selected' : '' }}>
                                                                                {{ $data->keterangan }}</option>
                                                                        @empty
                                                                        @endforelse
                                                                    </select>
                                                                    @error('status_warganegara')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div><br>

                                                            <div class="row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label required">Nilai
                                                                    Harta - harta Tetap (RM)</label>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control"
                                                                        name='nilai_harta' placeholder="Nilai Harta"
                                                                        onkeypress="return isNumberKey(event)"
                                                                        oninput="validate(this)"
                                                                        value="{{ $kilang_info->nilai_harta }}">
                                                                    @error('nilai_harta')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div><br>

                                                            <script>
                                                                var validate = function(e) {
                                                                    var t = e.value;
                                                                    e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
                                                                }
                                                            </script>

                                                            <script>
                                                                function ajax_warganegara(select) {
                                                                    status_warganegara = select.value;
                                                                    // console.log(negeri);

                                                                    //clear jenis_data selection
                                                                    $("#status_warganegara").empty();
                                                                    //initialize selection
                                                                    $("#status_warganegara").append(
                                                                        '<option value="" selected disabled hidden>Sila Pilih Status Warganegara</option>');

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
                                                                                $("#status_warganegara").append('<option value="' + respond[x].keterangan +
                                                                                    '">' +
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
                                                                <div class="col-md-3"></div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wphoneNumber2" class="required">Muat
                                                                            Naik Sijil
                                                                            SSM</label>
                                                                        {{-- <input type='file' class="form-control"
                                                                            name="sijil_ssm" id="ssm" /> --}}

                                                                        <label for="ssm" class="form-control">PILIH
                                                                            FAIL</label>
                                                                        <input type="file" id="ssm"
                                                                            name="sijil_ssm" accept="*"
                                                                            style="display: none">

                                                                        {{-- <img id="blah" /> --}}

                                                                        @error('sijil_ssm')
                                                                            <div class="alert alert-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group ">
                                                                        <label for="wphoneNumber2" class="required">Muat
                                                                            Naik Lesen
                                                                            Kilang</label>
                                                                        {{-- <input type="file" class="form-control"
                                                                            name="lesen_kilang" id="lesenkilang"> --}}

                                                                        <label for="lesenkilang"
                                                                            class="form-control">PILIH FAIL</label>
                                                                        <input type="file" id="lesenkilang"
                                                                            name="lesen_kilang" accept="*"
                                                                            style="display: none">
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
                                                                <div class="col-md-4">
                                                                    <p>Gambar Dimuat Naik:</p>
                                                                    <img src="{{ asset($image_path = str_replace('public', 'storage', $kilang_info->sijil_ssm)) }}"
                                                                        alt="Sila Muatnaik Gambar Sijil SSM"
                                                                        id="category-img-ssm"
                                                                        style="width:100%;height:30vh;">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <p>Gambar Dimuat Naik:</p>
                                                                    <img src="{{ asset($image_path = str_replace('public', 'storage', $kilang_info->lesen_kilang)) }}"
                                                                        alt="Sila Muatnaik Gambar Lesen Kilang"
                                                                        id="category-img-tag-lesenkilang"
                                                                        style="width:100%;height:30vh;">
                                                                </div>
                                                            </div>
                                                            <hr>


                                                            @if($ulasan)

                                                            <div class="row" style="text-align:center">
                                                                <div class="col-md-12">
                                                                    <label>Ulasan PHD</label><br>

                                                                    @if($ulasan->ulasan == NULL)

                                                                    <textarea name="ulasan_phd" cols="100%" rows="5" readonly disabled>Tiada Ulasan</textarea>
                                                                    @else
                                                                    <textarea name="ulasan_phd" cols="100%" rows="5" readonly disabled>{{ $ulasan->ulasan }}</textarea>

                                                                    @endif


                                                                </div>
                                                            </div>
                                                            @endif

                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-4"></div>
                                                                    <div class="col-md-4">

                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="text-right form-group m-b-0">
                                                                            <a href="{{ route('user.shuttle-5-senaraiA', date('Y')) }}"
                                                                                class="btn btn-primary">Kembali</a>

                                                                            <button type="button" class="btn btn-primary"
                                                                                data-toggle="modal"
                                                                                data-target="#confirmation_borang_a">HANTAR</button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="modal fade" id="confirmation_borang_a"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="confirmation_borang_aTitle"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered"
                                                                    role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-info">
                                                                            <h5 class="modal-title "
                                                                                id="exampleModalLongTitle"><i
                                                                                    style="color:rgb(255, 255, 0)"
                                                                                    class="fas fa-exclamation-triangle"></i>&nbspPENGESAHAN
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <span class="text-center"><b>Adakah anda pasti
                                                                                    ingin menghantar borang ini?</b></span>
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

                                                        </div>
                                                </div>
                                                {{-- <div class="row">
                                                        <div class="col-md-3"></div>
                                                        <div class="col-md-4">
                                                            <p>Gambar Dimuat Naik:</p>
                                                            <img src="{{ asset($image_path = str_replace('public', 'storage', $kilang_info->sijil_ssm)) }}" alt="Sila Muatnaik Gambar Sijil SSM" id="category-img-ssm" style="width:100%;height:30vh;">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p>Gambar Dimuat Naik:</p>
                                                            <img src="{{ asset($image_path = str_replace('public', 'storage', $kilang_info->lesen_kilang)) }}" alt="Sila Muatnaik Gambar Lesen Kilang" id="category-img-tag-lesenkilang" style="width:100%;height:30vh;">
                                                        </div>
                                                    </div>
                                                    <hr> --}}


                                                {{-- <div class="card-body">
                                                    <div class="text-right form-group m-b-0">
                                                        <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>

                                                        <button type="submit" class="btn btn-primary" >Simpan</button>
                                                    </div>

                                                </div> --}}
                                            </div>
                                        </div>
                                    </table>
                                </div>
                            </form>
                        </div>
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
        function ajax_poskod_surat_menyurat(select) {
            poskod_surat = select.value;
            // console.log(poskod_surat);

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

                            // console.log(respond[x]);value="{{ $kilang_info->alamat_surat_menyurat_daerah }}"
                            $("#alamat_surat_menyurat_daerah").append('<option value="' + respond[x]
                                .bandar +
                                '" {{ $kilang_info->alamat_surat_menyurat_daerah == "' + respond[x].bandar +'" ? 'selected' : '' }}>' +
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

        $("#ssm").change(function() {
            // readURL(this);
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#category-img-ssm').attr('src', e.target.result);
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

                }

                reader.readAsDataURL(this.files[0]);
            }


        });
    </script>

    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode != 46 && (charCode < 48 || charCode > 57)))
                return false;
            return true;
        }
    </script>

    <script>
        var uploadField = document.getElementById("ssm");
        // console.log(uploadField);
        uploadField.onchange = function() {
            if (this.files[0].size > 8388608) {
                alert("Fail dimuatnaik terlalu besar! Sila muatnaik fail tidak melebihi 8mb");
                this.value = "";
            };
        };
    </script>
    <script>
        var uploadField = document.getElementById("lesenkilang");
        // console.log(uploadField);
        uploadField.onchange = function() {
            if (this.files[0].size > 8388608) {
                alert("Fail dimuatnaik terlalu besar! Sila muatnaik fail tidak melebihi 8mb");
                this.value = "";
            };
        };
    </script>
    <script>
        var uploadField = document.getElementById("icfront");
        // console.log(uploadField);
        uploadField.onchange = function() {
            if (this.files[0].size > 8388608) {
                alert("Fail dimuatnaik terlalu besar! Sila muatnaik fail tidak melebihi 8mb");
                this.value = "";
            };
        };
    </script>
    <script>
        var uploadField = document.getElementById("icback");
        // console.log(uploadField);
        uploadField.onchange = function() {
            if (this.files[0].size > 8388608) {
                alert("Fail dimuatnaik terlalu besar! Sila muatnaik fail tidak melebihi 8mb");
                this.value = "";
            };
        };
    </script>
    <script>
        var uploadField = document.getElementById("passport");
        // console.log(uploadField);
        uploadField.onchange = function() {
            if (this.files[0].size > 8388608) {
                alert("Fail dimuatnaik terlalu besar! Sila muatnaik fail tidak melebihi 8mb");
                this.value = "";
            };
        };
    </script>
    <script>
        var uploadField = document.getElementById("kad_pekerja");
        // console.log(uploadField);
        uploadField.onchange = function() {
            if (this.files[0].size > 8388608) {
                alert("Fail dimuatnaik terlalu besar! Sila muatnaik fail tidak melebihi 8mb");
                this.value = "";
            };
        };
    </script>

    </div>


@endsection
