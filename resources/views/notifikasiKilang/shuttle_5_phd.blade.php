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
                            {{-- <div class="row">
                                <div class="col-md-2">
                                    <select name="select_year" id="select_year" class="form-control"
                                        onchange="return changePage();">

                                        @foreach ($year_list as $data)
                                            <option value="{{ $data->tahun }}"
                                                {{ $data->tahun == $year ? 'selected' : '' }}>
                                                Tahun {{ $data->tahun }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div> --}}
                            <br><br>
                            <div>
                                <h4 class="text-center">NOTIFIKASI KILANG - SHUTTLE 5</h4>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="text-center display" style="width:100%">
                                    <thead style="background-color:#f1db2e;">
                                        <tr>
                                            <th>Bil</th>

                                            <th>Nama Kilang</th>

                                            <th>Negeri</th>
                                            <th>Daerah</th>
                                            <th>No. SSM</th>
                                            <th>No. Lesen</th>

                                            <th>Borang A</th>
                                            <th>Borang B</th>
                                            <th>Borang C</th>
                                            <th>Borang D</th>
                                            <th>Borang E</th>

                                            <th>Jumlah Borang Tidak Diisi</th>
                                            <th>Tindakan</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kilang_s5 as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                <td style="text-align:left">{{ $data->nama_kilang }}</td>

                                                <td>{{ $data->negeri_id }}</td>
                                                <td>{{ $data->daerah_id }}</td>
                                                <td>{{ $data->no_ssm }}</td>
                                                <td>{{ $data->no_lesen }}</td>

                                                <td>
                                                    @php
                                                        $form_A_counter = 0;

                                                        foreach ($form_a as $form) {
                                                            if ($data->id == $form->shuttle_id) {
                                                                $form_A_counter++;
                                                            }
                                                        }
                                                    @endphp

                                                    {{ $form_A_counter }}

                                                </td>

                                                <td>
                                                    @php
                                                        $form_B_counter = 0;

                                                        foreach ($form_b as $form) {
                                                            if ($data->id == $form->shuttle_id) {
                                                                $time = strtotime($form->tarikh_tutup_borang);
                                                                $delay = '+' . $buffer_b->delay . ' month';
                                                                $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));

                                                                if (date('Y-m-d') >= $form->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini) {
                                                                    $form_B_counter++;
                                                                }
                                                            }
                                                        }
                                                    @endphp

                                                    {{ $form_B_counter }}

                                                </td>

                                                <td>
                                                    @php
                                                        $form_C_counter = 0;

                                                        foreach ($form_c as $form) {
                                                            if ($data->id == $form->shuttle_id) {
                                                                $time = strtotime($form->tarikh_tutup_borang);
                                                                $delay = '+' . $buffer_c->delay . ' month';
                                                                $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));

                                                                if (date('Y-m-d') >= $form->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini) {
                                                                    $form_C_counter++;
                                                                }
                                                            }
                                                        }
                                                    @endphp

                                                    {{ $form_C_counter }}
                                                </td>

                                                <td>
                                                    @php
                                                        $form_D_counter = 0;

                                                        foreach ($form_d as $form) {
                                                            if ($data->id == $form->shuttle_id) {
                                                                $time = strtotime($form->tarikh_tutup_borang);
                                                                $delay = '+' . $buffer_d->delay . ' month';
                                                                $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));

                                                                if (date('Y-m-d') >= $form->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini) {
                                                                    $form_D_counter++;
                                                                }
                                                            }
                                                        }
                                                    @endphp

                                                    {{ $form_D_counter }}

                                                </td>

                                                <td>
                                                    @php
                                                        $form_E_counter = 0;

                                                        foreach ($form_e as $form) {
                                                            if ($data->id == $form->shuttle_id) {
                                                                $time = strtotime($form->tarikh_tutup_borang);
                                                                $delay = '+' . $buffer_e->delay . ' month';
                                                                $tarikh_tutup_terkini = date('Y-m-d', strtotime($delay, $time));

                                                                if (date('Y-m-d') >= $form->tarikh_buka_borang && date('Y-m-d') <= $tarikh_tutup_terkini) {
                                                                    $form_E_counter++;
                                                                }
                                                            }
                                                        }
                                                    @endphp

                                                    {{ $form_E_counter }}

                                                </td>

                                                <td>{{ $form_A_counter + $form_B_counter + $form_C_counter + $form_D_counter + $form_E_counter }}
                                                </td>

                                                <td>
                                                    @if ($form_A_counter + $form_B_counter + $form_C_counter + $form_D_counter + $form_E_counter != 0)
                                                        <button class="btn btn-success"
                                                            onclick="return change_id({{ $data->id }});"> <i
                                                                class="far fa-envelope"></i> </button>
                                                    @else
                                                        <button class="btn btn-dark"> <i class="far fa-envelope"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                        @endforeach
                                        </tr>
                                    </tbody>
                                </table>

                                <br>
                            </div>
                            <div class="row">
                                <a class="btn btn-primary" href="{{ route('home-phd') }}" style="color:white">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="confirmation_send_notification" tabindex="-1" role="dialog"
                aria-labelledby="confirmation_send_notificationTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title " id="exampleModalLongTitle"><i style="color:rgb(255, 255, 0)"
                                    class="fas fa-exclamation-triangle"></i>&nbspPengesahan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <span class="text-center"><b>Anda pasti mahu menghantar notifikasi kepada kilang?</b></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
                            <form action="{{ route('phd.notifikasi-kilang.s5.send') }}">
                                @csrf
                                <input type="hidden" id="shuttle_id" name="shuttle_id">
                                <button type="submit" class="btn btn-success">HANTAR</button>
                            </form>
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
        function change_id(e) {
            var shuttle_id = e;
            // console.log(shuttle_id);
            $('#shuttle_id').val(shuttle_id);
            $('#confirmation_send_notification').modal('show');
        }

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
                ordering: false,
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
