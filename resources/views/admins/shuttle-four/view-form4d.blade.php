
@extends($returnArr['layout'])


@section('content')


<div>
    <div>
        <div>
            <div>
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
                                        style="text-align:center; background-color: #6df173 !important; font-size: 130%; font-weight: bold;">
                                        BORANG 4D - PENYATA PENGELUARAN DARIPADA JENTERA
                                            MEMPROSES PAPAN LAPIS/VENIR
                                    </div>
                                    <div class="card-body">

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="hotel" role="tabpanel" aria-labelledby="hotel-tab">
                                                <br>
                                                <div class="" >
                                                    <table class="table table-striped table-bordered" id=""
                                                        style="width: 100%;">

                                                            <div class="row">
                                                            <div class="col-12">
                                                                <div class="card">


                                                                        <div class="card-body">

                                                                            <div class="row" style="justify-content: center;margin-bottom:-2%;">
                                                                                <div class="col-md-2">
                                                                                    <label><b>Tahun:</b></label>
                                                                                   <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color: #6df173"
                                                                                        value="{{ $form4d->tahun }}" readonly />
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <label><b>Bulan:</b></label>
                                                                                    @if($form4d->bulan <= '1')

                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                        value="Januari" readonly />
                                                                                    @elseif($form4d->bulan  <= '2')

                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                        value="Februari" readonly />
                                                                                    @elseif($form4d->bulan  <= '3')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                        value="Mac" readonly />
                                                                                    @elseif($form4d->bulan  <= '4')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                        value="April" readonly />
                                                                                    @elseif($form4d->bulan  <= '5')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                        value="Mei" readonly />
                                                                                    @elseif($form4d->bulan  <= '6')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                        value="Jun" readonly />
                                                                                    @elseif($form4d->bulan  <= '7')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                        value="Julai" readonly />
                                                                                    @elseif($form4d->bulan  <= '8')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                        value="Ogos" readonly />
                                                                                    @elseif($form4d->bulan  <= '9')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                        value="September" readonly />
                                                                                    @elseif($form4d->bulan  <= '10')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                        value="Oktober" readonly />
                                                                                    @elseif($form4d->bulan  <= '11')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                        value="November" readonly />
                                                                                    @elseif($form4d->bulan  <= '12')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                        value="Disember" readonly />
                                                                                    @endif

                                                                                </div>
                                                                                   <div class="col-md-3">
                                                                                    <label><b>Nama Kilang:</b></label>
                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color: #6df173"
                                                                                        value="{{ $form4d->nama_kilang }}" readonly />
                                                                                </div>
                                                                                {{-- <div class="col-md-2"></div> --}}
                                                                                   <div class="col-md-2">
                                                                                    <label><b>No. Pendaftaran Syarikat (SSM):</b></label>
                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color: #6df173"
                                                                                        value="{{ $form4d->no_ssm }}" readonly />
                                                                                </div>
                                                                                   <div class="col-md-2">
                                                                                    <label><b>No. Lesen:</b></label>
                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color: #6df173"
                                                                                        value="{{ $form4d->no_lesen }}" readonly />
                                                                                </div>


                                                                            </div>
                                                                            <br>
                                                                            <div class="row" style="margin-top:2%;"">
                                                                                <div class="col-md-8"></div>
                                                                                <div class="col-md-4">

                                                                                        <div class="legend" style="border:2px solid;">

                                                                                                <b>MR</b>: <i>Moisture Resistant</i> (tahan lembap) <br>
                                                                                                <b>WBP</b>: <i>Weather and Boil Proof</i> (tahan rebus dan cuaca) <br>

                                                                                        </div>
                                                                                </div>
                                                                            </div>
                                                                            @php
                                                                                $jk1_mr     = $nipis->sum('produk_isipadumr');
                                                                                $jk1_wbp    = $nipis->sum('produk_isipaduwbp');
                                                                                $jk2_mr     = $tebal ? collect($tebal)->sum('produk_isipadumr') : 0;
                                                                                $jk2_wbp    = $tebal ? collect($tebal)->sum('produk_isipaduwbp') : 0;
                                                                                $jbesar_mr  = $jk1_mr + $jk2_mr;
                                                                                $jbesar_wbp = $jk1_wbp + $jk2_wbp;
                                                                                $jml_venier = (float)($form4d->rekod_veniermuka ?? 0) + (float)($form4d->rekod_venierteras ?? 0);
                                                                                $jml_besar  = $jbesar_mr + $jbesar_wbp + $jml_venier;
                                                                            @endphp
                                                                            <table class="table-responsive">
                                                                                <tr style="height:50px;">
                                                                                    <th style="text-align:center;background-color: #7ee48c6b;" class="col-md-12" colspan="3">Pengeluaran</th>
                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <th style="background-color: #7ee48c6b;" class="" >A. PAPAN LAPIS</th>
                                                                                    <th style="text-align:center;background-color: #7ee48c6b;" class="" > MR (&#x33A5;) </th>
                                                                                    <th style="text-align:center;background-color: #7ee48c6b;" class="" >WBP (&#x33A5;) </th>
                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <th style="" class="col-md-12" >"Nipis" (Ketebalan kurang daripada 12mm)</th>
                                                                                    <td style="text-align:center;" ></td>
                                                                                    <td style="text-align:center;" ></td>
                                                                                </tr>

                                                                                @foreach($nipis as $data)
                                                                                <tr style="height:50px;">
                                                                                    <td style="text-align:center;padding: 10px"><input readonly type="text" size="70" value="{{ $data->produk_ketebalan }}"></td>
                                                                                    <td style="text-align:center;padding: 5px"><input readonly style="text-align:right" type="text" size="20" value="{{ $data->produk_isipadumr }}"></td>
                                                                                    <td style="text-align:center;padding: 5px"><input readonly style="text-align:right" type="text" size="20" value="{{ $data->produk_isipaduwbp }}"></td>
                                                                                </tr>
                                                                                @endforeach

                                                                                <tr style="height:50px;">
                                                                                    <th style="text-align:right;background-color: #7ee48c6b;" class="" >JUMLAH KECIL</th>
                                                                                    <td style="text-align:center;padding: 5px"><input readonly style="background-color: #7ee48c6b;text-align:right" type="text" size="20" value="{{ number_format($jk1_mr, 2) }}"></td>
                                                                                    <td style="text-align:center;padding: 5px"><input readonly style="background-color: #7ee48c6b;text-align:right" type="text" size="20" value="{{ number_format($jk1_wbp, 2) }}"></td>
                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <th style="" class="col-md-12" >"Tebal" (Ketebalan 12mm dan lebih)</th>
                                                                                    <td style="text-align:center;" ></td>
                                                                                    <td style="text-align:center;" ></td>
                                                                                </tr>
                                                                                @if($tebal != null)
                                                                                @foreach($tebal as $data)
                                                                                <tr style="height:50px;">
                                                                                    <td style="text-align:center;padding: 10px"><input readonly type="text" size="70" value="{{ $data->produk_ketebalan }}"></td>
                                                                                    <td style="text-align:center;padding: 5px"><input readonly style="text-align:right" type="text" size="20" value="{{ $data->produk_isipadumr }}"></td>
                                                                                    <td style="text-align:center;padding: 5px"><input readonly style="text-align:right" type="text" size="20" value="{{ $data->produk_isipaduwbp }}"></td>
                                                                                </tr>
                                                                                @endforeach
                                                                                @else
                                                                                <tr style="height:50px;">
                                                                                    <td style="text-align:center;padding: 10px"><input readonly type="text" size="70" value="0.00"></td>
                                                                                    <td style="text-align:center;padding: 5px"><input readonly style="text-align:right" type="text" size="20" value="0.00"></td>
                                                                                    <td style="text-align:center;padding: 5px"><input readonly style="text-align:right" type="text" size="20" value="0.00"></td>
                                                                                </tr>
                                                                                @endif

                                                                                <tr style="height:50px;">
                                                                                    <th style="text-align:right;background-color: #7ee48c6b;" class="" >JUMLAH KECIL</th>
                                                                                    <td style="text-align:center;padding: 5px"><input readonly style="background-color: #7ee48c6b;text-align:right" type="text" size="20" value="{{ number_format($jk2_mr, 2) }}"></td>
                                                                                    <td style="text-align:center;padding: 5px"><input readonly style="background-color: #7ee48c6b;text-align:right" type="text" size="20" value="{{ number_format($jk2_wbp, 2) }}"></td>
                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <th style="text-align:right;background-color: #7ee48c6b;" class="" >JUMLAH</th>
                                                                                    <td style="text-align:center;padding: 5px"><input readonly style="background-color: #7ee48c6b;text-align:right" type="text" size="20" value="{{ number_format($jbesar_mr, 2) }}"></td>
                                                                                    <td style="text-align:center;padding: 5px"><input readonly style="background-color: #7ee48c6b;text-align:right" type="text" size="20" value="{{ number_format($jbesar_wbp, 2) }}"></td>
                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <th style="background-color: #7ee48c6b;" class="" >B. VENIR</th>
                                                                                    <th style="text-align:center;background-color: #7ee48c6b;" colspan="2" class="" > (&#x33A5;) </th>
                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <td style="" class="" >Muka (Face)</td>
                                                                                    <td style="text-align:center;padding: 5px" colspan="2"><input readonly style="text-align:right" type="text" size="50" value="{{ number_format((float)($form4d->rekod_veniermuka ?? 0), 2) }}"></td>
                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <td style="" class="" >Teras (Core)</td>
                                                                                    <td style="text-align:center;padding: 5px" colspan="2"><input readonly style="text-align:right" type="text" size="50" value="{{ number_format((float)($form4d->rekod_venierteras ?? 0), 2) }}"></td>
                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <th style="text-align:right;background-color: #7ee48c6b;" class="" >JUMLAH</th>
                                                                                    <td style="text-align:center;padding: 5px" colspan="2"><input readonly style="background-color: #7ee48c6b;text-align:right" type="text" size="50" value="{{ number_format($jml_venier, 2) }}"></td>
                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <th style="text-align:right;background-color: #7ee48c6b;" class="" >JUMLAH BESAR</th>
                                                                                    <td style="text-align:center;padding: 5px" colspan="2"><input readonly style="background-color: #7ee48c6b;text-align:right" type="text" size="50" value="{{ number_format($jml_besar, 2) }}"></td>
                                                                                </tr>
                                                                            </table>
                                                                            <br>

                                                                        </div>
                                                                </div>
                                                            </div>

                                                            <hr>
                                                            <div class="text-center form-group m-b-0">
                                                                @if(auth()->user()->kategori_pengguna == 'PHD')
                                                                <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#modal-tidak-lengkap">
                                                                    TIDAK LENGKAP
                                                                </button>
                                                                @endif
                                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmation_borang_a">
                                                                    SIMPAN
                                                                </button>
                                                            </div>

                                                            {{-- SIMPAN / SAHKAN modal --}}
                                                            @if(auth()->user()->kategori_pengguna == 'BPE')
                                                            <form action="{{ route('update_status_form4D_ipjpsm',$id) }}" method="post">
                                                            @else
                                                            <form action="{{ route('update_status_form4D',$id) }}" method="post">
                                                            @endif
                                                                @csrf
                                                                <div class="modal fade" id="confirmation_borang_a" tabindex="-1" role="dialog" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header bg-info">
                                                                                <h5 class="modal-title"><i style="color:rgb(255,255,0)" class="fas fa-exclamation-triangle"></i>&nbsp;PENGESAHAN</h5>
                                                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p class="text-center"><b>Adakah anda pasti ingin mengesahkan borang ini?</b></p>
                                                                                <div class="form-group mt-2">
                                                                                    <label>Ulasan (jika ada):</label>
                                                                                    <textarea name="ulasan_phd" class="form-control" rows="3"></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                                @if(auth()->user()->kategori_pengguna == 'BPE')
                                                                                <input type="hidden" value="Lulus" name="status">
                                                                                @else
                                                                                <input type="hidden" value="Dihantar ke IPJPSM" name="status">
                                                                                @endif
                                                                                <button type="submit" class="btn btn-success">SAHKAN</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>

                                                            {{-- TIDAK LENGKAP modal (PHD only) --}}
                                                            @if(auth()->user()->kategori_pengguna == 'PHD')
                                                            <form action="{{ route('update_status_form4D',$id) }}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="status" value="Tidak Lengkap">
                                                                <div class="modal fade" id="modal-tidak-lengkap" tabindex="-1" role="dialog" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header bg-warning">
                                                                                <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i>&nbsp;HANTAR SEMULA KE IBK</h5>
                                                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p><b>Borang akan dihantar semula kepada IBK untuk diperbetulkan.</b></p>
                                                                                <div class="form-group">
                                                                                    <label>Sebab / Ulasan: <span class="text-danger">*</span></label>
                                                                                    <textarea name="ulasan_phd" class="form-control" rows="3" required placeholder="Nyatakan sebab borang tidak lengkap..."></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                                <button type="submit" class="btn btn-warning">HANTAR SEMULA</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            @endif



                                                        </div>
                                                </div>
                                            </div>

                                            </table>
                                        </div>
                                    </div>









                                </div>


                            </div>
                        </div>

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

</div>

@endsection

