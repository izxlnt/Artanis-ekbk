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
                <div class="card-header"
                    style="text-align:center; background-color: #ee8dcd !important; font-size: 130%; font-weight: bold;">
                    BORANG 3B - JUMLAH GUNA TENAGA PADA AKHIR BULAN
                </div>

                <div class="card-body">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <form wire:submit.prevent='store' id="formB">
                            <table class="table table-striped table-bordered" id="" style="width: 100%;">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="form-horizontal">
                                                <div class="card-body" style="padding-top: 0%;">
                                                    <div class="row" style="justify-content: center;margin-bottom:-3%;">
                                                        <div class="col-md-2">
                                                            <label><b>Tahun:</b></label>
                                                           <input type="text" class="form-control"
                                                                style="background-color: #f8dbee; border-color: #d89bc4"
                                                                value="{{ date('Y') }}" readonly />
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label><b>Suku Tahun:</b></label>
                                                                <input type="text" class="form-control"
                                                                    style="background-color: #f8dbee;border-color: #d89bc4"" wire:model='suku'
                                                                    value="Tiada Data" readonly />

                                                            </div>
                                                           <div class="col-md-3">
                                                            <label><b>Nama Kilang:</b></label>
                                                            <input type="text" class="form-control"
                                                                style="background-color: #f8dbee;border-color: #d89bc4""
                                                                value="{{ $kilang_info->nama_kilang }}" readonly />
                                                        </div>
                                                        {{-- <div class="col-md-2"></div> --}}
                                                           <div class="col-md-2">
                                                            <label><b>No. Pendaftaran Syarikat (SSM):</b></label>
                                                            <input type="text" class="form-control"
                                                                style="background-color: #f8dbee;border-color: #d89bc4""
                                                                value="{{ $kilang_info->no_ssm }}" readonly />
                                                        </div>
                                                           <div class="col-md-2">
                                                            <label><b>No. Lesen:</b></label>
                                                            <input type="text" class="form-control"
                                                                style="background-color: #f8dbee;border-color: #d89bc4""
                                                                value="{{ $kilang_info->no_lesen }}" readonly />
                                                        </div>


                                                    </div>
                                                    <table style="padding-top:0% !important;">

                                                        <tr style="height:50px;background-color:#f8dbee;">
                                                            <th style="text-align:center;" colspan="2" rowspan="4">
                                                                Kategori<br>Pekerja
                                                            </th>
                                                            <th style="text-align:center;" colspan="4">
                                                                Warganegara Malaysia</th>
                                                            <th style="text-align:center;" colspan="2" rowspan="3">Bukan <br>
                                                                Warganegara <br>
                                                                Malaysia</th>
                                                            <th style="text-align:center;" colspan="3" rowspan="3">
                                                                Jumlah<br>Pekerja</th>
                                                            <th style="text-align:center;" colspan="3" rowspan="3">
                                                                Purata Bayaran Gaji dan <br>Upah Per Pekerja<br>(Sebulan)<br>(RM / bulan / pekerja)</th>
                                                            <th style="text-align:center;" colspan="3" rowspan="3">
                                                                Jumlah Bayaran Gaji dan
                                                                Upah<br>(Sebulan)<br>(RM)</th>
                                                        </tr>
                                                        <tr style="height:50px;background-color:#f8dbee;">
                                                            <th style="text-align:center;" colspan="2" rowspan="2">
                                                                Bumiputera</th>
                                                            <th style="text-align:center;" colspan="2" rowspan="2">Bukan
                                                                Bumiputera</th>
                                                        </tr>
                                                        <tr style="height:50px;background-color:#f8dbee;">

                                                        </tr>
                                                        <tr style="height:50px;background-color:#f8dbee;">
                                                            <th style="text-align:center;">L</th>
                                                            <th style="text-align:center;">P</th>
                                                            <th style="text-align:center;">L</th>
                                                            <th style="text-align:center;">P</th>
                                                            <th style="text-align:center;">L</th>
                                                            <th style="text-align:center;">P</th>
                                                            <th style="text-align:center;">L</th>
                                                            <th style="text-align:center;">P</th>
                                                            <th style="text-align:center;width:100px;">L+P</th>
                                                            <th style="text-align:center;">L</th>
                                                            <th style="text-align:center;">P</th>
                                                            <th style="text-align:center;width:80px;">L+P</th>
                                                            <th style="text-align:center;width:90px;">L</th>
                                                            <th style="text-align:center;width:90px;">P</th>
                                                            <th style="text-align:center;width:90px;">L+P</th>
                                                        </tr>

                                                        <tr style="height:50px;background-color:#f8dbee;">
                                                            <th style="text-align:center;" colspan="2">(01)</th>
                                                            <th style="text-align:center;">(02)</th>
                                                            <th style="text-align:center;">(03)</th>
                                                            <th style="text-align:center;">(04)</th>
                                                            <th style="text-align:center;">(05)</th>
                                                            <th style="text-align:center;width:70px;">(06)</th>
                                                            <th style="text-align:center;width:70px;">(07)</th>
                                                            <th style="text-align:center;">(08)=<br>(02)+(04)+(06)
                                                            </th>
                                                            <th style="text-align:center;">(09)=<br>(03)+(05)+(07)
                                                            </th>
                                                            <th style="text-align:center;width:100px;">(10)=<br>(08)+(09)</th>
                                                            <th style="text-align:center;width:80px;">(11)</th>
                                                            <th style="text-align:center;width:80px;">(12)</th>
                                                            <th style="text-align:center;width:90px;">(13)=<br>(11)+(12)</th>
                                                            <th style="text-align:center;width:90px;">(14)=<br>(08)*(11)</th>
                                                            <th style="text-align:center;width:90px;">(15)=<br>(09)*(12)</th>
                                                            <th style="text-align:center;">(16)=<br>(14)+(15)</th>
                                                        </tr>

                                                        @forelse($kategori_pekerja as $key=>$data)
                                                            <tr style="height:50px;">

                                                                <td style="text-align:left;">
                                                                    {{ $data->keterangan }}</td>
                                                                <td style="text-align:center;width:30px;">
                                                                    {{ $i = $loop->iteration }}</td>
                                                                <td style="text-align:center;padding:5px"><input style="text-align:right"
                                                                        type="text" size="3"
                                                                        wire:model='pekerja_wargabumi_lelaki.{{ $key }}'
                                                                        wire:change="calcJumlahPekerjaLelaki({{ $key }});"
                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;padding:5px"><input style="text-align:right"
                                                                        type="text" size="3"
                                                                        wire:model='pekerja_wargabumi_perempuan.{{ $key }}'
                                                                        wire:change="calcJumlahPekerjaPerempuan({{ $key }})"
                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;padding:5px"><input style="text-align:right"
                                                                        type="text" size="3"
                                                                        wire:model='pekerja_bukan_wargabumi_lelaki.{{ $key }}'
                                                                        wire:change="calcJumlahPekerjaLelaki({{ $key }})"
                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;padding:5px"><input style="text-align:right"
                                                                        type="text" size="3"
                                                                        wire:model='pekerja_bukan_wargabumi_perempuan.{{ $key }}'
                                                                        wire:change="calcJumlahPekerjaPerempuan({{ $key }})"
                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;"><input type="text" style="text-align:right"
                                                                        size="3"
                                                                        wire:model='pekerja_asing_lelaki.{{ $key }}'
                                                                        wire:change="calcJumlahPekerjaLelaki({{ $key }})"
                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;"><input type="text" style="text-align:right"
                                                                        size="3"
                                                                        wire:model='pekerja_asing_perempuan.{{ $key }}'
                                                                        wire:change="calcJumlahPekerjaPerempuan({{ $key }})"
                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center; background-color:#f8dbee;"><input readonly style="text-align:right"
                                                                        type="text" style="background-color: #f8dbee;"
                                                                        size="6"
                                                                        wire:model='jumlah_lelaki.{{ $key }}'
                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;width:100px;background-color:#f8dbee;"><input readonly type style="text-align:right"
                                                                        type="text" style="background-color: #f8dbee;"
                                                                        size="6"
                                                                        wire:model='jumlah_perempuan.{{ $key }}'
                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;background-color:#f8dbee;"><input readonly type style="text-align:right"
                                                                        type="text" style="background-color: #f8dbee;"
                                                                        size="6"
                                                                        wire:model='jumlah_pekerja.{{ $key }}'
                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>

                                                                {{-- column 11 --}}
                                                                <td style="text-align:center; ">

                                                                    <input type="text" size="6" style="text-align:right"
                                                                        id="gaji_lelaki.{{ $key }}"
                                                                        wire:model.lazy='gaji_lelaki.{{ $key }}'
                                                                        oninput="validate(this)"
                                                                        wire:change="calcJumlahPekerjaLelaki({{ $key }})"
                                                                        @if($jumlah_lelaki[$key] == 0)
                                                                            readonly
                                                                        @endif
                                                                        onkeypress="return isNumberKey(event)"
                                                                        style="@error('gaji_lelaki.' . $key) color:red; outline: 2px solid red; @else color:black @endif">
                                                                        @error('gaji_lelaki.' . $key)
                                                                            <i class="fas fa-exclamation-circle"
                                                                                style="color: red"
                                                                                title="Gaji perlulah minimum {{ $min_gaji[$key] }} dan maximum {{ $max_gaji[$key] }}"
                                                                            >
                                                                        @enderror
                                                                    {{-- @error('gaji_lelaki.' . $key)
                                                                            <div class="alert alert-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </div>
                                                                            @enderror --}}
                                                                </td>
                                                                <td style="text-align:center;">
                                                                    <input type="text" size="6" style="text-align:right"
                                                                        id="gaji_perempuan.{{ $key }}"
                                                                        wire:model='gaji_perempuan.{{ $key }}'
                                                                        oninput="validate(this)"
                                                                        wire:change="calcJumlahPekerjaPerempuan({{ $key }})"
                                                                        @if($jumlah_perempuan[$key] == 0)
                                                                            readonly
                                                                        @endif
                                                                        onkeypress="return isNumberKey(event)"
                                                                        style="@error('gaji_perempuan.' . $key) color:red; outline: 2px solid red @else color:black @endif">
                                                                        @error('gaji_perempuan.' . $key)
                                                                            <i class="fas fa-exclamation-circle"
                                                                                style="color: red"
                                                                                title="Gaji perlulah minimum {{ $min_gaji[$key] }} dan maximum {{ $max_gaji[$key] }}"
                                                                            >
                                                                                {{-- title="{{ $message }}" --}}
                                                                            </i>
                                                                        @enderror

                                                                </td>
                                                                <td style="text-align:center;background-color:#f8dbee;"><input readonly type="text" style="text-align:right"
                                                                        size="7" style="background-color: #f8dbee;"
                                                                        wire:model='gaji_lelaki_perempuan.{{ $key }}'
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;background-color:#f8dbee;"><input readonly style="text-align:right"
                                                                        type="text" style="background-color: #f8dbee;"
                                                                        size="7"
                                                                        wire:model='total_gaji_lelaki.{{ $key }}'
                                                                        wire:change="calcJumlahGaji({{ $key }})"

                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;background-color:#f8dbee;"><input readonly style="text-align:right"
                                                                        type="text" style="background-color: #f8dbee;"
                                                                        size="7"
                                                                        wire:model='total_gaji_perempuan.{{ $key }}'
                                                                        wire:change="calcJumlahGaji({{ $key }})"
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;background-color:#f8dbee;"><input readonly style="text-align:right"
                                                                        type="text" style="background-color: #f8dbee;"
                                                                        size="7"
                                                                        wire:model='total_gaji.{{ $key }}'>
                                                                </td>

                                                            </tr>
                                                        @empty

                                                        @endforelse
                                                        <tr style="height:50px;">
                                                            <td style="text-align:right;"><b>Jumlah</b></td>
                                                            <td style="text-align:center;" style="width:20px">
                                                                <b>{{ $i = $i + 1 }}</b>
                                                            </td>
                                                            <td style="text-align:center;"><input readonly type="text" style="text-align:right;font-weight: bold;"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='total_bumi_lelaki'></td>
                                                            <td style="text-align:center;"><input readonly type="text" style="text-align:right;font-weight: bold;"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='total_bumi_perempuan'></td>
                                                            <td style="text-align:center;"><input readonly type="text" style="text-align:right;font-weight: bold;"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='total_bukanbumi_lelaki'></td>
                                                            <td style="text-align:center;"><input readonly type="text" style="text-align:right;font-weight: bold;"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='total_bukanbumi_perempuan'></td>
                                                            <td style="text-align:center;"><input readonly type="text" style="text-align:right;font-weight: bold;"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='total_asing_lelaki'></td>
                                                            <td style="text-align:center;"><input readonly type="text" style="text-align:right;font-weight: bold;"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    wire:model='total_asing_perempuan'></td>
                                                            <td style="text-align:center ;background-color:#f8dbee;"><input readonly type="text" style="text-align:right;font-weight: bold;"
                                                                    style="background-color: #f8dbee;" size="6"
                                                                    wire:model='total_pekerja_lelaki'></td>
                                                            <td style="text-align:center;background-color:#f8dbee;"><input readonly type="text" style="text-align:right;font-weight: bold;"
                                                                    style="background-color: #f8dbee;" size="6"
                                                                    wire:model='total_pekerja_perempuan'></td>
                                                            <td style="text-align:center;background-color:#f8dbee;"><input readonly type="text" style="text-align:right;font-weight: bold;"
                                                                    style="background-color: #f8dbee;" size="6"
                                                                    wire:model='total_pekerja'></td>
                                                            <td style="text-align:center;"><input readonly type="text" style="text-align:right;font-weight: bold;"
                                                                    style="background-color: #f8dbee;" size="6"
                                                                    wire:model='jumlah_gaji_lelaki'></td>
                                                            <td style="text-align:center;"><input readonly type="text" style="text-align:right;font-weight: bold;"
                                                                    style="background-color: #f8dbee;" size="6"
                                                                    wire:model='jumlah_gaji_perempuan'></td>

                                                            <td style="text-align:center;background-color:#f8dbee;"><input readonly type="text" style="text-align:right;font-weight: bold;"
                                                                    style="background-color: #f8dbee;" size="7"
                                                                    wire:model='jumlah_lelaki_perempuan'></td>

                                                            <td style="text-align:center;background-color:#f8dbee;"><input readonly type="text" style="text-align:right;font-weight: bold;"
                                                                    style="background-color: #f8dbee;" size="7"
                                                                    wire:model='jumlah_total_lelaki'></td>
                                                            <td style="text-align:center;background-color:#f8dbee;"><input readonly type="text" style="text-align:right;font-weight: bold;"
                                                                    style="background-color: #f8dbee;" size="7"
                                                                    wire:model='jumlah_total_perempuan'></td>
                                                            <td style="text-align:center;background-color:#f8dbee;"><input readonlytype="text" style="text-align:right;font-weight: bold;"
                                                                    style="background-color: #f8dbee;" size="7"
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
                                        {{-- @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                            <div class="text-center form-group m-b-0">
                                                <h4 style="color:red">{{ $error }}
                                                </h4>
                                            </div>
                                        @endforeach
                                        @endif --}}
                                        <div class="text-right form-group m-b-0">

                                            <a href="{{ route('user.shuttle-3-senaraiB', date('Y')) }}" class="btn btn-primary">Kembali</a>
                                            {{-- @if ($errors->isEmpty()) --}}
                                            <button type="button" class="btn btn-primary" alt="default"
                                                data-toggle="modal" data-target="#confirmation_borang_b"
                                                class="model_img img-fluid">
                                                HANTAR</button>

                                        </div>

                                        <div class="modal fade" id="confirmation_borang_b" tabindex="-1"
                                            role="dialog" aria-labelledby="confirmation_borang_bTitle"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info" style="background-color: #f3ce8f !important;">
                                                        <h5 class="modal-title " id="exampleModalLongTitle"><i style="color:rgb(255, 255, 0)"
                                                                class="fas fa-exclamation-triangle"></i>&nbspPENGESAHAN
                                                        </h5>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <span class="text-center"><b>Adakah anda pasti ingin menghantar borang ini?</b></span>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button"  id="submit-button"  class="btn btn-danger" wire:loading.attr="disabled"
                                                            data-dismiss="modal">Kembali</button>
                                                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                                            <div wire:loading wire:target="store">
                                                                <div class="la-ball-pulse-sync la-sm">
                                                                    <div></div>
                                                                    <div></div>
                                                                    <div></div>
                                                                </div>
                                                            </div>
                                                            <div wire:loading.remove wire:target="store">Hantar</div>
                                                        </button>
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



<script>
    $('#formB').submit(function(e) {
        e.preventDefault();
        // Coding
        console.log('lol');
        // $('#responsive-modal').modal('hide'); //or  $('#IDModal').modal('hide');
        $('#responsive-modal').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        return false;
    });
</script>

<script>
    window.livewire.on('alert', param => {
        toastr[param['type']](param['message'], 'Ralat', {
            "progressBar": true
        })
        // toastr.error(param['message'], 'Ralat', { "progressBar": true });
    });
</script>

<script>
    var validate = function(e) {
    var t = e.value;
    e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
    }

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

<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
