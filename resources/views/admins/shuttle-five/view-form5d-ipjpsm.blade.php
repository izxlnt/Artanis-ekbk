@extends('layouts.layout-ipjpsm-nicepage')

@section('content')


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
                                        BORANG 5D - PENYATA PENGELUARAN KAYU KUMAI MENGIKUT JENIS KAYU KUMAI
                                    </div>
                                    <div class="card-body">

                                        <!-- Tab panes -->
                                        <div class="tab-content">

                                            <div class="tab-pane active" id="hotel" role="tabpanel"
                                                aria-labelledby="hotel-tab">
                                                <br>
                                                <div class="" >
                                                <table class="table table-striped table-bordered" id="" style="width: 100%;">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card">

                                                                <div class="card-body">

                                                                    <div class="row" style="justify-content: center;margin-bottom:1%;">
                                                                        <div class="col-md-2">
                                                                            <label>Tahun:</label>
                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #7ee48c6b;  border-color: #6df173;"
                                                                                value="{{ $form5d->tahun }}" readonly />
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label><b>Bulan:</b></label>
                                                                            @if($form5d->bulan <= '1')

                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                value="Januari" readonly />
                                                                            @elseif($form5d->bulan  <= '2')

                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                value="Februari" readonly />
                                                                            @elseif($form5d->bulan  <= '3')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                value="Mac" readonly />
                                                                            @elseif($form5d->bulan  <= '4')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                value="April" readonly />
                                                                            @elseif($form5d->bulan  <= '5')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                value="Mei" readonly />
                                                                            @elseif($form5d->bulan  <= '6')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                value="Jun" readonly />
                                                                            @elseif($form5d->bulan  <= '7')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                value="Julai" readonly />
                                                                            @elseif($form5d->bulan  <= '8')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                value="Ogos" readonly />
                                                                            @elseif($form5d->bulan  <= '9')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                value="September" readonly />
                                                                            @elseif($form5d->bulan  <= '10')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                value="Oktober" readonly />
                                                                            @elseif($form5d->bulan  <= '11')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                value="November" readonly />
                                                                            @elseif($form5d->bulan  <= '12')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #7ee48c6b; border-color: #6df173;"
                                                                                value="Disember" readonly />
                                                                            @endif

                                                                        </div>
                                                                    {{-- </div> --}}
                                                                    <br>

                                                                    {{-- <div class="row"> --}}
                                                                        <div class="col-md-3">
                                                                            <label>Nama Kilang:</label>
                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #7ee48c6b;  border-color: #6df173;"
                                                                                value="{{ $kilang_info->nama_kilang }}" readonly />

                                                                        </div>
                                                                        <div class="col-md-2">

                                                                            <label>No. SSM:</label>
                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #7ee48c6b;  border-color: #6df173;"
                                                                                value="{{ $kilang_info->no_ssm }}" readonly />

                                                                        </div>
                                                                    {{-- </div> --}}
                                                                    <br>
                                                                    {{-- <div class="row"> --}}
                                                                        {{-- <div class="col-md-3"></div> --}}
                                                                        <div class="col-md-2">
                                                                            <label>No. Lesen:</label>
                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #7ee48c6b;  border-color: #6df173;"
                                                                                value="{{ $kilang_info->no_ssm }}" readonly />


                                                                        </div>
                                                                    </div>

                                                                    <table>
                                                                        <tr style="height:50px;">
                                                                            <th style="text-align:center;background-color: #7ee48c6b;"
                                                                                class="col-md-12">Jenis Kayu Kumai</th>
                                                                            <th style="text-align:center;background-color: #7ee48c6b;"
                                                                                class="col-md-12">Pengeluaran Kayu
                                                                                Kumai (&#x33A5;) </th>
                                                                        </tr>

                                                                        @foreach ($jenis_kumai as $key => $data)

                                                                            <tr style="height:50px;">
                                                                                <td style="" class="col-md-12">
                                                                                    {{ $data->keterangan }}
                                                                                    @if ($data->keterangan == 'Lain-lain Profil Kumai (Other Moulding Profiles) (Nyatakan)')
                                                                                        <br>
                                                                                        <input readonly type="text"
                                                                                            style="margin:10px"
                                                                                            value="{{ $form_5d[$key]->catatan ?? 'Tiada Catatan'}} "
                                                                                            size="80"
                                                                                            wire:model='catatan.{{ $key }}'>

                                                                                    @elseif($data->keterangan ==
                                                                                        'Lain-lain (Nyatakan)')
                                                                                        <br>
                                                                                        <input type="text"
                                                                                            style="margin:10px" size="100"
                                                                                            wire:model='catatan.{{ $key }}'>

                                                                                    @endif
                                                                                </td>
                                                                                <td style="text-align:center;">
                                                                                    <input readonly style="text-align:right" type="text" size="10"
                                                                                        wire:model='pengeluaran_kayu.{{ $key }}' value={{ number_format($form_5d[$key]->pengeluaran_kayu,2) }}>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach

                                                                        <tr style="height:50px;">
                                                                            <th style="background-color: #7ee48c6b;"
                                                                                class="col-md-12">Jumlah</th>
                                                                            <td
                                                                                style="text-align:center;background-color: #7ee48c6b;">
                                                                                <input readonly style="text-align:right" type="text" size="10"
                                                                                    wire:model='total_jumlah_pengeluaran' value= {{ number_format($form5d->total_jumlah_pengeluaran ?? 0,2) }}>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <br>
                                                                </div>
                                                            </div>

                                                        <form action="{{ route('update_status_form5D_ipjpsm',$id) }}" method="post">
                                                            @csrf
                                                            <div class="card-body">

                                                                <div class="text-center form-group m-b-0">
                                                                    @if($form5d->status == 'Lulus')
                                                                    <a href="{{ route('ipjpsm.borang-keseluruhan.shuttle5.borangD', date('Y')) }}"
                                                                        class="btn btn-primary">Kembali</a>
                                                                    @else
                                                                    <a href="{{ route('shuttle-5-listD', date('Y')) }}"
                                                                        class="btn btn-primary">Kembali</a>
                                                                    @endif



                                                                    {{-- @if ($errors->isEmpty()) --}}

                                                                    @if($form5d->status == 'Lulus')
                                                                    @else
                                                                    <button type="button" class="btn btn-primary" alt="default"
                                                                        data-toggle="modal" data-target="#confirmation_borang_b"
                                                                        class="model_img img-fluid">
                                                                        DIPERAKU</button>
                                                                    @endif


                                                                </div>

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

                                            </table>
                                        {{-- </div> --}}
                                    {{-- </div> --}}









                                {{-- </div> --}}


                            {{-- </div>
                        </div>
                    </div>
                </div>

            </div> --}}
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

<script>
    var validate = function(e) {
    var t = e.value;
    e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
    }
</script>

    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }

    </style>

    </div>

@endsection
