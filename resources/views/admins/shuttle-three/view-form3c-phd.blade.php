@extends('layouts.layout-phd-nicepage')




@section('content')

<style>
    table,
    th,
    td {
        border: 1px solid black;
    }

    th {
        overflow: auto;
        /* height: 100px; */
        width: 200px;
    }

    thead th {
        position: sticky;
        top: 0;
        z-index: 1;
    }

    tbody th {
        position: sticky;
        left: 0;
    }

    /* Just common table stuff. Really. */
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        padding: 8px 8px;
    }

    th {
        background: #eee;
    }

    thead,
    tbody {
        display: block;
    }

    tbody {
        height: 500px;
        /* Just for the demo          */
        overflow-y: auto;
        /* Trigger vertical scroll    */
        overflow-x: hidden;
        /* Hide the horizontal scroll */
        width: 1600px;
    }

    ::-webkit-scrollbar {
        width: 10px;
        /* height: 2em */
    }

</style>

<div>
    <div>
        <div>

            <div class="container-fluid">

                <div class="row">

                    <div class="col-md-12">

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

                        <div class="rounded-lg card" style="border-color: #000000 !important;">
                            @if($kilang_info->shuttle_type=="3")
                            <div class="card-header"
                                style="text-align:center; background-color: #f0e10dbd !important; font-size: 130%; font-weight: bold;">
                                BORANG 3C - PENYATA KEMASUKAN & PEMPROSESAN KAYU BALAK DAN PENGELUARAN KAYU
                                        GERGAJI MENGIKUT KUMPULAN KAYU-KAYAN

                            </div>
                            @elseif($kilang_info->shuttle_type=="4")
                            <div class="card-header"
                                style="text-align:center; background-color: #f0e10dbd !important; font-size: 130%; font-weight: bold;">
                                BORANG 4C - PENYATA KEMASUKAN & PEMPROSESAN KAYU BALAK MENGIKUT KUMPULAN KAYU-KAYAN


                            </div>
                            @elseif($kilang_info->shuttle_type=="5")
                            <div class="card-header"
                                style="text-align:center; background-color: #f0e10dbd !important; font-size: 130%; font-weight: bold;">
                                BORANG 5C - PENYATA KEMASUKAN & PEMPROSESAN KAYU GERGAJI DAN PENGELUARAN KAYU
                                        KUMAI MENGIKUT KUMPULAN KAYU-KAYAN
                            </div>
                            @endif
                            <div class="card-body">

                                    <div class="tab-content">
                                        <div class="tab-pane active" id="hotel" role="tabpanel" aria-labelledby="hotel-tab">
                                            <br>
                                            <div class="">
                                                <table class="table table-striped table-bordered" id=""
                                                    style="width: 100%;">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card">


                                                                <div class="card-body">

                                                                    <div class="row"
                                                                        style="justify-content: center;margin-bottom:-0%;">
                                                                        <div class="col-md-2">
                                                                            <label>Tahun:</label>
                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #e0ec3754; border-color:#f0e10dbd;"
                                                                                value="{{ $formc->tahun }}" readonly />
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label>Bulan:</label>
                                                                            @if ($formc->bulan <= '1')

                                                                                <input type="text" class="form-control"
                                                                                    style="background-color: #e0ec3754; border-color:#f0e10dbd;"
                                                                                    value="Januari" readonly />
                                                                            @elseif($formc->bulan
                                                                                <= '2' ) <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #e0ec3754; border-color:#f0e10dbd;"
                                                                                    value="Februari" readonly />
                                                                            @elseif($formc->bulan
                                                                                <= '3' ) <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #e0ec3754; border-color:#f0e10dbd;"
                                                                                    value="Mac" readonly />
                                                                            @elseif($formc->bulan
                                                                                <= '4' ) <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #e0ec3754; border-color:#f0e10dbd;"
                                                                                    value="April" readonly />
                                                                            @elseif($formc->bulan
                                                                                <= '5' ) <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #e0ec3754; border-color:#f0e10dbd;"
                                                                                    value="Mei" readonly />
                                                                            @elseif($formc->bulan
                                                                                <= '6' ) <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #e0ec3754; border-color:#f0e10dbd;"
                                                                                    value="Jun" readonly />
                                                                            @elseif($formc->bulan
                                                                                <= '7' ) <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #e0ec3754; border-color:#f0e10dbd;"
                                                                                    value="Julai" readonly />
                                                                            @elseif($formc->bulan
                                                                                <= '8' ) <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #e0ec3754; border-color:#f0e10dbd;"
                                                                                    value="Ogos" readonly />
                                                                            @elseif($formc->bulan
                                                                                <= '9' ) <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #e0ec3754; border-color:#f0e10dbd;"
                                                                                    value="September" readonly />
                                                                            @elseif($formc->bulan
                                                                                <= '10' ) <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #e0ec3754; border-color:#f0e10dbd;"
                                                                                    value="Oktober" readonly />
                                                                            @elseif($formc->bulan
                                                                                <= '11' ) <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #e0ec3754; border-color:#f0e10dbd;"
                                                                                    value="November" readonly />
                                                                            @elseif($formc->bulan
                                                                                <= '12' ) <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #e0ec3754; border-color:#f0e10dbd;"
                                                                                    value="Disember" readonly />
                                                                            @endif
                                                                        </div>



                                                                        <div class="col-md-3">
                                                                            <label>Nama Kilang:</label>
                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #e0ec3754; border-color:#f0e10dbd;"
                                                                                value="{{ $formc->nama_kilang }}"
                                                                                readonly />

                                                                        </div>
                                                                        <div class="col-md-2">

                                                                            <label>No. Pendaftaran Syarikat (SSM): </label>
                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #e0ec3754; border-color:#f0e10dbd;"
                                                                                value="{{ $formc->no_ssm }}" readonly />

                                                                        </div>


                                                                        <div class="col-md-2">
                                                                            <label>No. Lesen:</label>
                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #e0ec3754; border-color:#f0e10dbd;"
                                                                                value="{{ $formc->no_lesen }}" readonly />


                                                                        </div>
                                                                    </div>

                                                                    <table>
                                                                        <thead class="">
                                                                            @if($kilang_info->shuttle_type == '3')
                                                                <tr style="height:50px;">
                                                                    <th style="text-align:center; width: 389px;"
                                                                        colspan="2">Kumpulan Kayu Kayan</th>
                                                                    <th style="text-align:center;" colspan="2">Baki Stok
                                                                        Dari Bulan
                                                                        Lepas</th>
                                                                    <th style="text-align:center;" colspan="2">Kemasukan
                                                                        Kayu Balak Ke
                                                                        Dalam Kawasan Kilang</th>
                                                                    <th style="text-align:center;" colspan="2">Jumlah
                                                                        Stok Kayu Balak
                                                                    </th>
                                                                    <th style="text-align:center;" colspan="2">Kemasukan
                                                                        Kayu Balak Ke
                                                                        Dalam Jentera Memproses</th>
                                                                    <th style="text-align:center;" colspan="2">
                                                                        Pengeluaran Kayu Gergaji
                                                                        Daripada Jentera Memproses</th>
                                                                    <th style="text-align:center;" colspan="2">Baki Stok
                                                                        Kayu Balak
                                                                        Dibawa Ke Bulan Hadapan</th>
                                                                </tr>
                                                                @elseif($kilang_info->shuttle_type == '5')
                                                                <tr style="height:50px;">
                                                                    <th style="text-align:center; width: 389px;"
                                                                        colspan="2">Kumpulan Kayu Kayan</th>
                                                                    <th style="text-align:center;" colspan="2">Baki Stok
                                                                        Dari Bulan
                                                                        Lepas</th>
                                                                    <th style="text-align:center;" colspan="2">Kemasukan
                                                                        Kayu Gergaji Ke
                                                                        Dalam Kawasan Kilang</th>
                                                                    <th style="text-align:center;" colspan="2">Jumlah
                                                                        Stok Kayu Gergaji
                                                                    </th>
                                                                    <th style="text-align:center;" colspan="2">Kemasukan
                                                                        Kayu Gergaji Ke
                                                                        Dalam Jentera Memproses</th>
                                                                    <th style="text-align:center;" colspan="2">
                                                                        Pengeluaran Kayu Kumai</th>
                                                                    <th style="text-align:center;" colspan="2">Baki Stok
                                                                        Kayu Gergaji
                                                                        Dibawa Ke Bulan Hadapan</th>

                                                                </tr>
                                                                @endif

                                                                            <tr style="height:50px;">
                                                                                <th style="text-align:center;" colspan="2">(01)</th>
                                                                                <th style="text-align:center;" colspan="2">(&#x33A5;)<br>(02)</th>
                                                                                <th style="text-align:center;" colspan="2">(&#x33A5;)<br>(03)</th>
                                                                                <th style="text-align:center;" colspan="2">(&#x33A5;)<br>(04)=(02)+(03)</th>
                                                                                <th style="text-align:center;" colspan="2">(&#x33A5;)<br>(05)</th>
                                                                                <th style="text-align:center;" colspan="2">(&#x33A5;)<br>(06)</th>
                                                                                <th style="text-align:center;" colspan="2">(&#x33A5;)<br>(07)=(04)-(05)</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody class="">
                                                                            @foreach ($kumpulan_kayu as $keyKumpulanKayu=>$data)
                                                                            <tr style="height:50px;">
                                                                                <th style="text-align:left;width: 289px;">{{ $data->singkatan }} </th>
                                                                                <th style="text-align:center;width:100px;">Kod</th>
                                                                                <th colspan="2"></th>
                                                                                <th colspan="2"></th>
                                                                                <th colspan="2"></th>
                                                                                <th colspan="2"></th>
                                                                                <th colspan="2"></th>
                                                                                <th colspan="2"></th>
                                                                            </tr>

                                                                            @foreach ($species as $keySpecies=>$data1)

                                                                                @if($data1->kumpulan_kayu->singkatan == $data->singkatan)

                                                                                    <tr style="height:50px;">
                                                                                        <td style="text-align:left;">{{ $data1->nama_tempatan }}</td>
                                                                                        <td style="text-align:center;">{{ $data1->kod }}</td>
                                                                                        <td style="text-align:center;" colspan="2"><input readonly type="text" size="10" style="background-color: #e0ec3754;text-align:right" value="{{ number_format($form_c[$keySpecies]->baki_stok,2) }}" wire:change="calcJumlahBakiStok({{ $keySpecies}}, {{ $keyKumpulanKayu }}, '{{ $data->singkatan }}');" onkeypress="return isNumberKey(event)"></td>
                                                                                        <td style="text-align:center;" colspan="2"><input readonly type="text" size="10" style="background-color: #ffffff;text-align:right" value="{{ number_format($form_c[$keySpecies]->kayu_masuk,2) }}" wire:model='kayu_masuk.{{ $keySpecies }}' wire:change="calcJumlahKayuMasuk({{ $keySpecies}}, {{ $keyKumpulanKayu }}, '{{ $data->singkatan }}');" onkeypress="return isNumberKey(event)"></td>
                                                                                        <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" value="{{ number_format($form_c[$keySpecies]->jumlah_stok_kayu_balak,2) }}" wire:model='jumlah_stok_kayu_balak.{{ $keySpecies }}' wire:change="calcTotalStokKayuDibawaBulanHadapan({{ $keySpecies}}, {{ $keyKumpulanKayu }}, '{{ $data->singkatan }}');"></td>
                                                                                        <td style="text-align:center;" colspan="2"><input readonly type="text" size="10" style="background-color: #ffffff;text-align:right" value="{{ number_format($form_c[$keySpecies]->proses_masuk,2) }}" wire:model='proses_masuk.{{ $keySpecies }}' wire:change="calcBakiStok({{ $keySpecies}}, {{ $keyKumpulanKayu }}, '{{ $data->singkatan }}');" onkeypress="return isNumberKey(event)"></td>
                                                                                        <td style="text-align:center;" colspan="2"><input readonly type="text" size="10" style="background-color: #ffffff;text-align:right" value="{{ number_format($form_c[$keySpecies]->proses_keluar,2) }}" wire:model='proses_keluar.{{ $keySpecies }}' wire:change="calcTotalPengeluaranKayuDaripadaJentera({{ $keySpecies}}, {{ $keyKumpulanKayu }}, '{{ $data->singkatan }}');" onkeypress="return isNumberKey(event)"></td>
                                                                                        <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" value="{{ number_format($form_c[$keySpecies]->baki_stok_kehadapan,2) }}" wire:model='baki_stok_kehadapan.{{ $keySpecies }}' ></td>
                                                                                    </tr>

                                                                                @endif

                                                                            @endforeach

                                                                            <tr style="height:50px;">
                                                                                <th style="text-align:center;" colspan="2"> Jumlah </th>
                                                                                @if( $keyKumpulanKayu == '0')
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_baki_stoks.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kkb->jumlah_baki_stok,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_kayu_masuk.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kkb->jumlah_kayu_masuk,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_stok_kayu_balak.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kkb->total_stok_kayu_balak,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_kayu_masuk_jentera.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kkb->total_kayu_masuk_jentera,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_kayu_keluar_jentera.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kkb->total_kayu_keluar_jentera,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_kayu_dibawa_bulan_hadapan.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kkb->total_kayu_dibawa_bulan_hadapan,2) }}"></td>
                                                                                @elseif(  $keyKumpulanKayu == '1')
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_baki_stoks.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kks->jumlah_baki_stok,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_kayu_masuk.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kks->jumlah_kayu_masuk,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_stok_kayu_balak.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kks->total_stok_kayu_balak,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_kayu_masuk_jentera.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kks->total_kayu_masuk_jentera,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_kayu_keluar_jentera.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kks->total_kayu_keluar_jentera,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_kayu_dibawa_bulan_hadapan.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kks->total_kayu_dibawa_bulan_hadapan,2) }}"></td>

                                                                                @elseif(  $keyKumpulanKayu == '2')
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_baki_stoks.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kkr->jumlah_baki_stok,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_kayu_masuk.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kkr->jumlah_kayu_masuk,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_stok_kayu_balak.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kkr->total_stok_kayu_balak,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_kayu_masuk_jentera.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kkr->total_kayu_masuk_jentera,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_kayu_keluar_jentera.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kkr->total_kayu_keluar_jentera,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_kayu_dibawa_bulan_hadapan.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kkr->total_kayu_dibawa_bulan_hadapan,2) }}"></td>

                                                                                @elseif(  $keyKumpulanKayu == '3')
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_baki_stoks.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kayu_lembut->jumlah_baki_stok,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_kayu_masuk.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kayu_lembut->jumlah_kayu_masuk,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_stok_kayu_balak.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kayu_lembut->total_stok_kayu_balak,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_kayu_masuk_jentera.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kayu_lembut->total_kayu_masuk_jentera,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_kayu_keluar_jentera.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kayu_lembut->total_kayu_keluar_jentera,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_kayu_dibawa_bulan_hadapan.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_kayu_lembut->total_kayu_dibawa_bulan_hadapan,2) }}"></td>

                                                                                @elseif(  $keyKumpulanKayu == '4')
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_baki_stoks.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_lain_lain->jumlah_baki_stok,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_kayu_masuk.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_lain_lain->jumlah_kayu_masuk,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_stok_kayu_balak.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_lain_lain->total_stok_kayu_balak,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_kayu_masuk_jentera.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_lain_lain->total_kayu_masuk_jentera,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_kayu_keluar_jentera.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_lain_lain->total_kayu_keluar_jentera,2) }}"></td>
                                                                                    <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='total_kayu_dibawa_bulan_hadapan.{{ $keyKumpulanKayu }}' value="{{ number_format($kemasukan_bahan_calc_lain_lain->total_kayu_dibawa_bulan_hadapan,2) }}"></td>

                                                                                @endif
                                                                            </tr>

                                                                        @endforeach

                                                                        @if($formc->tiada_pengeluaran == "1")
                                                                        <tr style="height:50px;">
                                                                            <th style="text-align:center;" colspan="2"> Jumlah Besar </th>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_besar_baki_stok_bulan_lepas' value="{{ number_format($kemasukan_bahan_calc_lain_lain->jumlah_besar_baki_stok_bulan_lepas,2) }}" ></td>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_besar_kemasukan_kayu_ke_kilang' value="0.00"></td>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_besar_stok_kayu_balak' value="0.00"></td>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_besar_kayu_ke_dalam_jentera' value="0.00"></td>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_besar_pengeluaran_kayu_daripada_jentera' value="0.00"></td>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_besar_baki_stok_bulan_depan' value="0.00"></td>
                                                                        </tr>
                                                                        @else
                                                                        <tr style="height:50px;">
                                                                            <th style="text-align:center;" colspan="2"> Jumlah Besar </th>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_besar_baki_stok_bulan_lepas' value="{{ number_format($kemasukan_bahan_calc_lain_lain->jumlah_besar_baki_stok_bulan_lepas,2) }}" ></td>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_besar_kemasukan_kayu_ke_kilang' value="{{ number_format($kemasukan_bahan_calc_lain_lain->jumlah_besar_kemasukan_kayu_ke_kilang,2) }}"></td>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_besar_stok_kayu_balak' value="{{ number_format($kemasukan_bahan_calc_lain_lain->jumlah_besar_stok_kayu_balak,2) }}"></td>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_besar_kayu_ke_dalam_jentera' value="{{ number_format($kemasukan_bahan_calc_lain_lain->jumlah_besar_kayu_ke_dalam_jentera,2) }}"></td>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_besar_pengeluaran_kayu_daripada_jentera' value="{{ number_format($kemasukan_bahan_calc_lain_lain->jumlah_besar_pengeluaran_kayu_daripada_jentera,2) }}"></td>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;text-align:right" type="text" size="10" wire:model='jumlah_besar_baki_stok_bulan_depan' value="{{ number_format($kemasukan_bahan_calc_lain_lain->jumlah_besar_baki_stok_bulan_depan,2) }}"></td>
                                                                        </tr>
                                                                        @endif
                                                                        </tbody>


                                                                    </table>
                                                                    <br>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <br>
                                                        <div class="text-center form-group m-b-0">
                                                            {{-- <button type="submit" class="btn btn-primary" >Simpan</button> --}}
                                                            {{-- <button type="button" class="btn btn-primary">Kembali</button> --}}

                                                            {{-- <button type="button" class="btn btn-primary" alt="default"
                                                                        data-toggle="modal" data-target="#responsive-modal-tidaklengkap"
                                                                        class="model_img img-fluid">
                                                                        TIDAK LENGKAP</button> --}}

                                                            {{-- @if ($errors->isEmpty()) --}}
                                                            {{-- <button type="button" class="btn btn-primary" alt="default"
                                                                data-toggle="modal" data-target="#confirmation_borang_a"
                                                                class="model_img img-fluid">
                                                                SIMPAN</button> --}}

                                                            {{-- @else --}}
                                                            {{-- <button type="submit" class="btn btn-primary" disabled>RALAT</button> --}}
                                                            {{-- <button type="submit" class="btn btn-primary" >Simpan</button> --}}
                                                            {{-- @endif --}}
                                                        </div>

                                                        <form action="{{ route('update_status_form3C', $id) }}"
                                                            method="post">
                                                            @csrf
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
                                                                                ingin mengesahkan borang ini?</b></span>
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

                                                        {{-- <div id="responsive-modal-tidaklengkap" class="modal fade"
                                                            tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                            aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header"
                                                                        style="justify-content:center;background-color:#f3ce8f">
                                                                        <h4><b>ULASAN PEGAWAI HUTAN DAERAH<b></h4> --}}

                                                                        {{-- <button type="button" class="close"
                                                                        data-dismiss="modal" aria-hidden="true">×</button> --}}
                                                                    {{-- </div>
                                                                    <form
                                                                        action="{{ route('update_status_form3C', $id) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <div class="modal-body"
                                                                            style="text-align: center">

                                                                            <input type="hidden" value="Tidak Lengkap"
                                                                                name="status">
                                                                            <textarea name="ulasan_phd" cols="50"
                                                                                rows="10"></textarea><br>
                                                                            <h6 style="text-align: center"><i><b>*Pegawai
                                                                                        Hutan yang tidak rendah daripada
                                                                                        Penolong Pegawai/Penolong Pegawai
                                                                                        Hutan Daerah/Penolong Pegawai Hutan
                                                                                        Jajahan</i></b></h6>
                                                                            <br>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" data-dismiss="modal"
                                                                                class="btn btn-danger waves-effect waves-light">Batal</button>
                                                                            <button type="submit" id="submit-button"
                                                                                class="btn btn-success waves-effect waves-light">HANTAR</button>


                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <br>
                                                    </div>
                                            </div>
                                        </div>

                                        </table>
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
