@extends('layouts.layout-ipjpsm-nicepage')

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

                                                                <div class="row" style="justify-content: center;margin-bottom:1%;">
                                                                    <div class="col-md-2">
                                                                        <label>Tahun:</label>
                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #ccebf96b;"
                                                                            value="{{ $kilang_info->tahun }}" readonly />
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>Bulan:</label>
                                                                        @if($form5e->bulan <= '1')

                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #ccebf96b;"
                                                                                value="Januari" readonly />
                                                                            @elseif($form5e->bulan  <= '2')

                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #ccebf96b;"
                                                                                value="Februari" readonly />
                                                                            @elseif($form5e->bulan  <= '3')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #ccebf96b;"
                                                                                value="Mac" readonly />
                                                                            @elseif($form5e->bulan  <= '4')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #ccebf96b;"
                                                                                value="April" readonly />
                                                                            @elseif($form5e->bulan  <= '5')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #ccebf96b;"
                                                                                value="Mei" readonly />
                                                                            @elseif($form5e->bulan  <= '6')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #ccebf96b;"
                                                                                value="Jun" readonly />
                                                                            @elseif($form5e->bulan  <= '7')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #ccebf96b;"
                                                                                value="Julai" readonly />
                                                                            @elseif($form5e->bulan  <= '8')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #ccebf96b;"
                                                                                value="Ogos" readonly />
                                                                            @elseif($form5e->bulan  <= '9')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #ccebf96b;"
                                                                                value="September" readonly />
                                                                            @elseif($form5e->bulan  <= '10')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #ccebf96b;"
                                                                                value="Oktober" readonly />
                                                                            @elseif($form5e->bulan  <= '11')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #ccebf96b;"
                                                                                value="November" readonly />
                                                                            @elseif($form5e->bulan  <= '12')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #ccebf96b;"
                                                                                value="Disember" readonly />
                                                                            @endif
                                                                    </div>
                                                                {{-- </div> --}}
                                                                <br>

                                                                {{-- <div class="row"> --}}
                                                                    <div class="col-md-3">
                                                                        <label>Nama Kilang:</label>
                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #ccebf96b;"
                                                                            value="{{ $kilang_info->nama_kilang }}"
                                                                            readonly />

                                                                    </div>
                                                                    <div class="col-md-2">

                                                                        <label>No. SSM:</label>
                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #ccebf96b;"
                                                                            value="{{ $kilang_info->no_ssm }}" readonly />

                                                                    </div>
                                                                {{-- </div> --}}
                                                                <br>
                                                                {{-- <div class="row">
                                                                    <div class="col-md-3"></div> --}}
                                                                    <div class="col-md-2">
                                                                        <label>No. Lesen:</label>
                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #ccebf96b;"
                                                                            value="{{ $kilang_info->no_lesen }}"
                                                                            readonly />


                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <form action="{{ route('update_status_form5E_ipjpsm',$id) }}" method="post">
                                                                    @csrf
                                                                <div class="row">
                                                                    {{-- <div class="col-md-2"></div> --}}
                                                                    <div class="col-md-12">
                                                                        <center>
                                                                            <table>
                                                                                <tr style="height:50px;">
                                                                                    <th style="text-align:center;background-color: #9ac4f7; "
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
                                                                                        <input
                                                                                            wire:model='jumlah_jualan_pasaran_tempatan' readonly
                                                                                            style="text-align:right;background-color: #9ac4f7; " type="text"
                                                                                            size="15" value="{{ number_format($form5e->jumlah_jualan_pasaran_tempatan ?? '0.00',2)}}">
                                                                                        <input
                                                                                        name='jumlah_jualan_pasaran_tempatan_cleaning' onkeypress="return isNumberKey(event)"
                                                                                        style="text-align:right" type="text" value="{{ number_format($form5e->jumlah_jualan_pasaran_tempatan_cleaning ?? '0.00',2)}}"
                                                                                        size="15" readonly>
                                                                                    </td>

                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <td style="text-align:center;"
                                                                                        class="" >2.</td>
                                                                                            <td style="" class="" >Jumlah kayu kumai yang dieksport</td>
                                                                                            <td style="text-align:center;padding:10px">
                                                                                        <input
                                                                                            wire:model='jumlah_jualan_eksport' readonly
                                                                                            style="text-align:right;background-color: #9ac4f7; " type="text" size="15" value="{{ number_format($form5e->jumlah_jualan_eksport ?? '0.00',2) }}">

                                                                                        <input
                                                                                            name='jumlah_jualan_eksport_cleaning' onkeypress="return isNumberKey(event)"
                                                                                            style="text-align:right" type="text" size="15" value="{{ number_format($form5e->jumlah_jualan_eksport_cleaning ?? '0.00',2)}}" readonly>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                            <br>
                                                                        </center>

                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>



                                                        <br>

                                                        {{-- <form action="{{ route('update_status_form5E_ipjpsm',$id) }}" method="post">
                                                            @csrf
                                                        <div class="row" style="text-align:center">
                                                            <div class="col-md-12">
                                                                <p>
                                                                    <button style="width:300px;" class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                                        Ulasan IPJPSM
                                                                    </button>
                                                                </p>
                                                                <div class="collapse" id="collapseExample">
                                                                    <div class="card card-body">
                                                                        <textarea name="ulasan_ipjpsm" cols="30" rows="10"></textarea>
                                                                    </div>
                                                                    <fieldset class="radio">
                                                                        <label for="radio1">
                                                                            <input type="radio" id="radio1" name="status" value="Tidak Lengkap">&nbsp Tidak Lengkap
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset class="radio">
                                                                        <label>
                                                                            <input type="radio" name="status" value="Lulus" >&nbsp Diterima
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset class="radio">
                                                                        <label>
                                                                            <input type="radio" name="status" value="Gagal" >&nbsp Tidak Diterima
                                                                        </label>
                                                                    </fieldset>
                                                                    <br>
                                                                    <button type="submit" class="btb btn-primary">Hantar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form> --}}


                                                        <div class="card-body">
                                                            {{-- @if ($errors->any())
                                                                            <div class="text-center form-group m-b-0">
                                                                                <h4 style="color:red">Sila Betulkan Maklumat Yang Berwarna Merah
                                                                                </h4>
                                                                            </div>
                                                                        @endif --}}
                                                            {{--  --}}

                                                            <div class="modal fade" id="confirmation_borang_b" tabindex="-1"
                                                                role="dialog" aria-labelledby="confirmation_borang_bTitle"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-info"
                                                                            style="background-color: #f3ce8f !important;">
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
                                                                        <div class="modal-body"><b>
                                                                            <span class="text-center">Adakah anda
                                                                                pasti untuk mengesahkan
                                                                                borang ini?</b></span>
                                                                        </div>

                                                                        <input type="hidden" name="status" value='Lulus'>
                                                                        <div class="modal-footer">
                                                                            <button type="button" id="submit-button"
                                                                                class="btn btn-danger"
                                                                                data-dismiss="modal">Kembali</button>
                                                                            <button type="submit"
                                                                                class="btn btn-success">PERAKU</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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
