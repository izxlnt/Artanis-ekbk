<div>

    <link href="{{asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css')}}" rel="stylesheet" />


    <script src="{{asset('https://code.jquery.com/jquery-3.5.1.js')}}"></script>
    <script src="{{asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js')}}"></script>

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
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->

    <div class="container-fluid" style="width:100%">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if($updatedMode == 0)
                        <div class="card-header"
                            style="text-align:center; background-color: #a0e4ff !important; font-size: 130%; font-weight: bold;">
                            Kemaskini Senarai Status Operasi
                        </div>

                        <br>
                        <div class="">
                                <table id="example" class="display" style="width:100%;text-align:center">
                                    <thead>
                                        <tr>
                                            <th style="width:5%">Bil.</th>
                                            <th style="text-align:center">Keterangan</th>
                                            <th style="text-align:center;style=width:20%">Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                            @forelse($list as $data)
                                        <tr>
                                            <td>{{  $i = $loop->iteration }}</td>
                                            <td>{{ $data->keterangan }}</td>

                                            <td>
                                                <div style="text-align:center">
                                                <button type="button"  wire:click='edit({{ $data->id }})' class="mr-1 btn btn-success"><i class="fas fa-pencil-alt"></i></a>
                                                <button class="btn btn-danger" data-toggle="modal" data-target="#modalID{{ $data->id }}" type="button" ><i class="fas fa-trash-alt"></i></button>
                                                <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;" id="modalID{{ $data->id }}">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="mySmallModalLabel">Adakah anda ingin menghapuskan maklumat?</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">

                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md"></div>
                                                                    <button class="btn btn-success" wire:click='delete({{ $data->id }})' type="button" >Ya</i></button>
                                                                    &nbsp
                                                                    <button class="btn btn-danger" data-dismiss="modal"  type="button" >Batal</i></button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>


                                            </div>
                                            </td>
                                        </tr>
                                            @empty

                                            @endforelse






                                </table>
                                <br>
                            </div>

                            <button class="btn btn-primary" wire:click="addNew()">Tambah</button>
                            @elseif($updatedMode == 1)

                            <form wire:submit.prevent="store">
                                <div class="">
                                    <table class="table table-striped table-bordered" id="" style="width: 100%;">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">

                                                    <form class="form-horizontal">
                                                        <div class="card-body">
                                                            <h4 class="card-title" style="text-align: center">Tambah Senarai Status Operasi</h4>
                                                            <div class="form-group row">
                                                                <label for="fname" class="text-right col-sm-3 control-label col-form-label">Keterangan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" wire:model='keterangan' placeholder="Operasi/Tidak Operasi">
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <hr>
                                                        <div class="card-body">
                                                            <div class="text-right form-group m-b-0">
                                                                <a href="{{ route('home') }}"
                                                                    type="button"
                                                                    class="btn btn-primary">Kembali</a>
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </table>

                                </div>
                            </form>
                            @else
                            <form wire:submit.prevent="update()">
                                <div class="">
                                    <table class="table table-striped table-bordered" id="" style="width: 100%;">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">

                                                    <form class="form-horizontal">
                                                        <div class="card-body">
                                                            <h4 class="card-title" style="text-align: center">Kemaskini Senarai Status Operasi</h4>
                                                            <div class="form-group row">
                                                                <label for="fname" class="text-right col-sm-3 control-label col-form-label">Keterangan</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" wire:model='keterangan' placeholder="Operasi/Tidak Operasi">
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <hr>
                                                        <div class="card-body">
                                                            <div class="text-right form-group m-b-0">
                                                                <a href="{{ route('home') }}"
                                                                    type="button"
                                                                    class="btn btn-primary">Kembali</a>
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </table>

                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="padding-top: 1%">
                                    @if (session()->has('message'))
                                        <div class="alert alert-success" style="text-align: center">
                                         {{ session('message') }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </form>
                            @endif
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
    </div>

