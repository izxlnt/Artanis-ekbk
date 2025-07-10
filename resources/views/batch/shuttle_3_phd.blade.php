@extends('layouts.layout-phd-nicepage')

@section('content')


    {{-- @livewire('shuttle-three.shuttle3') --}}


    <div>

        <link href="{{ asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css') }}" rel="stylesheet" />


        <script src="{{ asset('https://code.jquery.com/jquery-3.5.1.js') }}"></script>
        <script src="{{ asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js') }}"></script>

        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid" style="width:100%">
            @if (session()->has('message'))
                <div class="row">
                    <div class="col-md-12" style="padding-top: 1% ; text-align:center">
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    </div>
                </div>
            @endif

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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body" style="width: 100%">
                            <div class="row">
                                <div class="col-md-2">
                                    <select name="select_year" id="select_year" class="form-control"
                                        onchange="return changePage();">

                                        <option value="" selected hidden disabled>
                                            TIADA BORANG DIREKODKAN
                                        </option>

                                        @foreach ($year_list as $data)
                                            <option value="{{ $data->tahun }}"
                                                {{ $data->tahun == $year ? 'selected' : '' }}>
                                                Tahun {{ $data->tahun }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <br><br>
                            <div>
                                <h4 class="text-center">PENGESAHAN PAKEJ - SHUTTLE 3</h4>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="text-center display" style="width:100%">
                                    <thead style="background-color:#ee8dcd">
                                        <tr>
                                            <th>Bil</th>

                                            <th>Nama Kilang</th>

                                            <th>Tahun</th>
                                            <th>Bulan</th>
                                            <th>Status</th>

                                            <th>Borang A</th>
                                            <th>Borang B</th>
                                            <th>Borang C</th>
                                            <th>Borang D</th>

                                            <th>Tindakan</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($batch as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                <td style="text-align:left">{{ $data->shuttle->nama_kilang }}</td>

                                                <td>{{ $data->tahun }}</td>
                                                <td>{{ $data->bulan }}</td>
                                                <td>{{ $data->status }}</td>

                                                <td>
                                                    @if ($data->borang_a == 1)
                                                    <img src="{{ asset('warning.png') }}" height='30px' alt=""
                                                    style="color: green; font-size: 18pt;" data-toggle="tooltip"
                                                    data-placement="bottom" title="Borang perlu disahkan"></i>
                                                    @elseif($data->borang_a == 2)
                                                        <img src="{{ asset('circle_check.png') }}" height='30px' alt=""
                                                            style="color: green; font-size: 18pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang telah disahkan"></i>
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($data->borang_b == 1)
                                                    <img src="{{ asset('warning.png') }}" height='30px' alt=""
                                                    style="color: green; font-size: 18pt;" data-toggle="tooltip"
                                                    data-placement="bottom" title="Borang perlu disahkan"></i>
                                                    @elseif($data->borang_b == 2)
                                                        <img src="{{ asset('circle_check.png') }}" height='30px' alt=""
                                                            style="color: green; font-size: 18pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang telah disahkan"></i>
                                                    @else
                                                        @if ($data->bulan == 3 || $data->bulan == 6 || $data->bulan == 9 || $data->bulan == 12)
                                                            <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                                style="color: black; font-size: 18pt;" data-toggle="tooltip"
                                                                data-placement="bottom" title="Borang tidak diisi"></i>
                                                        @else
                                                            -
                                                        @endif
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($data->borang_c == 1)
                                                    <img src="{{ asset('warning.png') }}" height='30px' alt=""
                                                    style="color: green; font-size: 18pt;" data-toggle="tooltip"
                                                    data-placement="bottom" title="Borang perlu disahkan"></i>
                                                    @elseif($data->borang_c == 2)
                                                        <img src="{{ asset('circle_check.png') }}" height='30px' alt=""
                                                            style="color: green; font-size: 18pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang telah disahkan"></i>
                                                    @else
                                                        <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                            style="color: black; font-size: 18pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang tidak diisi"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($data->borang_d == 1)
                                                    <img src="{{ asset('warning.png') }}" height='30px' alt=""
                                                    style="color: green; font-size: 18pt;" data-toggle="tooltip"
                                                    data-placement="bottom" title="Borang perlu disahkan"></i>
                                                    @elseif($data->borang_d == 2)
                                                        <img src="{{ asset('circle_check.png') }}" height='30px' alt=""
                                                            style="color: green; font-size: 18pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang telah disahkan"></i>
                                                    @else
                                                        <img src="{{ asset('circle_times.png') }}"
                                                                            height='30px' alt=""
                                                            style="color: black; font-size: 18pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang tidak diisi"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    {{-- @if ($data->borang_a == 1 || $data->borang_b == 1 || $data->borang_c == 1 || $data->borang_d == 1)
                                                        <button class="mr-1 btn btn-dark"><i class="fas fa-pencil-alt"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum disahkan"></i></button>
                                                    @else
                                                        @if ($data->bulan == 3 || $data->bulan == 6 || $data->bulan == 9 || $data->bulan == 12)
                                                            @if ($data->borang_b != 2)
                                                                <button class="mr-1 btn btn-dark" data-toggle="tooltip"
                                                                    data-placement="bottom" title="Borang belum disahkan"><i
                                                                        class="fas fa-pencil-alt"></i></button>
                                                            @else
                                                                <form action="{{ route('phd.batch.s3.hantar') }}">
                                                                    @csrf
                                                                    <input type="hidden" name="batch_id" id="batch_id"
                                                                        value="{{ $data->id }}">
                                                                    <button type="submit" ><img src="{{ asset('share.png') }}" height='30px' alt=""></i></button>
                                                                </form>
                                                            @endif
                                                        @else
                                                            <form action="{{ route('phd.batch.s3.hantar') }}">
                                                                @csrf
                                                                <input type="hidden" name="batch_id" id="batch_id"
                                                                    value="{{ $data->id }}">
                                                                <input type="hidden" name="year" id="year"
                                                                    value="{{ $year }}">
                                                                <button type="submit" class="mr-1 btn btn-success"><i
                                                                        class="fas fa-share"></i></button>
                                                            </form>
                                                        @endif
                                                    @endif --}}


                                                    @if ($data->borang_c == 2 && $data->borang_d == 2)

                                                        @if ($data->bulan == 3 || $data->bulan == 6 || $data->bulan == 9 || $data->bulan == 12)
                                                            @if ($data->borang_b == 2)
                                                                @if ($data->borang_a == 1)
                                                                    <a class="mr-1 btn btn-dark"><i
                                                                            class="fas fa-pencil-alt" data-toggle="tooltip"
                                                                            data-placement="bottom"
                                                                            title="Borang belum disahkan"></i></a>
                                                                @else
                                                                    <form action="{{ route('phd.batch.s3.hantar',$data->id) }}">
                                                                        @csrf
                                                                        <input type="hidden" name="batch_id" id="batch_id"
                                                                            value="{{ $data->id }}">
                                                                        <input type="hidden" name="year" id="year"
                                                                            value="{{ $year }}">
                                                                        <a type="button" alt="default"
                                                                            data-toggle="modal"
                                                                            data-target="#confirmation_borang_a{{ $data->id }}"><img src="{{ asset('share.png') }}" height='30px' alt="" data-toggle="tooltip"
                                                                                data-placement="bottom"
                                                                                title="Hantar pakej"></i></a>


                                                                        <div class="modal fade"
                                                                            id="confirmation_borang_a{{ $data->id }}" tabindex="-1"
                                                                            role="dialog"
                                                                            aria-labelledby="confirmation_borang_aTitle"
                                                                            aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered"
                                                                                role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header"
                                                                                        style="background-color:#f3ce8f  !important">
                                                                                        <h5 class="modal-title "
                                                                                            id="exampleModalLongTitle"><i
                                                                                                style="color:rgb(255, 255, 0)"
                                                                                                class="fas fa-exclamation-triangle"></i>&nbspPENGESAHAN
                                                                                        </h5>
                                                                                        <button type="button"
                                                                                            class="close"
                                                                                            data-dismiss="modal"
                                                                                            aria-label="Close">
                                                                                            <span
                                                                                                aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body" style="text-align: left"><b>
                                                                                        <span class="text-left">Adakah
                                                                                            anda
                                                                                            pasti ingin menghantar borang
                                                                                            ini?</span>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button"
                                                                                            class="btn btn-danger"
                                                                                            data-dismiss="modal">Batal</button>
                                                                                        <button type="submit"
                                                                                            class="btn btn-success">HANTAR</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                    </form>
                                                                @endif
                                                            @else
                                                                <button class="mr-1 btn btn-dark"><i
                                                                        class="fas fa-pencil-alt" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Borang belum disahkan"></i></button>
                                                            @endif
                                                        @else
                                                            @if ($data->borang_a == 1)
                                                                <button class="mr-1 btn btn-dark"><i
                                                                        class="fas fa-pencil-alt" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Borang belum disahkan"></i></button>
                                                            @else
                                                                <form action="{{ route('phd.batch.s3.hantar',$data->id) }}">
                                                                    @csrf
                                                                    <input type="hidden" name="batch_id" id="batch_id"
                                                                        value="{{ $data->id }}">
                                                                    <input type="hidden" name="year" id="year"
                                                                        value="{{ $year }}">
                                                                    <a type="button" alt="default" data-toggle="modal"
                                                                        data-target="#confirmation_borang_a{{ $data->id }}"
                                                                        ><img src="{{ asset('share.png') }}" height='30px' alt="" data-toggle="tooltip"
                                                                            data-placement="bottom"
                                                                            title="Hantar pakej"></i></a>

                                                                    <div class="modal fade" id="confirmation_borang_a{{ $data->id }}"
                                                                        tabindex="-1" role="dialog"
                                                                        aria-labelledby="confirmation_borang_aTitle"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered"
                                                                            role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header"
                                                                                    style="background-color:#f3ce8f  !important">
                                                                                    <h5 class="modal-title "
                                                                                        id="exampleModalLongTitle"><i
                                                                                            style="color:rgb(255, 255, 0)"
                                                                                            class="fas fa-exclamation-triangle"></i>&nbspPENGESAHAN
                                                                                    </h5>
                                                                                    <button type="button"
                                                                                        class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span
                                                                                            aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body" style="text-align: left"><b>
                                                                                    <span class="text-left">Adakah anda
                                                                                        pasti ingin menghantar borang
                                                                                        ini?</span>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-danger"
                                                                                        data-dismiss="modal">Batal</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-success">HANTAR</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            @endif

                                                        @endif

                                                    @else
                                                        <button class="mr-1 btn btn-dark"><i class="fas fa-pencil-alt"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Borang belum disahkan"></i></button>
                                                    @endif
                                                </td>
                                        @endforeach
                                        </tr>
                                    </tbody>
                                </table>

                                <br>
                            </div>
                            <div class="row">
                                <a class="btn btn-primary" href="{{  route('home-phd')  }}" style="color:white">Kembali</a>
                            </div>



                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->


    </div>

    <script>
        function changePage() {

            var year = $("#select_year").val();

            window.location.href = "<?php echo URL::to('/phd/batch/shuttle-3/" + year +"'); ?>";
        }
    </script>

    <script>
        // document.addEventListener("DOMContentLoaded", () => {
        //     Livewire.hook('component.initialized', (component) => {
        //         console.log(component);
        //         $(document).ready(function() {
        //             $('#example').DataTable();
        //         });
        //     })
        // });
    </script>

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
            ordering : false,
                "language": {
                    "lengthMenu": "Memaparkan _MENU_ rekod per halaman",
                    "zeroRecords": "Maaf, tiada rekod.",
                    "info": "Memaparkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada rekod yang tersedia",
                    "infoFiltered": "(Ditapis dari _MAX_ jumlah rekod)",
                    "search": "Carian",
                    "previous": "Sebelum",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Seterusnya",
                        "previous": "Sebelumnya"
                    },
                },
            });
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
        function onlyNumberKey(evt) {

            // Only ASCII charactar in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
    </script>

@endsection
