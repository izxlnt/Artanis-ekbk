@extends('layouts.layout-ipjpsm-nicepage')


@section('content')


    {{-- @livewire('shuttle-three.shuttle3') --}}


    <div>

        <link href="{{ asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css') }}" rel="stylesheet" />


        <script src="{{ asset('https://code.jquery.com/jquery-3.5.1.js') }}"></script>
        <script src="{{ asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js') }}"></script>

        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            @if (session()->has('message'))
            <div class="row">
                <div class="col-md-12" style="padding-top: 1% ; text-align:center">

                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                </div>
            </div>
            @endif


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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body" style="width: 100%">
                            <ul class="nav nav-pills m-t-30 m-b-30">
                                @if ($kilang)
                                    <li class=" nav-item"> <a href="#navpills-1" class="nav-link active"
                                            data-toggle="tab" aria-expanded="false">Maklumat Kilang Bahagian A</a> </li>
                                    <li class="nav-item"> <a href="#navpills-2" class="nav-link"
                                            data-toggle="tab" aria-expanded="false">Maklumat Kilang Bahagian B</a> </li>
                                @elseif($users)
                                    <li class="nav-item"> <a href="#navpills-3" class="nav-link active"
                                            data-toggle="tab" aria-expanded="true">Maklumat Pengguna Kilang</a> </li>
                                @endif
                            </ul>
                            <div class="tab-content br-n pn">
                                <div id="navpills-1" class="tab-pane active">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <form wire:submit.prevent='store'>
                                                @if ($kilang)
                                                    <section>
                                                        <h4 class="card-title" style="text-align: center">Maklumat
                                                            Kilang Papan</h4>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Tahun</label>
                                                            <div class="col-md-6">
                                                                <input readonly type="text" class="form-control"
                                                                    name='tahun' placeholder="Tahun"
                                                                    value="{{ $kilang->tahun }}">
                                                                @error('tahun')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div> <br>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Negeri</label>
                                                            <div class="col-md-6">
                                                                <select disabled class="form-control" name='negeri_id'>
                                                                    <option disabled selected hidden value="">Pilih Negeri
                                                                    </option>
                                                                    @foreach (App\Models\Negeri::distinct()->get() as $data)

                                                                        @if ($data->negeri == 'JHR')
                                                                            <option value="{{ $data->id }}">Johor
                                                                            </option>
                                                                        @elseif($data->negeri == "KDH")
                                                                            <option value="{{ $data->id }}">Kedah
                                                                            </option>
                                                                        @elseif($data->negeri == "KTN")
                                                                            <option value="{{ $data->id }}">Kelantan
                                                                            </option>
                                                                        @elseif($data->negeri == "KUL")
                                                                            <option value="{{ $data->id }}">W.P Kuala
                                                                                Lumpur
                                                                            </option>
                                                                        @elseif($data->negeri == "KTN")
                                                                            <option value="{{ $data->id }}">W.P Labuan
                                                                            </option>
                                                                        @elseif($data->negeri == "MLK")
                                                                            <option value="{{ $data->id }}">Melaka
                                                                            </option>
                                                                        @elseif($data->negeri == "NSN")
                                                                            <option value="{{ $data->id }}">N.Sembilan
                                                                            </option>
                                                                        @elseif($data->negeri == "PHG")
                                                                            <option value="{{ $data->id }}">Pahang
                                                                            </option>
                                                                        @elseif($data->negeri == "PNG")
                                                                            <option value="{{ $data->id }}">P.Pinang
                                                                            </option>
                                                                        @elseif($data->negeri == "PRK")
                                                                            <option value="{{ $data->id }}">Perak
                                                                            </option>
                                                                        @elseif($data->negeri == "PJY")
                                                                            <option value="{{ $data->id }}">W.P
                                                                                Putrajaya
                                                                            </option>
                                                                        @elseif($data->negeri == "SBH")
                                                                            <option value="{{ $data->id }}">Sabah
                                                                            </option>
                                                                        @elseif($data->negeri == "SRW")
                                                                            <option value="{{ $data->id }}">Sarawak
                                                                            </option>
                                                                        @elseif($data->negeri == "SGR")
                                                                            <option value="{{ $data->id }}">Selangor
                                                                            </option>
                                                                        @elseif($data->negeri == "TRG")
                                                                            <option value="{{ $data->id }}">Terengganu
                                                                            </option>
                                                                        @elseif($data->negeri == "PLS")
                                                                            <option value="{{ $data->id }}">Perlis
                                                                            </option>
                                                                        @endif

                                                                    @endforeach
                                                                </select>
                                                                @error('negeri')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div> <br>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Daerah
                                                                Hutan</label>
                                                            <div class="col-md-6">
                                                                <select disabled class="form-control" name='daerah_id'
                                                                    placeholder="Daerah">
                                                                    <option value="" selected hidden disabled>Sila Pilih
                                                                        Daerah
                                                                    </option>
                                                                    @foreach (App\Models\Negeri::distinct()->get() as $data)
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->bandar }}</option>
                                                                    @endforeach

                                                                </select>
                                                                @error('daerah_id')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div> <br>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Nama
                                                                Kilang</label>
                                                            <div class="col-md-6">
                                                                <input readonly type="text" class="form-control"
                                                                    name='nama_kilang' placeholder="Nama Kilang"
                                                                    value="{{ $kilang->nama_kilang }}">
                                                                @error('nama_kilang')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div><br>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Alamat
                                                                Kilang</label>
                                                            <div class="col-md-6">
                                                                <input readonly type="text" class="form-control"
                                                                    name='alamat_kilang_1' placeholder="Alamat Kilang"
                                                                    value="{{ $kilang->alamat_kilang_1 }}">
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
                                                            <div class="col-md-6">
                                                                <input readonly type="text" class="form-control"
                                                                    name='alamat_kilang_2' placeholder="Alamat Kilang"
                                                                    value="{{ $kilang->alamat_kilang_2 }}">
                                                                @error('alamat_kilang_2')
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
                                                                    <label for="wphoneNumber2">Poskod</label>
                                                                    <input readonly type="text" class="form-control"
                                                                        name="alamat_kilang_poskod">
                                                                    @error('nama_kilang')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="wphoneNumber2">Daerah</label>
                                                                    <input readonly type="text" class="form-control"
                                                                        name="alamat_kilang_daerah">
                                                                    @error('alamat_kilang_daerah')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Alamat
                                                                Surat Menyurat</label>
                                                            <div class="col-md-6">
                                                                <input readonly type="text" class="form-control"
                                                                    name='alamat_surat_menyurat_1'
                                                                    placeholder="Alamat Surat Menyurat"
                                                                    value="{{ $kilang->alamat_surat_menyurat_1 }}">
                                                                @error('alamat_surat_menyurat_1')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div><br>
                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label"></label>
                                                            <div class="col-md-6">
                                                                <input readonly type="text" class="form-control"
                                                                    name='alamat_surat_menyurat_2'
                                                                    placeholder="Alamat Surat Menyurat"
                                                                    value="{{ $kilang->alamat_surat_menyurat_2 }}">
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
                                                                    <label for="wphoneNumber2">Poskod</label>
                                                                    <input readonly type="text" class="form-control"
                                                                        name="alamat_surat_menyurat_poskod">
                                                                    @error('alamat_surat_menyurat_poskod')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="wphoneNumber2">Daerah</label>
                                                                    <input readonly type="text" class="form-control"
                                                                        name="alamat_surat_menyurat_daerah">
                                                                    @error('alamat_surat_menyurat_daerah')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">No.
                                                                Pendaftaran Syarikat(SSM)</label>
                                                            <div class="col-md-6">
                                                                <input readonly type="text" class="form-control"
                                                                    name='no_ssm'
                                                                    placeholder="No. Pendaftaran Syarikat(SSM)"
                                                                    value="{{ $kilang->no_ssm }}">
                                                                @error('no_ssm')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="wphoneNumber2">Latitude</label>
                                                                    <input readonly type="text" class="form-control"
                                                                        name="longtitude_x"
                                                                        value="{{ $kilang->longtitude_x }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="wphoneNumber2">Longitude</label>
                                                                    <input readonly type="text" class="form-control"
                                                                        name="langtitude_y"
                                                                        value="{{ $kilang->langtitude_y }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                        </div>
                                    </div>
                                </div>

                                {{-- tab 2 --}}
                                <div id="navpills-2" class="tab-pane">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <section>
                                                <h4 class="card-title" style="text-align: center">Bahagian B</h4>
                                                <div class="row">
                                                    <label for="fname"
                                                        class="text-right col-sm-3 control-label col-form-label">No.Telefon</label>
                                                    <div class="col-md-6">
                                                        <input readonly type="text" class="form-control"
                                                            name='no_telefon' placeholder="No.Telefon"
                                                            value="{{ $kilang->no_telefon }}">
                                                        @error('no_telefon')
                                                            <div class="alert alert-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div> <br>
                                                <div class="row">
                                                    <label for="fname"
                                                        class="text-right col-sm-3 control-label col-form-label">No.Faks</label>
                                                    <div class="col-md-6">
                                                        <input readonly type="text" class="form-control" name='no_faks'
                                                            placeholder="No.Faks" value="{{ $kilang->no_faks }}">
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
                                                    <div class="col-md-6">
                                                        <input readonly type="email" class="form-control"
                                                            name='email_kilang' placeholder="Emel"
                                                            value="{{ $kilang->email_kilang }}">
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
                                                    <div class="col-md-6">
                                                        <input readonly type="text" class="form-control" name='website'
                                                            placeholder="Laman Sesawang (Website)"
                                                            value="{{ $kilang->website }}">
                                                        @error('website')
                                                            <div class="alert alert-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <label for="fname"
                                                        class="text-right col-sm-3 control-label col-form-label">No.Lesen</label>
                                                    <div class="col-md-6">
                                                        <input readonly type="text" class="form-control" name='no_lesen'
                                                            placeholder="No.Lesen" value="{{ $kilang->no_lesen }}">
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
                                                    <div class="col-md-6">
                                                        <input readonly type="date" class="form-control"
                                                            name="tarikh_tubuh" value="{{ $kilang->tarikh_tubuh }}">
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
                                                    <div class="col-md-6">
                                                        <input readonly type="date" class="form-control"
                                                            name="tarikh_operasi" value="{{ $kilang->tarikh_operasi }}">
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
                                                    <div class="col-md-6">
                                                        <input readonly type="text" class="form-control"
                                                            name="tarikh_operasi"
                                                            value="{{ $kilang->taraf_syarikat_catatan }}">

                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <label for="fname"
                                                        class="text-right col-sm-3 control-label col-form-label">Status Hak
                                                        Milik Syarikat</label>
                                                    <div class="col-md-6">
                                                        <input readonly type="text" class="form-control"
                                                            name="status_hak_milik"
                                                            value="{{ $kilang->status_hak_milik }}">

                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <label for="fname"
                                                        class="text-right col-sm-3 control-label col-form-label">Status
                                                        Warganegara</label>
                                                    <div class="col-md-6">
                                                        <input readonly type="text" class="form-control"
                                                            name="status_warganegara"
                                                            value="{{ $kilang->status_warganegara }}">
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <label for="fname"
                                                        class="text-right col-sm-3 control-label col-form-label">Nilai
                                                        Harta - Harta Tetap</label>
                                                    <div class="col-md-6">
                                                        <input readonly type="text" class="form-control"
                                                            name='nilai_harta' placeholder="Nilai Harta"
                                                            value="{{ $kilang->nilai_harta }}">
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
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="card">
                                                                    <div class="el-card-item">
                                                                        <div class="el-card-avatar el-overlay-1">
                                                                            @if(pathinfo(asset( $image_path =
                                                                            str_replace('public', 'storage', $kilang
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
                                                                                    src="{{ asset($image_path = str_replace('public', 'storage', $kilang->sijil_ssm)) }}"
                                                                                    alt="Lesen Kilang"
                                                                                    class="imgthumbnail" width="300px"
                                                                                    height="300px"></img>
                                                                            </div>
                                                                            @endif

                                                                            <div class="el-overlay">
                                                                                <ul class="list-style-none el-info">
                                                                                    @if(pathinfo(asset( $image_path =
                                                                                    str_replace('public', 'storage', $kilang
                                                                                    ->sijil_ssm)), PATHINFO_EXTENSION) ==
                                                                                    "pdf")

                                                                                    <li class="el-item"><a
                                                                                            target="_blank"
                                                                                            href="{{ asset($image_path = str_replace('public', 'storage', $kilang->sijil_ssm)) }}"><i
                                                                                                class="icon-magnifier"></i></a>
                                                                                    </li>
                                                                                @else
                                                                                    <li class="el-item"><a
                                                                                            class="btn default btn-outline image-popup-vertical-fit el-link"
                                                                                            href="{{ asset($image_path = str_replace('public', 'storage', $kilang->sijil_ssm)) }}"><i
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
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="card">
                                                                    <div class="el-card-item">
                                                                        <div class="el-card-avatar el-overlay-1">
                                                                            @if(pathinfo(asset( $image_path =
                                                                            str_replace('public', 'storage', $kilang
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
                                                                                    src="{{ asset($image_path = str_replace('public', 'storage', $kilang->lesen_kilang)) }}"
                                                                                    alt="Lesen Kilang"
                                                                                    class="imgthumbnail" width="300px"
                                                                                    height="300px"></img>
                                                                            </div>
                                                                            @endif
                                                                            {{-- <img src="{{asset( $image_path = str_replace('public', 'storage',  $kilang ->lesen_kilang))}}" alt="ic belakang" /> --}}
                                                                            <div class="el-overlay">
                                                                                <ul class="list-style-none el-info">

                                                                                    @if(pathinfo(asset( $image_path =
                                                                                    str_replace('public', 'storage', $kilang
                                                                                    ->lesen_kilang)), PATHINFO_EXTENSION) ==
                                                                                    "pdf")

                                                                                    <li class="el-item"><a
                                                                                            target="_blank"
                                                                                            href="{{ asset($image_path = str_replace('public', 'storage', $kilang->lesen_kilang)) }}"><i
                                                                                                class="icon-magnifier"></i></a>
                                                                                    </li>
                                                                                @else
                                                                                    <li class="el-item"><a
                                                                                            class="btn default btn-outline image-popup-vertical-fit el-link"
                                                                                            href="{{ asset($image_path = str_replace('public', 'storage', $kilang->lesen_kilang)) }}"><i
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
                                                <button type="button" class="btn btn-danger"><i
                                                        class="fas fa-times"></i>
                                                    Batal</button> &nbsp
                                                <button type="submit" class="btn btn-success"><i
                                                        class="fa fa-check"></i>
                                                    Sahkan</button>
                                            </section>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            @else
                                {{-- tab 3 --}}
                                <div id="navpills-3" class="tab-pane">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="card-title" style="text-align: center">Maklumat Pengguna Kilang
                                            </h4>
                                            <div class="row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Nama
                                                    Kilang</label>
                                                <div class="col-md-6">
                                                    <input readonly type="text" class="form-control" name='name'
                                                        placeholder="Nama Pengguna"
                                                        value="{{ $nama_kilang->nama_kilang }}">
                                                    @error('name')
                                                        <div class="alert alert-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Nama
                                                    Pengguna</label>
                                                <div class="col-md-6">
                                                    <input readonly type="text" class="form-control" name='name'
                                                        placeholder="Nama Pengguna" value="{{ $users->name }}">
                                                    @error('name')
                                                        <div class="alert alert-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <br>


                                            <div class="row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Jantina</label>
                                                <div class="col-md-6">
                                                    <input readonly type="text" class="form-control" name='jantina'
                                                        placeholder="Nama Pengguna" value="{{ $users->jantina }}">

                                                </div>
                                            </div> <br>
                                            <div class="row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Warganegara</label>
                                                <div class="col-md-6">
                                                    <input readonly type="text" class="form-control" name='warganegara'
                                                        placeholder="Nama Pengguna" value="{{ $users->warganegara }}">

                                                </div>
                                            </div> <br>
                                            <div class="row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Kaum</label>
                                                <div class="col-md-6">
                                                    <input readonly type="text" class="form-control" name='kaum'
                                                        placeholder="Nama Pengguna" value="{{ $users->kaum }}">

                                                </div>
                                            </div> <br>

                                            <div class="row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">E-mel</label>
                                                <div class="col-md-6">
                                                    <input readonly type="text" class="form-control" name='kaum'
                                                        placeholder="Nama Pengguna" value="{{ $users->email }}">

                                                </div>
                                            </div> <br>
                                            <div class="row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">No Kad
                                                    Pengenalan</label>
                                                <div class="col-md-6">
                                                    <input readonly type="text" class="form-control"
                                                        name='no_kad_pengenalan' placeholder="Nama Pengguna"
                                                        value="{{ $users->no_kad_pengenalan }}">

                                                </div>
                                            </div> <br>

                                            @if ($users->gambar_ic_hadapan && $users->gambar_ic_belakang)
                                                <div class="row" style="justify-content: center">
                                                    <div class="col-md-3">
                                                        <label for="wphoneNumber2">Gambar Hadapan Kad Pengenalan</label>
                                                        <div class="row el-element-overlay"
                                                            style="justify-content: center">
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="card">
                                                                    <div class="el-card-item">
                                                                        <div class="el-card-avatar el-overlay-1"> <img
                                                                                src="{{ asset($image_path = str_replace('public', 'storage', $users->gambar_ic_hadapan)) }}"
                                                                                alt="ic hadapan" />
                                                                            <div class="el-overlay">
                                                                                <ul class="list-style-none el-info">
                                                                                    <li class="el-item"><a
                                                                                            class="btn default btn-outline image-popup-vertical-fit el-link"
                                                                                            href="{{ asset($image_path = str_replace('public', 'storage', $users->gambar_ic_hadapan)) }}"><i
                                                                                                class="icon-magnifier"></i></a>
                                                                                    </li>
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
                                                    <div class="col-md-3">
                                                        <label for="wphoneNumber2">Gambar Belakang Kad Pengenalan</label>
                                                        <div class="row el-element-overlay"
                                                            style="justify-content: center">
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="card">
                                                                    <div class="el-card-item">
                                                                        <div class="el-card-avatar el-overlay-1"> <img
                                                                                src="{{ asset($image_path = str_replace('public', 'storage', $users->gambar_ic_belakang)) }}"
                                                                                alt="ic belakang" />
                                                                            <div class="el-overlay">
                                                                                <ul class="list-style-none el-info">
                                                                                    <li class="el-item"><a
                                                                                            class="btn default btn-outline image-popup-vertical-fit el-link"
                                                                                            href="{{ asset($image_path = str_replace('public', 'storage', $users->gambar_ic_belakang)) }}"><i
                                                                                                class="icon-magnifier"></i></a>
                                                                                    </li>
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
                                            @endif

                                            @if ($users->gambar_passport)
                                                <div class="row">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-6">
                                                        <label for="wphoneNumber2">Gambar Passport</label>
                                                        <div class="row el-element-overlay"
                                                            style="justify-content: center">
                                                            <div class="col-lg-3 col-md-6">
                                                                <div class="card">
                                                                    <div class="el-card-item">
                                                                        <div class="el-card-avatar el-overlay-1"> <img
                                                                                src="{{ asset($image_path = str_replace('public', 'storage', $users->gambar_passport)) }}"
                                                                                alt="passport" />
                                                                            <div class="el-overlay">
                                                                                <ul class="list-style-none el-info">
                                                                                    <li class="el-item"><a
                                                                                            class="btn default btn-outline image-popup-vertical-fit el-link"
                                                                                            href="{{ asset($image_path = str_replace('public', 'storage', $users->gambar_passport)) }}"><i
                                                                                                class="icon-magnifier"></i></a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> <br>

                                                </div>
                                            @endif
                                            <div class="row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Jawatan</label>
                                                <div class="col-md-6">
                                                    <input readonly type="text" class="form-control" name='jawatan'
                                                        placeholder="Nama Pengguna" value="{{ $users->jawatan }}">

                                                </div>
                                            </div> <br>

                                            <div class="row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">No.
                                                    Pekerja</label>
                                                <div class="col-md-6">
                                                    <input readonly type="text" class="form-control" name='jawatan'
                                                        placeholder="Nama Pengguna" value="{{ $users->no_pekerja }}">

                                                </div>
                                            </div> <br>
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6">
                                                    <label for="wphoneNumber2">Gambar Kad Pekerja</label>
                                                    <div class="row el-element-overlay" style="justify-content: center">
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="card">
                                                                <div class="el-card-item">
                                                                    <div class="el-card-avatar el-overlay-1"> <img
                                                                            src="{{ asset($image_path = str_replace('public', 'storage', $users->gambar_kad_pekerja)) }}"
                                                                            alt="kad pekerja" />
                                                                        <div class="el-overlay">
                                                                            <ul class="list-style-none el-info">
                                                                                <li class="el-item"><a
                                                                                        class="btn default btn-outline image-popup-vertical-fit el-link"
                                                                                        href="{{ asset($image_path = str_replace('public', 'storage', $users->gambar_kad_pekerja)) }}"><i
                                                                                            class="icon-magnifier"></i></a>
                                                                                </li>
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
                                                </div> <br>

                                            </div>
                                            <div class="row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Pilihan
                                                    Kilang</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" name='shuttle_type'
                                                        disabled>
                                                        <option value="3"
                                                            {{ $users->shuttle_type == '3' ? 'selected' : '' }}>Kilang
                                                            Papan</option>
                                                        <option value="4"
                                                            {{ $users->shuttle_type == '4' ? 'selected' : '' }}>Kilang
                                                            Papan Lapis/Venir</option>
                                                        <option value="5"
                                                            {{ $users->shuttle_type == '5' ? 'selected' : '' }}>Kilang
                                                            Kayu Kumai</option>
                                                    </select>
                                                    @error('shuttle_type')
                                                        <div class="alert alert-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div> <br>

                                            <button type="button" class="btn btn-danger"><i class="fas fa-times"></i>
                                                Batal</button> &nbsp
                                            <button type="button" class="btn btn-success"><i class="fa fa-check"></i>
                                                Sahkan</button>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->


    </div>

    <script>
        // document.addEventListener("DOMContentLoaded", () => {
        //     Livewire.hook('component.initialized', (component) => {
        //         console.log(component);
        //         $(document).ready(function() {
        //             $('#example').DataTable();
        //         });
        //     })
        // });
    </script>

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
