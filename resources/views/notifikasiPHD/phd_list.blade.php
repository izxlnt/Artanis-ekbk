@extends('layouts.layout-jpn-nicepage')

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

                                <div class="row">
                                    <div class="col-md-12">
                                        <a type="button " href="{{ route('jpn.shuttle-3-listA-jpn', date('Y')) }}"
                                            class="btn"
                                            style="background-color:rgb(196, 188, 186);color:black;border-color:black">Borang
                                            3A</a>
                                        <a type="button" href="{{ route('jpn.shuttle-3-listB-jpn', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#ee8dcd">Borang 3B</a>
                                        <a type="button" href="{{ route('jpn.shuttle-3-listC-jpn', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#bbb235f3">Borang 3C</a>
                                        <a type="button" href="{{ route('jpn.shuttle-3-listD-jpn', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#1b9e21f3">Borang 3D</a>

                                    </div>
                                </div>
                            </div> --}}

                            <br><br>
                            <div>
                                <h4 class="text-center">Notifikasi PHD</h4>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="text-center display" style="width:100%">
                                    <thead>
                                        <tr style="background-color: rgb(196, 188, 186) ">


                                            <th>Bil</th>
                                            <th>Daerah Hutan</th>
                                            <th>Jumlah Borang Yang Tidak Diambil Tindakan</th>
                                            <th>Tindakan</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($daerah_list as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->daerah_hutan }}</td>
                                                <td>
                                                    @php
                                                        $form_counter = 0;

                                                        foreach($form_a as $form){
                                                            if($form->shuttle->daerah_id == $data->daerah_hutan){
                                                                $form_counter++;
                                                            }
                                                        }

                                                        foreach($form_b as $form){
                                                            if($form->shuttle->daerah_id == $data->daerah_hutan){
                                                                $form_counter++;
                                                            }
                                                        }

                                                        foreach($form_c as $form){
                                                            if($form->shuttle->daerah_id == $data->daerah_hutan){
                                                                $form_counter++;
                                                            }
                                                        }

                                                        foreach($form_4d as $form){
                                                            if($form->shuttle->daerah_id == $data->daerah_hutan){
                                                                $form_counter++;
                                                            }
                                                        }

                                                        foreach($form_4e as $form){
                                                            if($form->shuttle->daerah_id == $data->daerah_hutan){
                                                                $form_counter++;
                                                            }
                                                        }

                                                        foreach($form_5d as $form){
                                                            if($form->shuttle->daerah_id == $data->daerah_hutan){
                                                                $form_counter++;
                                                            }
                                                        }

                                                        foreach($form_5e as $form){
                                                            if($form->shuttle->daerah_id == $data->daerah_hutan){
                                                                $form_counter++;
                                                            }
                                                        }
                                                    @endphp

                                                    {{ $form_counter }}

                                                </td>
                                                <td>
                                                        @if($form_counter != 0)
                                                        <button class="btn btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Hantar notifikasi" onclick="return change_id('{{ $data->daerah_hutan }}');"><i class="far fa-envelope"></i></button>
                                                        @else
                                                        <button class="btn btn-dark"><i class="far fa-envelope"></i></button>
                                                        @endif
                                                </td>

                                        @endforeach
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="row">
                                <a class="btn btn-primary" href="{{ route('home-jpn') }}" style="color:white">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="confirmation_send_notification" tabindex="-1" role="dialog"
                aria-labelledby="confirmation_send_notificationTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#f3ce8f  !important">
                            <h5 class="modal-title " id="exampleModalLongTitle"><i
                                    style="color:rgb(255, 255, 0)"
                                    class="fas fa-exclamation-triangle"></i>&nbspPENGESAHAN
                            </h5>
                            <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <span class="text-center"><b>Anda pasti mahu menghantar notifikasi kepada Pejabat Hutan Daerah?</b></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
                            <form action="{{ route('jpn.shuttle-list-jpn.email') }}">
                            @csrf
                                <input type="hidden" id="daerah_hutan" name="daerah_hutan" readonly>
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
        function change_id(e){
            var daerah_hutan = e;
            // console.log(daerah_hutan);
            $('#daerah_hutan').val(daerah_hutan);
            $('#confirmation_send_notification').modal('show');
        }

        function changePage() {

            var year = $("#select_year").val();

            window.location.href = "<?php echo URL::to('/jpn.shuttle-3-listA-jpn/" + year +"'); ?>";
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
          "first":      "Pertama",
          "last":       "Terakhir",
          "next":       "Seterusnya",
          "previous":   "Sebelumnya"
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
