@extends('layouts.layout-ipjpsm-nicepage')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                                            <a class="btn btn-primary" href="{{ route('ipjpsm.senaraikilang3') }}">Industri
                                                Berasas Kayu (IBK)</a>
                                            <a class="btn btn-secondary" href="{{ route('ipjpsm.senaraiphd') }}">Pejabat
                                                Hutan
                                                Daerah (PHD)</a>
                                            <a class="btn btn-secondary" href="{{ route('ipjpsm.senaraijpn') }}">Jabatan
                                                Perhutanan Negeri (JPN)</a>
                                            <a class="btn btn-secondary" href="{{ route('ipjpsm.senaraiipjpsm') }}">Ibu
                                                Pejabat Jabatan Perhutanan Semenanjung Malaysia (IPJPSM)</a>
                                        </div>
                                    </div> <br><br>


                                    <div>
                                        <h2>PENYATA SHUTTLE 5: KILANG KAYU KUMAI</h2>
                                    </div>

                                    <div>
                                        <h3>SENARAI INDUSTRI BERASAS KAYU (IBK)</h3>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="btn btn-secondary"
                                                href="{{ route('ipjpsm.senaraikilang3') }}">Shuttle
                                                3</a>
                                            <a class="btn btn-secondary"
                                                href="{{ route('ipjpsm.senaraikilang4') }}">Shuttle 4</a>
                                            <a class="btn btn-primary" href="{{ route('ipjpsm.senaraikilang5') }}">Shuttle
                                                5</a>

                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="table-responsive">
                                        <table id="example" class="display" style="width:100%">
                                            <thead style="background-color:#ee8dcd">
                                                <tr>
                                                    <th>Bil</th>
                                                    <th>Nama Kilang</th>
                                                    <th>No. SSM</th>
                                                    <th>Jenis Kilang</th>
                                                    <th>Tarikh Permohonan</th>
                                                    <th>Status</th>
                                                    <th>Pengguna Kilang</th>
                                                    <th>Tindakan</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $data)
                                                    @if ($data->kategori_pengguna == 'IBK')
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td style="text-align:left">{{ $data->name }}</td>
                                                            <td>{{ $data->login_id }}</td>
                                                            @if ($data->shuttle_type == '3')
                                                                <td class="txt-oflo">Kilang Papan</td>
                                                            @elseif($data->shuttle_type == '4')
                                                                <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                                                            @else
                                                                <td class="txt-oflo">Kilang Kayu Kumai</td>
                                                            @endif
                                                            <td>{{ $data->created_at }}</td>

                                                            @if ($data->status == 1)
                                                                <td><span
                                                                        class="label label-success label-rounded">Aktif</span>
                                                                </td>
                                                            @elseif($data->status == 0)
                                                                <td><span class="label label-danger label-rounded">Tidak
                                                                        Aktif</span> </td>
                                                            @endif
                                                            <td><a
                                                                    href="{{ route('ipjpsm.senaraiibk5', $data->shuttle_id) }}"><img
                                                                        src="{{ asset('share.png') }}" height='30px'
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Pengguna Kilang"></a>
                                                            </td>
                                                            <td>
                                                                <button class="mr-1 btn btn-warning" data-toggle="modal"
                                                                    data-target="#edit{{ $data->id }}"><i
                                                                        class="fas fa-pencil-alt" data-toggle="tooltip"
                                                                        data-placement="bottom"
                                                                        title="Kemaskini Emel Pengguna"></i></button>
                                                                @if ($data->status == 1)
                                                                    <button class="mr-1 btn btn-danger" data-toggle="modal"
                                                                        data-target="#confirmation_borang_a{{ $data->id }}"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Nyahaktifkan Pengguna"><i
                                                                            class="fas fa-times"></i></button>
                                                                @else
                                                                    <button class="mr-1 btn btn-success" data-toggle="modal"
                                                                        data-target="#confirmation_borang_b{{ $data->id }}"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Aktifkan Pengguna"><i
                                                                            class="fas fa-check"></i></button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif

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
                                                                <form action="{{ route('ipjpsm.emelkilang', $data->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="form-group row">
                                                                            <label for="current_email_{{ $data->id }}"
                                                                                class="text-right col-sm-3 control-label col-form-label">Emel Semasa</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" class="form-control" 
                                                                                    id="current_email_{{ $data->id }}"
                                                                                    value="{{ $data->getCurrentEmail() }}" 
                                                                                    readonly 
                                                                                    style="background-color: #f8f9fa; color: #6c757d;">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="email_{{ $data->id }}"
                                                                                class="text-right col-sm-3 control-label col-form-label">Emel Baru</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="email" class="form-control"
                                                                                    id="email_{{ $data->id }}" name="email"
                                                                                    value=""
                                                                                    placeholder="Masukkan emel baru..."
                                                                                    oninput="validateEmail(this, {{ $data->id }})"
                                                                                    required>
                                                                                <div id="email_feedback_{{ $data->id }}" class="feedback-message"></div>
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
                                                                <div class="modal-body" style="text-align: left">
                                                                    <span class="text-center"><b>Adakah anda pasti ingin
                                                                            menyahaktifkan pengguna?</b></span>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-dismiss="modal">Batal</button>
                                                                    <a style="text-color:white;"
                                                                        href="{{ route('ipjpsm.updateStatusKilang', $data->shuttle_id) }}"
                                                                        class="btn btn-success">NYAHKAKTIF</a>
                                                                </div>
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
                                                                <div class="modal-body" style="text-align: left">
                                                                    <span class="text-center"><b>Adakah anda pasti ingin
                                                                            mengaktifkan pengguna?</b></span>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-dismiss="modal">Batal</button>
                                                                    <a style="text-color:white;"
                                                                        href="{{ route('ipjpsm.updateStatusAktifKilang', $data->shuttle_id) }}"
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

        // Email validation function
        function validateEmail(input, userId) {
            const email = input.value;
            const feedbackDiv = document.getElementById(`email_feedback_${userId}`);

            // Clear previous feedback
            feedbackDiv.innerHTML = '';
            input.classList.remove('is-valid', 'is-invalid');

            if (email === '') {
                return;
            }

            // Basic email format validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                input.classList.add('is-invalid');
                feedbackDiv.innerHTML = '<div class="invalid-feedback" style="display: block; color: red;">Format emel tidak sah.</div>';
                return;
            }

            // Show loading state
            feedbackDiv.innerHTML = '<div style="display: block; color: #007bff;"><i class="fas fa-spinner fa-spin"></i> Memeriksa emel...</div>';

            // AJAX call to check email uniqueness
            fetch('/validate-email', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    email: email,
                    user_id: userId
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.valid) {
                    input.classList.add('is-valid');
                    feedbackDiv.innerHTML = '<div class="valid-feedback" style="display: block; color: green;"><i class="fas fa-check"></i> Emel ini boleh digunakan.</div>';
                } else {
                    input.classList.add('is-invalid');
                    feedbackDiv.innerHTML = '<div class="invalid-feedback" style="display: block; color: red;"><i class="fas fa-exclamation-triangle"></i> ' + data.message + '</div>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                input.classList.add('is-invalid');
                feedbackDiv.innerHTML = '<div class="invalid-feedback" style="display: block; color: red;"><i class="fas fa-exclamation-triangle"></i> Ralat semasa memeriksa emel. Sila cuba lagi.</div>';
            });
        }
    </script>

    <style>
        .feedback-message {
            margin-top: 5px;
        }
        .is-valid {
            border-color: #28a745;
        }
        .is-invalid {
            border-color: #dc3545;
        }
        .valid-feedback {
            display: block;
            color: #28a745;
            font-size: 0.875em;
        }
        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875em;
        }
    </style>
    </script>
@endsection
