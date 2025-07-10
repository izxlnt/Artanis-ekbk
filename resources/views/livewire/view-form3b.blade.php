
@extends('layouts.layout-user-nicepage-formB')

@section('content')
<div>

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">
                <div class="rounded-lg card" style="border-color: #000000 !important;">
                    <div class="card-header"
                        style="text-align:center; background-color: #ee8dcd !important; font-size: 130%; font-weight: bold;">
                        BORANG 3B - JUMLAH GUNA TENAGA PADA AKHIR BULAN
                    </div>

                    <div class="card-body">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <form wire:submit.prevent = 'store'>
                            <div class="tab-pane active" id="hotel" role="tabpanel" aria-labelledby="hotel-tab"><br>
                                <div class="">
                                    <table class="table table-striped table-bordered" id="" style="width: 100%;">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                        <div class="card-body">

                                                            <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label>Tahun:</label>
                                                                        <span type="text" class="form-control"
                                                                        style="background-color: #f8dbee;"
                                                                            value="{{ $kilang_info->tahun }}" readonly />{{ $kilang_info->tahun }}</span>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Suku Tahun:</label>
                                                                        <span type="text" class="form-control"
                                                                        style="background-color: #f8dbee;"
                                                                            value="{{ now('M') }}" readonly />{{ now('M') }}</span>
                                                                    </div>
                                                            </div>
                                                            <br>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                <label>Nama Kilang:</label>

                                                                    <span type="text" class="form-control"
                                                                    style="background-color: #f8dbee;"
                                                                        value="{{ $kilang_info->nama_kilang }}" readonly />
                                                                        {{ $kilang_info->nama_kilang }}</span>

                                                            </div>
                                                            <div class="col-md-6">

                                                                <label>No. Pendaftaran Syarikat (SSM):</label>

                                                                    <span type="text" class="form-control"
                                                                    style="background-color: #f8dbee;"
                                                                        value="{{ $kilang_info->no_ssm }}" readonly />
                                                                        {{ $kilang_info->no_ssm }}</span>

                                                            </div>
                                                        </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-3"></div>
                                                                <div class="col-md-6">
                                                                <label>No. Lesen:</label>

                                                                    <span type="text" class="form-control"
                                                                    style="background-color: #f8dbee;"
                                                                        value="{{ $kilang_info->no_lesen }}" readonly />
                                                                        {{ $kilang_info->no_lesen }}</span>


                                                                    </div>
                                                            </div>



                                                            <table>

                                                                <tr style="height:50px;">
                                                                    <th style="text-align:center;" colspan="2" rowspan="4">Kategori Pekerja
                                                                    </th>
                                                                    <th style="text-align:center;" colspan="4">Warganegara Malaysia</th>
                                                                    <th style="text-align:center;" colspan="2" rowspan="3">Bukan Warganegara
                                                                        Malaysia</th>
                                                                    <th style="text-align:center;" colspan="3" rowspan="3">Jumlah Pekerja</th>
                                                                    <th style="text-align:center;" colspan="3" rowspan="3">Bayaran Gaji dan Upah
                                                                        Per Pekerja (Sebulan) (RM/ bulan/ pekerja)</th>
                                                                        <th style="text-align:center;" colspan="3" rowspan="3">Jumlah Bayaran Gaji
                                                                            dan Upah (Sebulan) (RM)</th>
                                                                </tr>
                                                                <tr style="height:50px;">
                                                                    <th style="text-align:center;" colspan="2" rowspan="2">Bumiputera</th>
                                                                    <th style="text-align:center;" colspan="2" rowspan="2">Bukan Bumiputera</th>
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

                                                                    <td style="text-align:center;" >{{ $data->kategori_guna_tenaga->keterangan }}</td>
                                                                    <td style="text-align:center;width:30px;">{{ $i = $loop->iteration }}</td>
                                                                    <td style="text-align:center;padding:5px" ><span type="text" size="3" value="{{ $data->pekerja_wargabumi_lelaki }}" wire:model='pekerja_wargabumi_lelaki.{{ $key }}' wire:change="calcJumlahPekerjaLelaki({{ $key }});" onkeypress="return isNumberKey(event)">{{ $data->pekerja_wargabumi_lelaki }}</span></td>
                                                                    <td style="text-align:center;padding:5px" ><span type="text" size="3" value="{{ $data->pekerja_wargabumi_perempuan }}" wire:model='pekerja_wargabumi_perempuan.{{ $key }}' wire:change="calcJumlahPekerjaPerempuan({{ $key }})" onkeypress="return isNumberKey(event)">{{ $data->pekerja_wargabumi_perempuan }}</span></td>
                                                                    <td style="text-align:center;padding:5px" ><span type="text" size="3" value="{{ $data->pekerja_bukan_wargabumi_lelaki }}" wire:model='pekerja_bukan_wargabumi_lelaki.{{ $key }}' wire:change="calcJumlahPekerjaLelaki({{ $key }})" onkeypress="return isNumberKey(event)">{{ $data->pekerja_bukan_wargabumi_lelaki }}</span></td>
                                                                    <td style="text-align:center;padding:5px" ><span type="text" size="3" value="{{ $data->pekerja_bukan_wargabumi_perempuan }}" wire:model='pekerja_bukan_wargabumi_perempuan.{{ $key }}' wire:change="calcJumlahPekerjaPerempuan({{ $key }})" onkeypress="return isNumberKey(event)">{{ $data->pekerja_bukan_wargabumi_perempuan }}</span></td>
                                                                    <td style="text-align:center;" ><span type="text" size="3" value="{{ $data->pekerja_asing_lelaki }}" wire:model='pekerja_asing_lelaki.{{ $key }}' wire:change="calcJumlahPekerjaLelaki({{ $key }})" onkeypress="return isNumberKey(event)" >{{ $data->pekerja_asing_lelaki }}</span></td>
                                                                    <td style="text-align:center;" ><span type="text" size="3" value="{{ $data->pekerja_asing_perempuan }}" wire:model='pekerja_asing_perempuan.{{ $key }}' wire:change="calcJumlahPekerjaPerempuan({{ $key }})" onkeypress="return isNumberKey(event)">{{ $data->pekerja_asing_perempuan }}</span></td>
                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly type="text" value="{{ $data->jumlah_lelaki }}"  size="3" wire:model='jumlah_lelaki.{{ $key }}' onkeypress="return isNumberKey(event)">{{ $data->jumlah_lelaki }}</span></td>
                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly type type="text" value="{{ $data->jumlah_perempuan }}"  size="3" wire:model='jumlah_perempuan.{{ $key }}' onkeypress="return isNumberKey(event)">{{ $data->jumlah_perempuan }}</span></td>
                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly type type="text" value="{{ $data->jumlah_pekerja }}"  size="3" wire:model='jumlah_pekerja.{{ $key }}' onkeypress="return isNumberKey(event)">{{ $data->jumlah_pekerja }}</span></td>
                                                                    <td style="text-align:center;"><span type="text" size="3" value="{{ $data->gaji_lelaki }}" wire:model='gaji_lelaki.{{ $key }}' wire:change="calcTotalAllBayaranGajiPerPekerjaLelaki({{ $key }})" onkeypress="return isNumberKey(event)" >{{ $data->gaji_lelaki }}</span></td>
                                                                    <td style="text-align:center;"><span type="text" size="3" value="{{ $data->gaji_perempuan }}" wire:model='gaji_perempuan.{{ $key }}'  wire:change="calcTotalAllBayaranGajiPerPekerjaPerempuan({{ $key }})" onkeypress="return isNumberKey(event)">{{ $data->gaji_perempuan }}</span></td>

                                                                    <td style="text-align:center;background-color: #f8dbee;"><span type="text" size="3"  value="" wire:model='gaji_lelaki_perempuan.{{ $key }}'  wire:change="calcTotalAllBayaranGajiPerPekerjaPerempuan({{ $key }})" onkeypress="return isNumberKey(event)">{{ $data->gaji_lelaki_perempuan }}</span></td>

                                                                    <td style="text-align:center;"><span type="text" size="3" wire:model='total_gaji_lelaki.{{ $key }}' value="{{ $data->total_gaji_lelaki }}"  wire:change="calcJumlahGaji({{ $key }})" onkeypress="return isNumberKey(event)">{{ $data->total_gaji_lelaki }}</span></td>
                                                                    <td style="text-align:center;"><span type="text" size="3" wire:model='total_gaji_perempuan.{{ $key }}' value="{{ $data->total_gaji_perempuan }}" wire:change="calcJumlahGaji({{ $key }})" onkeypress="return isNumberKey(event)">{{ $data->total_gaji_perempuan }}</span></td>
                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly  type="text"  size="3" value="{{ $data->total_gaji }}" wire:model='total_gaji.{{ $key }}' >{{ $data->total_gaji }}</span></td>

                                                                </tr>
                                                                @if($loop->last)
                                                                <tr style="height:50px;">
                                                                    <td style="text-align:center;"><b>Jumlah</b></td>
                                                                    <td style="text-align:center;" style="width:20px"><b>{{ $i = $i + 1 }}</b></td>
                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly type="text"  size="3"  value="{{ $data->total_gaji }}" wire:model='total_bumi_lelaki'>{{ $data->total_bumi_lelaki }}</span></td>
                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly type="text"  size="3"  value="{{ $data->total_gaji }}" wire:model='total_bumi_perempuan'>{{ $data->total_bumi_perempuan }}</span></td>
                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly type="text"  size="3"  value="{{ $data->total_gaji }}" wire:model='total_bukanbumi_lelaki'>{{ $data->total_bukanbumi_lelaki }}</span></td>
                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly type="text"  size="3"  value="{{ $data->total_gaji }}" wire:model='total_bukanbumi_perempuan'>{{ $data->total_bukanbumi_perempuan }}</span></td>
                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly type="text"  size="3"  value="{{ $data->total_gaji }}" wire:model='total_asing_lelaki'>{{ $data->total_asing_lelaki }}</span></td>
                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly type="text"  size="3"  value="{{ $data->total_gaji }}" wire:model='total_asing_perempuan'>{{ $data->total_asing_perempuan }}</span></td>
                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly type="text"  size="3"  value="{{ $data->total_gaji }}" wire:model='total_pekerja_lelaki'>{{ $data->total_pekerja_lelaki }}</span></td>
                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly type="text"  size="3"  value="{{ $data->total_gaji }}" wire:model='total_pekerja_perempuan'>{{ $data->total_pekerja_perempuan }}</span></td>
                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly type="text"  size="3"  value="{{ $data->total_gaji }}" wire:model='total_pekerja'>{{ $data->total_pekerja }}</span></td>
                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly type="text"  size="3"  value="{{ $data->total_gaji }}" wire:model='jumlah_gaji_lelaki'>{{ $data->jumlah_gaji_lelaki }}</span></td>
                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly type="text"  size="3"  value="{{ $data->total_gaji }}" wire:model='jumlah_gaji_perempuan'>{{ $data->jumlah_gaji_perempuan }}</span></td>

                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly type="text"  size="3"  value="{{ $data->total_gaji }}" wire:model='jumlah_gaji_perempuan'>{{ $data->jumlah_lelaki_perempuan }}</span></td>

                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly type="text"  size="3"  value="{{ $data->total_gaji }}" wire:model='jumlah_total_lelaki'>{{ $data->jumlah_total_lelaki }}</span></td>
                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonly type="text"  size="3"  value="{{ $data->total_gaji }}" wire:model='jumlah_total_perempuan'>{{ $data->jumlah_total_perempuan }}</span></td>
                                                                    <td style="text-align:center;background-color: #f8dbee;"><span readonlytype="text"  size="3"  value="{{ $data->total_gaji }}" wire:model='jumlah_total_gaji'>{{ $data->jumlah_total_gaji }}</span></td>
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
                                            <div class="row">
                                                <form action="{{ route('update_status_formB') }}" method="post">
                                                    @csrf
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
                                                                <input type="radio" name="status" value="Dihantar ke IPJPSM" >&nbsp Dihantar ke IPJPSM
                                                            </label>
                                                        </fieldset>
                                                        <br>
                                                        <button type="submit" class="btb btn-primary">Hantar</button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
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

<style >

    table, th, td {
      border: 1px solid black;
    }
    </style>

@endsection

