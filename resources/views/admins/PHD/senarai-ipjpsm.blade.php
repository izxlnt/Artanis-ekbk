@extends($layout)


@section('content')
    {{-- @livewire('shuttle-three.shuttle3') --}}


    <div>

        <link href="{{ asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css') }}" rel="stylesheet" />


        <script src="{{ asset('https://code.jquery.com/jquery-3.5.1.js') }}"></script>
        <script src="{{ asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js') }}"></script>

        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid" style="width: 100%;">

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
                <div class="col-md-12" style="padding-top: 1% ; text-align:center">

                    <div class="row">
                        <div class="col-12">
                            <div class="card">

                                <div class="card-body" style="width: 100%">

                                    <div>
                                        <h3>PENGURUSAN PENGGUNA</h3>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align:left">
                                            @if (auth()->user()->kategori_pengguna == 'BPE')
                                                <a class="btn btn-secondary"
                                                    href="{{ route('ipjpsm.senaraikilang3') }}">Industri Berasas Kayu
                                                    (IBK)</a>
                                                <a class="btn btn-secondary" href="{{ route('ipjpsm.senaraiphd') }}">Pejabat
                                                    Hutan Daerah (PHD)</a>
                                                <a class="btn btn-secondary"
                                                    href="{{ route('ipjpsm.senaraijpn') }}">Jabatan Perhutanan Negeri
                                                    (JPN)</a>
                                                <a class="btn btn-primary" href="{{ route('ipjpsm.senaraiipjpsm') }}">Ibu
                                                    Pejabat Jabatan Perhutanan Semenanjung Malaysia (IPJPSM)</a>
                                            @elseif(auth()->user()->kategori_pengguna == 'BPM')
                                                <a class="btn btn-secondary"
                                                    href="{{ route('ipjpsm.senaraibpm') }}">Bahagian Pengurusan Maklumat
                                                    (BPM)</a>
                                                <a class="btn btn-primary" href="{{ route('ipjpsm.senaraiipjpsm') }}">Ibu
                                                    Pejabat Jabatan Perhutanan Semenanjung Malaysia (IPJPSM)</a>
                                                <a class="btn btn-secondary"
                                                    href="{{ route('ipjpsm.senaraiphd') }}">Pejabat Hutan Daerah (PHD)</a>
                                                <a class="btn btn-secondary"
                                                    href="{{ route('ipjpsm.senaraijpn') }}">Jabatan Perhutanan Negeri
                                                    (JPN)</a>
                                            @endif


                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table id="example" class="display" style="width:100%">
                                            <thead style="background-color:#ee8dcd">
                                                <tr>
                                                    <th>Bil</th>
                                                    <th>Nama Penuh</th>
                                                    <th>No. Kad Pengenalan</th>
                                                    {{-- <th>Negeri</th>
                                        <th>Daerah Hutan</th> --}}
                                                    <th>Status</th>
                                                    <th>Tindakan</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $data)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td style="text-align:left">{{ $data->name }}</td>
                                                        <td>{{ $data->login_id }}</td>
                                                        {{-- <td>{{ $data->negeri }}</td>
                                        <td>{{ $data->daerah }}</td> --}}
                                                        @if ($data->status == 1)
                                                            <td><span class="label label-success label-rounded">Aktif</span>
                                                            </td>
                                                        @elseif($data->status == 0)
                                                            <td><span class="label label-danger label-rounded">Tidak
                                                                    Aktif</span> </td>
                                                        @endif


                                                        <td>
                                                            <button class="mr-1 btn btn-warning" data-toggle="modal"
                                                                data-target="#edit{{ $data->id }}"><i
                                                                    class="fas fa-pencil-alt" data-toggle="tooltip"
                                                                    data-placement="bottom"
                                                                    title="Kemaskini Emel Pengguna"></i></button>
                                                            @if ($data->status == 1)
                                                                <button class="mr-1 btn btn-danger" data-toggle="modal"
                                                                    data-target="#confirmation_borang_a{{ $data->id }}"><i
                                                                        class="fas fa-times" data-toggle="tooltip"
                                                                        data-placement="bottom" title="Nyahaktifkan Pengguna"></i></button>
                                                            @else
                                                                <button class="mr-1 btn btn-success" data-toggle="modal"
                                                                    data-target="#confirmation_borang_b{{ $data->id }}"><i
                                                                        class="fas fa-check" data-toggle="tooltip"
                                                                        data-placement="bottom" title="Aktifkan Pengguna"><i
                                                                            class="fas fa-check"></i></button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="confirmation_borang_a{{ $data->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="confirmation_borang_aTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header"
                                                                    style="background-color:#f3ce8f  !important">
                                                                    <h5 class="modal-title " id="exampleModalLongTitle"><i
                                                                            style="color:rgb(255, 255, 0)"
                                                                            class="fas fa-exclamation-triangle"></i>&nbspPENGESAHAN
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body" style="text-align:left">
                                                                    <span class="text-center"><b>Adakah anda pasti ingin
                                                                            menyahaktifkan pengguna?</b></span>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-dismiss="modal">Batal</button>
                                                                    <a style="text-color:white;"
                                                                        href="{{ route('ipjpsm.updateStatus', $data->id) }}"
                                                                        class="btn btn-success">NYAHAKTIF</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="edit{{ $data->id }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="confirmation_borang_aTitle"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header"
                                                                    style="background-color:#f3ce8f  !important">
                                                                    <h5 class="modal-title " id="exampleModalLongTitle"><i
                                                                            style="color:rgb(255, 255, 0)"
                                                                            class="fas fa-exclamation-triangle"></i>&nbspKEMASKINI
                                                                        EMEL PENGGUNA
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="{{ route('ipjpsm.emelipjpsm', $data->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="form-group row">
                                                                            <label for="cono1"
                                                                                class="text-right col-sm-3 control-label col-form-label ">Emel</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="email" class="form-control"
                                                                                    id="email" name="email"
                                                                                    value="{{ $data->email }}">
                                                                            </div>
                                                                            @error('email')
                                                                                <div class="alert alert-danger">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger"
                                                                            data-dismiss="modal">Batal</button>
                                                                        <button style="text-color:white;" type="submit"
                                                                            class="btn btn-success">KEMASKINI</a>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="confirmation_borang_b{{ $data->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="confirmation_borang_aTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header"
                                                                    style="background-color:#f3ce8f  !important">
                                                                    <h5 class="modal-title " id="exampleModalLongTitle"><i
                                                                            style="color:rgb(255, 255, 0)"
                                                                            class="fas fa-exclamation-triangle"></i>&nbspPENGESAHAN
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body" style="text-align:left">
                                                                    <span class="text-center"><b>Adakah anda pasti ingin
                                                                            mengaktifkan pengguna?</b></span>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-dismiss="modal">Batal</button>
                                                                    <a style="text-color:white;"
                                                                        href="{{ route('ipjpsm.updateStatusAktif', $data->id) }}"
                                                                        class="btn btn-success">AKTIF</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </tbody>


                                        </table>


                                        <br>
                                    </div>
                                    <div class="row">
                                        <a class="btn btn-primary" href="{{ route('home') }}"
                                            style="color:white">Kembali</a>
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
        </div>
    </div>

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
