<div>

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">
                <div class="rounded-lg card" style="border-color: #000000 !important;">
                    <div class="card-header"
                        style="text-align:center; background-color: #c5d6eb !important; font-size: 130%; font-weight: bold; ">
                        BORANG 5A - MAKLUMAT KILANG KAYU KUMAI
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
                                                            Kilang Papan </h4>
                                                            <hr>
                                                        <div class="form-group row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">Tahun</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control"
                                                                    wire:model='tahun' placeholder="Tahun">
                                                                @error('tahun')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="text-right col-sm-3 control-label col-form-label">Negeri</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control" wire:model='negeri'
                                                                    wire:click="loadDaerah($event.target.value)">
                                                                    <option disabled hidden value="">Pilih
                                                                        Negeri</option>
                                                                    @forelse ($state as $data )
                                                                        @if ($data->negeri == 'JHR')
                                                                            <option value="JHR">Johor</option>
                                                                        @elseif($data->negeri == "KDH")
                                                                            <option value="KDH">Kedah</option>
                                                                        @elseif($data->negeri == "KTN")
                                                                            <option value="KTN">Kelantan</option>
                                                                        @elseif($data->negeri == "KUL")
                                                                            <option value="KUL">W.P Kuala Lumpur
                                                                            </option>
                                                                        @elseif($data->negeri == "KTN")
                                                                            <option value="KTN">W.P Labuan</option>
                                                                        @elseif($data->negeri == "MLK")
                                                                            <option value="MLK">Melaka</option>
                                                                        @elseif($data->negeri == "NSN")
                                                                            <option value="NSN">N.Sembilan</option>
                                                                        @elseif($data->negeri == "PHG")
                                                                            <option value="PHG">Pahang</option>
                                                                        @elseif($data->negeri == "PNG")
                                                                            <option value="PNG">P.Pinang</option>
                                                                        @elseif($data->negeri == "PRK")
                                                                            <option value="PRK">Perak</option>
                                                                        @elseif($data->negeri == "PJY")
                                                                            <option value="PJY">W.P Putrajaya</option>
                                                                        @elseif($data->negeri == "SBH")
                                                                            <option value="SBH">Sabah</option>
                                                                        @elseif($data->negeri == "SRW")
                                                                            <option value="SRW">Sarawak</option>
                                                                        @elseif($data->negeri == "SGR")
                                                                            <option value="SGR">Selangor</option>
                                                                        @elseif($data->negeri == "TRG")
                                                                            <option value="TRG">Terengganu</option>
                                                                        @elseif($data->negeri == "PLS")
                                                                            <option value="PLS">Perlis</option>
                                                                        @endif
                                                                    @empty

                                                                    @endforelse
                                                                </select>
                                                                @error('negeri')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="text-right col-sm-3 control-label col-form-label">Daerah
                                                                Hutan</label>
                                                            <div class="col-sm-9">
                                                                @if ($daerah_readonly == false)
                                                                    <select class="form-control" wire:model='daerah_id'>
                                                                        <option value="" disabled hidden>Sila Pilih
                                                                            Daerah
                                                                        </option>
                                                                        @forelse ($district as $data )
                                                                            <option value="{{ $data->id }}">
                                                                                {{ $data->bandar }}
                                                                            </option>
                                                                        @empty

                                                                        @endforelse
                                                                    </select>
                                                                    @error('daerah_id')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                @else
                                                                    <select class="form-control" wire:model='daerah_id'
                                                                        disabled>
                                                                        <option value="" disabled hidden>Sila Pilih
                                                                            Daerah
                                                                        </option>
                                                                        @forelse ($district as $data )
                                                                            <option value="">{{ $data->bandar }}
                                                                            </option>
                                                                        @empty

                                                                        @endforelse
                                                                    </select>
                                                                    @error('daerah_id')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                @endif

                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="form-group row">
                                                            <label for="cono1"
                                                                class="text-right col-sm-3 control-label col-form-label">Nama
                                                                Kilang</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control"
                                                                    wire:model='nama_kilang' placeholder="Nama Kilang">
                                                                @error('nama_kilang')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="com1"
                                                                class="text-right col-sm-3 control-label col-form-label">Alamat
                                                                Kilang</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control"
                                                                    wire:model='alamat_kilang_1'
                                                                    placeholder="Alamat Kilang">
                                                                @error('alamat_kilang_1')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                                <br>
                                                                <input type="text" class="form-control"
                                                                    wire:model='alamat_kilang_2'
                                                                    placeholder="Alamat Kilang">
                                                                @error('alamat_kilang_2')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="com1"
                                                                class="text-right col-sm-4 control-label col-form-label">Poskod</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" style="width:80px;"
                                                                    class="form-control"
                                                                    wire:model='alamat_kilang_poskod'
                                                                    wire:click="loadPoskodKilang($event.target.value)"
                                                                    placeholder="Poskod">
                                                                @error('alamat_kilang_poskod')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <label for="com1"
                                                                class="text-right col-sm-1 control-label col-form-label">Daerah</label>
                                                            <div class="col-sm-3">
                                                                @if ($poskod_kilang_readonly == false)
                                                                    <select class="form-control"
                                                                        wire:model='alamat_kilang_daerah'
                                                                        style="width:150px;text-align: center">
                                                                        <option value="" disabled hidden>Pilih Daerah
                                                                        </option>
                                                                        @forelse ($poskod_kilang as $data)
                                                                            <option value="{{ $data->bandar }}">
                                                                                {{ $data->bandar }}
                                                                            </option>
                                                                        @empty
                                                                        @endforelse
                                                                    </select>
                                                                    @error('alamat_kilang_daerah')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                @else
                                                                    <select class="form-control"
                                                                        wire:model='alamat_kilang_daerah'
                                                                        style="width:150px;text-align: center" disabled>
                                                                        <option value="" disabled hidden>Pilih Daerah
                                                                        </option>
                                                                        @forelse ($poskod_kilang as $data)
                                                                            <option value="{{ $data->bandar }}">
                                                                                {{ $data->bandar }}
                                                                            </option>
                                                                        @empty
                                                                        @endforelse
                                                                    </select>
                                                                    @error('alamat_kilang_daerah')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr>


                                                        <div class="form-group row">
                                                            <label for="com1"
                                                                class="text-right col-sm-3 control-label col-form-label">Alamat
                                                                Surat Menyurat</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control"
                                                                    wire:model='alamat_surat_menyurat_1'
                                                                    placeholder="Alamat Surat Menyurat">
                                                                @error('alamat_surat_menyurat_1')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                                <br>
                                                                <input type="text" class="form-control"
                                                                    wire:model='alamat_surat_menyurat_2'
                                                                    placeholder="Alamat Surat Menyurat">
                                                                @error('alamat_surat_menyurat_2')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="com1"
                                                                class="text-right col-sm-4 control-label col-form-label">Poskod</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" style="width:80px;"
                                                                    class="form-control"
                                                                    wire:model='alamat_surat_menyurat_poskod'
                                                                    wire:click="loadPoskodSuratMenyurat($event.target.value)"
                                                                    placeholder="Poskod">
                                                                @error('alamat_surat_menyurat_poskod')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <label for="com1"
                                                                class="text-right col-sm-1 control-label col-form-label">Daerah</label>
                                                            <div class="col-sm-3">
                                                                @if ($poskod_surat_readonly == false)
                                                                    <select class="form-control"
                                                                        wire:model='alamat_surat_menyurat_daerah'
                                                                        style="width:150px;text-align: center">
                                                                        <option value="" disabled hidden>Pilih Daerah
                                                                        </option>
                                                                        @forelse ($poskod_surat_menyurat as $data)
                                                                            <option value="{{ $data->bandar }}">
                                                                                {{ $data->bandar }}
                                                                            </option>
                                                                        @empty
                                                                        @endforelse
                                                                    </select>
                                                                    @error('alamat_surat_menyurat_daerah')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                @else
                                                                    <select class="form-control"
                                                                        wire:model='alamat_surat_menyurat_daerah'
                                                                        disabled style="width:150px;text-align: center">
                                                                        <option value="" disabled hidden>Pilih Daerah
                                                                        </option>
                                                                        @forelse ($poskod_surat_menyurat as $data)
                                                                            <option value="{{ $data->bandar }}">
                                                                                {{ $data->bandar }}
                                                                            </option>
                                                                        @empty
                                                                        @endforelse
                                                                    </select>
                                                                    @error('alamat_surat_menyurat_daerah')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                @endif
                                                            </div>

                                                        </div>

                                                        <hr>
                                                        <div class="form-group row">
                                                            <label for="abpro"
                                                                class="text-right col-sm-3 control-label col-form-label">No.
                                                                Pendaftaran Syarikat (SSM)</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control"
                                                                    wire:model='no_ssm'
                                                                    placeholder="No. Pendaftaran Syarikat (SSM)">
                                                                @error('no_ssm')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="abpro"
                                                                class="text-right col-sm-7 control-label col-form-label">Lokasi Koordinat Kilang </label>
                                                            <div class="col-sm-12">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <label>Latitude:</label>
                                                                                <input type="text" class="form-control"
                                                                                    style="background-color: #FFFFFF;"
                                                                                    wire:model='langtitude_y' id="lat"
                                                                                    value="0" />
                                                                                @error('langtitude_y')
                                                                                    <div class="alert alert-danger">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label>Longitude:</label>
                                                                                <input type="text" class="form-control"
                                                                                    style="background-color: #FFFFFF;"
                                                                                    wire:model='longtitude_x' id="lng"
                                                                                    value="0" />
                                                                                @error('longtitude_x')
                                                                                    <div class="alert alert-danger">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">

                                                <form class="form-horizontal">
                                                    <div class="card-body">
                                                        <div class="form-group row">
                                                            <label for="fname"
                                                                class="text-right col-sm-3 control-label col-form-label">No.
                                                                Telefon</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control"
                                                                    wire:model='no_telefon' placeholder="No.Telefon">
                                                                @error('no_telefon')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-horizontal">
                                                            <div class="form-group row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label">No.
                                                                    Faks</label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control"
                                                                        wire:model='no_faks' placeholder="No. Faks">
                                                                    @error('no_faks')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-horizontal">
                                                            <div class="form-group row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label">Email</label>
                                                                <div class="col-sm-7">
                                                                    <input type="text" class="form-control"
                                                                        wire:model='email' placeholder="Email">
                                                                    @error('email')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-horizontal">
                                                            <div class="form-group row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label">Laman
                                                                    Sesawang (Website)</label>
                                                                <div class="col-sm-7">
                                                                    <input type="text" class="form-control"
                                                                        wire:model='website'
                                                                        placeholder="Laman Sesawang (Website)">
                                                                    @error('website')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>

                                                        <div class="form-horizontal">
                                                            <div class="form-group row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label">No.
                                                                    Lesen</label>
                                                                <div class="col-sm-7">
                                                                    <input type="text" class="form-control"
                                                                        wire:model='no_lesen' placeholder="Tahun">
                                                                    @error('no_lesen')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-horizontal">
                                                            <div class="form-group row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label">Tarikh
                                                                    Kilang Ditubuhkan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="date" class="form-control"
                                                                        wire:model='tarikh_tubuh' placeholder="Tahun">
                                                                    @error('tarikh_tubuh')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-horizontal">
                                                            <div class="form-group row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label">Tarikh
                                                                    Kilang Mula Beroperasi</label>
                                                                <div class="col-sm-9">
                                                                    <input type="date" class="form-control"
                                                                        wire:model='tarikh_operasi' placeholder="Tahun">
                                                                    @error('tarikh_operasi')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label
                                                                class="text-right col-sm-3 control-label col-form-label">Taraf
                                                                Sah Syarikat</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control"
                                                                    wire:model='taraf_syarikat_catatan'>
                                                                    <option value="" disabled hidden>Pilih Taraf Sah
                                                                        Syarikat</option>

                                                                    @forelse($taraf_sah_syarikat as $data )
                                                                        <option value="{{ $data->keterangan }}">
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

                                                        <div class="form-group row">
                                                            <label
                                                                class="text-right col-sm-3 control-label col-form-label">Status
                                                                Hakmilik Syarikat</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control"
                                                                    wire:model='status_hak_milik'>
                                                                    <option value="" disabled hidden>Pilih Status
                                                                        Hakmilik Syarikat</option>
                                                                    @forelse($hak_milik as $data )
                                                                        <option value="{{ $data->keterangan }}">
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

                                                        <div class="form-group row">
                                                            <label
                                                                class="text-right col-sm-3 control-label col-form-label">Status
                                                                Warganegara</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control"
                                                                    wire:model='status_warganegara'>
                                                                    <option value="" disabled hidden>Pilih Status
                                                                        Warganegara</option>
                                                                    @forelse($warganegara as $data )
                                                                        <option value="{{ $data->keterangan }}">
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
                                                        </div>

                                                        <div class="form-horizontal">
                                                            <div class="form-group row">
                                                                <label for="fname"
                                                                    class="text-right col-sm-3 control-label col-form-label">Nilai
                                                                    Harta-Harta Tetap</label>
                                                                <div class="col-sm-3">
                                                                    <input type="text" class="form-control"
                                                                        wire:model='nilai_harta'
                                                                        placeholder="Nilai Harta Tetap">
                                                                    @error('nilai_harta')
                                                                        <div class="alert alert-danger">
                                                                            <strong>{{ $message }}</strong>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label
                                                                class="text-right col-sm-3 control-label col-form-label">Catatan</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control" wire:model='catatan_1'>
                                                                    <option>Pilih Catatan</option>
                                                                    <option>Lesen Batal</option>
                                                                    <option>Tukar Nama</option>
                                                                    <option>Lain-lain</option>
                                                                </select>
                                                                @error('catatan_1')
                                                                    <div class="alert alert-danger">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <hr>
                                                    <div class="card-body">
                                                        <div class="text-right form-group m-b-0">
                                                            <button type="button"
                                                                class="btn btn-primary">Kembali</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </div>
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
