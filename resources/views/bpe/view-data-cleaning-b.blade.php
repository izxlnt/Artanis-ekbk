@extends('layouts.layout-ipjpsm-nicepage')

@section('content')

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

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">
                <div class="rounded-lg card" style="border-color: #000000 !important;">
                    @if ($kilang_info->shuttle_type == '3')
                        <div class="card-header"
                            style="text-align:center; background-color: #ee8dcd !important; font-size: 130%; font-weight: bold;">
                            BORANG 3B - JUMLAH GUNA TENAGA PADA AKHIR BULAN
                        </div>
                    @elseif($kilang_info->shuttle_type=="4")
                        <div class="card-header"
                            style="text-align:center; background-color: #ee8dcd !important; font-size: 130%; font-weight: bold;">
                            BORANG 4B - JUMLAH GUNA TENAGA PADA AKHIR BULAN
                        </div>
                    @elseif($kilang_info->shuttle_type=="5")
                        <div class="card-header"
                            style="text-align:center; background-color: #ee8dcd !important; font-size: 130%; font-weight: bold;">
                            BORANG 5B - JUMLAH GUNA TENAGA PADA AKHIR BULAN
                        </div>
                    @endif

                    <div class="card-body">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <form wire:submit.prevent='update'>
                                @csrf


                            <div class="tab-pane active" id="hotel" role="tabpanel" aria-labelledby="hotel-tab"><br>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">

                                                    <div class="row"
                                                        style="justify-content: center;margin-bottom:-0%;">
                                                        <div class="col-md-2">
                                                            <label>Tahun:</label>
                                                            <span type="text" class="form-control"
                                                                style="background-color: #ee8dcd; border-color: #e030a6"
                                                                value="{{ $kilang_info->tahun }}"
                                                                readonly />{{ $kilang_info->tahun }}</span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label>Suku Tahun:</label>
                                                            @if ($formb->suku_tahun <= '1')
                                                                <input type="text" class="form-control"
                                                                style="background-color: #ee8dcd; border-color: #e030a6"
                                                                    value="Pertama (Mac)" readonly />

                                                            @elseif($formb->suku_tahun <= '2' ) <input type="text" class="form-control"
                                                            style="background-color: #ee8dcd; border-color: #e030a6"
                                                                    value="Kedua (Jun)" readonly />
                                                            @elseif($formb->suku_tahun <= '3' ) <input type="text" class="form-control"
                                                            style="background-color: #ee8dcd; border-color: #e030a6"
                                                                    value="Ketiga (September)" readonly />
                                                            @elseif($formb->suku_tahun <= '4' )
                                                            <input type="text" class="form-control"
                                                            style="background-color: #ee8dcd; border-color: #e030a6"
                                                                    value="Keempat (Disember)" readonly />
                                                            @else
                                                                <input type="text" class="form-control"
                                                                style="background-color: #ee8dcd; border-color: #e030a6"
                                                                    value="Tiada Data" readonly />
                                                            @endif
                                                        </div>


                                                        <div class="col-md-3">
                                                            <label>Nama Kilang:</label>

                                                            <span type="text" class="form-control"
                                                                style="background-color: #ee8dcd;border-color: #e030a6"
                                                                value="{{ $kilang_info->nama_kilang }}" readonly />
                                                            {{ $kilang_info->nama_kilang }}</span>

                                                        </div>
                                                        <div class="col-md-2">

                                                            <label>No. Pendaftaran Syarikat (SSM):</label>


                                                            <span type="text" class="form-control"
                                                                style="background-color: #ee8dcd;border-color: #e030a6"
                                                                value="{{ $kilang_info->no_ssm }}" readonly />
                                                            {{ $kilang_info->no_ssm }}</span>

                                                        </div>



                                                        <div class="col-md-2">
                                                            <label>No. Lesen:</label>

                                                            <span type="text" class="form-control"
                                                                style="background-color: #ee8dcd;border-color: #e030a6"
                                                                value="{{ $kilang_info->no_lesen }}" readonly />
                                                            {{ $kilang_info->no_lesen }}</span>


                                                        </div>
                                                    </div>
                                                    <br>
                                                    <br>



                                                    <div class="table-responsive">
                                                        <table style="width: 100%;">

                                                            <tr style="height:50px;">
                                                                <th style="text-align:center;" colspan="2" rowspan="4">
                                                                    Kategori Pekerja
                                                                </th>
                                                                <th style="text-align:center;" colspan="8">Warganegara
                                                                    Malaysia</th>
                                                                <th style="text-align:center;" colspan="4" rowspan="3">
                                                                    Bukan Warganegara
                                                                    Malaysia</th>
                                                                <th style="text-align:center;" colspan="6" rowspan="3">
                                                                    Jumlah Pekerja</th>
                                                                <th style="text-align:center;" colspan="6" rowspan="3">
                                                                    Bayaran Gaji dan Upah
                                                                    Per Pekerja (Sebulan) (RM/ bulan/ pekerja)</th>
                                                                <th style="text-align:center;" colspan="6" rowspan="3">
                                                                    Jumlah Bayaran Gaji
                                                                    dan Upah (Sebulan) (RM)</th>
                                                            </tr>
                                                            <tr style="height:50px;">
                                                                <th style="text-align:center;" colspan="4" rowspan="2">
                                                                    Bumiputera</th>
                                                                <th style="text-align:center;" colspan="4" rowspan="2">
                                                                    Bukan Bumiputera</th>
                                                            </tr>
                                                            <tr style="height:50px;">

                                                            </tr>
                                                            <tr style="height:50px;">
                                                                <th style="text-align:center;">L</th>
                                                                <th style="text-align:center;">L</th>
                                                                <th style="text-align:center;">P</th>
                                                                <th style="text-align:center;">P</th>
                                                                <th style="text-align:center;">L</th>
                                                                <th style="text-align:center;">L</th>
                                                                <th style="text-align:center;">P</th>
                                                                <th style="text-align:center;">P</th>
                                                                <th style="text-align:center;">L</th>
                                                                <th style="text-align:center;">L</th>
                                                                <th style="text-align:center;">P</th>
                                                                <th style="text-align:center;">P</th>
                                                                <th style="text-align:center;">L</th>
                                                                <th style="text-align:center;">L</th>
                                                                <th style="text-align:center;">P</th>
                                                                <th style="text-align:center;">P</th>
                                                                <th style="text-align:center;">L+P</th>
                                                                <th style="text-align:center;">L+P</th>
                                                                <th style="text-align:center;">L</th>
                                                                <th style="text-align:center;">L</th>
                                                                <th style="text-align:center;">P</th>
                                                                <th style="text-align:center;">P</th>
                                                                <th style="text-align:center;">L+P</th>
                                                                <th style="text-align:center;">L+P</th>
                                                                <th style="text-align:center;">L</th>
                                                                <th style="text-align:center;">L</th>
                                                                <th style="text-align:center;">P</th>
                                                                <th style="text-align:center;">P</th>
                                                                <th style="text-align:center;">L+P</th>
                                                                <th style="text-align:center;">L+P</th>
                                                            </tr>

                                                            <tr style="height:50px;">
                                                                <th style="text-align:center;" colspan="2">(01)</th>
                                                                <th style="text-align:center;">(02)</th>
                                                                <th style="text-align:center;">(02)</th>
                                                                <th style="text-align:center;">(03)</th>
                                                                <th style="text-align:center;">(03)</th>
                                                                <th style="text-align:center;">(04)</th>
                                                                <th style="text-align:center;">(04)</th>
                                                                <th style="text-align:center;">(05)</th>
                                                                <th style="text-align:center;">(05)</th>
                                                                <th style="text-align:center;">(06)</th>
                                                                <th style="text-align:center;">(06)</th>
                                                                <th style="text-align:center;">(07)</th>
                                                                <th style="text-align:center;">(07)</th>
                                                                <th style="text-align:center;">(08)=(02)+(04)+(06)</th>
                                                                <th style="text-align:center;">(08)=(02)+(04)+(06)</th>
                                                                <th style="text-align:center;">(09)=(03)+(05)+(07)</th>
                                                                <th style="text-align:center;">(09)=(03)+(05)+(07)</th>
                                                                <th style="text-align:center;">(10)=(08)+(09)</th>
                                                                <th style="text-align:center;">(10)=(08)+(09)</th>
                                                                <th style="text-align:center;">(11)</th>
                                                                <th style="text-align:center;">(11)</th>
                                                                <th style="text-align:center;">(12)</th>
                                                                <th style="text-align:center;">(12)</th>
                                                                <th style="text-align:center;">(13)=(11)+(12)</th>
                                                                <th style="text-align:center;">(13)=(11)+(12)</th>
                                                                <th style="text-align:center;">(14)=(08)*(11)</th>
                                                                <th style="text-align:center;">(14)=(08)*(11)</th>
                                                                <th style="text-align:center;">(15)=(09)*(12)</th>
                                                                <th style="text-align:center;">(15)=(09)*(12)</th>
                                                                <th style="text-align:center;">(16)=(14)+(15)</th>
                                                                <th style="text-align:center;">(16)=(14)+(15)</th>
                                                            </tr>

                                                            @forelse($form_b as $key=>$data)
                                                                <tr style="height:50px;">

                                                                    <td style="text-align:left;">
                                                                        {{ $data->kategori_guna_tenaga->keterangan }}
                                                                    </td>
                                                                    <td style="text-align:center;width:30px;">
                                                                        {{ $i = $loop->iteration }}</td>
                                                                    <td style="text-align:right;padding:5px;background-color: #b8d0f5;"><span
                                                                            type="text" size="5"
                                                                            value="{{ $data->pekerja_wargabumi_lelaki }}"
                                                                            wire:model='pekerja_wargabumi_lelaki.{{ $key }}'
                                                                            onkeypress="return isNumberKey(event)">{{ $data->pekerja_wargabumi_lelaki }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="text-align:right;padding:5px;background-color: #e3d3f1;">
                                                                            {{number_format($data->pekerja_wargabumi_lelaki_cleaning ?? 0) }}
                                                                    </td>

                                                                    <td style="text-align:right;padding:5px;background-color: #b8d0f5;"><span
                                                                            type="text" size="5"
                                                                            value="{{ $data->pekerja_wargabumi_perempuan ?? 0 }}"
                                                                            wire:model='pekerja_wargabumi_perempuan.{{ $key }}'
                                                                            onkeypress="return isNumberKey(event)">{{ $data->pekerja_wargabumi_perempuan }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="text-align:right;padding:5px;background-color: #e3d3f1;">
                                                                            {{ number_format($data->pekerja_wargabumi_perempuan_cleaning ?? 0) }}
                                                                        </td>


                                                                    <td style="text-align:right;padding:5px;background-color: #b8d0f5;"><span
                                                                            type="text" size="5"
                                                                            value="{{ $data->pekerja_bukan_wargabumi_lelaki }}"
                                                                            wire:model='pekerja_bukan_wargabumi_lelaki.{{ $key }}'
                                                                            onkeypress="return isNumberKey(event)">{{ $data->pekerja_bukan_wargabumi_lelaki }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="text-align:right;padding:5px;background-color: #e3d3f1;">

                                                                            {{ number_format($data->pekerja_bukan_wargabumi_lelaki_cleaning ?? 0) }}
                                                                        </td>


                                                                    <td style="text-align:right;padding:5px;background-color: #b8d0f5;"><span
                                                                            type="text" size="5"
                                                                            value="{{ $data->pekerja_bukan_wargabumi_perempuan }}"
                                                                            wire:model='pekerja_bukan_wargabumi_perempuan.{{ $key }}'
                                                                            onkeypress="return isNumberKey(event)">{{ $data->pekerja_bukan_wargabumi_perempuan }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="text-align:right;padding:5px;background-color: #e3d3f1;">

                                                                            {{ number_format($data->pekerja_bukan_wargabumi_perempuan_cleaning ?? 0 )}}
                                                                        </td>


                                                                    <td style="text-align:right;background-color: #b8d0f5;"><span type="text"
                                                                            size="5"
                                                                            value="{{ $data->pekerja_asing_lelaki }}"
                                                                            wire:model='pekerja_asing_lelaki.{{ $key }}'
                                                                            onkeypress="return isNumberKey(event)">{{ $data->pekerja_asing_lelaki }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="text-align:right;padding:5px;background-color: #e3d3f1;">

                                                                            {{ number_format($data->pekerja_asing_lelaki_cleaning ?? 0 )}}
                                                                        </td>


                                                                    <td style="text-align:right;background-color: #b8d0f5;"><span type="text"
                                                                            size="5"
                                                                            value="{{ $data->pekerja_asing_perempuan }}"
                                                                            wire:model='pekerja_asing_perempuan.{{ $key }}'
                                                                            onkeypress="return isNumberKey(event)">{{ $data->pekerja_asing_perempuan }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="text-align:right;padding:5px;background-color: #e3d3f1;">

                                                                            {{ number_format($data->pekerja_asing_perempuan_cleaning ?? 0) }}
                                                                        </td>


                                                                    <td
                                                                        style="text-align:right;background-color: #b8d0f5;">
                                                                        <span readonly type="text"
                                                                            value="{{ $data->jumlah_lelaki }}"
                                                                            size="5"
                                                                            wire:model='jumlah_lelaki.{{ $key }}'
                                                                            onkeypress="return isNumberKey(event)">{{ $data->jumlah_lelaki }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="text-align:right;padding:5px;background-color: #dd7d54;">

                                                                            {{number_format($data->jumlah_lelaki_cleaning ?? 0)  }}
                                                                        </td>


                                                                    <td
                                                                        style="text-align:right;background-color: #b8d0f5;">
                                                                        <span readonly type type="text"
                                                                            value="{{ $data->jumlah_perempuan }}"
                                                                            size="5"
                                                                            wire:model='jumlah_perempuan.{{ $key }}'
                                                                            onkeypress="return isNumberKey(event)">{{ $data->jumlah_perempuan }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="text-align:right;padding:5px;background-color: #dd7d54;">

                                                                            {{ number_format($data->jumlah_perempuan_cleaning ?? 0) }}
                                                                        </td>


                                                                    <td
                                                                        style="text-align:right;background-color: #b8d0f5;">
                                                                        <span readonly type type="text"
                                                                            value="{{ $data->jumlah_pekerja }}"
                                                                            size="5"
                                                                            wire:model='jumlah_pekerja.{{ $key }}'
                                                                            onkeypress="return isNumberKey(event)">{{ $data->jumlah_pekerja }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="text-align:right;padding:5px;background-color: #dd7d54;">

                                                                            {{ number_format($data->jumlah_pekerja_cleaning ?? 0) }}
                                                                        </td>


                                                                    <td style="text-align:right;background-color: #b8d0f5;"><span type="text"
                                                                            size="5" value="{{ $data->gaji_lelaki }}"
                                                                            wire:model='gaji_lelaki.{{ $key }}'
                                                                            wire:change="calcJumlahPekerjaLelakiCleaning({{ $key }})"
                                                                            onkeypress="return isNumberKey(event)">{{ number_format($data->gaji_lelaki, 2) }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="text-align:right;padding:5px;background-color: #e3d3f1;">

                                                                            {{ number_format($data->gaji_lelaki_cleaning ?? 0 ,2) }}
                                                                        </td>


                                                                    <td style="text-align:right;background-color: #b8d0f5;"><span type="text"
                                                                            size="5"
                                                                            value="{{ $data->gaji_perempuan }}"
                                                                            wire:model='gaji_perempuan.{{ $key }}'
                                                                            wire:change="calcJumlahPekerjaPerempuanCleaning({{ $key }})"
                                                                            onkeypress="return isNumberKey(event)">{{ number_format($data->gaji_perempuan, 2) }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="text-align:right;padding:5px;background-color: #e3d3f1;">

                                                                            {{number_format($data->gaji_perempuan_cleaning ?? 0 ,2)  }}
                                                                        </td>


                                                                    <td
                                                                        style="text-align:right;background-color: #b8d0f5;">
                                                                        <span type="text" size="5" value=""
                                                                            wire:model='gaji_lelaki_perempuan.{{ $key }}'
                                                                            wire:change="calcJumlahPekerjaLelakiCleaning({{ $key }})"
                                                                            onkeypress="return isNumberKey(event)">{{ number_format($data->gaji_lelaki_perempuan, 2) }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="text-align:right;padding:5px;background-color: #dd7d54;">

                                                                            {{ number_format($data->gaji_lelaki_perempuan_cleaning ?? 0 , 2) }}
                                                                        </td>


                                                                    <td style="text-align:right;background-color: #b8d0f5;"><span type="text"
                                                                            size="5"
                                                                            wire:model='total_gaji_lelaki.{{ $key }}'
                                                                            value="{{ $data->total_gaji_lelaki }}"
                                                                            wire:change="calcJumlahPekerjaLelakiCleaning({{ $key }})"
                                                                            onkeypress="return isNumberKey(event)">{{ number_format($data->total_gaji_lelaki, 2) }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="text-align:right;padding:5px;background-color: #dd7d54;">

                                                                            {{ number_format($data->total_gaji_lelaki_cleaning ?? 0 , 2) }}
                                                                        </td>


                                                                    <td style="text-align:right;background-color: #b8d0f5;"><span type="text"
                                                                            size="5"
                                                                            wire:model='total_gaji_perempuan.{{ $key }}'
                                                                            value="{{ $data->total_gaji_perempuan }}"
                                                                            wire:change="calcJumlahPekerjaPerempuanCleaning({{ $key }})"
                                                                            onkeypress="return isNumberKey(event)">{{ number_format($data->total_gaji_perempuan, 2) }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="text-align:right;padding:5px;background-color: #dd7d54;">

                                                                            {{ number_format($data->total_gaji_perempuan_cleaning ?? 0 , 2) }}
                                                                        </td>


                                                                    <td
                                                                        style="text-align:right;background-color: #b8d0f5;">
                                                                        <span readonly type="text" size="5"
                                                                            value="{{ $data->total_gaji }}"
                                                                            wire:model='total_gaji.{{ $key }}'>{{ number_format($data->total_gaji, 2) }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="text-align:right;padding:5px;background-color: #dd7d54;">

                                                                            {{ number_format($data->total_gaji_cleaning ?? 0 , 2) }}
                                                                        </td>


                                                                </tr>
                                                                @if ($loop->last)
                                                                    <tr style="height:50px;">
                                                                        <td style="text-align:center;"><b>Jumlah</b>
                                                                        </td>
                                                                        <td style="text-align:center;"
                                                                            style="width:20px">
                                                                            {{ $i = $i + 1 }}</td>
                                                                        <td
                                                                            style="text-align:right;background-color: #b8d0f5;">
                                                                            <span readonly type="text" size="5"
                                                                                value="{{ $data->total_bumi_lelaki }}">{{ $data->total_bumi_lelaki }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;padding:5px;background-color: #e3d3f1;">

                                                                                {{ number_format($data->total_bumi_lelaki_cleaning ?? 0) }}
                                                                        </td>

                                                                        <td
                                                                            style="text-align:right;background-color: #b8d0f5;">
                                                                            <span readonly type="text" size="5"
                                                                                value="{{ $data->total_bumi_perempuan }}">{{ $data->total_bumi_perempuan }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;padding:5px;background-color: #e3d3f1;">

                                                                                {{ number_format($data->total_bumi_perempuan_cleaning ?? 0) }}
                                                                        </td>

                                                                        <td
                                                                            style="text-align:right;background-color: #b8d0f5;">
                                                                            <span readonly type="text" size="5"
                                                                                value="{{ $data->total_bukanbumi_lelaki }}"
                                                                                wire:model='total_bukanbumi_lelaki'>{{ $data->total_bukanbumi_lelaki }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;padding:5px;background-color: #e3d3f1;">

                                                                                {{ number_format($data->total_bukanbumi_lelaki_cleaning ?? 0) }}
                                                                        </td>

                                                                        <td
                                                                            style="text-align:right;background-color: #b8d0f5;">
                                                                            <span readonly type="text" size="5"
                                                                                value="{{ $data->total_bukanbumi_perempuan }}"
                                                                                wire:model='total_bukanbumi_perempuan'>{{ $data->total_bukanbumi_perempuan }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;padding:5px;background-color: #e3d3f1;">

                                                                                {{ number_format($data->total_bukanbumi_perempuan_cleaning ?? 0) }}
                                                                        </td>

                                                                        <td
                                                                            style="text-align:right;background-color: #b8d0f5;">
                                                                            <span readonly type="text" size="5"
                                                                                value="{{ $data->total_gaji }}"
                                                                                wire:model='total_asing_lelaki'>{{ $data->total_asing_lelaki }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;padding:5px;background-color: #e3d3f1;">

                                                                                {{ number_format($data->total_asing_lelaki_cleaning ?? 0) }}
                                                                        </td>

                                                                        <td
                                                                            style="text-align:right;background-color: #b8d0f5;">
                                                                            <span readonly type="text" size="5"
                                                                                value="{{ $data->total_gaji }}"
                                                                                wire:model='total_asing_perempuan'>{{ $data->total_asing_perempuan }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;padding:5px;background-color: #e3d3f1;">

                                                                                {{ number_format($data->total_asing_perempuan_cleaning ?? 0) }}
                                                                        </td>

                                                                        <td
                                                                            style="text-align:right;background-color: #b8d0f5;">
                                                                            <span readonly type="text" size="5"
                                                                                value="{{ $data->total_gaji }}"
                                                                                wire:model='total_pekerja_lelaki'>{{ $data->total_pekerja_lelaki }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;padding:5px;background-color: #dd7d54;">

                                                                                {{ number_format($data->total_pekerja_lelaki_cleaning ?? 0) }}
                                                                        </td>

                                                                        <td
                                                                            style="text-align:right;background-color: #b8d0f5;">
                                                                            <span readonly type="text" size="5"
                                                                                value="{{ $data->total_gaji }}"
                                                                                wire:model='total_pekerja_perempuan'>{{ $data->total_pekerja_perempuan }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;padding:5px;background-color: #dd7d54;">

                                                                                {{ number_format($data->total_pekerja_perempuan_cleaning ?? 0) }}
                                                                        </td>

                                                                        <td
                                                                            style="text-align:right;background-color: #b8d0f5;">
                                                                            <span readonly type="text" size="5"
                                                                                value="{{ $data->total_gaji }}"
                                                                                wire:model='total_pekerja'>{{ $data->total_pekerja }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;padding:5px;background-color: #dd7d54;">

                                                                                {{ number_format($data->total_pekerja_cleaning ?? 0) }}
                                                                        </td>

                                                                        <td
                                                                            style="text-align:right;background-color: #b8d0f5;">
                                                                            <span readonly type="text" size="5"
                                                                                value="{{ $data->total_gaji }}"
                                                                                wire:model='jumlah_gaji_lelaki'>{{ number_format($data->jumlah_gaji_lelaki, 2) }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;padding:5px;background-color: #e3d3f1;">

                                                                                {{ number_format($data->jumlah_gaji_lelaki_cleaning ?? 0 ,2) }}
                                                                        </td>

                                                                        <td
                                                                            style="text-align:right;background-color: #b8d0f5;">
                                                                            <span readonly type="text" size="5"
                                                                                value="{{ $data->total_gaji }}"
                                                                                wire:model='jumlah_gaji_perempuan'>{{ number_format($data->jumlah_gaji_perempuan, 2) }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;padding:5px;background-color: #e3d3f1;">

                                                                                {{ number_format($data->jumlah_gaji_perempuan_cleaning ?? 0 , 2) }}
                                                                        </td>

                                                                        <td
                                                                            style="text-align:right;background-color: #b8d0f5;">
                                                                            <span readonly type="text" size="5"
                                                                                value="{{ $data->total_gaji }}"
                                                                                wire:model='jumlah_gaji_perempuan'>{{ number_format($data->jumlah_lelaki_perempuan, 2) }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;padding:5px;background-color: #dd7d54;">

                                                                                {{ number_format($data->jumlah_lelaki_perempuan_cleaning ?? 0 , 2) }}
                                                                        </td>

                                                                        <td
                                                                            style="text-align:right;background-color: #b8d0f5;">
                                                                            <span readonly type="text" size="5"
                                                                                value="{{ $data->total_gaji }}"
                                                                                wire:model='jumlah_total_lelaki'>{{ number_format($data->jumlah_total_lelaki, 2) }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;padding:5px;background-color: #dd7d54;">

                                                                                {{ number_format($data->jumlah_total_lelaki_cleaning ?? 0 , 2 )}}
                                                                        </td>

                                                                        <td
                                                                            style="text-align:right;background-color: #b8d0f5;">
                                                                            <span readonly type="text" size="5"
                                                                                value="{{ $data->total_gaji }}"
                                                                                wire:model='jumlah_total_perempuan'>{{ number_format($data->jumlah_total_perempuan, 2) }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;padding:5px;background-color: #dd7d54;">

                                                                                {{ number_format($data->jumlah_total_perempuan_cleaning ?? 0 , 2) }}
                                                                        </td>

                                                                        <td
                                                                            style="text-align:right;background-color: #b8d0f5;">
                                                                            <span readonlytype="text" size="5"
                                                                                value="{{ $data->total_gaji }}"
                                                                                wire:model='jumlah_total_gaji'>{{ number_format($data->jumlah_total_gaji, 2) }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;padding:5px;background-color: #dd7d54;">

                                                                                {{ number_format($data->jumlah_total_gaji_cleaning ?? 0 , 2) }}
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

                                            {{-- <form action="{{ route('update_status_form3B_ipjpsm',$id) }}" method="post"> --}}
                                            <div class="row" style="text-align:center">
                                                <div class="col-md-12">
                                                    <label>
                                                        <input type="hidden" wire:model="status">
                                                    </label>


                                                    <br>
                                                    {{-- <button type="button" class="btn btn-primary" alt="default"
                                                        data-toggle="modal" data-target="#confirmation_borang_a">
                                                        DIPERAKU</button> --}}

                                                </div>
                                            </div>


                                            <div class="modal fade" id="confirmation_borang_a" tabindex="-1"
                                                role="dialog" aria-labelledby="confirmation_borang_aTitle"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header"
                                                            style="background-color:#f3ce8f  !important">
                                                            <h5 class="modal-title " id="exampleModalLongTitle"><i
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
                                                                memperaku borang ini?</b></span>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Batal</button>
                                                            <button type="submit"
                                                                class="btn btn-success">PERAKU</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <br>
                                        </div>
                                    </div>
                                </div>

                                </table>
                            </form>

                        </div>
                    </div>









                </div>



                <!-- ============================================================== -->
                <!-- End Container fluid  -->
                <!-- ============================================================== -->


            </div>
        </div>
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
