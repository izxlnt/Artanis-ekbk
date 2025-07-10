@extends('layouts.layout-ipjpsm-nicepage')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" style="padding-top: 1% ; text-align:center">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
        </div>
        <form action="{{ route('laporanpopup') }}" target="print_popup"
            onsubmit="window.open('about:blank','print_popup','width=1000,height=800');" class=""
            id="senarai_laporan_form" method="get">

            <div class="row">
                <div class="col-12">

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
                                                        <a href="{{ $breadcrumb['link'] }}"
                                                            style="color: white !important;"
                                                            onMouseOver="this.style.color='lightblue'"
                                                            onMouseOut="this.style.color='white'">
                                                            {{ $breadcrumb['name'] }}
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

                    <div class="card">
                        <div class="card-body" style="height: 50vh">
                            <ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home2"
                                        id="tab_s3" role="tab"><span class="hidden-xs-down">Laporan Shuttle 3 (Kilang
                                            Papan)</span></a>
                                </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile2"
                                        id="tab_s4" role="tab"></span> <span class="hidden-xs-down">Laporan Shuttle 4
                                            (Kilang Papan
                                            Lapis/Venir)</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages2"
                                        id="tab_s5" role="tab"></span> <span class="hidden-xs-down">Laporan Shuttle 5
                                            (Kilang Kayu
                                            Kumai)</span></a> </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="home2" role="tabpanel">
                                    {{-- Shuttle 3 --}}
                                    <div class="p-20"><br>

                                        <div class="row">
                                            <label for="fname"
                                                class="text-right col-sm-3 control-label col-form-label">Laporan</label>
                                            <div class="col-md-6">

                                                <select type="text" class="form-control" id="laporan_list" name='laporan'
                                                    onchange="display_option(this)">
                                                    <option value="" selected hidden disabled>Sila Pilih Laporan</option>

                                                    <optgroup label="Laporan Maklumat Kilang Papan">
                                                        <option value="1. Maklumat Penuh Senarai Kilang Papan">1. Maklumat
                                                            Penuh Senarai Kilang Papan</option>
                                                        <option value="2. Senarai Pemilik Kilang Papan Bumiputera">2.
                                                            Senarai Pemilik Kilang Papan Bumiputera</option>
                                                        <option value="3. Senarai Pemilik Kilang Papan Bukan Bumiputera">3.
                                                            Senarai Pemilik Kilang Papan Bukan Bumiputera</option>
                                                        <option value="4. Senarai Pemilik Kilang Papan Bukan Warganegara">4.
                                                            Senarai Pemilik Kilang Papan Bukan Warganegara</option>
                                                        <option value="5. Top 10 Pengeluar Kayu Gergaji di Kilang Papan">5.
                                                            Top 10 Pengeluar Kayu Gergaji di Kilang Papan</option>
                                                        <option
                                                            value="6. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak">
                                                            6. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak
                                                        </option>
                                                        <option
                                                            value="7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan">
                                                            7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang
                                                            Papan</option>
                                                    </optgroup>

                                                    <optgroup label="Laporan Guna Tenaga Oleh Kilang Papan">
                                                        <option
                                                            value="11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Papan Mengikut Negeri Dan Jantina">
                                                            11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Papan Mengikut
                                                            Negeri Dan Jantina</option>
                                                        <option
                                                            value="12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Papan">
                                                            12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori
                                                            Di Kilang Papan</option>
                                                        <option
                                                            value="13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan">
                                                            13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di
                                                            Kilang Papan</option>
                                                        <option
                                                            value="14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Papan">
                                                            14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di
                                                            Kilang Papan</option>
                                                        <option
                                                            value="15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan">
                                                            15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori
                                                            Dan Kewarganegaraan Di Kilang Papan</option>
                                                    </optgroup>

                                                    <optgroup label="Laporan Penggunaan Kayu Balak Oleh Kilang Papan">
                                                        <option
                                                            value="21. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Dan Bulan">
                                                            21. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Dan
                                                            Bulan</option>
                                                        <option
                                                            value="22. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa">
                                                            22. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Bagi
                                                            Siri Masa</option>
                                                        <option
                                                            value="23. Penggunaan Kayu Balak Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan">
                                                            23. Penggunaan Kayu Balak Oleh Kilang Papan Bagi Negeri-Negeri
                                                            Mengikut Kumpulan Kayu Kayan</option>
                                                        <option
                                                            value="24. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan">
                                                            24. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan
                                                            Kayu Kayan Dan Bulan</option>
                                                        <option
                                                            value="25. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa">
                                                            25. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan
                                                            Kayu Kayan Bagi Siri Masa</option>

                                                    </optgroup>

                                                    <optgroup label="Laporan Pengeluaran Kayu Gergaji Oleh Kilang Papan">
                                                        <option
                                                            value="31. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Dan Bulan">
                                                            31. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri
                                                            Dan Bulan</option>
                                                        <option
                                                            value="32. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa">
                                                            32. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri
                                                            Bagi Siri Masa</option>
                                                        <option
                                                            value="33. Pengeluaran Kayu Gergaji Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan">
                                                            33. Pengeluaran Kayu Gergaji Oleh Kilang Papan Bagi
                                                            Negeri-Negeri Mengikut Kumpulan Kayu Kayan</option>
                                                        <option
                                                            value="34. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan">
                                                            34. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan
                                                            Kayu Kayan Dan Bulan</option>
                                                        <option
                                                            value="35. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa">
                                                            35. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan
                                                            Kayu Kayan Bagi Siri Masa</option>
                                                        <option
                                                            value="36. Pengeluaran Kayu Gergaji Daripada Spesies Tertentu Oleh Kilang Papan Mengikut Negeri Dan Bulan">
                                                            36. Pengeluaran Kayu Gergaji Daripada Spesies Tertentu Oleh
                                                            Kilang Papan Mengikut Negeri Dan Bulan</option>

                                                    </optgroup>

                                                    <optgroup label="Laporan Jualan Kayu Gergaji Oleh Kilang Papan">

                                                        <option value="41. Jualan Domestik Kayu Gergaji Mengikut Bulan">41.
                                                            Jualan Domestik Kayu Gergaji Mengikut Bulan</option>
                                                        <option value="42. Jualan Domestik Kayu Gergaji Mengikut Negeri">42.
                                                            Jualan Domestik Kayu Gergaji Mengikut Negeri</option>
                                                        <option
                                                            value="43. Jualan Domestik Kayu Gergaji Mengikut Negeri Dan Bulan">
                                                            43. Jualan Domestik Kayu Gergaji Mengikut Negeri Dan Bulan
                                                        </option>
                                                        <option
                                                            value="44. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Bulan">
                                                            44. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut
                                                            Bulan</option>
                                                        <option
                                                            value="45. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Negeri">
                                                            45. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut
                                                            Negeri</option>
                                                        <option
                                                            value="46. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Bagi Siri Masa">
                                                            46. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Bagi Siri
                                                            Masa</option>
                                                        <option value="47. Jualan Eksport Kayu Gergaji Mengikut Bulan">47.
                                                            Jualan Eksport Kayu Gergaji Mengikut Bulan</option>
                                                        <option value="48. Jualan Eksport Kayu Gergaji Mengikut Negeri">48.
                                                            Jualan Eksport Kayu Gergaji Mengikut Negeri</option>

                                                    </optgroup>
                                                </select>
                                                <br>
                                            </div>
                                        </div>

                                        <div id="tahun_s3_div" style="display: none;">

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Tahun</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="tahun" name='tahun'
                                                        onchange="display_spesies_option(this)">
                                                        <option value="" selected hidden disabled>Sila Pilih Tahun</option>
                                                        @for ($i = intval(date('Y')); $i >= 2016; $i--)
                                                            <option value={{ $i }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>

                                                </div>
                                            </div>

                                        </div>

                                        <div id="spesis_s3_div" style="display: none;">

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Spesies</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="spesis" name='spesis'>
                                                        <option value="" selected hidden disabled>Sila Pilih Spesies
                                                        </option>
                                                        @forelse ($spesis as $spesis_data)
                                                            <option value="{{ $spesis_data->id }}">
                                                                {{ $spesis_data->nama_tempatan }}</option>
                                                        @empty
                                                            <option disabled>Tiada Data Spesies</option>
                                                        @endforelse
                                                    </select>

                                                </div>
                                            </div>

                                        </div>

                                        <div id="spesis_lama_s3_div" style="display: none;">

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Spesies</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="spesis_lama"
                                                        name='spesis_lama'>
                                                        <option value="" selected hidden disabled>Sila Pilih Spesies
                                                        </option>
                                                        @forelse ($spesis_lama as $spesis_data_lama)
                                                            <option value="{{ $spesis_data_lama->spesies_id }}">
                                                                {{ $spesis_data_lama->spesies_namatempatan }}</option>
                                                        @empty
                                                            <option disabled>Tiada Data Spesies</option>
                                                        @endforelse
                                                    </select>

                                                </div>
                                            </div>

                                        </div>

                                        <div id="range_tahun_s3_div" style="display: none;">
                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Tahun
                                                    Mula</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="tahun_mula" name='tahun'>
                                                        <option value="" selected hidden disabled>Sila Pilih Tahun</option>
                                                        @for ($i = intval(date('Y')); $i >= 2016; $i--)
                                                            <option value={{ $i }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Tahun
                                                    Akhir</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="tahunakhir"
                                                        name='tahunakhir'>
                                                        <option value="" selected hidden disabled>Sila Pilih Tahun</option>
                                                        @for ($i = intval(date('Y')); $i >= 2016; $i--)
                                                            <option value={{ $i }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>

                                                </div>
                                            </div>
                                        </div>

                                        <div id="suku_tahun_s3_div" style="display: none;">

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Suku
                                                    Tahun</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="suku_tahun"
                                                        name='suku_tahun'>
                                                        <option value="" selected hidden disabled>Sila Pilih Suku Tahun
                                                        </option>

                                                        <option value="1">Suku Tahun Pertama</option>
                                                        <option value="2">Suku Tahun Kedua</option>
                                                        <option value="3">Suku Tahun Ketiga</option>
                                                        <option value="4">Suku Tahun Keempat</option>

                                                    </select>

                                                </div>
                                            </div>

                                        </div>

                                        <div id="suku_tahun_s3_akhir_div" style="display: none;">

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Suku
                                                    Tahun</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="suku_tahun_akhir"
                                                        name='suku_tahun_akhir'>
                                                        <option value="" selected hidden disabled>Sila Pilih Suku Tahun
                                                        </option>

                                                        <option value="1">Suku Tahun Pertama</option>
                                                        <option value="2">Suku Tahun Kedua</option>
                                                        <option value="3">Suku Tahun Ketiga</option>
                                                        <option value="4">Suku Tahun Keempat</option>
                                                    </select>

                                                </div>
                                            </div>

                                        </div>



                                    </div>
                                </div>
                                {{-- Shuttle 4 --}}
                                <div class="p-20 tab-pane" id="profile2" role="tabpanel">
                                    <div class="p-20"><br>
                                        <div class="row">
                                            <label for="fname"
                                                class="text-right col-sm-3 control-label col-form-label">Laporan</label>
                                            <div class="col-md-6">
                                                <select type="text" class="form-control" name='laporan'
                                                    id="laporan_list_4" onchange="display_option_4(this)">
                                                    <option value="" selected hidden disabled>Sila Pilih Laporan</option>
                                                    <optgroup label="Laporan Maklumat Kilang Papan Lapis/Venir">
                                                        <option value="1. Maklumat Penuh Senarai Kilang Papan Lapis/Venir">
                                                            1. Maklumat Penuh Senarai Kilang Papan Lapis/Venir</option>
                                                        <option
                                                            value="2. Senarai Pemilik Kilang Papan Lapis/Venir Bumiputera">
                                                            2. Senarai Pemilik Kilang Papan Lapis/Venir Bumiputera</option>
                                                        <option
                                                            value="3. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Bumiputera">
                                                            3. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Bumiputera
                                                        </option>
                                                        <option
                                                            value="4. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Warganegara">
                                                            4. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Warganegara
                                                        </option>
                                                        <option
                                                            value="5. Top 10 Pengeluar Papan Lapis di Kilang Papan Lapis/Venir">
                                                            5. Top 10 Pengeluar Papan Lapis di Kilang Papan Lapis/Venir
                                                        </option>
                                                        <option
                                                            value="6. Top 10 Pengeluar Venir di Kilang Papan Lapis/Venir">6.
                                                            Top 10 Pengeluar Venir di Kilang Papan Lapis/Venir</option>
                                                        <option
                                                            value="7. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak Di Kilang Papan Lapis/Venir">
                                                            7. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak Di Kilang Papan Lapis/Venir</option>
                                                        <option
                                                            value="8. Jumlah Pelaburan (Harta Tetap) Bagi Kilang Papan Lapis/Venir">
                                                            8. Jumlah Pelaburan (Harta Tetap) Bagi Kilang Papan Lapis/Venir
                                                        </option>
                                                        <option
                                                            value="9. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan Lapis/Venir">
                                                            9. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang
                                                            Papan Lapis/Venir</option>
                                                    </optgroup>
                                                    <optgroup label="Laporan Guna Tenaga Oleh Kilang Papan Lapis/Venir">
                                                        <option value="211">11. Guna Tenaga Dan Pendapatan (RM) Di Kilang
                                                            Papan Lapis/Venir Mengikut Negeri Dan Jantina</option>
                                                        <option value="212">12. Jumlah Dan Purata Pendapatan (RM) Pekerja
                                                            Mengikut Kategori Di Kilang Papan Lapis/Venir</option>
                                                        <option value="213">13. Jumlah Guna Tenaga Mengikut Kategori Dan
                                                            Kewarganegaraan Di Kilang Papan Lapis/Venir</option>
                                                        <option value="214">14. Jumlah Guna Tenaga Mengikut Negeri Dan
                                                            Kewarganegaraan Di Kilang Papan Lapis/Venir</option>
                                                        <option value="215">15. Jumlah dan Purata Pendapatan Guna Tenaga
                                                            Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan
                                                            Lapis/Venir</option>
                                                    </optgroup>
                                                    <optgroup
                                                        label="Laporan Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir">
                                                        <option
                                                            value="21. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Dan Bulan">
                                                            21. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut
                                                            Negeri Dan Bulan</option>
                                                        <option
                                                            value="22. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Bagi Siri Masa">
                                                            22. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut
                                                            Negeri Bagi Siri Masa</option>
                                                        <option
                                                            value="23. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan">
                                                            23. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Bagi
                                                            Negeri-Negeri Mengikut Kumpulan Kayu Kayan</option>
                                                        <option
                                                            value="24. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Dan Bulan">
                                                            24. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut
                                                            Kumpulan Kayu Kayan Dan Bulan</option>
                                                        <option
                                                            value="25. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Bagi Siri Masa">
                                                            25. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut
                                                            Kumpulan Kayu Kayan Bagi Siri Masa</option>
                                                    </optgroup>
                                                    <optgroup
                                                        label="Laporan Pengeluaran Papan Lapis/Venir Oleh Kilang Papan Lapis/Venir">
                                                        <option
                                                            value="31. Pengeluaran Papan Lapis Mengikut Negeri Dan Bulan">
                                                            31. Pengeluaran Papan Lapis Mengikut Negeri Dan Bulan</option>
                                                        <option
                                                            value="32. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa">
                                                            32. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Jenis
                                                            Bagi Siri Masa</option>
                                                        <option
                                                            value="33. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan Mengikut Jenis">
                                                            33. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan
                                                            Mengikut Jenis</option>
                                                        <option
                                                            value="34. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Ketebalan Bagi Siri Masa">
                                                            34. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut
                                                            Ketebalan Bagi Siri Masa</option>
                                                        <option
                                                            value="35. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan Mengikut Ketebalan">
                                                            35. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan
                                                            Mengikut Ketebalan</option>
                                                        <option value="36. Pengeluaran Venir Mengikut Negeri Dan Bulan">36.
                                                            Pengeluaran Venir Mengikut Negeri Dan Bulan</option>
                                                        <option
                                                            value="37. Pengeluaran Venir Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa">
                                                            37. Pengeluaran Venir Bagi Negeri-Negeri Mengikut Jenis Bagi
                                                            Siri Masa</option>
                                                        <option
                                                            value="38. Pengeluaran Venir Bagi Negeri-Negeri Dan Bulan Mengikut Jenis">
                                                            38. Pengeluaran Venir Bagi Negeri-Negeri Dan Bulan Mengikut
                                                            Jenis</option>
                                                    </optgroup>
                                                    <optgroup
                                                        label="Laporan Jualan Papan Lapis/Venir Oleh Kilang Papan Lapis/Venir">
                                                        <option
                                                            value="41. Jualan Domestik Papan Lapis/Venir Mengikut Bulan">41.
                                                            Jualan Domestik Papan Lapis/Venir Mengikut Bulan</option>
                                                        <option
                                                            value="42. Jualan Domestik Papan Lapis/Venir Mengikut Negeri">
                                                            42. Jualan Domestik Papan Lapis/Venir Mengikut Negeri</option>
                                                        <option
                                                            value="43. Jualan Domestik Papan Lapis Mengikut Negeri Dan Bulan">
                                                            43. Jualan Domestik Papan Lapis Mengikut Negeri Dan Bulan
                                                        </option>
                                                        <option value="44. Jualan Domestik Venir Mengikut Negeri Dan Bulan">
                                                            44. Jualan Domestik Venir Mengikut Negeri Dan Bulan</option>
                                                        <option
                                                            value="45. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Bulan">
                                                            45. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut
                                                            Bulan</option>
                                                        <option
                                                            value="46. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Negeri">
                                                            46. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut
                                                            Negeri</option>
                                                        <option
                                                            value="47. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Bagi Siri Masa">
                                                            47. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Bagi Siri
                                                            Masa</option>
                                                        <option value="48. Jualan Eksport Papan Lapis/Venir Mengikut Bulan">
                                                            48. Jualan Eksport Papan Lapis/Venir Mengikut Bulan</option>
                                                        <option
                                                            value="49. Jualan Eksport Papan Lapis/Venir Mengikut Negeri">49.
                                                            Jualan Eksport Papan Lapis/Venir Mengikut Negeri</option>
                                                    </optgroup>

                                                </select>
                                                <br>
                                            </div>
                                        </div>
                                        <div id="tahun_s4_div" style="display: none;">

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Tahun</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="tahun_4" name='tahun'
                                                        onchange="display_spesies_option_4(this)">
                                                        <option value="" selected hidden disabled>Sila Pilih Tahun</option>
                                                        @for ($i = intval(date('Y')); $i >= 2016; $i--)
                                                            <option value={{ $i }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>

                                                </div>
                                            </div>

                                        </div>

                                        <div id="spesis_s4_div" style="display: none;">

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Spesies</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="spesis_4" name='spesis'>
                                                        <option value="" selected hidden disabled>Sila Pilih Spesies
                                                        </option>
                                                        @forelse ($spesis as $spesis_data)
                                                            <option value="{{ $spesis_data->id }}">
                                                                {{ $spesis_data->nama_tempatan }}</option>
                                                        @empty
                                                            <option disabled>Tiada Data Spesies</option>
                                                        @endforelse
                                                    </select>

                                                </div>
                                            </div>

                                        </div>

                                        <div id="spesis_lama_s4_div" style="display: none;">

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Spesies</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="spesis_lama_4"
                                                        name='spesis_lama'>
                                                        <option value="" selected hidden disabled>Sila Pilih Spesies
                                                        </option>
                                                        @forelse ($spesis_lama as $spesis_data_lama)
                                                            <option value="{{ $spesis_data_lama->spesies_id }}">
                                                                {{ $spesis_data_lama->spesies_namatempatan }}</option>
                                                        @empty
                                                            <option disabled>Tiada Data Spesies</option>
                                                        @endforelse
                                                    </select>

                                                </div>
                                            </div>

                                        </div>

                                        <div id="range_tahun_s4_div" style="display: none;">
                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Tahun
                                                    Mula</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="tahun_mula_4"
                                                        name='tahun'>
                                                        <option value="" selected hidden disabled>Sila Pilih Tahun</option>
                                                        @for ($i = intval(date('Y')); $i >= 2016; $i--)
                                                            <option value={{ $i }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Tahun
                                                    Akhir</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="tahunakhir_4"
                                                        name='tahunakhir'>
                                                        <option value="" selected hidden disabled>Sila Pilih Tahun</option>
                                                        @for ($i = intval(date('Y')); $i >= 2016; $i--)
                                                            <option value={{ $i }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>

                                                </div>
                                            </div>
                                        </div>

                                        <div id="suku_tahun_s4_div" style="display: none;">

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Suku
                                                    Tahun</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="suku_tahun_4"
                                                        name='suku_tahun'>
                                                        <option value="" selected hidden disabled>Sila Pilih Suku Tahun
                                                        </option>

                                                        <option value="1">Suku Tahun Pertama</option>
                                                        <option value="2">Suku Tahun Kedua</option>
                                                        <option value="3">Suku Tahun Ketiga</option>
                                                        <option value="4">Suku Tahun Keempat</option>

                                                    </select>

                                                </div>
                                            </div>

                                        </div>

                                        <div id="suku_tahun_s4_akhir_div" style="display: none;">

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Suku
                                                    Tahun</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="suku_tahun_akhir_4"
                                                        name='suku_tahun_akhir'>
                                                        <option value="" selected hidden disabled>Sila Pilih Suku Tahun
                                                        </option>

                                                        <option value="1">Suku Tahun Pertama</option>
                                                        <option value="2">Suku Tahun Kedua</option>
                                                        <option value="3">Suku Tahun Ketiga</option>
                                                        <option value="4">Suku Tahun Keempat</option>
                                                    </select>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                {{-- Shuttle 5 --}}
                                <div class="p-20 tab-pane" id="messages2" role="tabpanel">
                                    <div class="p-20"><br>
                                        <div class="row">
                                            <label for="fname"
                                                class="text-right col-sm-3 control-label col-form-label">Laporan</label>
                                            <div class="col-md-6">
                                                <select type="text" class="form-control" name='laporan'
                                                    id="laporan_list_5" onchange="display_option_5(this)">
                                                    <option value="" selected hidden disabled>Sila Pilih Laporan</option>
                                                    <optgroup label="Laporan Maklumat Kilang Kayu Kumai">
                                                        <option value="1. Maklumat Penuh Senarai Kilang Kayu Kumai">1.
                                                            Maklumat Penuh Senarai Kilang Kayu Kumai</option>
                                                        <option value="2. Senarai Pemilik Kilang Kayu Kumai Bumiputera">2.
                                                            Senarai Pemilik Kilang Kayu Kumai Bumiputera</option>
                                                        <option
                                                            value="3. Senarai Pemilik Kilang Kayu Kumai Bukan Bumiputera">3.
                                                            Senarai Pemilik Kilang Kayu Kumai Bukan Bumiputera</option>
                                                        <option
                                                            value="4. Senarai Pemilik Kilang Kayu Kumai Bukan Warganegara">
                                                            4. Senarai Pemilik Kilang Kayu Kumai Bukan Warganegara</option>
                                                        <option value="5. Top 10 Pengeluar Kayu Kumai di Kilang Kayu Kumai">
                                                            5. Top 10 Pengeluar Kayu Kumai di Kilang Kayu Kumai</option>
                                                        <option
                                                            value="6. Top 10 Kilang Kayu Kumai Dalam Penggunaan Spesies Kayu Balak Di Kilang Kayu Kumai">
                                                            6. Top 10 Kilang Kayu Kumai Dalam Penggunaan Spesies Kayu Balak
                                                            Di Kilang Kayu Kumai</option>
                                                        <option
                                                            value="7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Kayu Kumai">
                                                            7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang
                                                            Kayu Kumai</option>
                                                    </optgroup>
                                                    <optgroup label="Laporan Guna Tenaga Oleh Kilang Kayu Kumai">
                                                        <option value="311">11. Guna Tenaga Dan Pendapatan (RM) Di Kilang
                                                            Kayu Kumai Mengikut Negeri Dan Jantina</option>
                                                        <option value="312">12. Jumlah Dan Purata Pendapatan (RM) Pekerja
                                                            Mengikut Kategori Di Kilang Kayu Kumai</option>
                                                        <option value="313">13. Jumlah Guna Tenaga Mengikut Kategori Dan
                                                            Kewarganegaraan Di Kilang Kayu Kumai</option>
                                                        <option value="314">14. Jumlah Guna Tenaga Mengikut Negeri Dan
                                                            Kewarganegaraan Di Kilang Kayu Kumai</option>
                                                        <option value="315">15. Jumlah dan Purata Pendapatan Guna Tenaga
                                                            Mengikut Kategori Dan Kewarganegaraan Di Kilang Kayu Kumai
                                                        </option>
                                                    </optgroup>
                                                    <optgroup
                                                        label="Laporan Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai">
                                                        <option
                                                            value="21. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan">
                                                            21. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut
                                                            Negeri Dan Bulan</option>
                                                        <option
                                                            value="22. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa">
                                                            22. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut
                                                            Negeri Bagi Siri Masa</option>
                                                        <option
                                                            value="23. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan">
                                                            23. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Bagi
                                                            Negeri-Negeri Mengikut Kumpulan Kayu Kayan</option>
                                                        <option
                                                            value="24. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Dan Bulan">
                                                            24. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut
                                                            Kumpulan Kayu Kayan Dan Bulan</option>
                                                        <option
                                                            value="25. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Bagi Siri Masa">
                                                            25. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut
                                                            Kumpulan Kayu Kayan Bagi Siri Masa</option>
                                                    </optgroup>
                                                    <optgroup label="Laporan Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai">
                                                        <option
                                                            value="31. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan">
                                                            31. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut
                                                            Negeri Dan Bulan</option>
                                                        <option
                                                            value="32. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa">
                                                            32. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut
                                                            Negeri Bagi Siri Masa</option>
                                                        <option
                                                            value="33. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Jenis Produk Dan Bulan">
                                                            33. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Jenis
                                                            Produk Dan Bulan</option>
                                                    </optgroup>

                                                    <optgroup label="Laporan Jualan Kayu Kumai Oleh Kilang Kayu Kumai">
                                                        <option value="341">41. Jualan Domestik Kayu Kumai Mengikut Bulan
                                                        </option>
                                                        <option value="342">42. Jualan Domestik Kayu Kumai Mengikut Negeri
                                                        </option>
                                                        <option value="393">43. Jualan Domestik Kayu Kumai Mengikut Negeri
                                                            Dan Bulan</option>
                                                        <option value="343">44. Jualan Eksport Kayu Kumai Mengikut Bulan
                                                        </option>
                                                        <option value="344">45. Jualan Eksport Kayu Kumai Mengikut Negeri
                                                        </option>

                                                    </optgroup>


                                                </select>
                                                <br>
                                            </div>
                                        </div>

                                        <div id="tahun_s5_div" style="display: none;">

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Tahun</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="tahun_5" name='tahun'
                                                        onchange="display_spesies_option_5(this)">
                                                        <option value="" selected hidden disabled>Sila Pilih Tahun</option>
                                                        @for ($i = intval(date('Y')); $i >= 2016; $i--)
                                                            <option value={{ $i }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>

                                                </div>
                                            </div>

                                        </div>

                                        <div id="spesis_s5_div" style="display: none;">

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Spesies</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="spesis_5" name='spesis'>
                                                        <option value="" selected hidden disabled>Sila Pilih Spesies
                                                        </option>
                                                        @forelse ($spesis as $spesis_data)
                                                            <option value="{{ $spesis_data->id }}">
                                                                {{ $spesis_data->nama_tempatan }}</option>
                                                        @empty
                                                            <option disabled>Tiada Data Spesies</option>
                                                        @endforelse
                                                    </select>

                                                </div>
                                            </div>

                                        </div>

                                        <div id="spesis_lama_s5_div" style="display: none;">

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Spesies</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="spesis_lama_5"
                                                        name='spesis_lama'>
                                                        <option value="" selected hidden disabled>Sila Pilih Spesies
                                                        </option>
                                                        @forelse ($spesis_lama as $spesis_data_lama)
                                                            <option value="{{ $spesis_data_lama->spesies_id }}">
                                                                {{ $spesis_data_lama->spesies_namatempatan }}</option>
                                                        @empty
                                                            <option disabled>Tiada Data Spesies</option>
                                                        @endforelse
                                                    </select>

                                                </div>
                                            </div>

                                        </div>

                                        <div id="range_tahun_s5_div" style="display: none;">
                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Tahun
                                                    Mula</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="tahun_mula_5"
                                                        name='tahun'>
                                                        <option value="" selected hidden disabled>Sila Pilih Tahun</option>
                                                        @for ($i = intval(date('Y')); $i >= 2016; $i--)
                                                            <option value={{ $i }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Tahun
                                                    Akhir</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="tahunakhir_5"
                                                        name='tahunakhir'>
                                                        <option value="" selected hidden disabled>Sila Pilih Tahun</option>
                                                        @for ($i = intval(date('Y')); $i >= 2016; $i--)
                                                            <option value={{ $i }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>

                                                </div>
                                            </div>
                                        </div>

                                        <div id="suku_tahun_s5_div" style="display: none;">

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Suku
                                                    Tahun</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="suku_tahun_5"
                                                        name='suku_tahun'>
                                                        <option value="" selected hidden disabled>Sila Pilih Suku Tahun
                                                        </option>

                                                        <option value="1">Suku Tahun Pertama</option>
                                                        <option value="2">Suku Tahun Kedua</option>
                                                        <option value="3">Suku Tahun Ketiga</option>
                                                        <option value="4">Suku Tahun Keempat</option>

                                                    </select>

                                                </div>
                                            </div>

                                        </div>

                                        <div id="suku_tahun_s5_akhir_div" style="display: none;">

                                            <div class="pb-3 row">
                                                <label for="fname"
                                                    class="text-right col-sm-3 control-label col-form-label">Suku
                                                    Tahun</label>
                                                <div class="col-md-6">
                                                    <select type="text" class="form-control" id="suku_tahun_akhir_5"
                                                        name='suku_tahun_akhir'>
                                                        <option value="" selected hidden disabled>Sila Pilih Suku Tahun
                                                        </option>

                                                        <option value="1">Suku Tahun Pertama</option>
                                                        <option value="2">Suku Tahun Kedua</option>
                                                        <option value="3">Suku Tahun Ketiga</option>
                                                        <option value="4">Suku Tahun Keempat</option>
                                                    </select>

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div id="submit_button" style="text-align: center; display: none;">
                                <a class="btn btn-primary" href="{{ URL::previous() }}" style="color:white">Kembali</a>
                                <button class="btn btn-success" type="submit">Jana Laporan</button>
                            </div>
                            <div id="submit_button_disable" style="text-align: center">
                                <a class="btn btn-primary" href="{{ URL::previous() }}" style="color:white">Kembali</a>
                                <button class="btn btn-dark" id="jana_laporan_disabled" type="button">Jana
                                    Laporan</button>
                            </div>

                        </div>

                    </div>

                </div>


            </div>
        </form>


    </div>

    {{-- shuttle 3 --}}
    <script>
        function display_spesies_option(e) { // filter spesis based on tahun yang dipilih

            var laporan = $("#laporan_list").val();

            if (
                laporan == "6. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak" ||
                laporan ==
                "36. Pengeluaran Kayu Gergaji Daripada Spesies Tertentu Oleh Kilang Papan Mengikut Negeri Dan Bulan"
            ) {
                if (e.value < 2021) {
                    document.getElementById('spesis_lama_s3_div').style.display = "block";
                    document.getElementById('spesis_s3_div').style.display = "none";
                } else {
                    document.getElementById('spesis_lama_s3_div').style.display = "none";
                    document.getElementById('spesis_s3_div').style.display = "block";
                }
            }

        }

        function display_option(e) {

            $('#tahun').prop('selectedIndex', 0);
            $('#spesis').prop('selectedIndex', 0);
            $('#spesis_lama').prop('selectedIndex', 0);
            $('#tahun_mula').prop('selectedIndex', 0);
            $('#tahunakhir').prop('selectedIndex', 0);
            $('#suku_tahun').prop('selectedIndex', 0);
            $('#suku_tahun_akhir').prop('selectedIndex', 0);

            //disable submit button
            $("#submit_button").css("display", "none");
            $("#submit_button_disable").css("display", "block");

            if (
                e.value == "1. Maklumat Penuh Senarai Kilang Papan" ||
                e.value == "2. Senarai Pemilik Kilang Papan Bumiputera" ||
                e.value == "3. Senarai Pemilik Kilang Papan Bukan Bumiputera" ||
                e.value == "4. Senarai Pemilik Kilang Papan Bukan Warganegara" ||
                e.value == "5. Top 10 Pengeluar Kayu Gergaji di Kilang Papan" ||
                e.value == "6. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak" ||
                e.value == "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan" ||


                e.value == "21. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Dan Bulan" ||
                e.value == "23. Penggunaan Kayu Balak Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan" ||
                e.value == "24. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan" ||

                e.value == "31. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Dan Bulan" ||
                e.value ==
                "33. Pengeluaran Kayu Gergaji Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan" ||
                e.value == "34. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan" ||

                e.value == "41. Jualan Domestik Kayu Gergaji Mengikut Bulan" ||
                e.value == "42. Jualan Domestik Kayu Gergaji Mengikut Negeri" ||
                e.value == "43. Jualan Domestik Kayu Gergaji Mengikut Negeri Dan Bulan" ||
                e.value == "44. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Bulan" ||
                e.value == "45. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Negeri" ||
                e.value == "47. Jualan Eksport Kayu Gergaji Mengikut Bulan" ||
                e.value == "48. Jualan Eksport Kayu Gergaji Mengikut Negeri"

            ) {
                document.getElementById('tahun_s3_div').style.display = "block";
                document.getElementById('suku_tahun_s3_div').style.display = "none";
                document.getElementById('spesis_s3_div').style.display = "none";
                document.getElementById('suku_tahun_s3_akhir_div').style.display = "none";

                document.getElementById('range_tahun_s3_div').style.display = "none";
                document.getElementById('spesis_lama_s3_div').style.display = "none";

            } else if (
                e.value == "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Papan Mengikut Negeri Dan Jantina" ||
                e.value == "12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Papan" ||
                e.value == "13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan" ||
                e.value == "14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Papan" ||
                e.value ==
                "15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan"
            ) {
                document.getElementById('tahun_s3_div').style.display = "block";
                document.getElementById('suku_tahun_s3_div').style.display = "block";
                document.getElementById('suku_tahun_s3_akhir_div').style.display = "block";
                document.getElementById('spesis_s3_div').style.display = "none";
                document.getElementById('range_tahun_s3_div').style.display = "none";
                document.getElementById('spesis_lama_s3_div').style.display = "none";
            } else if (
                e.value == "22. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa" ||

                e.value == "25. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa" ||

                e.value == "32. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa" ||
                e.value == "35. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa" ||
                e.value == "46. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Bagi Siri Masa"

            ) {
                document.getElementById('tahun_s3_div').style.display = "none";
                document.getElementById('suku_tahun_s3_div').style.display = "none";
                document.getElementById('suku_tahun_s3_akhir_div').style.display = "none";
                document.getElementById('spesis_s3_div').style.display = "none";
                document.getElementById('range_tahun_s3_div').style.display = "block";
                document.getElementById('spesis_lama_s3_div').style.display = "none";
            } else {
                document.getElementById('tahun_s3_div').style.display = "none";
                document.getElementById('suku_tahun_s3_div').style.display = "none";
                document.getElementById('suku_tahun_s3_akhir_div').style.display = "none";
                document.getElementById('spesis_s3_div').style.display = "none";
                document.getElementById('range_tahun_s3_div').style.display = "none";
                document.getElementById('spesis_lama_s3_div').style.display = "none";
            }

            if (e.value == "6. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak") {
                document.getElementById('spesis_s3_div').style.display = "block";
                document.getElementById('spesis_lama_s3_div').style.display = "none";
            }

            if (e.value ==
                "36. Pengeluaran Kayu Gergaji Daripada Spesies Tertentu Oleh Kilang Papan Mengikut Negeri Dan Bulan") {
                document.getElementById('tahun_s3_div').style.display = "block";
                document.getElementById('suku_tahun_s3_div').style.display = "none";
                document.getElementById('suku_tahun_s3_akhir_div').style.display = "none";
                document.getElementById('spesis_s3_div').style.display = "block";
                document.getElementById('range_tahun_s3_div').style.display = "none";
                document.getElementById('spesis_lama_s3_div').style.display = "none";
            }

        }
    </script>

    {{-- shuttle 4 --}}
    <script>
        function display_spesies_option_4(e) { // filter spesis based on tahun yang dipilih

            var laporan = $("#laporan_list_4").val();

            if (
                laporan == "7. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak Di Kilang Papan Lapis/Venir"
            ) {
                if (e.value < 2021) {
                    document.getElementById('spesis_lama_s4_div').style.display = "block";
                    document.getElementById('spesis_s4_div').style.display = "none";
                } else {
                    document.getElementById('spesis_lama_s4_div').style.display = "none";
                    document.getElementById('spesis_s4_div').style.display = "block";
                }
            }

        }

        function display_option_4(e) {

            $('#tahun_4').prop('selectedIndex', 0);
            $('#spesis_4').prop('selectedIndex', 0);
            $('#spesis_lama_4').prop('selectedIndex', 0);
            $('#tahun_mula_4').prop('selectedIndex', 0);
            $('#tahunakhir_4').prop('selectedIndex', 0);
            $('#suku_tahun_4').prop('selectedIndex', 0);
            $('#suku_tahun_akhir_4').prop('selectedIndex', 0);

            //disable submit button
            $("#submit_button").css("display", "none");
            $("#submit_button_disable").css("display", "block");

            if (
                e.value == "1. Maklumat Penuh Senarai Kilang Papan Lapis/Venir" ||
                e.value == "2. Senarai Pemilik Kilang Papan Lapis/Venir Bumiputera" ||
                e.value == "3. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Bumiputera" ||
                e.value == "4. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Warganegara" ||
                e.value == "5. Top 10 Pengeluar Papan Lapis di Kilang Papan Lapis/Venir" ||
                e.value == "6. Top 10 Pengeluar Venir di Kilang Papan Lapis/Venir" ||
                e.value == "7. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak Di Kilang Papan Lapis/Venir" ||
                e.value == "8. Jumlah Pelaburan (Harta Tetap) Bagi Kilang Papan Lapis/Venir" ||
                e.value == "9. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan Lapis/Venir" ||

                e.value == "21. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Dan Bulan" ||
                e.value == "23. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan" ||
                e.value == "24. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Dan Bulan" ||

                e.value == "31. Pengeluaran Papan Lapis Mengikut Negeri Dan Bulan" ||
                e.value == "33. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan Mengikut Jenis" ||
                e.value == "35. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan Mengikut Ketebalan" ||
                e.value == "36. Pengeluaran Venir Mengikut Negeri Dan Bulan" ||
                e.value == "38. Pengeluaran Venir Bagi Negeri-Negeri Dan Bulan Mengikut Jenis" ||

                e.value == "41. Jualan Domestik Papan Lapis/Venir Mengikut Bulan" ||
                e.value == "42. Jualan Domestik Papan Lapis/Venir Mengikut Negeri" ||
                e.value == "43. Jualan Domestik Papan Lapis Mengikut Negeri Dan Bulan" ||
                e.value == "44. Jualan Domestik Venir Mengikut Negeri Dan Bulan" ||
                e.value == "45. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Bulan" ||
                e.value == "46. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Negeri" ||
                e.value == "48. Jualan Eksport Papan Lapis/Venir Mengikut Bulan" ||
                e.value == "49. Jualan Eksport Papan Lapis/Venir Mengikut Negeri"

            ) {
                document.getElementById('tahun_s4_div').style.display = "block";
                document.getElementById('suku_tahun_s4_div').style.display = "none";
                document.getElementById('spesis_s4_div').style.display = "none";
                document.getElementById('suku_tahun_s4_akhir_div').style.display = "none";

                document.getElementById('range_tahun_s4_div').style.display = "none";
                document.getElementById('spesis_lama_s4_div').style.display = "none";

            } else if (
                e.value == "211" ||
                e.value == "212" ||
                e.value == "213" ||
                e.value == "214" ||
                e.value == "215"
            ) {
                document.getElementById('tahun_s4_div').style.display = "block";
                document.getElementById('suku_tahun_s4_div').style.display = "block";
                document.getElementById('suku_tahun_s4_akhir_div').style.display = "block";
                document.getElementById('spesis_s4_div').style.display = "none";
                document.getElementById('range_tahun_s4_div').style.display = "none";
                document.getElementById('spesis_lama_s4_div').style.display = "none";
            } else if (
                e.value == "22. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Bagi Siri Masa" ||
                e.value == "25. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Bagi Siri Masa" ||
                e.value == "32. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa" ||
                e.value == "34. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Ketebalan Bagi Siri Masa" ||
                e.value == "37. Pengeluaran Venir Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa" ||
                e.value == "47. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Bagi Siri Masa"

            ) {
                document.getElementById('tahun_s4_div').style.display = "none";
                document.getElementById('suku_tahun_s4_div').style.display = "none";
                document.getElementById('suku_tahun_s4_akhir_div').style.display = "none";
                document.getElementById('spesis_s4_div').style.display = "none";
                document.getElementById('range_tahun_s4_div').style.display = "block";
                document.getElementById('spesis_lama_s4_div').style.display = "none";
            } else {
                document.getElementById('tahun_s4_div').style.display = "none";
                document.getElementById('suku_tahun_s4_div').style.display = "none";
                document.getElementById('suku_tahun_s4_akhir_div').style.display = "none";
                document.getElementById('spesis_s4_div').style.display = "none";
                document.getElementById('range_tahun_s4_div').style.display = "none";
                document.getElementById('spesis_lama_s4_div').style.display = "none";
            }

            // if (e.value ==
            //     "6. Top 10 Pengeluar Papan Venir di Kilang Papan Lapis/Venir") {
            //     document.getElementById('spesis_s4_div').style.display = "block";
            //     document.getElementById('spesis_lama_s4_div').style.display = "none";
            // }

            if (e.value == "7. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak Di Kilang Papan Lapis/Venir") {
                document.getElementById('spesis_s4_div').style.display = "block";
                document.getElementById('spesis_lama_s4_div').style.display = "none";
            }

            // if (e.value ==
            //     "36. Pengeluaran Kayu Gergaji Daripada Spesies Tertentu Oleh Kilang Papan Lapis/Venir Mengikut Negeri Dan Bulan"
            // ) {
            //     document.getElementById('tahun_s4_div').style.display = "block";
            //     document.getElementById('suku_tahun_s4_div').style.display = "none";
            //     document.getElementById('suku_tahun_s4_akhir_div').style.display = "none";
            //     document.getElementById('spesis_s4_div').style.display = "block";
            //     document.getElementById('range_tahun_s4_div').style.display = "none";
            //     document.getElementById('spesis_lama_s4_div').style.display = "none";
            // }

        }
    </script>

    {{-- shuttle 5 --}}
    <script>
        function display_spesies_option_5(e) { // filter spesis based on tahun yang dipilih

            var laporan = $("#laporan_list_5").val();

            if (
                laporan == "6. Top 10 Kilang Kayu Kumai Dalam Penggunaan Spesies Kayu Balak Di Kilang Kayu Kumai"
            ) {
                if (e.value < 2021) {
                    document.getElementById('spesis_lama_s5_div').style.display = "block";
                    document.getElementById('spesis_s5_div').style.display = "none";
                } else {
                    document.getElementById('spesis_lama_s5_div').style.display = "none";
                    document.getElementById('spesis_s5_div').style.display = "block";
                }
            }

        }

        function display_option_5(e) {

            $('#tahun_5').prop('selectedIndex', 0);
            $('#spesis_5').prop('selectedIndex', 0);
            $('#spesis_lama_5').prop('selectedIndex', 0);
            $('#tahun_mula_5').prop('selectedIndex', 0);
            $('#tahunakhir_5').prop('selectedIndex', 0);
            $('#suku_tahun_5').prop('selectedIndex', 0);
            $('#suku_tahun_akhir_5').prop('selectedIndex', 0);

            //disable submit button
            $("#submit_button").css("display", "none");
            $("#submit_button_disable").css("display", "block");

            if (
                e.value == "1. Maklumat Penuh Senarai Kilang Kayu Kumai" ||
                e.value == "2. Senarai Pemilik Kilang Kayu Kumai Bumiputera" ||
                e.value == "3. Senarai Pemilik Kilang Kayu Kumai Bukan Bumiputera" ||
                e.value == "4. Senarai Pemilik Kilang Kayu Kumai Bukan Warganegara" ||
                e.value == "5. Top 10 Pengeluar Kayu Kumai di Kilang Kayu Kumai" ||
                e.value == "6. Top 10 Kilang Kayu Kumai Dalam Penggunaan Spesies Kayu Balak Di Kilang Kayu Kumai" ||
                e.value == "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Kayu Kumai" ||


                e.value == "21. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan" ||
                e.value ==
                "23. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan" ||
                e.value == "24. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Dan Bulan" ||

                e.value == "31. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan" ||
                e.value ==
                "33. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Jenis Produk Dan Bulan" ||
                e.value == "34. Pengeluaran Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Dan Bulan" ||

                e.value == "341" ||
                e.value == "342" ||
                e.value == "393" ||
                e.value == "343" ||
                e.value == "344" ||
                e.value == "47. Jualan Eksport Kayu Gergaji Mengikut Bulan" ||
                e.value == "48. Jualan Eksport Kayu Gergaji Mengikut Negeri"

            ) {
                document.getElementById('tahun_s5_div').style.display = "block";
                document.getElementById('suku_tahun_s5_div').style.display = "none";
                document.getElementById('spesis_s5_div').style.display = "none";
                document.getElementById('suku_tahun_s5_akhir_div').style.display = "none";

                document.getElementById('range_tahun_s5_div').style.display = "none";
                document.getElementById('spesis_lama_s5_div').style.display = "none";

            } else if (
                e.value == "311" ||
                e.value == "312" ||
                e.value == "313" ||
                e.value == "314" ||
                e.value == "315"
            ) {
                document.getElementById('tahun_s5_div').style.display = "block";
                document.getElementById('suku_tahun_s5_div').style.display = "block";
                document.getElementById('suku_tahun_s5_akhir_div').style.display = "block";
                document.getElementById('spesis_s5_div').style.display = "none";
                document.getElementById('range_tahun_s5_div').style.display = "none";
                document.getElementById('spesis_lama_s5_div').style.display = "none";
            } else if (
                e.value == "22. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa" ||

                e.value ==
                "25. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Bagi Siri Masa" ||

                e.value == "32. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa" ||
                e.value ==
                "35. Pengeluaran Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Bagi Siri Masa" ||
                e.value == "46. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Bagi Siri Masa"

            ) {
                document.getElementById('tahun_s5_div').style.display = "none";
                document.getElementById('suku_tahun_s5_div').style.display = "none";
                document.getElementById('suku_tahun_s5_akhir_div').style.display = "none";
                document.getElementById('spesis_s5_div').style.display = "none";
                document.getElementById('range_tahun_s5_div').style.display = "block";
                document.getElementById('spesis_lama_s5_div').style.display = "none";
            } else {
                document.getElementById('tahun_s5_div').style.display = "none";
                document.getElementById('suku_tahun_s5_div').style.display = "none";
                document.getElementById('suku_tahun_s5_akhir_div').style.display = "none";
                document.getElementById('spesis_s5_div').style.display = "none";
                document.getElementById('range_tahun_s5_div').style.display = "none";
                document.getElementById('spesis_lama_s5_div').style.display = "none";
            }

            if (e.value == "6. Top 10 Kilang Kayu Kumai Dalam Penggunaan Spesies Kayu Balak Di Kilang Kayu Kumai") {
                document.getElementById('spesis_s5_div').style.display = "block";
                document.getElementById('spesis_lama_s5_div').style.display = "none";
            }

            if (e.value ==
                "36. Pengeluaran Kayu Gergaji Daripada Spesies Tertentu Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan") {
                document.getElementById('tahun_s5_div').style.display = "block";
                document.getElementById('suku_tahun_s5_div').style.display = "none";
                document.getElementById('suku_tahun_s5_akhir_div').style.display = "none";
                document.getElementById('spesis_s5_div').style.display = "block";
                document.getElementById('range_tahun_s5_div').style.display = "none";
                document.getElementById('spesis_lama_s5_div').style.display = "none";
            }

        }
    </script>


    {{-- validation shuttle 3 --}}
    <script>
        $("#tahun, #suku_tahun, #suku_tahun_akhir, #tahun_mula, #tahunakhir, #spesis, #spesis_lama").change(function() {
            var laporan = $("#laporan_list").val();

            if (
                laporan == "1. Maklumat Penuh Senarai Kilang Papan" ||
                laporan == "2. Senarai Pemilik Kilang Papan Bumiputera" ||
                laporan == "3. Senarai Pemilik Kilang Papan Bukan Bumiputera" ||
                laporan == "4. Senarai Pemilik Kilang Papan Bukan Warganegara" ||
                laporan == "5. Top 10 Pengeluar Kayu Gergaji di Kilang Papan" ||
                laporan == "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan" ||


                laporan == "21. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Dan Bulan" ||
                laporan ==
                "23. Penggunaan Kayu Balak Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan" ||
                laporan == "24. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan" ||

                laporan == "31. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Dan Bulan" ||
                laporan ==
                "33. Pengeluaran Kayu Gergaji Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan" ||
                laporan ==
                "34. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan" ||

                laporan == "41. Jualan Domestik Kayu Gergaji Mengikut Bulan" ||
                laporan == "42. Jualan Domestik Kayu Gergaji Mengikut Negeri" ||
                laporan == "43. Jualan Domestik Kayu Gergaji Mengikut Negeri Dan Bulan" ||
                laporan == "44. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Bulan" ||
                laporan == "45. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Negeri" ||
                laporan == "47. Jualan Eksport Kayu Gergaji Mengikut Bulan" ||
                laporan == "48. Jualan Eksport Kayu Gergaji Mengikut Negeri"
            ) {

                var tahun = $("#tahun").val();

                if (tahun != null) {

                    $("#submit_button").css("display", "block");
                    $("#submit_button_disable").css("display", "none");


                } else {

                    $("#submit_button").css("display", "none");
                    $("#submit_button_disable").css("display", "block");
                }

            } else if (
                laporan == "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Papan Mengikut Negeri Dan Jantina" ||
                laporan == "12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Papan" ||
                laporan == "13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan" ||
                laporan == "14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Papan" ||
                laporan ==
                "15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan"
            ) {
                var tahun = $("#tahun").val();
                var suku_tahun = $("#suku_tahun").val();
                var suku_tahun_akhir = $("#suku_tahun_akhir").val();

                if (tahun != null && suku_tahun != null && suku_tahun_akhir != null) {

                    $("#submit_button").css("display", "block");
                    $("#submit_button_disable").css("display", "none");
                } else {

                    $("#submit_button").css("display", "none");
                    $("#submit_button_disable").css("display", "block");
                }
            } else if (
                laporan == "22. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa" ||

                laporan ==
                "25. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa" ||

                laporan == "32. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa" ||
                laporan ==
                "35. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa" ||
                laporan == "46. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Bagi Siri Masa"
            ) {
                var tahun_mula = $("#tahun_mula").val();
                var tahunakhir = $("#tahunakhir").val();

                if (tahun_mula != null && tahunakhir != null) {

                    $("#submit_button").css("display", "block");
                    $("#submit_button_disable").css("display", "none");
                } else {

                    $("#submit_button").css("display", "none");
                    $("#submit_button_disable").css("display", "block");
                }
            } else if (
                laporan == "6. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak" ||
                laporan ==
                "36. Pengeluaran Kayu Gergaji Daripada Spesies Tertentu Oleh Kilang Papan Mengikut Negeri Dan Bulan"
            ) {
                var tahun = $("#tahun").val();
                var spesis = $("#spesis").val();
                var spesis_lama = $("#spesis_lama").val();


                if (tahun != null) {

                    if (tahun > 2021) {
                        if (spesis != null) {
                            $("#submit_button").css("display", "block");
                            $("#submit_button_disable").css("display", "none");
                        } else {
                            $("#submit_button").css("display", "none");
                            $("#submit_button_disable").css("display", "block");
                        }
                    } else {
                        if (spesis_lama != null) {
                            $("#submit_button").css("display", "block");
                            $("#submit_button_disable").css("display", "none");
                        } else {
                            $("#submit_button").css("display", "none");
                            $("#submit_button_disable").css("display", "block");
                        }
                    }


                } else {

                    $("#submit_button").css("display", "none");
                    $("#submit_button_disable").css("display", "block");
                }

            }


        });
    </script>

    {{-- validation shuttle 4 --}}
    <script>
        $("#tahun_4, #suku_tahun_4, #suku_tahun_akhir_4, #tahun_mula_4, #tahunakhir_4, #spesis_4, #spesis_lama_4").change(
            function() {
                var laporan = $("#laporan_list_4").val();
                if (
                    laporan == "1. Maklumat Penuh Senarai Kilang Papan Lapis/Venir" ||
                    laporan == "2. Senarai Pemilik Kilang Papan Lapis/Venir Bumiputera" ||
                    laporan == "3. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Bumiputera" ||
                    laporan == "4. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Warganegara" ||
                    laporan == "5. Top 10 Pengeluar Papan Lapis di Kilang Papan Lapis/Venir" ||
                    laporan == "6. Top 10 Pengeluar Venir di Kilang Papan Lapis/Venir" ||
                    laporan == "8. Jumlah Pelaburan (Harta Tetap) Bagi Kilang Papan Lapis/Venir" ||
                    laporan == "9. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan Lapis/Venir" ||

                    laporan == "21. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Dan Bulan" ||
                    laporan ==
                    "23. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan" ||
                    laporan ==
                    "24. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Dan Bulan" ||

                    laporan == "31. Pengeluaran Papan Lapis Mengikut Negeri Dan Bulan" ||
                    laporan == "33. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan Mengikut Jenis" ||
                    laporan == "35. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan Mengikut Ketebalan" ||
                    laporan == "36. Pengeluaran Venir Mengikut Negeri Dan Bulan" ||
                    laporan == "38. Pengeluaran Venir Bagi Negeri-Negeri Dan Bulan Mengikut Jenis" ||

                    laporan == "41. Jualan Domestik Papan Lapis/Venir Mengikut Bulan" ||
                    laporan == "42. Jualan Domestik Papan Lapis/Venir Mengikut Negeri" ||
                    laporan == "43. Jualan Domestik Papan Lapis Mengikut Negeri Dan Bulan" ||
                    laporan == "44. Jualan Domestik Venir Mengikut Negeri Dan Bulan" ||
                    laporan == "45. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Bulan" ||
                    laporan == "46. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Negeri" ||
                    laporan == "48. Jualan Eksport Papan Lapis/Venir Mengikut Bulan" ||
                    laporan == "49. Jualan Eksport Papan Lapis/Venir Mengikut Negeri"

                ) {
                    var tahun = $("#tahun_4").val();

                    if (tahun != null) {

                        $("#submit_button").css("display", "block");
                        $("#submit_button_disable").css("display", "none");
                    } else {

                        $("#submit_button").css("display", "none");
                        $("#submit_button_disable").css("display", "block");
                    }

                } else if (
                    laporan == "211" ||
                    laporan == "212" ||
                    laporan == "213" ||
                    laporan == "214" ||
                    laporan == "215"
                ) {
                    var tahun = $("#tahun_4").val();
                    var suku_tahun = $("#suku_tahun_4").val();
                    var suku_tahun_akhir = $("#suku_tahun_akhir_4").val();

                    if (tahun != null && suku_tahun != null && suku_tahun_akhir != null) {

                        $("#submit_button").css("display", "block");
                        $("#submit_button_disable").css("display", "none");
                    } else {

                        $("#submit_button").css("display", "none");
                        $("#submit_button_disable").css("display", "block");
                    }
                } else if (
                    laporan == "22. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Bagi Siri Masa" ||
                    laporan == "25. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Bagi Siri Masa" ||

                    laporan == "32. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa" ||
                    laporan == "34. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Ketebalan Bagi Siri Masa" ||
                    laporan == "37. Pengeluaran Venir Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa" ||
                    laporan == "47. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Bagi Siri Masa"

                ) {
                    var tahun_mula = $("#tahun_mula_4").val();
                    var tahunakhir = $("#tahunakhir_4").val();

                    if (tahun_mula != null && tahunakhir != null) {

                        $("#submit_button").css("display", "block");
                        $("#submit_button_disable").css("display", "none");
                    } else {

                        $("#submit_button").css("display", "none");
                        $("#submit_button_disable").css("display", "block");
                    }
                } else if (
                    laporan ==
                    "7. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak Di Kilang Papan Lapis/Venir"
                ) {
                    var tahun = $("#tahun_4").val();
                    var spesis = $("#spesis_4").val();
                    var spesis_lama = $("#spesis_lama_4").val();

                    if (tahun != null) {
                        if (tahun > 2021) {
                            if (spesis != null) {
                                $("#submit_button").css("display", "block");
                                $("#submit_button_disable").css("display", "none");
                            } else {
                                $("#submit_button").css("display", "none");
                                $("#submit_button_disable").css("display", "block");
                            }
                        } else {
                            if (spesis_lama != null) {
                                $("#submit_button").css("display", "block");
                                $("#submit_button_disable").css("display", "none");
                            } else {
                                $("#submit_button").css("display", "none");
                                $("#submit_button_disable").css("display", "block");
                            }
                        }


                    } else {

                        $("#submit_button").css("display", "none");
                        $("#submit_button_disable").css("display", "block");
                    }

                }


            });
    </script>

    {{-- validation shuttle 5 --}}
    <script>
        $("#tahun_5, #suku_tahun_5, #suku_tahun_akhir_5, #tahun_mula_5, #tahunakhir_5, #spesis_5, #spesis_lama_5").change(
            function() {
                var laporan = $("#laporan_list_5").val();
                if (
                    laporan == "1. Maklumat Penuh Senarai Kilang Kayu Kumai" ||
                    laporan == "2. Senarai Pemilik Kilang Kayu Kumai Bumiputera" ||
                    laporan == "3. Senarai Pemilik Kilang Kayu Kumai Bukan Bumiputera" ||
                    laporan == "4. Senarai Pemilik Kilang Kayu Kumai Bukan Warganegara" ||
                    laporan == "5. Top 10 Pengeluar Kayu Kumai di Kilang Kayu Kumai" ||
                    laporan == "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Kayu Kumai" ||


                    laporan == "21. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan" ||
                    laporan ==
                    "23. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan" ||
                    laporan ==
                    "24. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Dan Bulan" ||

                    laporan == "31. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan" ||
                    laporan ==
                    "33. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Jenis Produk Dan Bulan" ||

                    laporan ==
                    "341" ||

                    laporan ==
                    "342" ||

                    laporan ==
                    "393" ||
                    laporan ==
                    "343" ||
                    laporan ==
                    "344"

                ) {
                    var tahun = $("#tahun_5").val();

                    if (tahun != null) {

                        $("#submit_button").css("display", "block");
                        $("#submit_button_disable").css("display", "none");
                    } else {

                        $("#submit_button").css("display", "none");
                        $("#submit_button_disable").css("display", "block");
                    }

                } else if (
                    laporan == "311" ||
                    laporan == "312" ||
                    laporan == "313" ||
                    laporan == "314" ||
                    laporan == "315"
                ) {
                    var tahun = $("#tahun_5").val();
                    var suku_tahun = $("#suku_tahun_5").val();
                    var suku_tahun_akhir = $("#suku_tahun_akhir_5").val();

                    if (tahun != null && suku_tahun != null && suku_tahun_akhir != null) {

                        $("#submit_button").css("display", "block");
                        $("#submit_button_disable").css("display", "none");
                    } else {

                        $("#submit_button").css("display", "none");
                        $("#submit_button_disable").css("display", "block");
                    }
                } else if (
                    laporan == "22. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa" ||

                    laporan ==
                    "25. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Bagi Siri Masa" ||

                    laporan == "32. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa"
                ) {
                    var tahun_mula = $("#tahun_mula_5").val();
                    var tahunakhir = $("#tahunakhir_5").val();

                    if (tahun_mula != null && tahunakhir != null) {

                        $("#submit_button").css("display", "block");
                        $("#submit_button_disable").css("display", "none");
                    } else {

                        $("#submit_button").css("display", "none");
                        $("#submit_button_disable").css("display", "block");
                    }
                } else if (
                    laporan == "6. Top 10 Kilang Kayu Kumai Dalam Penggunaan Spesies Kayu Balak Di Kilang Kayu Kumai"
                ) {
                    var tahun = $("#tahun_5").val();
                    var spesis = $("#spesis_5").val();
                    var spesis_lama = $("#spesis_lama_5").val();


                    if (tahun != null) {

                        if (tahun > 2021) {
                            if (spesis != null) {
                                $("#submit_button").css("display", "block");
                                $("#submit_button_disable").css("display", "none");
                            } else {
                                $("#submit_button").css("display", "none");
                                $("#submit_button_disable").css("display", "block");
                            }
                        } else {
                            if (spesis_lama != null) {
                                $("#submit_button").css("display", "block");
                                $("#submit_button_disable").css("display", "none");
                            } else {
                                $("#submit_button").css("display", "none");
                                $("#submit_button_disable").css("display", "block");
                            }
                        }


                    } else {

                        $("#submit_button").css("display", "none");
                        $("#submit_button_disable").css("display", "block");
                    }

                }


            });
    </script>

    <script>
        // reset input shuttle
        $("#tab_s3, #tab_s4, #tab_s5").click(
            function() {

                //hide div all div shuttle 3
                $("#spesis_lama_s3_div").css("display", "none");
                $("#spesis_s3_div").css("display", "none");
                $("#tahun_s3_div").css("display", "none");
                $("#suku_tahun_s3_div").css("display", "none");
                $("#suku_tahun_s3_akhir_div").css("display", "none");
                $("#spesis_s3_div").css("display", "none");
                $("#range_tahun_s3_div").css("display", "none");
                $("#spesis_lama_s3_div").css("display", "none");

                //hide div all div shuttle 4
                $("#spesis_lama_s4_div").css("display", "none");
                $("#spesis_s4_div").css("display", "none");
                $("#tahun_s4_div").css("display", "none");
                $("#suku_tahun_s4_div").css("display", "none");
                $("#suku_tahun_s4_akhir_div").css("display", "none");
                $("#spesis_s4_div").css("display", "none");
                $("#range_tahun_s4_div").css("display", "none");
                $("#spesis_lama_s4_div").css("display", "none");

                //hide div all div shuttle 5
                $("#spesis_lama_s5_div").css("display", "none");
                $("#spesis_s5_div").css("display", "none");
                $("#tahun_s5_div").css("display", "none");
                $("#suku_tahun_s5_div").css("display", "none");
                $("#suku_tahun_s5_akhir_div").css("display", "none");
                $("#spesis_s5_div").css("display", "none");
                $("#range_tahun_s5_div").css("display", "none");
                $("#spesis_lama_s5_div").css("display", "none");

                //disable submit button
                $("#submit_button").css("display", "none");
                $("#submit_button_disable").css("display", "block");

                //reset shuttle 3
                $('#laporan_list').prop('selectedIndex', 0);
                $('#tahun').prop('selectedIndex', 0);
                $('#spesis').prop('selectedIndex', 0);
                $('#spesis_lama').prop('selectedIndex', 0);
                $('#tahun_mula').prop('selectedIndex', 0);
                $('#tahunakhir').prop('selectedIndex', 0);
                $('#suku_tahun').prop('selectedIndex', 0);
                $('#suku_tahun_akhir').prop('selectedIndex', 0);

                // reset shuttle 4
                $('#laporan_list_4').prop('selectedIndex', 0);
                $('#tahun_4').prop('selectedIndex', 0);
                $('#spesis_4').prop('selectedIndex', 0);
                $('#spesis_lama_4').prop('selectedIndex', 0);
                $('#tahun_mula_4').prop('selectedIndex', 0);
                $('#tahunakhir_4').prop('selectedIndex', 0);
                $('#suku_tahun_4').prop('selectedIndex', 0);
                $('#suku_tahun_akhir_4').prop('selectedIndex', 0);

                // reset shuttle 5
                $('#laporan_list_5').prop('selectedIndex', 0);
                $('#tahun_5').prop('selectedIndex', 0);
                $('#spesis_5').prop('selectedIndex', 0);
                $('#spesis_lama_5').prop('selectedIndex', 0);
                $('#tahun_mula_5').prop('selectedIndex', 0);
                $('#tahunakhir_5').prop('selectedIndex', 0);
                $('#suku_tahun_5').prop('selectedIndex', 0);
                $('#suku_tahun_akhir_5').prop('selectedIndex', 0);

                //reset css border shuttle 3
                $("#laporan_list").css("border", "#0074ff 1px solid");

                //reset css border shuttle 4
                $("#laporan_list_4").css("border", "#0074ff 1px solid");

                //reset css border shuttle 5
                $("#laporan_list_5").css("border", "#0074ff 1px solid");

            });
    </script>

    <script>
        //shuttle 3 css validation
        $("#jana_laporan_disabled").click(
            function() {

                var laporan = $("#laporan_list").val();

                if (laporan == null) {
                    $("#laporan_list").css("border", "red 1px solid");
                } else {

                    if (
                        laporan == "1. Maklumat Penuh Senarai Kilang Papan" ||
                        laporan == "2. Senarai Pemilik Kilang Papan Bumiputera" ||
                        laporan == "3. Senarai Pemilik Kilang Papan Bukan Bumiputera" ||
                        laporan == "4. Senarai Pemilik Kilang Papan Bukan Warganegara" ||
                        laporan == "5. Top 10 Pengeluar Kayu Gergaji di Kilang Papan" ||
                        laporan == "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan" ||


                        laporan == "21. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Dan Bulan" ||
                        laporan ==
                        "23. Penggunaan Kayu Balak Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan" ||
                        laporan ==
                        "24. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan" ||

                        laporan == "31. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Dan Bulan" ||
                        laporan ==
                        "33. Pengeluaran Kayu Gergaji Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan" ||
                        laporan ==
                        "34. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan" ||

                        laporan == "41. Jualan Domestik Kayu Gergaji Mengikut Bulan" ||
                        laporan == "42. Jualan Domestik Kayu Gergaji Mengikut Negeri" ||
                        laporan == "43. Jualan Domestik Kayu Gergaji Mengikut Negeri Dan Bulan" ||
                        laporan == "44. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Bulan" ||
                        laporan == "45. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Negeri" ||
                        laporan == "47. Jualan Eksport Kayu Gergaji Mengikut Bulan" ||
                        laporan == "48. Jualan Eksport Kayu Gergaji Mengikut Negeri"
                    ) {
                        var tahun = $("#tahun").val();
                        if (tahun == null) {
                            $("#tahun").css("border", "red 1px solid");
                        }
                    } else if (
                        laporan == "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Papan Mengikut Negeri Dan Jantina" ||
                        laporan == "12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Papan" ||
                        laporan == "13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan" ||
                        laporan == "14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Papan" ||
                        laporan ==
                        "15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan"
                    ) {
                        var tahun = $("#tahun").val();
                        if (tahun == null) {
                            $("#tahun").css("border", "red 1px solid");
                        }

                        var suku_tahun = $("#suku_tahun").val();
                        if (suku_tahun == null) {
                            $("#suku_tahun").css("border", "red 1px solid");
                        }

                        var suku_tahun_akhir = $("#suku_tahun_akhir").val();
                        if (suku_tahun_akhir == null) {
                            $("#suku_tahun_akhir").css("border", "red 1px solid");
                        }

                    } else if (
                        laporan == "22. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa" ||

                        laporan ==
                        "25. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa" ||

                        laporan == "32. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa" ||
                        laporan ==
                        "35. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa" ||
                        laporan == "46. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Bagi Siri Masa"
                    ) {
                        var tahun_mula = $("#tahun_mula").val();
                        if (tahun_mula == null) {
                            $("#tahun_mula").css("border", "red 1px solid");
                        }

                        var tahunakhir = $("#tahunakhir").val();
                        if (tahunakhir == null) {
                            $("#tahunakhir").css("border", "red 1px solid");
                        }
                    } else if (
                        laporan == "6. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak" ||
                        laporan ==
                        "36. Pengeluaran Kayu Gergaji Daripada Spesies Tertentu Oleh Kilang Papan Mengikut Negeri Dan Bulan"
                    ) {
                        var tahun = $("#tahun").val();
                        if (tahun == null) {
                            $("#tahun").css("border", "red 1px solid");

                            var spesis = $("#spesis").val();
                            if (spesis == null) {
                                $("#spesis").css("border", "red 1px solid");
                                $("#spesis_lama").css("border", "red 1px solid");
                            }
                        } else {
                            if (tahun > 2020) {
                                var spesis = $("#spesis").val();
                                if (spesis == null) {
                                    $("#spesis").css("border", "red 1px solid");
                                }
                            } else if (tahun <= 2020) {
                                var spesis_lama = $("#spesis_lama").val();
                                if (spesis_lama == null) {
                                    $("#spesis_lama").css("border", "red 1px solid");
                                }
                            }
                        }

                    }

                }

            });

        //shuttle 3
        $("#laporan_list").change(
            function() {

                var laporan = $("#laporan_list").val();

                if (laporan != null) {
                    $("#laporan_list").css("border", "#0074ff 1px solid");
                }


            });

        $("#tahun").change(
            function() {

                var tahun = $("#tahun").val();

                if (tahun != null) {
                    $("#tahun").css("border", "#0074ff 1px solid");
                }


            });

        $("#suku_tahun").change(
            function() {

                var suku_tahun = $("#suku_tahun").val();

                if (suku_tahun != null) {
                    $("#suku_tahun").css("border", "#0074ff 1px solid");
                }


            });

        $("#suku_tahun_akhir").change(
            function() {

                var suku_tahun_akhir = $("#suku_tahun_akhir").val();

                if (suku_tahun_akhir != null) {
                    $("#suku_tahun_akhir").css("border", "#0074ff 1px solid");
                }


            });

        $("#tahun_mula").change(
            function() {

                var tahun_mula = $("#tahun_mula").val();

                if (tahun_mula != null) {
                    $("#tahun_mula").css("border", "#0074ff 1px solid");
                }


            });

        $("#tahunakhir").change(
            function() {

                var tahunakhir = $("#tahunakhir").val();

                if (tahunakhir != null) {
                    $("#tahunakhir").css("border", "#0074ff 1px solid");
                }


            });

        $("#spesis").change(
            function() {

                var spesis = $("#spesis").val();

                if (spesis != null) {
                    $("#spesis").css("border", "#0074ff 1px solid");
                }

            });

        $("#spesis_lama").change(
            function() {

                var spesis_lama = $("#spesis_lama").val();

                if (spesis_lama != null) {
                    $("#spesis_lama").css("border", "#0074ff 1px solid");
                }

            });

        //shuttle 4 css validation
        $("#jana_laporan_disabled").click(
            function() {

                var laporan = $("#laporan_list_4").val();

                if (laporan == null) {
                    $("#laporan_list_4").css("border", "red 1px solid");
                } else {

                    if (
                        laporan == "1. Maklumat Penuh Senarai Kilang Papan Lapis/Venir" ||
                        laporan == "2. Senarai Pemilik Kilang Papan Lapis/Venir Bumiputera" ||
                        laporan == "3. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Bumiputera" ||
                        laporan == "4. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Warganegara" ||
                        laporan == "5. Top 10 Pengeluar Papan Lapis di Kilang Papan Lapis/Venir" ||
                        laporan == "6. Top 10 Pengeluar Venir di Kilang Papan Lapis/Venir" ||
                        laporan ==
                        "7. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak Di Kilang Papan Lapis/Venir" ||
                        laporan == "8. Jumlah Pelaburan (Harta Tetap) Bagi Kilang Papan Lapis/Venir" ||
                        laporan == "9. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan Lapis/Venir" ||

                        laporan ==
                        "21. Penggunaan Kayu Gergaji Oleh Kilang Papan Lapis/Venir Mengikut Negeri Dan Bulan" ||
                        laporan ==
                        "23. Penggunaan Kayu Gergaji Oleh Kilang Papan Lapis/Venir Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan" ||
                        laporan ==
                        "24. Penggunaan Kayu Gergaji Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Dan Bulan" ||

                        laporan ==
                        "31. Pengeluaran Papan Lapis/Venir Oleh Kilang Papan Lapis/Venir Mengikut Negeri Dan Bulan" ||
                        laporan ==
                        "33. Pengeluaran Papan Lapis/Venir Oleh Kilang Papan Lapis/Venir Mengikut Jenis Produk Dan Bulan" ||

                        laporan ==
                        "341" ||

                        laporan ==
                        "342" ||

                        laporan ==
                        "393" ||
                        laporan ==
                        "343" ||
                        laporan ==
                        "344"
                    ) {
                        var tahun = $("#tahun").val();
                        if (tahun == null) {
                            $("#tahun_4").css("border", "red 1px solid");
                        }
                    } else if (
                        laporan == "211" ||
                        laporan == "212" ||
                        laporan == "213" ||
                        laporan == "214" ||
                        laporan == "215"
                    ) {
                        var tahun = $("#tahun_4").val();
                        if (tahun == null) {
                            $("#tahun_4").css("border", "red 1px solid");
                        }

                        var suku_tahun = $("#suku_tahun_4").val();
                        if (suku_tahun == null) {
                            $("#suku_tahun_4").css("border", "red 1px solid");
                        }

                        var suku_tahun_akhir = $("#suku_tahun_akhir_4").val();
                        if (suku_tahun_akhir == null) {
                            $("#suku_tahun_akhir_4").css("border", "red 1px solid");
                        }

                    } else if (
                        laporan ==
                        "22. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Bagi Siri Masa" ||

                        laporan ==
                        "24. Penggunaan Kayu Gergaji Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Bagi Siri Masa" ||

                        laporan ==
                        "32. Pengeluaran Papan Lapis/Venir Oleh Kilang Papan Lapis/Venir Mengikut Negeri Bagi Siri Masa"
                    ) {
                        var tahun_mula = $("#tahun_mula").val();
                        if (tahun_mula == null) {
                            $("#tahun_mula_4").css("border", "red 1px solid");
                        }

                        var tahunakhir = $("#tahunakhir").val();
                        if (tahunakhir == null) {
                            $("#tahunakhir_4").css("border", "red 1px solid");
                        }
                    } else if (
                        laporan ==
                        "7. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak Di Kilang Papan Lapis/Venir"
                    ) {
                        var tahun_4 = $("#tahun_4").val();
                        if (tahun_4 == null) {
                            $("#tahun_4").css("border", "red 1px solid");

                            var spesis = $("#spesis_4").val();
                            if (spesis == null) {
                                $("#spesis_4").css("border", "red 1px solid");
                                $("#spesis_lama_4").css("border", "red 1px solid");
                            }
                        } else {
                            if (tahun > 2020) {
                                var spesis = $("#spesis_4").val();
                                if (spesis == null) {
                                    $("#spesis_4").css("border", "red 1px solid");
                                }
                            } else if (tahun <= 2020) {
                                var spesis_lama = $("#spesis_lama_4").val();
                                if (spesis_lama == null) {
                                    $("#spesis_lama_4").css("border", "red 1px solid");
                                }
                            }
                        }

                    }

                }

            });

        //shuttle 4
        $("#laporan_list_4").change(
            function() {

                var laporan = $("#laporan_list_4").val();

                if (laporan != null) {
                    $("#laporan_list_4").css("border", "#0074ff 1px solid");
                }
            });

        $("#tahun_4").change(
            function() {

                var tahun_4 = $("#tahun_4").val();

                if (tahun_4 != null) {
                    $("#tahun_4").css("border", "#0074ff 1px solid");
                }


            });

        $("#suku_tahun_4").change(
            function() {

                var suku_tahun_4 = $("#suku_tahun_4").val();

                if (suku_tahun_4 != null) {
                    $("#suku_tahun_4").css("border", "#0074ff 1px solid");
                }


            });

        $("#suku_tahun_akhir_4").change(
            function() {

                var suku_tahun_akhir_4 = $("#suku_tahun_akhir_4").val();

                if (suku_tahun_akhir_4 != null) {
                    $("#suku_tahun_akhir_4").css("border", "#0074ff 1px solid");
                }


            });

        $("#tahun_mula_4").change(
            function() {

                var tahun_mula_4 = $("#tahun_mula_4").val();

                if (tahun_mula_4 != null) {
                    $("#tahun_mula_4").css("border", "#0074ff 1px solid");
                }


            });

        $("#tahunakhir_4").change(
            function() {

                var tahunakhir_4 = $("#tahunakhir_4").val();

                if (tahunakhir_4 != null) {
                    $("#tahunakhir_4").css("border", "#0074ff 1px solid");
                }


            });

        $("#spesis_4").change(
            function() {

                var spesis_4 = $("#spesis_4").val();

                if (spesis_4 != null) {
                    $("#spesis_4").css("border", "#0074ff 1px solid");
                }

            });

        $("#spesis_lama_4").change(
            function() {

                var spesis_lama_4 = $("#spesis_lama_4").val();

                if (spesis_lama_4 != null) {
                    $("#spesis_lama_4").css("border", "#0074ff 1px solid");
                }

            });


        //shuttle 5 css validation
        $("#jana_laporan_disabled").click(
            function() {

                var laporan = $("#laporan_list_5").val();

                if (laporan == null) {
                    $("#laporan_list_5").css("border", "red 1px solid");
                } else {

                    if (
                        laporan == "1. Maklumat Penuh Senarai Kilang Kayu Kumai" ||
                        laporan == "2. Senarai Pemilik Kilang Kayu Kumai Bumiputera" ||
                        laporan == "3. Senarai Pemilik Kilang Kayu Kumai Bukan Bumiputera" ||
                        laporan == "4. Senarai Pemilik Kilang Kayu Kumai Bukan Warganegara" ||
                        laporan == "5. Top 10 Pengeluar Kayu Kumai di Kilang Kayu Kumai" ||
                        laporan == "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Kayu Kumai" ||


                        laporan == "21. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan" ||
                        laporan ==
                        "23. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan" ||
                        laporan ==
                        "24. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Dan Bulan" ||

                        laporan == "31. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan" ||
                        laporan ==
                        "33. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Jenis Produk Dan Bulan" ||

                        laporan ==
                        "341" ||

                        laporan ==
                        "342" ||

                        laporan ==
                        "393" ||
                        laporan ==
                        "343" ||
                        laporan ==
                        "344"
                    ) {
                        var tahun = $("#tahun_5").val();
                        if (tahun == null) {
                            $("#tahun_5").css("border", "red 1px solid");
                        }
                    } else if (
                        laporan == "311" ||
                        laporan == "312" ||
                        laporan == "313" ||
                        laporan == "314" ||
                        laporan == "315"
                    ) {
                        var tahun = $("#tahun_5").val();
                        if (tahun == null) {
                            $("#tahun_5").css("border", "red 1px solid");
                        }

                        var suku_tahun = $("#suku_tahun_5").val();
                        if (suku_tahun == null) {
                            $("#suku_tahun_5").css("border", "red 1px solid");
                        }

                        var suku_tahun_akhir = $("#suku_tahun_akhir_5").val();
                        if (suku_tahun_akhir == null) {
                            $("#suku_tahun_akhir_5").css("border", "red 1px solid");
                        }

                    } else if (
                        laporan ==
                        "22. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa" ||

                        laporan ==
                        "25. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Bagi Siri Masa" ||

                        laporan == "32. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa"
                    ) {
                        var tahun_mula = $("#tahun_mula_5").val();
                        if (tahun_mula == null) {
                            $("#tahun_mula_5").css("border", "red 1px solid");
                        }

                        var tahunakhir = $("#tahunakhir_5").val();
                        if (tahunakhir == null) {
                            $("#tahunakhir_5").css("border", "red 1px solid");
                        }
                    }
                    else if (
                        laporan ==
                        "6. Top 10 Kilang Kayu Kumai Dalam Penggunaan Spesies Kayu Balak Di Kilang Kayu Kumai"
                    ) {
                        var tahun_5 = $("#tahun_5").val();
                        if (tahun_5 == null) {
                            $("#tahun_5").css("border", "red 1px solid");

                            var spesis = $("#spesis_5").val();
                            if (spesis == null) {
                                $("#spesis_5").css("border", "red 1px solid");
                                $("#spesis_lama_5").css("border", "red 1px solid");
                            }
                        } else {
                            if (tahun > 2020) {
                                var spesis = $("#spesis_5").val();
                                if (spesis == null) {
                                    $("#spesis_5").css("border", "red 1px solid");
                                }
                            } else if (tahun <= 2020) {
                                var spesis_lama = $("#spesis_lama_5").val();
                                if (spesis_lama == null) {
                                    $("#spesis_lama_5").css("border", "red 1px solid");
                                }
                            }
                        }

                    }

                }

            });

        //shuttle 5
        $("#laporan_list_5").change(
            function() {

                var laporan = $("#laporan_list_5").val();

                if (laporan != null) {
                    $("#laporan_list_5").css("border", "#0074ff 1px solid");
                }
            });

        $("#tahun_5").change(
            function() {

                var tahun_5 = $("#tahun_5").val();

                if (tahun_5 != null) {
                    $("#tahun_5").css("border", "#0074ff 1px solid");
                }


            });

        $("#suku_tahun_5").change(
            function() {

                var suku_tahun_5 = $("#suku_tahun_5").val();

                if (suku_tahun_5 != null) {
                    $("#suku_tahun_5").css("border", "#0074ff 1px solid");
                }


            });

        $("#suku_tahun_akhir_5").change(
            function() {

                var suku_tahun_akhir_5 = $("#suku_tahun_akhir_5").val();

                if (suku_tahun_akhir_5 != null) {
                    $("#suku_tahun_akhir_5").css("border", "#0074ff 1px solid");
                }


            });

        $("#tahun_mula_5").change(
            function() {

                var tahun_mula_5 = $("#tahun_mula_5").val();

                if (tahun_mula_5 != null) {
                    $("#tahun_mula_5").css("border", "#0074ff 1px solid");
                }


            });

        $("#tahunakhir_5").change(
            function() {

                var tahunakhir_5 = $("#tahunakhir_5").val();

                if (tahunakhir_5 != null) {
                    $("#tahunakhir_5").css("border", "#0074ff 1px solid");
                }


            });

        $("#spesis_5").change(
            function() {

                var spesis_5 = $("#spesis_5").val();

                if (spesis_5 != null) {
                    $("#spesis_5").css("border", "#0074ff 1px solid");
                }

            });

        $("#spesis_lama_5").change(
            function() {

                var spesis_lama_5 = $("#spesis_lama_5").val();

                if (spesis_lama_5 != null) {
                    $("#spesis_lama_5").css("border", "#0074ff 1px solid");
                }

            });
    </script>
@endsection
