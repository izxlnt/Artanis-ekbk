<div class="container-fluid">

    <div class="row">

        <div class="col-md-12">
            <div class="rounded-lg card" style="border-color: #000000 !important;">
                <div class="card-header"
                    style="text-align:center; background-color: #ee8dcd !important; font-size: 130%; font-weight: bold;">
                    BORANG 4B - JUMLAH GUNA TENAGA PADA AKHIR BULAN
                </div>

                <div class="card-body">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <form wire:submit.prevent='store'>
                            <table class="table table-striped table-bordered" id="" style="width: 100%;">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="form-horizontal">
                                                <div class="card-body">

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Tahun:</label>
                                                            <input type="text" class="form-control"
                                                                style="background-color: #f8dbee; border-color: #d89bc4"
                                                                value="{{ $kilang_info->tahun }}" readonly />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Suku Tahun:</label>
                                                            <input type="text" class="form-control"
                                                                style="background-color: #f8dbee;" wire:model='suku'
                                                                readonly />
                                                        </div>
                                                    </div>
                                                    <br>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Nama Kilang:</label>

                                                            <input type="text" class="form-control"
                                                                style="background-color: #f8dbee;"
                                                                value="{{ $kilang_info->nama_kilang }}" readonly />

                                                        </div>
                                                        <div class="col-md-6">

                                                            <label>No. Pendaftaran Syarikat (SSM):</label>

                                                            <input type="text" class="form-control"
                                                                style="background-color: #f8dbee;"
                                                                value="{{ $kilang_info->no_ssm }}" readonly />

                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-3"></div>
                                                        <div class="col-md-6">
                                                            <label>No. Lesen:</label>

                                                            <input type="text" class="form-control"
                                                                style="background-color: #f8dbee;"
                                                                value="{{ $kilang_info->no_lesen }}" readonly />


                                                        </div>
                                                    </div>



                                                    <table>

                                                        <tr style="height:50px;">
                                                            <th style="text-align:center;" colspan="2" rowspan="4">
                                                                Kategori Pekerja
                                                            </th>
                                                            <th style="text-align:center;" colspan="4">
                                                                Warganegara Malaysia</th>
                                                            <th style="text-align:center;" colspan="2" rowspan="3">Bukan
                                                                Warganegara
                                                                Malaysia</th>
                                                            <th style="text-align:center;" colspan="3" rowspan="3">
                                                                Jumlah Pekerja</th>
                                                            <th style="text-align:center;" colspan="3" rowspan="3">
                                                                Bayaran Gaji dan Upah
                                                                Per Pekerja (Sebulan) (RM/ bulan/ pekerja)</th>
                                                            <th style="text-align:center;" colspan="3" rowspan="3">
                                                                Jumlah Bayaran Gaji
                                                                dan Upah (Sebulan) (RM)</th>
                                                        </tr>
                                                        <tr style="height:50px;">
                                                            <th style="text-align:center;" colspan="2" rowspan="2">
                                                                Bumiputera</th>
                                                            <th style="text-align:center;" colspan="2" rowspan="2">Bukan
                                                                Bumiputera</th>
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
                                                            <th style="text-align:center;">(08)=(02)+(04)+(06)
                                                            </th>
                                                            <th style="text-align:center;">(09)=(03)+(05)+(07)
                                                            </th>
                                                            <th style="text-align:center;">(10)=(08)+(09)</th>
                                                            <th style="text-align:center;">(11)</th>
                                                            <th style="text-align:center;">(12)</th>
                                                            <th style="text-align:center;">(13)=(11)+(12)</th>
                                                            <th style="text-align:center;">(14)=(08)*(11)</th>
                                                            <th style="text-align:center;">(15)=(09)*(12)</th>
                                                            <th style="text-align:center;">(16)=(14)+(15)</th>
                                                        </tr>

                                                        @forelse($kategori_pekerja as $key=>$data)
                                                            <tr style="height:50px;">

                                                                <td style="text-align:center;">
                                                                    {{ $data->keterangan }}</td>
                                                                <td style="text-align:center;width:30px;">
                                                                    {{ $i = $loop->iteration }}</td>
                                                                <td style="text-align:center;padding:5px"><input
                                                                        type="text" size="3"
                                                                        wire:model='pekerja_wargabumi_lelaki.{{ $key }}'
                                                                        wire:change="calcJumlahPekerjaLelaki({{ $key }});"
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;padding:5px"><input
                                                                        type="text" size="3"
                                                                        wire:model='pekerja_wargabumi_perempuan.{{ $key }}'
                                                                        wire:change="calcJumlahPekerjaPerempuan({{ $key }})"
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;padding:5px"><input
                                                                        type="text" size="3"
                                                                        wire:model='pekerja_bukan_wargabumi_lelaki.{{ $key }}'
                                                                        wire:change="calcJumlahPekerjaLelaki({{ $key }})"
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;padding:5px"><input
                                                                        type="text" size="3"
                                                                        wire:model='pekerja_bukan_wargabumi_perempuan.{{ $key }}'
                                                                        wire:change="calcJumlahPekerjaPerempuan({{ $key }})"
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;"><input type="text"
                                                                        size="3"
                                                                        wire:model='pekerja_asing_lelaki.{{ $key }}'
                                                                        wire:change="calcJumlahPekerjaLelaki({{ $key }})"
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;"><input type="text"
                                                                        size="3"
                                                                        wire:model='pekerja_asing_perempuan.{{ $key }}'
                                                                        wire:change="calcJumlahPekerjaPerempuan({{ $key }})"
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;"><input readonly
                                                                        type="text" style="background-color: #f8dbee;"
                                                                        size="3"
                                                                        wire:model='jumlah_lelaki.{{ $key }}'
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;"><input readonly type
                                                                        type="text" style="background-color: #f8dbee;"
                                                                        size="3"
                                                                        wire:model='jumlah_perempuan.{{ $key }}'
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;"><input readonly type
                                                                        type="text" style="background-color: #f8dbee;"
                                                                        size="3"
                                                                        wire:model='jumlah_pekerja.{{ $key }}'
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>

                                                                <td style="text-align:center;">
                                                                    <input type="text" size="3"
                                                                        wire:model='gaji_lelaki.{{ $key }}'
                                                                        wire:change="calcTotalAllBayaranGajiPerPekerjaLelakiPerempuan({{ $key }})"
                                                                        style="@error('gaji_lelaki.' . $key) color:red @else color:black @endif"
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>

                                                                <td style="text-align:center;">
                                                                    <input type="text" size="3"
                                                                        wire:model='gaji_perempuan.{{ $key }}'
                                                                        wire:change="calcTotalAllBayaranGajiPerPekerjaLelakiPerempuan({{ $key }})"
                                                                        style="@error('gaji_perempuan.' . $key) color:red @else color:black @endif"
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>

                                                                <td style="text-align:center;"><input readonly
                                                                        type="text" size="3"
                                                                        style="background-color: #f8dbee;"
                                                                        wire:model='gaji_lelaki_perempuan.{{ $key }}'
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;"><input readonly
                                                                        type="text" size="5"
                                                                        wire:model='total_gaji_lelaki.{{ $key }}'
                                                                        wire:change="calcJumlahGaji({{ $key }})"
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;"><input readonly
                                                                        type="text" size="5"
                                                                        wire:model='total_gaji_perempuan.{{ $key }}'
                                                                        wire:change="calcJumlahGaji({{ $key }})"
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;"><input readonly
                                                                        type="text" style="background-color: #f8dbee;"
                                                                        size="5"
                                                                        wire:model='total_gaji.{{ $key }}'>
                                                                </td>

                                                            </tr>
                                                        @empty

                                                        @endforelse
                                                        <tr style="height:50px;">
                                                            <td style="text-align:center;"><b>Jumlah</b></td>
                                                            <td style="text-align:center;" style="width:20px">
                                                                <b>{{ $i = $i + 1 }}</b>
                                                            </td>
                                                            <td style="text-align:center;"><input readonly type="text"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='total_bumi_lelaki'></td>
                                                            <td style="text-align:center;"><input readonly type="text"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='total_bumi_perempuan'></td>
                                                            <td style="text-align:center;"><input readonly type="text"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='total_bukanbumi_lelaki'></td>
                                                            <td style="text-align:center;"><input readonly type="text"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='total_bukanbumi_perempuan'></td>
                                                            <td style="text-align:center;"><input readonly type="text"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='total_asing_lelaki'></td>
                                                            <td style="text-align:center;"><input readonly type="text"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='total_asing_perempuan'></td>
                                                            <td style="text-align:center;"><input readonly type="text"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='total_pekerja_lelaki'></td>
                                                            <td style="text-align:center;"><input readonly type="text"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='total_pekerja_perempuan'></td>
                                                            <td style="text-align:center;"><input readonly type="text"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='total_pekerja'></td>
                                                            <td style="text-align:center;"><input readonly type="text"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='jumlah_gaji_lelaki'></td>
                                                            <td style="text-align:center;"><input readonly type="text"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='jumlah_gaji_perempuan'></td>

                                                            <td style="text-align:center;"><input readonly type="text"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='jumlah_lelaki_perempuan'></td>

                                                            <td style="text-align:center;"><input readonly type="text"
                                                                    style="background-color: #f8dbee;" size="5"
                                                                    wire:model='jumlah_total_lelaki'></td>
                                                            <td style="text-align:center;"><input readonly type="text"
                                                                    style="background-color: #f8dbee;" size="5"
                                                                    wire:model='jumlah_total_perempuan'></td>
                                                            <td style="text-align:center;"><input readonlytype="text"
                                                                    style="background-color: #f8dbee;" size="5"
                                                                    wire:model='jumlah_total_gaji'></td>
                                                        </tr>


                                                    </table>
                                                    <br>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <hr>

                                    <div class="card-body">
                                        @if ($errors->any())
                                            <div class="text-center form-group m-b-0">
                                                <h4 style="color:red">Sila Betulkan Maklumat Yang Berwarna Merah
                                                </h4>
                                            </div>
                                        @endif
                                        <div class="text-right form-group m-b-0">
                                            {{-- <button type="submit" class="btn btn-primary" >Simpan</button> --}}
                                            {{-- <button type="button" class="btn btn-primary">Kembali</button> --}}
                                            <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
                                            @if ($errors->isEmpty())
                                                <button type="button" class="btn btn-primary" alt="default"
                                                    data-toggle="modal" data-target="#responsive-modal"
                                                    class="model_img img-fluid">
                                                    HANTAR</button>

                                            @else
                                                <button type="submit" class="btn btn-primary" disabled>RALAT</button>
                                                {{-- <button type="submit" class="btn btn-primary" >Simpan</button> --}}
                                            @endif
                                        </div>

                                        <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog"
                                            aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close"
                                                            data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body" style="text-align: center">
                                                        <h4><b>Adakah anda pasti untuk menghantar data ini?</h4>
                                                        <br>
                                                        <button type="submit"
                                                            class="btn btn-primary waves-effect waves-light">HANTAR</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('closeModal', event => {
        $('#responsive-modal').modal('hide')
    })
</script>

<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
