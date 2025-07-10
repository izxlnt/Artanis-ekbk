
{{-- @extends(Auth()->user()->kategori_pekerja == 'BPE' ? 'layouts.layout-ipjpsm-nicepage' : (Auth()->user()->kategori_pekerja == 'BPM' ? 'layouts.layout-bpm-nicepage' : (Auth()->user()->kategori_pekerja == 'PHD' ? 'layouts.layout-phd-nicepage' : ''))) --}}

{{-- @extends(auth()->user()->kategori_pengguna == 'PHD' ? 'layouts.layout-phd-nicepage' : (auth()->user()->kategori_pengguna == 'BPM' ? 'layouts.layout-bpm-nicepage' : (auth()->user()->kategori_pengguna == 'BPE' ? 'layouts.layout-ipjpsm-nicepage' : ''))) --}}

@extends($layout)

@section('content')
<div>

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
                                            <a href="{{ $breadcrumb['link'] }}" style="color: white !important;" onMouseOver="this.style.color='lightblue'" onMouseOut="this.style.color='white'"> {{ $breadcrumb['name'] }}
                                            </a>
                                        </li>
                                    @else
                                    <li class="breadcrumb-item active" aria-current="page" style="color: yellow !important;">
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


                    {{-- <div class="card-header"
                        style="text-align:center; background-color: #ee8dcd !important; font-size: 130%; font-weight: bold;">
                        BORANG 3A - Maklumat Kilang
                    </div> --}}

                    @if($forma->shuttle->shuttle_type == '3')
                    <div class="card-header"
                        style="text-align:center; background-color: #ee8dcd !important; font-size: 130%; font-weight: bold;">
                        BORANG 3A - MAKLUMAT KILANG PAPAN
                    </div>

                    @elseif($forma->shuttle->shuttle_type == '4')
                    <div class="card-header"
                        style="text-align:center; background-color: #ee8dcd !important; font-size: 130%; font-weight: bold;">
                        BORANG 4A - MAKLUMAT KILANG PAPAN LAPIS/VENIR
                    </div>

                    @else
                    <div class="card-header"
                        style="text-align:center; background-color: #ee8dcd !important; font-size: 130%; font-weight: bold;">
                        BORANG 5A - MAKLUMAT KILANG KAYU KUMAI
                    </div>
                    @endif



                    <div class="card-body">
                            <div class="">
                                <table class="table table-striped table-bordered" id="" style="width: 100%;">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                    <div class="card-body">
                                                        <h4 class="card-title" style="text-align: center">BAHAGIAN A </h4>
                                                            <hr>
                                                        <div class="form-group row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Tahun</label>
                                                            <div class="col-sm-8">
                                                                <input readonly type="text" class="form-control"
                                                                    name='tahun' onkeypress="return isNumberKey(event)" value="{{ $kilang_info->tahun }}" placeholder="Tahun"> </input>
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
                                                                    name='alamat_kilang_1' placeholder="Alamat Kilang"
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
                                                                    name='alamat_kilang_2' placeholder="Alamat Kilang"
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
                                                                        <input readonly type="text" class="form-control"
                                                                            name="alamat_kilang_poskod"
                                                                            value="{{ $kilang_info->alamat_kilang_poskod }}">
                                                                        @error('nama_kilang')
                                                                            <div class="alert alert-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            <label for="com1"
                                                                class="text-right col-sm-1 control-label col-form-label">Daerah Sivil</label>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <input readonly type="text" class="form-control"
                                                                            name="alamat_kilang_poskod"
                                                                            value="{{ $kilang_info->alamat_kilang_daerah }}">
                                                                        @error('nama_kilang')
                                                                            <div class="alert alert-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <hr>


                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Alamat
                                                                Surat Menyurat</label>
                                                            <div class="col-md-8 ">
                                                                <input type="text" class="form-control" readonly
                                                                    name='alamat_surat_menyurat_1'
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
                                                                    name='alamat_surat_menyurat_2' readonly
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
                                                                class="text-right col-sm-4 control-label col-form-label">Poskod</label>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="alamat_surat_menyurat_poskod" readonly
                                                                        id="alamat_surat_menyurat_poskod"
                                                                        onchange="ajax_poskod_surat_menyurat(this)"
                                                                        maxlength="5"
                                                                        onkeypress="return isNumberKey(event)" placeholder="Sila Masukkan Poskod"
                                                                        value="{{ $kilang_info->alamat_surat_menyurat_poskod}}">
                                                                    @error('alamat_surat_menyurat_poskod')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                    </div>
                                                                </div>
                                                                <label for="com1"
                                                                class="text-right col-sm-1 control-label col-form-label">Daerah Sivil</label>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                    <input class="form-control"
                                                                        id="alamat_surat_menyurat_daerah" readonly
                                                                        name='alamat_surat_menyurat_daerah' value="{{ $kilang_info->alamat_surat_menyurat_daerah }}"
                                                                        placeholder="alamat_surat_menyurat_daerah">
                                                                        </input>
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


                                                    </div>
                                                    <hr>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="card-title" style="text-align: center">BAHAGIAN B</h4>
                                    <div class="row">

                                        <div class="col-12">
                                            <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">No. Telefon</label>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" readonly
                                                                    name='no_telefon' placeholder="No.Telefon" onkeypress="return isNumberKey(event)"
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
                                                                class="text-right col-sm-3 control-label col-form-label">No. Faks</label>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" name='no_faks' onkeypress="return isNumberKey(event)" readonly
                                                                    placeholder="No.Faks" value="{{ $kilang_info->no_faks }}">
                                                                @error('no_faks')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div> <br>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Emel</label>
                                                            <div class="col-md-8">
                                                                <input type="email" class="form-control"
                                                                    name='email_kilang' placeholder="Emel" readonly
                                                                    value="{{ $kilang_info->email}}">
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
                                                                <input type="text" class="form-control" name='website' readonly
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
                                                                class="text-right col-sm-3 control-label col-form-label">No. Lesen</label>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" name='no_lesen' readonly
                                                                    placeholder="No. Lesen" value="{{ $kilang_info->no_lesen }}">
                                                                @error('no_lesen')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div><br>

                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Tarikh
                                                                Kilang Ditubuhkan</label>
                                                            <div class="col-md-8">
                                                                <input type="date" class="form-control" readonly
                                                                    name="tarikh_tubuh" value="{{ $kilang_info->tarikh_tubuh }}">
                                                                @error('tarikh_tubuh')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div><br>

                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Tarikh
                                                                Kilang Mula Beroperasi</label>
                                                            <div class="col-md-8">
                                                                <input  type="date" class="form-control" readonly
                                                                    name="tarikh_operasi" value="{{ $kilang_info->tarikh_operasi }}">
                                                                @error('tarikh_operasi')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div><br>

                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Taraf
                                                                Sah Syarikat</label>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" readonly
                                                                    name='taraf_syarikat_catatan' value="{{ $kilang_info->taraf_syarikat_catatan }}">

                                                                </input>
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
                                                                class="text-right col-sm-3 control-label col-form-label">Status
                                                                Hak Milik Syarikat</label>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" readonly
                                                                    name='status_hak_milik' value="{{ $kilang_info ->status_hak_milik}}">
                                                            </input>
                                                                @error('status_hak_milik')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div><br>

                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Status
                                                                Warganegara</label>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control" readonly
                                                                    name='status_warganegara' value="{{ $kilang_info->status_warganegara }}">

                                                            </input>
                                                                @error('status_warganegara')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div><br>

                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Nilai
                                                                Harta - harta Tetap (RM)</label>
                                                            <div class="col-md-8">
                                                                <input  type="text" class="form-control"
                                                                    name='nilai_harta' placeholder="Nilai Harta" readonly
                                                                    value="{{ number_format($kilang_info->nilai_harta,2) }}">
                                                                @error('nilai_harta')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div><br>
                                                        <form action="{{ route('update_status_form3A',$id) }}" method="post">
                                                            @csrf
                                                        <div class="form-group row">
                                                            <label for="com1"
                                                                class="text-right col-sm-4 control-label col-form-label required" >Latitude</label>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        @if($kilang_info->longtitude_x)
                                                                        <input  type="text" class="form-control" readonly
                                                                            name="longtitude_x" id="longtitude_x"
                                                                            value="{{ $kilang_info->longtitude_x }}">
                                                                        @else
                                                                        <input  type="text" class="form-control" readonly
                                                                            name="longtitude_x" id="longtitude_x"
                                                                            value="{{ old('longtitude_x') }}">
                                                                        @endif
                                                                        @error('longtitude_x')
                                                                            <div class="alert alert-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            <label for="com1"
                                                                class="text-right col-sm-1 control-label col-form-label required">Longitude</label>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        @if($kilang_info->langtitude_y)
                                                                        <input  type="text" class="form-control"
                                                                            name="langtitude_y" id="langtitude_y" readonly
                                                                            value="{{  $kilang_info->langtitude_y }}">
                                                                        @else
                                                                        <input  type="text" class="form-control" readonly
                                                                            name="langtitude_y" id="langtitude_y"
                                                                            value="{{ old('langtitude_y') }}">
                                                                        @endif
                                                                        @error('langtitude_y')
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
                                                            <p>Gambar Sijil SSM:</p>
                                                            <img src="{{ asset($image_path = str_replace('public', 'storage', $kilang_info->sijil_ssm)) }}" alt="Sila Muatnaik Gambar Sijil SSM" id="category-img-ssm" style="width:100%;height:30vh;">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p>Gambar Lesen Kilang:</p>
                                                            <img src="{{ asset($image_path = str_replace('public', 'storage', $kilang_info->lesen_kilang)) }}" alt="Sila Muatnaik Gambar Lesen Kilang" id="category-img-tag-lesenkilang" style="width:100%;height:30vh;">
                                                        </div>
                                                    </div>

                                                    <br>

                                            <br>
                                            </div>
                                        </div>
                                    </div>
                                </table>
                            </div>
                    </div>









                </div>



<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->


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
    $('#longtitude_x').keypress(function (e) {
var txt = String.fromCharCode(e.which);
if (!txt.match(/[A-Za-z0-9&. ]/)) {
    return false;
}
});

</script>

<script>
    $('#langtitude_y').keypress(function (e) {
var txt = String.fromCharCode(e.which);
if (!txt.match(/[A-Za-z0-9&. ]/)) {
    return false;
}
});

</script>

<style >

    table, th, td {
      border: 1px solid black;
    }
    </style>

@endsection

