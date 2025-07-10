@extends('layouts.layout-phd-nicepage')

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
                                        style="text-align:center; background-color: #a0e4ff !important; font-size: 130%; font-weight: bold;">
                                        BORANG 5E - PENYATA PENJUALAN KAYU KUMAI DALAM PASARAN TEMPATAN DAN EKSPORT
                                    </div>
                                    <div class="card-body">
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="hotel" role="tabpanel"
                                                aria-labelledby="hotel-tab">
                                                <br>
                                                <div class="" >
                                                    <div class=" row">
                                                    <div class="col-12">
                                                        <div class="card">


                                                            <div class="card-body">

                                                                <div class="row" style="justify-content: center;">
                                                                    <div class="col-md-2">
                                                                        <label><b>Tahun:</b></label>
                                                                       <input type="text" class="form-control"
                                                                            style="background-color: #a0e4ff; border-color: #9ac4f7"
                                                                            value="{{ $form5e->tahun }}" readonly />
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label><b>Bulan:</b></label>
                                                                        @if($form5e->bulan <= '1')

                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #a0e4ff; border-color: #9ac4f7"
                                                                            value="Januari" readonly />
                                                                        @elseif($form5e->bulan  <= '2')

                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #a0e4ff; border-color: #9ac4f7"
                                                                            value="Februari" readonly />
                                                                        @elseif($form5e->bulan  <= '3')


                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #a0e4ff; border-color: #9ac4f7"
                                                                            value="Mac" readonly />
                                                                        @elseif($form5e->bulan  <= '4')


                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #a0e4ff; border-color: #9ac4f7"
                                                                            value="April" readonly />
                                                                        @elseif($form5e->bulan  <= '5')


                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #a0e4ff; border-color: #9ac4f7"
                                                                            value="Mei" readonly />
                                                                        @elseif($form5e->bulan  <= '6')


                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #a0e4ff; border-color: #9ac4f7"
                                                                            value="Jun" readonly />
                                                                        @elseif($form5e->bulan  <= '7')


                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #a0e4ff; border-color: #9ac4f7"
                                                                            value="Julai" readonly />
                                                                        @elseif($form5e->bulan  <= '8')


                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #a0e4ff; border-color: #9ac4f7"
                                                                            value="Ogos" readonly />
                                                                        @elseif($form5e->bulan  <= '9')


                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #a0e4ff; border-color: #9ac4f7"
                                                                            value="September" readonly />
                                                                        @elseif($form5e->bulan  <= '10')


                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #a0e4ff; border-color: #9ac4f7"
                                                                            value="Oktober" readonly />
                                                                        @elseif($form5e->bulan  <= '11')


                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #a0e4ff; border-color: #9ac4f7"
                                                                            value="November" readonly />
                                                                        @elseif($form5e->bulan  <= '12')


                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #a0e4ff; border-color: #9ac4f7"
                                                                            value="Disember" readonly />
                                                                        @endif


                                                                    </div>
                                                                       <div class="col-md-3">
                                                                        <label><b>Nama Kilang:</b></label>
                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #a0e4ff; border-color: #9ac4f7"
                                                                            value="{{ $form5e->nama_kilang }}" readonly />
                                                                    </div>
                                                                    {{-- <div class="col-md-2"></div> --}}
                                                                       <div class="col-md-2">
                                                                        <label><b>No. Pendaftaran Syarikat (SSM):</b></label>
                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #a0e4ff; border-color: #9ac4f7"
                                                                            value="{{ $form5e->no_ssm }}" readonly />
                                                                    </div>
                                                                       <div class="col-md-2">
                                                                        <label><b>No. Lesen:</b></label>
                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #a0e4ff; border-color: #9ac4f7"
                                                                            value="{{ $form5e->no_lesen }}" readonly />
                                                                    </div>


                                                                </div>
                                                                <br>

                                                                <div class="row">
                                                                    {{-- <div class="col-md-2"></div> --}}
                                                                    <div class="col-md-12">
                                                                        <center>
                                                                            <table>
                                                                                <tr style="height:50px;">
                                                                                    <th style="text-align:center;background-color: #9ac4f7;"
                                                                                        class="col-md-12" colspan="2">
                                                                                        Jenis Pasaran </th>
                                                                                    <th style="text-align:center;background-color: #9ac4f7; "
                                                                                        class="col-md-12">Isipadu
                                                                                        (&#x33A5;) </th>
                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <td style="text-align:center;"
                                                                                        class="" >1.</td>
                                                                                    <td style="" class="" >Jumlah kayu kumai yang dijual dalam pasaran tempatan</td>
                                                                                    <td style="text-align:center;padding:10px">
                                                                                        <input wire:model='jumlah_jualan_pasaran_tempatan'
                                                                                        style="text-align:right" type="text" size="15" value=
                                                                                        {{ number_format($form5e->jumlah_jualan_pasaran_tempatan,2) ?? 0 }}>
                                                                                    </td>
                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <td style="text-align:center;"
                                                                                        class="" >2.</td>
                                                                                            <td style="" class="" >Jumlah kayu kumai yang dieksport</td>
                                                                                            <td style="text-align:center;padding:
                                                                                        10px"><input
                                                                                            wire:model='jumlah_jualan_eksport'
                                                                                            style="text-align:right" type="text" size="15" value=
                                                                                            {{  number_format($form5e->jumlah_jualan_eksport,2) ?? 0 }}></td>
                                                                                </tr>
                                                                            </table>
                                                                            <br>
                                                                        </center>

                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>

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
                                                        <form action="{{ route('update_status_form5E',$id) }}" method="post">
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
                                                                        id="exampleModalLongTitle"><i style="color:rgb(255, 255, 0)"
                                                                            class="fas fa-exclamation-triangle"></i>&nbspPENGESAHAN
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <span class="text-center"><b>Adakah anda pasti ingin mengesahkan borang ini?</b></span>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-dismiss="modal">Batal</button>
                                                                <input type="hidden" value="Dihantar ke IPJPSM" name="status">

                                                                    <button type="submit"
                                                                        class="btn btn-success">SIMPAN</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                                <div id="responsive-modal-tidaklengkap" class="modal fade" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="justify-content:center;background-color:#f3ce8f">
                                                            <h4><b>ULASAN PEGAWAI HUTAN DAERAH</b></h4>

                                                            {{-- <button type="button" class="close"
                                                                data-dismiss="modal" aria-hidden="true">×</button> --}}
                                                        </div>
                                                        <form action="{{ route('update_status_form5E',$id) }}" method="post">
                                                            @csrf
                                                        <div class="modal-body" style="text-align: center">

                                                            <input type="hidden" value="Tidak Lengkap" name="status">
                                                            <textarea name="ulasan_phd" cols="50" rows="10"></textarea><br>
                                                                <h6 style="text-align: center"><i><b>*Pegawai Hutan yang tidak rendah daripada Penolong Pegawai/Penolong Pegawai Hutan Daerah/Penolong Pegawai Hutan Jajahan</i></b></h6>
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
                                                    </div>




                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>









                            </div>


                        </div>
                    </div>
                </div>
            </div>

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
