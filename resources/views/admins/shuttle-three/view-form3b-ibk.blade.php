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

                        @if ($formb->shuttle_type == '3')
                            <div class="card-header"
                                style="text-align:center; background-color: #ee8dcd !important; font-size: 130%; font-weight: bold;">
                                BORANG 3B - JUMLAH GUNA TENAGA PADA AKHIR BULAN
                            </div>

                        @elseif($formb->shuttle_type == '4')
                            <div class="card-header"
                                style="text-align:center; background-color: #ee8dcd !important; font-size: 130%; font-weight: bold;">
                                BORANG 4B - JUMLAH GUNA TENAGA PADA AKHIR BULAN
                            </div>

                        @else
                            <div class="card-header"
                                style="text-align:center; background-color: #ee8dcd !important; font-size: 130%; font-weight: bold;">
                                BORANG 5B - JUMLAH GUNA TENAGA PADA AKHIR BULAN
                            </div>
                        @endif

                        <div class="card-body">
                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div class="tab-pane active" id="hotel" role="tabpanel" aria-labelledby="hotel-tab"><br>
                                    <div class="">
                                        <table class="table table-striped table-bordered" id="" style="width: 100%;">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-body" style="padding-top: 0%;">

                                                            <div class="row"
                                                                style="justify-content: center;margin-bottom:-3%;">
                                                                <div class="col-md-2">
                                                                    <label><b>Tahun:</b></label>
                                                                    <input type="text" class="form-control"
                                                                        style="background-color: #f8dbee; border-color: #d89bc4"
                                                                        value="{{ $formb->tahun }}" readonly />
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label><b>Suku Tahun:</b></label>
                                                                    @if ($formb->suku_tahun <= '1')

                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #f8dbee; border-color: #d89bc4"
                                                                            value="Pertama (Mac)" readonly />
                                                                    @elseif($formb->suku_tahun
                                                                        <= '2' ) <input type="text" class="form-control"
                                                                            style="background-color: #f8dbee; border-color: #d89bc4"
                                                                            value="Kedua (Jun)" readonly />
                                                                    @elseif($formb->suku_tahun
                                                                        <= '3' ) <input type="text" class="form-control"
                                                                            style="background-color: #f8dbee; border-color: #d89bc4"
                                                                            value="Ketiga (September)" readonly />
                                                                    @elseif($formb->suku_tahun
                                                                        <= '4' ) <input type="text" class="form-control"
                                                                            style="background-color: #f8dbee; border-color: #d89bc4"
                                                                            value="Keempat (Disember)" readonly />
                                                                    @else
                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #f8dbee;border-color: #d89bc4"
                                                                            value="Tiada Data" readonly />
                                                                    @endif

                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label><b>Nama Kilang:</b></label>
                                                                    <input type="text" class="form-control"
                                                                        style="background-color: #f8dbee;border-color: #d89bc4""
                                                                            value=" {{ $formb->nama_kilang }}"
                                                                        readonly />
                                                                </div>
                                                                {{-- <div class="col-md-2"></div> --}}
                                                                <div class="col-md-2">
                                                                    <label><b>No. Pendaftaran Syarikat (SSM):</b></label>
                                                                    <input type="text" class="form-control"
                                                                        style="background-color: #f8dbee;border-color: #d89bc4""
                                                                            value=" {{ $formb->no_ssm }}" readonly />
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label><b>No. Lesen:</b></label>
                                                                    <input type="text" class="form-control"
                                                                        style="background-color: #f8dbee;border-color: #d89bc4""
                                                                            value=" {{ $formb->no_lesen }}" readonly />
                                                                </div>


                                                            </div>


                                                            <br>
                                                            <table>

                                                                <tr style="height:50px;">
                                                                    <th style="text-align:center;" colspan="2" rowspan="4">
                                                                        Kategori Pekerja
                                                                    </th>
                                                                    <th style="text-align:center;" colspan="4">Warganegara
                                                                        Malaysia</th>
                                                                    <th style="text-align:center;" colspan="2" rowspan="3">
                                                                        Bukan<br> Warganegara
                                                                        Malaysia</th>
                                                                    <th style="text-align:center;" colspan="3" rowspan="3">
                                                                        Jumlah Pekerja</th>
                                                                    <th style="text-align:center;" colspan="3" rowspan="3">
                                                                        Purata Bayaran Gaji dan <br> Upah Per Pekerja<br>(Sebulan)<br> (RM / bulan / pekerja)</th>
                                                                    <th style="text-align:center;" colspan="3" rowspan="3">
                                                                        Jumlah Bayaran Gaji
                                                                        dan Upah (Sebulan) <br>(RM)</th>
                                                                </tr>
                                                                <tr style="height:50px;">
                                                                    <th style="text-align:center;" colspan="2" rowspan="2">
                                                                        Bumiputera</th>
                                                                    <th style="text-align:center;" colspan="2" rowspan="2">
                                                                        Bukan Bumiputera</th>
                                                                </tr>
                                                                <tr style="height:50px;">

                                                                </tr>
                                                                <tr style="height:50px;">
                                                                    <th style="text-align:center;">L</th>
                                                                    <th style="text-align:center;">P</th>
                                                                    <th style="text-align:center;">L</th>
                                                                    <th style="text-align:center;">P</th>
                                                                    <th style="text-align:center;">L</th>
                                                                    <th style="text-align:center;">P</th>
                                                                    <th style="text-align:center;">L</th>
                                                                    <th style="text-align:center;">P</th>
                                                                    <th style="text-align:center;">L+P</th>
                                                                    <th style="text-align:center;">L</th>
                                                                    <th style="text-align:center;">P</th>
                                                                    <th style="text-align:center;">L+P</th>
                                                                    <th style="text-align:center;">L</th>
                                                                    <th style="text-align:center;">P</th>
                                                                    <th style="text-align:center;">L+P</th>
                                                                </tr>

                                                                <tr style="height:50px;">
                                                                    <th style="text-align:center;" colspan="2">(01)</th>
                                                                    <th style="text-align:center;">(02)</th>
                                                                    <th style="text-align:center;">(03)</th>
                                                                    <th style="text-align:center;">(04)</th>
                                                                    <th style="text-align:center;">(05)</th>
                                                                    <th style="text-align:center;">(06)</th>
                                                                    <th style="text-align:center;">(07)</th>
                                                                    <th style="text-align:center;">(08)=(02)+(04)+(06)</th>
                                                                    <th style="text-align:center;">(09)=(03)+(05)+(07)</th>
                                                                    <th style="text-align:center;">(10)=(08)+(09)</th>
                                                                    <th style="text-align:center;">(11)</th>
                                                                    <th style="text-align:center;">(12)</th>
                                                                    <th style="text-align:center;">(13)=(11)+(12)</th>
                                                                    <th style="text-align:center;">(14)</th>
                                                                    <th style="text-align:center;">(15)</th>
                                                                    <th style="text-align:center;">(16)=(14)+(15)</th>
                                                                </tr>

                                                                @forelse($form_b as $key=>$data)
                                                                    <tr style="height:50px;">

                                                                        <td style="text-align:left;">
                                                                            {{ $data->kategori_guna_tenaga->keterangan }}
                                                                        </td>
                                                                        <td style="text-align:center;width:30px;">
                                                                            {{ $i = $loop->iteration }}</td>
                                                                        <td style="text-align:right;padding:5px"><span
                                                                                type="text" size="3"
                                                                                value="{{ $data->pekerja_wargabumi_lelaki }}"
                                                                                wire:model='pekerja_wargabumi_lelaki.{{ $key }}'
                                                                                wire:change="calcJumlahPekerjaLelaki({{ $key }});"
                                                                                onkeypress="return isNumberKey(event)">{{ $data->pekerja_wargabumi_lelaki }}</span>
                                                                        </td>
                                                                        <td style="text-align:right;padding:5px"><span
                                                                                type="text" size="3"
                                                                                value="{{ $data->pekerja_wargabumi_perempuan }}"
                                                                                wire:model='pekerja_wargabumi_perempuan.{{ $key }}'
                                                                                wire:change="calcJumlahPekerjaPerempuan({{ $key }})"
                                                                                onkeypress="return isNumberKey(event)">{{ $data->pekerja_wargabumi_perempuan }}</span>
                                                                        </td>
                                                                        <td style="text-align:right;padding:5px"><span
                                                                                type="text" size="3"
                                                                                value="{{ $data->pekerja_bukan_wargabumi_lelaki }}"
                                                                                wire:model='pekerja_bukan_wargabumi_lelaki.{{ $key }}'
                                                                                wire:change="calcJumlahPekerjaLelaki({{ $key }})"
                                                                                onkeypress="return isNumberKey(event)">{{ $data->pekerja_bukan_wargabumi_lelaki }}</span>
                                                                        </td>
                                                                        <td style="text-align:right;padding:5px"><span
                                                                                type="text" size="3"
                                                                                value="{{ $data->pekerja_bukan_wargabumi_perempuan }}"
                                                                                wire:model='pekerja_bukan_wargabumi_perempuan.{{ $key }}'
                                                                                wire:change="calcJumlahPekerjaPerempuan({{ $key }})"
                                                                                onkeypress="return isNumberKey(event)">{{ $data->pekerja_bukan_wargabumi_perempuan }}</span>
                                                                        </td>
                                                                        <td style="text-align:right;"><span type="text"
                                                                                size="3"
                                                                                value="{{ $data->pekerja_asing_lelaki }}"
                                                                                wire:model='pekerja_asing_lelaki.{{ $key }}'
                                                                                wire:change="calcJumlahPekerjaLelaki({{ $key }})"
                                                                                onkeypress="return isNumberKey(event)">{{ $data->pekerja_asing_lelaki }}</span>
                                                                        </td>
                                                                        <td style="text-align:right;"><span type="text"
                                                                                size="3"
                                                                                value="{{ $data->pekerja_asing_perempuan }}"
                                                                                wire:model='pekerja_asing_perempuan.{{ $key }}'
                                                                                wire:change="calcJumlahPekerjaPerempuan({{ $key }})"
                                                                                onkeypress="return isNumberKey(event)">{{ $data->pekerja_asing_perempuan }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;background-color: #f8dbee;">
                                                                            <span readonly type="text"
                                                                                value="{{ $data->jumlah_lelaki }}"
                                                                                size="3"
                                                                                wire:model='jumlah_lelaki.{{ $key }}'
                                                                                onkeypress="return isNumberKey(event)">{{ $data->jumlah_lelaki }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;background-color: #f8dbee;">
                                                                            <span readonly type type="text"
                                                                                value="{{ $data->jumlah_perempuan }}"
                                                                                size="3"
                                                                                wire:model='jumlah_perempuan.{{ $key }}'
                                                                                onkeypress="return isNumberKey(event)">{{ $data->jumlah_perempuan }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;background-color: #f8dbee;">
                                                                            <span readonly type type="text"
                                                                                value="{{ $data->jumlah_pekerja }}"
                                                                                size="3"
                                                                                wire:model='jumlah_pekerja.{{ $key }}'
                                                                                onkeypress="return isNumberKey(event)">{{ $data->jumlah_pekerja }}</span>
                                                                        </td>
                                                                        <td style="text-align:right;"><span type="text"
                                                                                size="3" value="{{ $data->gaji_lelaki }}"
                                                                                wire:model='gaji_lelaki.{{ $key }}'
                                                                                wire:change="calcTotalAllBayaranGajiPerPekerjaLelaki({{ $key }})"
                                                                                onkeypress="return isNumberKey(event)">{{ number_format($data->gaji_lelaki, 2) }}</span>
                                                                        </td>
                                                                        <td style="text-align:right;"><span type="text"
                                                                                size="3"
                                                                                value="{{ $data->gaji_perempuan }}"
                                                                                wire:model='gaji_perempuan.{{ $key }}'
                                                                                wire:change="calcTotalAllBayaranGajiPerPekerjaPerempuan({{ $key }})"
                                                                                onkeypress="return isNumberKey(event)">{{ number_format($data->gaji_perempuan, 2) }}</span>
                                                                        </td>

                                                                        <td
                                                                            style="text-align:right;background-color: #f8dbee;">
                                                                            <span type="text" size="3" value=""
                                                                                wire:model='gaji_lelaki_perempuan.{{ $key }}'
                                                                                wire:change="calcTotalAllBayaranGajiPerPekerjaPerempuan({{ $key }})"
                                                                                onkeypress="return isNumberKey(event)">{{ number_format($data->gaji_lelaki_perempuan, 2) }}</span>
                                                                        </td>

                                                                        <td style="text-align:right;"><span type="text"
                                                                                size="3"
                                                                                wire:model='total_gaji_lelaki.{{ $key }}'
                                                                                value="{{ $data->total_gaji_lelaki }}"
                                                                                wire:change="calcJumlahGaji({{ $key }})"
                                                                                onkeypress="return isNumberKey(event)">{{ number_format($data->total_gaji_lelaki, 2) }}</span>
                                                                        </td>
                                                                        <td style="text-align:right;"><span type="text"
                                                                                size="3"
                                                                                wire:model='total_gaji_perempuan.{{ $key }}'
                                                                                value="{{ $data->total_gaji_perempuan }}"
                                                                                wire:change="calcJumlahGaji({{ $key }})"
                                                                                onkeypress="return isNumberKey(event)">{{ number_format($data->total_gaji_perempuan, 2) }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;background-color: #f8dbee;">
                                                                            <span readonly type="text" size="3"
                                                                                value="{{ $data->total_gaji }}"
                                                                                wire:model='total_gaji.{{ $key }}'>{{ number_format($data->total_gaji, 2) }}</span>


                                                                        </td>

                                                                    </tr>
                                                                    @if ($loop->last)
                                                                        <tr style="height:50px;">
                                                                            <td style="text-align:right;"><b>Jumlah</b>
                                                                            </td>
                                                                            <td style="text-align:center;"
                                                                                style="width:20px">
                                                                                <b>{{ $i = $i + 1 }}</b></td>
                                                                            <td
                                                                                style="text-align:right;background-color: #f8dbee;">
                                                                                <span readonly type="text" size="3"
                                                                                    value="{{ $data->total_gaji }}"
                                                                                    wire:model='total_bumi_lelaki'><b>{{ $data->total_bumi_lelaki }}</b></span>
                                                                            </td>
                                                                            <td
                                                                                style="text-align:right;background-color: #f8dbee;">
                                                                                <span readonly type="text" size="3"
                                                                                    value="{{ $data->total_gaji }}"
                                                                                    wire:model='total_bumi_perempuan'><b>{{ $data->total_bumi_perempuan }}</b></span>
                                                                            </td>
                                                                            <td
                                                                                style="text-align:right;background-color: #f8dbee;">
                                                                                <span readonly type="text" size="3"
                                                                                    value="{{ $data->total_gaji }}"
                                                                                    wire:model='total_bukanbumi_lelaki'><b>{{ $data->total_bukanbumi_lelaki }}</b></span>
                                                                            </td>
                                                                            <td
                                                                                style="text-align:right;background-color: #f8dbee;">
                                                                                <span readonly type="text" size="3"
                                                                                    value="{{ $data->total_gaji }}"
                                                                                    wire:model='total_bukanbumi_perempuan'><b>{{ $data->total_bukanbumi_perempuan }}</b></span>
                                                                            </td>
                                                                            <td
                                                                                style="text-align:right;background-color: #f8dbee;">
                                                                                <span readonly type="text" size="3"
                                                                                    value="{{ $data->total_gaji }}"
                                                                                    wire:model='total_asing_lelaki'><b>{{ $data->total_asing_lelaki }}</b></span>
                                                                            </td>
                                                                            <td
                                                                                style="text-align:right;background-color: #f8dbee;">
                                                                                <span readonly type="text" size="3"
                                                                                    value="{{ $data->total_gaji }}"
                                                                                    wire:model='total_asing_perempuan'><b>{{ $data->total_asing_perempuan }}</b></span>
                                                                            </td>
                                                                            <td
                                                                                style="text-align:right;background-color: #f8dbee;">
                                                                                <span readonly type="text" size="3"
                                                                                    value="{{ $data->total_gaji }}"
                                                                                    wire:model='total_pekerja_lelaki'><b>{{ $data->total_pekerja_lelaki }}</b></span>
                                                                            </td>
                                                                            <td
                                                                                style="text-align:right;background-color: #f8dbee;">
                                                                                <span readonly type="text" size="3"
                                                                                    value="{{ $data->total_gaji }}"
                                                                                    wire:model='total_pekerja_perempuan'><b>{{ $data->total_pekerja_perempuan }}</b></span>
                                                                            </td>
                                                                            <td
                                                                                style="text-align:right;background-color: #f8dbee;">
                                                                                <span readonly type="text" size="3"
                                                                                    value="{{ $data->total_gaji }}"
                                                                                    wire:model='total_pekerja'><b>{{ $data->total_pekerja }}</b></span>
                                                                            </td>
                                                                            <td
                                                                                style="text-align:right;background-color: #f8dbee;">
                                                                                <span readonly type="text" size="3"
                                                                                    value="{{ $data->total_gaji }}"
                                                                                    wire:model='jumlah_gaji_lelaki'><b>{{ number_format($data->jumlah_gaji_lelaki, 2) }}</b></span>
                                                                            </td>
                                                                            <td
                                                                                style="text-align:right;background-color: #f8dbee;">
                                                                                <span readonly type="text" size="3"
                                                                                    value="{{ $data->total_gaji }}"
                                                                                    wire:model='jumlah_gaji_perempuan'><b>{{ number_format($data->jumlah_gaji_perempuan, 2) }}</b></span>
                                                                            </td>

                                                                            <td
                                                                                style="text-align:right;background-color: #f8dbee;">
                                                                                <span readonly type="text" size="3"
                                                                                    value="{{ $data->total_gaji }}"
                                                                                    wire:model='jumlah_gaji_perempuan'><b>{{ number_format($data->jumlah_lelaki_perempuan, 2) }}</b></span>
                                                                            </td>

                                                                            <td
                                                                                style="text-align:right;background-color: #f8dbee;">
                                                                                <span readonly type="text" size="3"
                                                                                    value="{{ $data->total_gaji }}"
                                                                                    wire:model='jumlah_total_lelaki'><b>{{ number_format($data->jumlah_total_lelaki, 2) }}</b></span>
                                                                            </td>
                                                                            <td
                                                                                style="text-align:right;background-color: #f8dbee;">
                                                                                <span readonly type="text" size="3"
                                                                                    value="{{ $data->total_gaji }}"
                                                                                    wire:model='jumlah_total_perempuan'><b>{{ number_format($data->jumlah_total_perempuan, 2) }}</b></span>
                                                                            </td>
                                                                            <td
                                                                                style="text-align:right;background-color: #f8dbee;">
                                                                                <span readonlytype="text" size="3"
                                                                                    value="{{ $data->total_gaji }}"
                                                                                    wire:model='jumlah_total_gaji'><b>{{ number_format($data->jumlah_total_gaji, 2) }}</b></span>
                                                                            </td>
                                                                        </tr>

                                                                    @endif
                                                                @empty

                                                                @endforelse


                                                            </table>
                                                            <br>

                                                        </div>
                                                    </div>

                                                </div>

                                                <hr>
                                                @if (auth()->user()->kategori_pengguna == 'PHD')



                                                    <div class="text-center form-group m-b-0">
                                                        {{-- <button type="submit" class="btn btn-primary" >Simpan</button> --}}
                                                        {{-- <button type="button" class="btn btn-primary">Kembali</button> --}}

                                                        <button type="button" class="btn btn-primary" alt="default"
                                                            data-toggle="modal" data-target="#responsive-modal-tidaklengkap"
                                                            class="model_img img-fluid">
                                                            TIDAK LENGKAP</button>

                                                        {{-- @if ($errors->isEmpty()) --}}
                                                        <button type="button" class="btn btn-primary" alt="default"
                                                            data-toggle="modal" data-target="#confirmation_borang_a"
                                                            class="model_img img-fluid">
                                                            SIMPAN</button>

                                                        {{-- @else --}}
                                                        {{-- <button type="submit" class="btn btn-primary" disabled>RALAT</button> --}}
                                                        {{-- <button type="submit" class="btn btn-primary" >Simpan</button> --}}
                                                        {{-- @endif --}}
                                                    </div>

                                                    <form action="{{ route('update_status_form3B', $id) }}" method="post">
                                                        @csrf
                                                        <div class="modal fade" id="confirmation_borang_a" tabindex="-1"
                                                            role="dialog" aria-labelledby="confirmation_borang_aTitle"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
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
                                                                        <span class="text-center"><b>Adakah anda pasti ingin
                                                                            mengesahkan borang ini?</b></span>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger"
                                                                            data-dismiss="modal">Batal</button>
                                                                        <input type="hidden" value="Dihantar ke IPJPSM"
                                                                            name="status">

                                                                        <button type="submit"
                                                                            class="btn btn-success">SIMPAN</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>


                                                    <div id="responsive-modal-tidaklengkap" class="modal fade"
                                                        tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                        aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header"
                                                                    style="justify-content:center;background-color:#f3ce8f">
                                                                    <h4><b>ULASAN PEGAWAI HUTAN DAERAH</b></h4>

                                                                    {{-- <button type="button" class="close"
                                                            data-dismiss="modal" aria-hidden="true">×</button> --}}
                                                                </div>
                                                                <form action="{{ route('update_status_form3B', $id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <div class="modal-body" style="text-align: center">

                                                                        <input type="hidden" value="Tidak Lengkap"
                                                                            name="status">
                                                                        <textarea name="ulasan_phd" cols="50"
                                                                            rows="10"></textarea><br>
                                                                        <h6 style="text-align: center"><i><b>*Pegawai Hutan
                                                                                    yang tidak rendah daripada Penolong
                                                                                    Pegawai/Penolong Pegawai Hutan
                                                                                    Daerah/Penolong Pegawai Hutan
                                                                                    Jajahan</i></b></h6>
                                                                        <br>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" data-dismiss="modal"
                                                                            class="btn btn-danger waves-effect waves-light">Batal</button>
                                                                        <button type="submit" id="submit-button"
                                                                            class="btn btn-success waves-effect waves-light">SIMPAN</button>


                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>



                                                    {{-- <form action="{{ route('update_status_form3B',$id) }}" method="post">
                                                @csrf
                                            <div class="row"  style="text-align:center">
                                                <div class="col-md-12">
                                                    <p>
                                                        <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                            Ulasan PHD
                                                        </button>
                                                    </p>
                                                    <div class="collapse" id="collapseExample">
                                                        <div class="card card-body">
                                                            <textarea name="ulasan_phd" cols="30" rows="10"></textarea>
                                                        </div>
                                                        <fieldset class="radio">
                                                            <label for="radio1">
                                                                <input type="radio" id="radio1" name="status" value="Tidak Lengkap">&nbsp Tidak Lengkap
                                                            </label>
                                                        </fieldset>
                                                        <fieldset class="radio">
                                                            <label>
                                                                <input type="radio" name="status" value="Dihantar ke IPJPSM" >&nbsp Disahkan dan hantar ke IPJPSM
                                                            </label>
                                                        </fieldset>
                                                        <br>
                                                        <button type="submit" class="btn btn-primary">HANTAR</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form> --}}
                                                @elseif(auth()->user()->kategori_pengguna == 'BPE')
                                                    <div class="row" style="text-align:center">
                                                        <div class="col-md-12">
                                                            <p>
                                                                <button style="width:300px;" class="btn btn-success"
                                                                    type="button" data-toggle="collapse"
                                                                    data-target="#collapseExample1" aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    Ulasan PHD
                                                                </button>
                                                            </p>
                                                            <div class="collapse" id="collapseExample1">
                                                                @foreach ($ulasan_phd as $data)
                                                                    <div class="card card-body">
                                                                        <textarea name="ulasan_phd" value="" cols="30"
                                                                            rows="10" readonly
                                                                            disabled>{{ $data->ulasan }}</textarea>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <form action="{{ route('update_status_form3B_ipjpsm', $id) }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="row" style="text-align:center">
                                                            <div class="col-md-12">
                                                                <p>
                                                                    <button style="width:300px;" class="btn btn-success"
                                                                        type="button" data-toggle="collapse"
                                                                        data-target="#collapseExample" aria-expanded="false"
                                                                        aria-controls="collapseExample">
                                                                        Ulasan IPJPSM
                                                                    </button>
                                                                </p>
                                                                <div class="collapse" id="collapseExample">
                                                                    <div class="card card-body">
                                                                        <textarea name="ulasan_ipjpsm" cols="30"
                                                                            rows="10"></textarea>
                                                                    </div>
                                                                    <fieldset class="radio">
                                                                        <label for="radio1">
                                                                            <input type="radio" id="radio1" name="status"
                                                                                value="Tidak Lengkap">&nbsp Tidak Lengkap
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset class="radio">
                                                                        <label>
                                                                            <input type="radio" name="status"
                                                                                value="Lulus">&nbsp Diterima
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset class="radio">
                                                                        <label>
                                                                            <input type="radio" name="status"
                                                                                value="Gagal">&nbsp Tidak Diterima
                                                                        </label>
                                                                    </fieldset>
                                                                    <br>
                                                                    <button type="submit"
                                                                        class="btb btn-primary">SIMPAN</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                @endif
                                                <br>
                                                {{-- <div class="text-right form-group m-b-0">
                                                    <button type="button" class="btn btn-primary">Kembali</button>

                                                </div> --}}
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

                <style>
                    table,
                    th,
                    td {
                        border: 1px solid black;
                    }

                </style>

            @endsection
