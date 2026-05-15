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
                    BORANG 5B - JUMLAH GUNA TENAGA PADA AKHIR BULAN
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
                                                                value="{{ $year }}" readonly />
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
                                                                        id="fb_wl_{{ $key }}" wire:model.defer='pekerja_wargabumi_lelaki.{{ $key }}' oninput="fbCalcRow({{ $key }})"
                                                                        
                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;padding:5px"><input style="text-align:right"
                                                                        type="text" size="3"
                                                                        id="fb_wp_{{ $key }}" wire:model.defer='pekerja_wargabumi_perempuan.{{ $key }}' oninput="fbCalcRow({{ $key }})"

                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;padding:5px"><input style="text-align:right"
                                                                        type="text" size="3"
                                                                        id="fb_bl_{{ $key }}" wire:model.defer='pekerja_bukan_wargabumi_lelaki.{{ $key }}' oninput="fbCalcRow({{ $key }})"
                                                                        
                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;padding:5px"><input style="text-align:right"
                                                                        type="text" size="3"
                                                                        id="fb_bp_{{ $key }}" wire:model.defer='pekerja_bukan_wargabumi_perempuan.{{ $key }}' oninput="fbCalcRow({{ $key }})"

                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;"><input type="text" style="text-align:right"
                                                                        size="3"
                                                                        id="fb_al_{{ $key }}" wire:model.defer='pekerja_asing_lelaki.{{ $key }}' oninput="fbCalcRow({{ $key }})"
                                                                        
                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;"><input type="text" style="text-align:right"
                                                                        size="3"
                                                                        id="fb_ap_{{ $key }}" wire:model.defer='pekerja_asing_perempuan.{{ $key }}' oninput="fbCalcRow({{ $key }})"

                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center; background-color:#f8dbee;"><input readonly style="text-align:right"
                                                                        type="text" style="background-color: #f8dbee;"
                                                                        size="6"
                                                                        id="fb_jl_{{ $key }}"
                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;width:100px;background-color:#f8dbee;"><input readonly type style="text-align:right"
                                                                        type="text" style="background-color: #f8dbee;"
                                                                        size="6"
                                                                        id="fb_jp_{{ $key }}"
                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;background-color:#f8dbee;"><input readonly type style="text-align:right"
                                                                        type="text" style="background-color: #f8dbee;"
                                                                        size="6"
                                                                        id="fb_j_{{ $key }}"
                                                                       onkeypress="return onlyNumberKey(event)">
                                                                </td>

                                                                {{-- column 11 --}}
                                                                <td style="text-align:center; ">

                                                                    <input type="text" size="6" style="text-align:right"
                                                                        id="fb_gl_{{ $key }}"
                                                                        wire:model.defer='gaji_lelaki.{{ $key }}'
                                                                        @if($jumlah_lelaki[$key] == 0)
                                                                            readonly
                                                                        @endif
                                                                        
                                                                        oninput="validate(this);fbCalcRow({{ $key }})"
                                                                        onkeypress="return isNumberKey(event)"
                                                                        style="@error('gaji_lelaki.' . $key) color:red; outline: 2px solid red; @else color:black @endif">
                                                                    @error('gaji_lelaki.' . $key)
                                                                        <i class="fas fa-exclamation-circle"
                                                                            style="color: red"
                                                                            title="Gaji perlulah minimum {{ $min_gaji[$key] }} dan maximum {{ $max_gaji[$key] }}"></i>
                                                                    @enderror
                                                                    {{-- @error('gaji_lelaki.' . $key)
                                                                            <div class="alert alert-danger">
                                                                                <strong>{{ $message }}</strong>
                                                                            </div>
                                                                            @enderror --}}
                                                                </td>
                                                                <td style="text-align:center;">
                                                                    <input type="text" size="6" style="text-align:right"
                                                                        id="fb_gp_{{ $key }}"
                                                                        @if($jumlah_perempuan[$key] == 0)
                                                                            readonly
                                                                        @endif
                                                                        wire:model.defer='gaji_perempuan.{{ $key }}'

                                                                        oninput="validate(this);fbCalcRow({{ $key }})"
                                                                        onkeypress="return isNumberKey(event)"
                                                                        style="@error('gaji_perempuan.' . $key) color:red; outline: 2px solid red @else color:black @endif">
                                                                    @error('gaji_perempuan.' . $key)
                                                                        <i class="fas fa-exclamation-circle"
                                                                            style="color: red"
                                                                            title="Gaji perlulah minimum {{ $min_gaji[$key] }} dan maximum {{ $max_gaji[$key] }}"></i>
                                                                    @enderror

                                                                </td>
                                                                <td style="text-align:center;background-color:#f8dbee;"><input readonly type="text" style="text-align:right"
                                                                        size="7" style="background-color: #f8dbee;"
                                                                        id="fb_glp_{{ $key }}"
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;background-color:#f8dbee;"><input readonly style="text-align:right"
                                                                        type="text" style="background-color: #f8dbee;"
                                                                        size="7"
                                                                        id="fb_tgl_{{ $key }}"
                                                                        
                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;background-color:#f8dbee;"><input readonly style="text-align:right"
                                                                        type="text" style="background-color: #f8dbee;"
                                                                        size="7"
                                                                        id="fb_tgp_{{ $key }}"

                                                                        onkeypress="return isNumberKey(event)">
                                                                </td>
                                                                <td style="text-align:center;background-color:#f8dbee;"><input readonly style="text-align:right"
                                                                        type="text" style="background-color: #f8dbee;"
                                                                        size="7"
                                                                        id="fb_tg_{{ $key }}">
                                                                </td>

                                                            </tr>
                                                        @empty

                                                        @endforelse
                                                        <tr style="height:50px;">
                                                            <td style="text-align:right;"><b>Jumlah</b></td>
                                                            <td style="text-align:center;" style="width:20px">
                                                                <b>{{ $i = $i + 1 }}</b>
                                                            </td>
                                                            <td style="text-align:center;"><input readonly type="text" style="text-align:right"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    id="fb_tot_wl"></td>
                                                            <td style="text-align:center;"><input readonly type="text" style="text-align:right"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    id="fb_tot_wp"></td>
                                                            <td style="text-align:center;"><input readonly type="text" style="text-align:right"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    id="fb_tot_bl"></td>
                                                            <td style="text-align:center;"><input readonly type="text" style="text-align:right"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    id="fb_tot_bp"></td>
                                                            <td style="text-align:center;"><input readonly type="text" style="text-align:right"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    id="fb_tot_al"></td>
                                                            <td style="text-align:center;"><input readonly type="text" style="text-align:right"
                                                                    style="background-color: #f8dbee;" size="3"
                                                                    id="fb_tot_ap"></td>
                                                            <td style="text-align:center ;background-color:#f8dbee;"><input readonly type="text" style="text-align:right"
                                                                    style="background-color: #f8dbee;" size="6"
                                                                    id="fb_tot_jl"></td>
                                                            <td style="text-align:center;background-color:#f8dbee;"><input readonly type="text" style="text-align:right"
                                                                    style="background-color: #f8dbee;" size="6"
                                                                    id="fb_tot_jp"></td>
                                                            <td style="text-align:center;background-color:#f8dbee;"><input readonly type="text" style="text-align:right"
                                                                    style="background-color: #f8dbee;" size="6"
                                                                    id="fb_tot_j"></td>
                                                            <td style="text-align:center;"><input readonly type="text" style="text-align:right"
                                                                    style="background-color: #f8dbee;" size="6"
                                                                    id="fb_tot_gl"></td>
                                                            <td style="text-align:center;"><input readonly type="text" style="text-align:right"
                                                                    style="background-color: #f8dbee;" size="6"
                                                                    id="fb_tot_gp"></td>

                                                            <td style="text-align:center;background-color:#f8dbee;"><input readonly type="text" style="text-align:right"
                                                                    style="background-color: #f8dbee;" size="7"
                                                                    id="fb_tot_glp"></td>

                                                            <td style="text-align:center;background-color:#f8dbee;"><input readonly type="text" style="text-align:right"
                                                                    style="background-color: #f8dbee;" size="7"
                                                                    id="fb_tot_tgl"></td>
                                                            <td style="text-align:center;background-color:#f8dbee;"><input readonly type="text" style="text-align:right"
                                                                    style="background-color: #f8dbee;" size="7"
                                                                    id="fb_tot_tgp"></td>
                                                            <td style="text-align:center;background-color:#f8dbee;"><input readonlytype="text" style="text-align:right"
                                                                    style="background-color: #f8dbee;" size="7"
                                                                    id="fb_tot_tg"></td>
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
                                            <a href="{{ route('user.shuttle-5-senaraiB', $year) }}" class="btn btn-primary">Kembali</a>
                                            {{-- @if ($errors->isEmpty()) --}}
                                            <button type="button" class="btn btn-primary" alt="default"
                                                data-toggle="modal" data-target="#confirmation_borang_b"
                                                class="model_img img-fluid">
                                                HANTAR</button>

                                            {{-- @else --}}
                                            {{-- <button type="submit" class="btn btn-primary" disabled>RALAT</button> --}}
                                            {{-- <button type="submit" class="btn btn-primary" >Simpan</button> --}}
                                            {{-- @endif --}}
                                        </div>

                                        {{-- <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog"
                                            aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close"
                                                            data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body" style="text-align: center">
                                                        <h4>Adakah anda pasti untuk menghantar data ini?</h4>
                                                        <br>
                                                        <button type="submit" id="submit-button"
                                                            class="btn btn-primary waves-effect waves-light">HANTAR</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

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

<script>
    function fbN(id) { var el = document.getElementById(id); return el ? (parseFloat(el.value) || 0) : 0; }
    function fbS(id, v) { var el = document.getElementById(id); if (el) el.value = v === 0 ? '' : (Math.round(v * 100) / 100); }

    function fbCalcRow(k) {
        var wl=fbN('fb_wl_'+k), wp=fbN('fb_wp_'+k);
        var bl=fbN('fb_bl_'+k), bp=fbN('fb_bp_'+k);
        var al=fbN('fb_al_'+k), ap=fbN('fb_ap_'+k);
        var gl=fbN('fb_gl_'+k), gp=fbN('fb_gp_'+k);

        var jl=wl+bl+al, jp=wp+bp+ap, j=jl+jp;
        var glp=gl+gp, tgl=jl*gl, tgp=jp*gp, tg=tgl+tgp;

        fbS('fb_jl_'+k,jl); fbS('fb_jp_'+k,jp); fbS('fb_j_'+k,j);
        fbS('fb_glp_'+k,glp); fbS('fb_tgl_'+k,tgl); fbS('fb_tgp_'+k,tgp); fbS('fb_tg_'+k,tg);

        // Toggle salary fields readonly based on worker count
        var glEl = document.getElementById('fb_gl_'+k);
        if (glEl) { glEl.readOnly = (jl === 0); if (jl === 0) glEl.value = ''; }
        var gpEl = document.getElementById('fb_gp_'+k);
        if (gpEl) { gpEl.readOnly = (jp === 0); if (jp === 0) gpEl.value = ''; }

        fbCalcAll();
    }

    function fbCalcAll() {
        var keys = []; document.querySelectorAll('[id^="fb_wl_"]').forEach(function(el) { keys.push(el.id.replace('fb_wl_','')); });
        var twl=0,twp=0,tbl=0,tbp=0,tal=0,tap=0,tjl=0,tjp=0,tj=0,tgl=0,tgp=0,tglp=0,ttgl=0,ttgp=0,ttg=0;
        keys.forEach(function(k) {
            twl+=fbN('fb_wl_'+k); twp+=fbN('fb_wp_'+k);
            tbl+=fbN('fb_bl_'+k); tbp+=fbN('fb_bp_'+k);
            tal+=fbN('fb_al_'+k); tap+=fbN('fb_ap_'+k);
            tjl+=fbN('fb_jl_'+k); tjp+=fbN('fb_jp_'+k); tj+=fbN('fb_j_'+k);
            tgl+=fbN('fb_gl_'+k); tgp+=fbN('fb_gp_'+k);
            tglp+=fbN('fb_glp_'+k); ttgl+=fbN('fb_tgl_'+k);
            ttgp+=fbN('fb_tgp_'+k); ttg+=fbN('fb_tg_'+k);
        });
        fbS('fb_tot_wl',twl); fbS('fb_tot_wp',twp);
        fbS('fb_tot_bl',tbl); fbS('fb_tot_bp',tbp);
        fbS('fb_tot_al',tal); fbS('fb_tot_ap',tap);
        fbS('fb_tot_jl',tjl); fbS('fb_tot_jp',tjp); fbS('fb_tot_j',tj);
        fbS('fb_tot_gl',tgl); fbS('fb_tot_gp',tgp);
        fbS('fb_tot_glp',tglp); fbS('fb_tot_tgl',ttgl);
        fbS('fb_tot_tgp',ttgp); fbS('fb_tot_tg',ttg);
    }
</script>

<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
