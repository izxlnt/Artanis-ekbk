<div>

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">
                <div class="rounded-lg card" style="border-color: #000000 !important;">
                    <div class="card-header"
                        style="text-align:center; background-color: #c5d6eb !important; font-size: 130%; font-weight: bold; ">
                        BORANG 3A - MAKLUMAT KILANG PAPAN
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="storeA">
                            @csrf
                            <div class="">
                                <table class="table table-striped table-bordered" id="" style="width: 100%;">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">

                                                <form class="form-horizontal">
                                                    <div class="card-body">
                                                        <h4 class="card-title" style="text-align: center">Maklumat
                                                            Kilang Bahagian A </h4>
                                                            <hr>
                                                        <div class="form-group row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Tahun</label>
                                                            <div class="col-sm-8">
                                                                <span type="text" class="form-control"
                                                                    wire:model='tahun' placeholder="Tahun"> 2021 </span>
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
                                                                class="text-right col-sm-1 control-label col-form-label">Daerah</label>
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
                                                                <input readonly type="text" class="form-control"
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
                                                                <input readonly type="text" class="form-control"
                                                                    name='alamat_surat_menyurat_2'
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
                                                                        <input readonly type="text" class="form-control"
                                                                            name="alamat_kilang_poskod"
                                                                            value="{{ $kilang_info->alamat_surat_menyurat_poskod }}">
                                                                        @error('nama_kilang')
                                                                            <div class="alert alert-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            <label for="com1"
                                                                class="text-right col-sm-1 control-label col-form-label">Daerah</label>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <input readonly type="text" class="form-control"
                                                                            name="alamat_kilang_poskod"
                                                                            value="{{ $kilang_info->alamat_surat_menyurat_daerah }}">
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
                                                                class="text-right col-sm-3 control-label col-form-label">No. Pendaftaran Syarikat (SSM)</label>
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

                                                        <div class="form-group row">
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
                                                        </div>
                                                    </div>
                                                    <hr>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="card-title" style="text-align: center">Maklumat
                                        Kilang Bahagian B </h4>
                                    <div class="row">

                                        <div class="col-12">
                                            <div class="card">

                                                <form class="form-horizontal">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">No. Telefon</label>
                                                            <div class="col-md-8">
                                                                <input readonly type="text" class="form-control"
                                                                    name='no_telefon' placeholder="No.Telefon"
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
                                                                <input readonly type="text" class="form-control" name='no_faks'
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
                                                                <input readonly type="email" class="form-control"
                                                                    name='email_kilang' placeholder="Emel"
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
                                                                <input readonly type="text" class="form-control" name='website'
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
                                                                <input readonly type="text" class="form-control" name='no_lesen'
                                                                    placeholder="No.Lesen" value="{{ $kilang_info->no_lesen }}">
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
                                                                <input readonly type="date" class="form-control"
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
                                                                <input readonly type="date" class="form-control"
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
                                                                class="text-right col-sm-3 control-label col-form-label">Taraf Sah
                                                                Syarikat</label>
                                                            <div class="col-md-8">
                                                                <input readonly type="text" class="form-control"
                                                                    name="tarikh_operasi"
                                                                    value="{{ $kilang_info->taraf_syarikat_catatan }}">

                                                            </div>
                                                        </div><br>

                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Status Hak
                                                                Milik Syarikat</label>
                                                            <div class="col-md-8">
                                                                <input readonly type="text" class="form-control"
                                                                    name="status_hak_milik"
                                                                    value="{{ $kilang_info->status_hak_milik }}">

                                                            </div>
                                                        </div><br>

                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Status
                                                                Warganegara</label>
                                                            <div class="col-md-8">
                                                                <input readonly type="text" class="form-control"
                                                                    name="status_warganegara"
                                                                    value="{{ $kilang_info->status_warganegara }}">
                                                            </div>
                                                        </div><br>

                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Nilai
                                                                Harta - harta Tetap (RM)</label>
                                                            <div class="col-md-8">
                                                                <input readonly type="text" class="form-control"
                                                                    name='nilai_harta' placeholder="Nilai
                                                                    Harta - harta Tetap"
                                                                    value="{{ $kilang_info->nilai_harta }}">
                                                                @error('nilai_harta')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div><br>

                                                        <div class="row" style="justify-content: center">
                                                            <div class="col-md-3">
                                                                <label for="wphoneNumber2">Sijil SSM</label>
                                                                <div class="row el-element-overlay"
                                                                    style="justify-content: center">
                                                                    <div class="col-lg-6 col-md-8">
                                                                        <div class="card">
                                                                            <div class="el-card-item">
                                                                                <div class="el-card-avatar el-overlay-1">
                                                                                    @if(pathinfo(asset( $image_path =
                                                                                    str_replace('public', 'storage', $kilang_info
                                                                                    ->sijil_ssm)), PATHINFO_EXTENSION) == "pdf")

                                                                                    <div class="modal-body modal-dialog1">
                                                                                        <img id="" class="img-responsive"
                                                                                            src="{{ asset('/pdf.png') }}"
                                                                                            alt="Lesen Kilang"
                                                                                            class="imgthumbnail"></img>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="modal-body">
                                                                                        <img id="" class="img-responsive"
                                                                                            src="{{ asset($image_path = str_replace('public', 'storage', $kilang_info->sijil_ssm)) }}"
                                                                                            alt="Lesen Kilang"
                                                                                            class="imgthumbnail" width="300px"
                                                                                            height="300px"></img>
                                                                                    </div>
                                                                                    @endif

                                                                                    <div class="el-overlay">
                                                                                        <ul class="list-style-none el-info">
                                                                                            @if(pathinfo(asset( $image_path =
                                                                                            str_replace('public', 'storage', $kilang_info
                                                                                            ->sijil_ssm)), PATHINFO_EXTENSION) ==
                                                                                            "pdf")

                                                                                            <li class="el-item"><a
                                                                                                    target="_blank"
                                                                                                    href="{{ asset($image_path = str_replace('public', 'storage', $kilang_info->sijil_ssm)) }}"><i
                                                                                                        class="icon-magnifier"></i></a>
                                                                                            </li>
                                                                                        @else
                                                                                            <li class="el-item"><a
                                                                                                    class="btn default btn-outline image-popup-vertical-fit el-link"
                                                                                                    href="{{ asset($image_path = str_replace('public', 'storage', $kilang_info->sijil_ssm)) }}"><i
                                                                                                        class="icon-magnifier"></i></a>
                                                                                            </li>
                                                                                            @endif
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="wphoneNumber2">Lesen Kilang</label>
                                                                <div class="row el-element-overlay"
                                                                    style="justify-content: center">
                                                                    <div class="col-lg-6 col-md-8">
                                                                        <div class="card">
                                                                            <div class="el-card-item">
                                                                                <div class="el-card-avatar el-overlay-1">
                                                                                    @if(pathinfo(asset( $image_path =
                                                                                    str_replace('public', 'storage', $kilang_info
                                                                                    ->lesen_kilang)), PATHINFO_EXTENSION) == "pdf")

                                                                                    <div class="modal-body modal-dialog1">
                                                                                        <img id="" class="img-responsive"
                                                                                            src="{{ asset('/pdf.png') }}"
                                                                                            alt="Lesen Kilang"
                                                                                            class="imgthumbnail"></img>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="modal-body">
                                                                                        <img id="" class="img-responsive"
                                                                                            src="{{ asset($image_path = str_replace('public', 'storage', $kilang_info->lesen_kilang)) }}"
                                                                                            alt="Lesen Kilang"
                                                                                            class="imgthumbnail" width="300px"
                                                                                            height="300px"></img>
                                                                                    </div>
                                                                                    @endif
                                                                                    {{-- <img src="{{asset( $image_path = str_replace('public', 'storage',  $kilang ->lesen_kilang))}}" alt="ic belakang" /> --}}
                                                                                    <div class="el-overlay">
                                                                                        <ul class="list-style-none el-info">

                                                                                            @if(pathinfo(asset( $image_path =
                                                                                            str_replace('public', 'storage', $kilang_info
                                                                                            ->lesen_kilang)), PATHINFO_EXTENSION) ==
                                                                                            "pdf")

                                                                                            <li class="el-item"><a
                                                                                                    target="_blank"
                                                                                                    href="{{ asset($image_path = str_replace('public', 'storage', $kilang_info->lesen_kilang)) }}"><i
                                                                                                        class="icon-magnifier"></i></a>
                                                                                            </li>
                                                                                        @else
                                                                                            <li class="el-item"><a
                                                                                                    class="btn default btn-outline image-popup-vertical-fit el-link"
                                                                                                    href="{{ asset($image_path = str_replace('public', 'storage', $kilang_info->lesen_kilang)) }}"><i
                                                                                                        class="icon-magnifier"></i></a>
                                                                                            </li>
                                                                                            @endif

                                                                                            {{-- <li class="el-item"><a
                                                                                                    class="btn default btn-outline el-link"
                                                                                                    href="javascript:void(0);"><i
                                                                                                        class="icon-link"></i></a>
                                                                                            </li> --}}
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <hr>
                                                    {{-- <div class="card-body">
                                                        <div class="text-right form-group m-b-0">
                                                            <button type="button"
                                                                class="btn btn-primary">Kembali</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </div> --}}
                                                </form>
                                            </div>
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

</div>
