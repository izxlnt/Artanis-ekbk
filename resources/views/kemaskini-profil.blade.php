@extends('layouts.layout-ibk-nicepage')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
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
            {{-- <div class="col-2"></div> --}}
            <div class="col-12">
                <div class="card">
                    <div class="text-center card-header" style="background-color: #f3ce8f;">
                        <h4>Kemaskini Profil</h4>
                    </div>
                    <form method="POST" enctype="multipart/form-data" action="{{ route('kemaskini-profil-update') }}">
                        @csrf

                        <div class="border card-body border-dark">

                            {{-- Flash Message --}}
                            {{-- @if ($message = Session::get('success'))
                    <div class="border alert alert-success border-success" style="text-align: center;">{{$message}}</div>
                  @elseif ($message = Session::get('error'))
                    <div class="border alert alert-danger border-danger" style="text-align: center;">{{$message}}</div>
                  @else
                    <div class="alert alert-white" style="text-align: center;"></div>
                  @endif --}}

                            <div class="row" style="padding-top: 15px;">
                                <div class="col-md-2"></div>
                                <div class="col-md">
                                    <label>Nama Pengguna</label>
                                    <div class="mb-3 input-group">
                                        <input readonly
                                            class="form-control  @error('name') is-invalid @else border-dark @enderror"
                                            id="name" name="name" type="text" value="{{ $user->name }}"
                                            oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md">
                                    <label>Nama Kilang</label>
                                    <div class="mb-3 input-group">
                                        <input readonly
                                            class="form-control  @error('name') is-invalid @else border-dark @enderror"
                                            id="name" name="name" type="text" value="{{ $info->nama_kilang }}"
                                            oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md">
                                    <label>No. SSM</label>
                                    <div class="mb-3 input-group">
                                        <input readonly
                                            class="form-control  @error('name') is-invalid @else border-dark @enderror"
                                            id="name" name="name" type="text" value="{{ $info->no_ssm }}"
                                            oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md">
                                    <label>No. Lesen</label>
                                    <div class="mb-3 input-group">
                                        <input readonly
                                            class="form-control  @error('name') is-invalid @else border-dark @enderror"
                                            id="name" name="name" type="text" value="{{ $info->no_lesen }}"
                                            oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md">
                                    <label>Jantina</label>
                                    <div class="mb-3 input-group">
                                        <input readonly class="form-control border-dark" id="jantina" name="jantina"
                                            type="text" value="{{ $pengguna->jantina }}"
                                            oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                                    </div>
                                </div>

                                <div class="col-md-2"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md">
                                    <label>Warganegara</label>
                                    <div class="mb-3 input-group">
                                        <input readonly class="form-control border-dark" id="warganegara"
                                            name="warganegara" type="text" value="{{ $pengguna->warganegara }}"
                                            oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                                    </div>
                                </div>

                                <div class="col-md-2"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md">
                                    <label>Kaum</label>
                                    <div class="mb-3 input-group">
                                        <input readonly class="form-control border-dark" id="kaum" name="kaum"
                                            type="text" value="{{ $pengguna->kaum }}"
                                            oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                                    </div>
                                </div>

                                <div class="col-md-2"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md">
                                    <label>No. Kad Pengenalan</label>
                                    <div class="mb-3 input-group">
                                        <input readonly
                                            class="form-control  @error('ic_number') is-invalid @else border-dark @enderror"
                                            id="ic_number" name="ic_number" type="text"
                                            value="{{ $pengguna->no_kad_pengenalan }}"
                                            oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);"
                                            maxlength="12" onkeypress="return onlyNumberKey(event)">
                                        @error('ic_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md">
                                    <label>Emel</label>
                                    <div class="mb-3 input-group">
                                        <input class="form-control  @error('email') is-invalid @else border-dark @enderror"
                                            id="email" name="email" type="email"
                                            value="{{ $user->getCurrentEmail() }}" oninput="validateEmail(this)">
                                        <div id="email-validation-message" class="invalid-feedback"></div>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2"></div>
                            </div>

                            {{-- The user's own documents (IC front/back, passport photo). Each shows what was
                                 uploaded - an image preview, or a "Lihat PDF" button for a PDF - and its own
                                 optional PILIH FAIL to replace it. --}}
                            @php
                                $dokumenPengguna = [
                                    'gambar_ic_hadapan' => 'Gambar Hadapan Kad Pengenalan',
                                    'gambar_ic_belakang' => 'Gambar Belakang Kad Pengenalan',
                                    'gambar_passport' => 'Gambar Berukuran Passport',
                                ];
                            @endphp
                            <div class="row">
                                <div class="col-md-2"></div>
                                @foreach ($dokumenPengguna as $field => $label)
                                    <div class="col-md-{{ $loop->last ? '2' : '3' }} mb-3" style="{{ $loop->last ? 'flex:0 0 22%;max-width:22%;' : '' }}">
                                        <label class="font-weight-bold">{{ $label }}</label>
                                        @php $docPath = $pengguna->$field ?? null; @endphp
                                        @if ($docPath)
                                            @php
                                                $docUrl = asset(str_replace('public', 'storage', $docPath));
                                                $docExt = strtolower(pathinfo($docPath, PATHINFO_EXTENSION));
                                            @endphp
                                            @if ($docExt === 'pdf')
                                                <div class="mb-2"><a href="{{ $docUrl }}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="fas fa-file-pdf"></i> Lihat PDF</a></div>
                                            @else
                                                <img src="{{ $docUrl }}" alt="{{ $label }}" style="width:100%;height:25vh;object-fit:contain;" class="mb-1">
                                                <div class="mb-2"><a href="{{ $docUrl }}" target="_blank" class="btn btn-sm btn-outline-secondary">Lihat / Muat Turun</a></div>
                                            @endif
                                        @else
                                            <p class="text-muted mb-2">Tiada fail dimuat naik</p>
                                        @endif
                                        <small class="form-text mb-1"><i class="fas fa-camera"></i> JPG, PNG atau PDF. Maks: 8MB</small>
                                        <label for="{{ $field }}" class="form-control" style="cursor:pointer;" id="{{ $field }}_label">PILIH FAIL</label>
                                        <input type="file" id="{{ $field }}" name="{{ $field }}" accept="image/jpeg,image/jpg,image/png,application/pdf" style="display: none"
                                            onchange="document.getElementById('{{ $field }}_label').textContent = this.files.length ? this.files[0].name : 'PILIH FAIL';">
                                        @error($field)
                                            <div class="alert alert-danger mt-1 p-1"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md">
                                    <label>Jawatan</label>
                                    <div class="mb-3 input-group">
                                        <input class="form-control  @error('email') is-invalid @else border-dark @enderror"
                                            name="jawatan" value="{{ $pengguna->jawatan }}"
                                            oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">

                                    </div>
                                </div>

                                <div class="col-md-2"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md">
                                    <label>No. Pekerja</label>
                                    <div class="mb-3 input-group">
                                        <input class="form-control  @error('email') is-invalid @else border-dark @enderror"
                                            name="no_pekerja" value="{{ $pengguna->no_pekerja }}">

                                    </div>
                                </div>

                                <div class="col-md-2"></div>
                            </div>







                            {{-- <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md">
                      <label>Telefon Bimbit</label>
                      <div class="mb-3 input-group">
                        <div class="mb-3 input-group">
                            <input class="form-control  @error('mobile_phone') is-invalid @else border-dark @enderror" id="mobile_phone" name="no_telefon" type="text" value="{{ $info->no_telefon }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);" minlength="10" maxlength="11" onkeypress="return onlyNumberKey(event)">
                          @error('mobile_phone')
                          <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                    </div>
                    </div>

                    <div class="col-md-2"></div>
                  </div> --}}

                            {{-- Submit Button --}}
                            <div class="row" style="padding-top: 35px;">
                                <div class="col-md-4"></div>
                                <div class="col-md" style="text-align: center;">
                                    <button type="button" class="btn waves-effect waves-light btn-info btn-block"
                                        data-toggle="modal" data-target="#confirmation">Kemaskini Profil Pengguna</button>
                                </div>
                                <div class="col-md-4"></div>
                            </div>

                            {{-- Hidden Gap - Just Ignore --}}
                            <div class="alert alert-white" style="text-align: center;"></div>
                            {{-- <div style="padding: 25px;"></div> --}}
                        </div>

                        <!-- Modal Confirmation -->
                        <div class="modal fade" id="confirmation" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color:#f3ce8f  !important">
                                        <h5 class="modal-title" id="exampleModalLongTitle"><i
                                                class="fa fa-exclamation-triangle" aria-hidden="true"
                                                style="color:rgb(255, 255, 0)"></i>&nbspPENGESAHAN</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body"><b>
                                            Anda pasti mahu mengemaskini profil pengguna?</b>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-dismiss="modal">Kembal





                            {{-- <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md">
                      <label>Telefon Bimbit</label>
                      <div class="mb-3 input-group">
                        <div class="mb-3 input-group">
                            <input class="form-control  @error('mobile_phone') is-invalid @else border-dark @enderror" id="mobile_phone" name="no_telefon" type="text" value="{{ $info->no_telefon }}" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);" minlength="10" maxlength="11" onkeypress="return onlyNumberKey(event)">
                          @error('mobile_phone')
                          <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                    </div>
                    </div>

                    <div class="col-md-2"></div>
                  </div> --}}

                            {{-- Submit Button --}}
                            <div class="row" style="padding-top: 35px;">
                                <div class="col-md-4"></div>
                                <div class="col-md" style="text-align: center;">
                                    <button type="button" class="btn waves-effect waves-light btn-info btn-block"
                                        data-toggle="modal" data-target="#confirmation">Kemaskini Profil Pengguna</button>
                                </div>
                                <div class="col-md-4"></div>
                            </div>

                            {{-- Hidden Gap - Just Ignore --}}
                            <div class="alert alert-white" style="text-align: center;"></div>
                            {{-- <div style="padding: 25px;"></div> --}}
                        </div>

                        <!-- Modal Confirmation -->
                        <div class="modal fade" id="confirmation" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color:#f3ce8f  !important">
                                        <h5 class="modal-title" id="exampleModalLongTitle"><i
                                                class="fa fa-exclamation-triangle" aria-hidden="true"
                                                style="color:rgb(255, 255, 0)"></i>&nbspPENGESAHAN</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body"><b>
                                            Anda pasti mahu mengemaskini profil pengguna?</b>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-dismiss="modal">Kembali</button>
                                        <button type="submit" class="btn btn-success">Kemaskini Profil Pengguna</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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

        function validateEmail(input) {
            const email = input.value;
            const messageDiv = document.getElementById('email-validation-message');

            // Clear previous validation
            input.classList.remove('is-invalid', 'is-valid');
            messageDiv.textContent = '';

            if (!email) {
                return;
            }

            // Basic email format validation
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                input.classList.add('is-invalid');
                messageDiv.textContent = 'Format emel tidak sah.';
                return;
            }

            // Check email uniqueness via AJAX
            fetch('/email/check-unique', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        email: email
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.unique) {
                        input.classList.add('is-valid');
                        messageDiv.textContent = '';
                    } else {
                        input.classList.add('is-invalid');
                        messageDiv.textContent = 'Emel ini telah digunakan.';
                    }
                })
                .catch(error => {
                    console.error('Error checking email:', error);
                });
        }
    </script>
@endsection
