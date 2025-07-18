@extends('layouts.layout-ibk-nicepage')
@section('content')


    <div class="container-fluid">

        <div class="row">
            <div class="col-12">

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

                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center card-title">PENDAFTARAN PENGGUNA KILANG KEDUA</h4>

                        <form action="{{ route('home-user.user-management.create') }}" method="post"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="row">
                                <label for="fname" class="text-right col-sm-3 control-label col-form-label required">Nama
                                    Pengguna</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name='name' placeholder="Nama Pengguna"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <div class="alert alert-danger">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row" style="padding-top: 5px;">
                                <label for="fname"
                                    class="text-right col-sm-3 control-label col-form-label required">Jantina</label>
                                <div class="col-md-6">
                                    <select class="form-control @error('jantina') is-invalid @enderror" id="jantina"
                                        name="jantina" value="{{ old('jantina') }}">
                                        <option selected disabled hidden>Sila Pilih Jantina</option>
                                        <option value="Lelaki" {{ old('jantina') == 'Lelaki' ? 'selected' : '' }}>Lelaki
                                        </option>
                                        <option value="Perempuan" {{ old('jantina') == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                    </select>
                                    @error('jantina')
                                        <div class="alert alert-danger">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row" style="padding-top: 5px;">
                                <label for="fname"
                                    class="text-right col-sm-3 control-label col-form-label required">Warganegara</label>
                                <div class="col-md-6">
                                    <select class="form-control @error('warganegara') is-invalid @enderror" id="warganegara"
                                        name="warganegara" value="{{ old('warganegara') }}">
                                        <option selected disabled hidden>Sila Pilih Warganegara</option>
                                        <option value="Bumiputera"
                                            {{ old('warganegara') == 'Bumiputera' ? 'selected' : '' }}>
                                            Bumiputera
                                        </option>
                                        <option value="Bukan Bumiputera"
                                            {{ old('warganegara') == 'Bukan Bumiputera' ? 'selected' : '' }}>
                                            Bukan Bumiputera
                                        </option>
                                        <option value="Bukan Warganegara"
                                            {{ old('warganegara') == 'Bukan Warganegara' ? 'selected' : '' }}>
                                            Bukan Warganegara
                                        </option>
                                    </select>
                                    @error('warganegara')
                                        <div class="alert alert-danger">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row" style="padding-top: 5px;">
                                <label for="fname"
                                    class="text-right col-sm-3 control-label col-form-label required">Kaum</label>
                                <div class="col-md-6">
                                    <select class="form-control @error('kaum') is-invalid @enderror" id="kaum" name="kaum"
                                        value="{{ old('kaum') }}">
                                        <option selected disabled hidden>Sila Pilih Kaum</option>
                                        <option value="Melayu" {{ old('kaum') == 'Melayu' ? 'selected' : '' }}>Melayu
                                        </option>
                                        <option value="Cina" {{ old('kaum') == 'Cina' ? 'selected' : '' }}>
                                            Cina
                                        </option>
                                        <option value="India" {{ old('kaum') == 'India' ? 'selected' : '' }}>
                                            India
                                        </option>
                                        <option value="Lain-lain" {{ old('kaum') == 'Lain-lain' ? 'selected' : '' }}>
                                            Lain-lain
                                        </option>
                                    </select>
                                    @error('kaum')
                                        <div class="alert alert-danger">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row" style="padding-top: 5px;">
                                <label for="fname"
                                    class="text-right col-sm-3 control-label col-form-label required">Emel</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" id="email" name='email' placeholder="Emel"
                                        value="{{ old('email') }}" oninput="validateEmail(this)">
                                    <div id="email-validation-message" class="invalid-feedback"></div>
                                    @error('email')
                                        <div class="alert alert-danger">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row" style="padding-top: 5px;">
                                <label for="fname" class="text-right col-sm-3 control-label col-form-label required">No. Kad
                                    Pengenalan</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="no_kad_pengenalan" name='no_kad_pengenalan'
                                        placeholder="No. Kad Pengenalan" maxlength="12" minlength="12"
                                        value="{{ old('no_kad_pengenalan') }}" onkeypress="return onlyNumberKey(event)"
                                        oninput="validateMalaysianIC(this)">
                                    <div id="ic-validation-message" class="invalid-feedback"></div>
                                    @error('no_kad_pengenalan')
                                        <div class="alert alert-danger">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="gambar_ic_hadapan" class="required">Muat Naik Gambar Hadapan<br>
                                            Kad
                                            Pengenalan</label>
                                        <label for="icfront" class="form-control">PILIH FAIL</label>
                                        <input type="file" id="icfront" name="gambar_ic_hadapan" accept="*"
                                            style="display: none">

                                        {{-- <input type="file" class="form-control"
                                            name="gambar_ic_hadapan" id="icfront"> --}}
                                        @error('gambar_ic_hadapan')
                                            <div class="alert alert-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="gambar_ic_belakang" class="required">Muat Naik Gambar
                                            Belakang <br> Kad
                                            Pengenalan</label>

                                        <label for="icback" class="form-control">PILIH FAIL</label>
                                        <input type="file" id="icback" name="gambar_ic_belakang" accept="*"
                                            style="display: none">
                                        {{-- <input type="file" class="form-control"
                                            name="gambar_ic_belakang" id="icback"> --}}
                                        @error('gambar_ic_belakang')
                                            <div class="alert alert-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="gambar_passport" class="required">Muat Naik Gambar<br>
                                            Berukuran Passport</label>

                                        <label for="passport" class="form-control">PILIH FAIL</label>
                                        <input type="file" id="passport" name="gambar_passport" accept="*"
                                            style="display: none">
                                        {{-- <input type="file" class="form-control"
                                            name="gambar_passport" id="passport"> --}}
                                        @error('gambar_passport')
                                            <div class="alert alert-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-2">
                                    <p>Gambar Dimuat Naik:</p>
                                    <img src="" alt="Sila Muatnaik Gambar Hadapan Kad Pengenalan"
                                        id="category-img-tag-icfront" style="width:100%;height:30vh;display: none;">
                                </div>
                                <div class="col-md-2">
                                    <p>Gambar Dimuat Naik:</p>
                                    <img src="" alt="Sila Muatnaik Gambar Belakang Kad Pengenalan"
                                        id="category-img-tag-icback" style="width:100%;height:30vh;display: none;">
                                </div>
                                <div class="col-md-2">
                                    <p>Gambar Dimuat Naik:</p>
                                    <img src="" alt="Sila Muatnaik Gambar Berukuran Passport" id="category-img-tag-passport"
                                        style="width:100%;height:30vh;display: none;">
                                </div>
                            </div>

                            <hr>

                            <div class="row" style="padding-top: 5px;">
                                <label for="fname"
                                    class="text-right col-sm-3 control-label col-form-label required">Jawatan</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name='jawatan' placeholder="Jawatan"
                                        value="{{ old('jawatan') }}">
                                    @error('jawatan')
                                        <div class="alert alert-danger">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row" style="padding-top: 5px;">
                                <label for="fname" class="text-right col-sm-3 control-label col-form-label">No.
                                    Pekerja</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name='no_pekerja' placeholder="No. Pekerja"
                                        value="{{ old('no_pekerja') }}">
                                    @error('no_pekerja')
                                        <div class="alert alert-danger">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row" style="padding-top: 5px;">
                                <label for="fname" class="text-right col-sm-3 control-label col-form-label">Muat
                                    Naik
                                    Gambar Kad Pekerja</label>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kad_pekerja" class="form-control">PILIH FAIL</label>
                                        <input type="file" id="kad_pekerja" name="gambar_kad_pekerja" accept="*"
                                            style="display: none">
                                    </div>
                                    @error('gambar_kad_pekerja')
                                        <div class="alert alert-danger">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <p>Gambar Dimuat Naik:</p>
                                    <img src="" alt="Sila Muatnaik Gambar Kad Pekerja" id="category-img-tag-kad_pekerja"
                                        style="width:100%;height:30vh;display: none;">
                                </div>

                            </div>

                            <br><br>

                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <button type="button"
                                        class="btn waves-effect waves-light btn-primary btn-block" data-toggle="modal" data-target="#confirmation_borang_a">HANTAR</button>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="modal fade" id="confirmation_borang_a" tabindex="-1" role="dialog"
                                aria-labelledby="confirmation_borang_aTitle" aria-hidden="true">
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
                                            <span class="text-center"><b>Adakah anda pasti ingin menambah pengguna
                                                ini?</span>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Tambah</button>
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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

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
            $('#example').DataTable({
                // dom: 'Bfrtip',
                // buttons: [
                //     // 'copyHtml5',
                //     'excelHtml5',
                //     'csvHtml5',
                //     'pdfHtml5'
                // ]
            });
        });
    </script>

    <script>
        $("#icfront").change(function() {
            // readURL(this);
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#category-img-tag-icfront').attr('src', e.target.result);
                    $('#category-img-tag-icfront').css("display", "block");
                }

                reader.readAsDataURL(this.files[0]);
            }


        });

        $("#icback").change(function() {
            // readURL(this);
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#category-img-tag-icback').attr('src', e.target.result);
                    $('#category-img-tag-icback').css("display", "block");
                }

                reader.readAsDataURL(this.files[0]);
            }


        });

        $("#passport").change(function() {
            // readURL(this);
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#category-img-tag-passport').attr('src', e.target.result);
                    $('#category-img-tag-passport').css("display", "block");
                }

                reader.readAsDataURL(this.files[0]);
            }


        });

        $("#kad_pekerja").change(function() {
            // readURL(this);
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#category-img-tag-kad_pekerja').attr('src', e.target.result);
                    $('#category-img-tag-kad_pekerja').css("display", "block");
                }

                reader.readAsDataURL(this.files[0]);
            }


        });
        
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
                body: JSON.stringify({ email: email })
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
        
        function validateMalaysianIC(input) {
            const ic = input.value;
            const messageDiv = document.getElementById('ic-validation-message');
            
            // Clear previous validation
            input.classList.remove('is-invalid', 'is-valid');
            messageDiv.textContent = '';
            
            if (!ic) {
                return;
            }
            
            // Check format - must be 12 digits
            if (!/^\d{12}$/.test(ic)) {
                input.classList.add('is-invalid');
                messageDiv.textContent = 'Nombor kad pengenalan mesti 12 digit.';
                return;
            }
            
            // Validate date
            const year = parseInt(ic.substring(0, 2));
            const month = parseInt(ic.substring(2, 4));
            const day = parseInt(ic.substring(4, 6));
            
            // Convert 2-digit year to 4-digit year
            const currentYear = new Date().getFullYear();
            const currentCentury = Math.floor(currentYear / 100) * 100;
            const cutoffYear = currentYear - currentCentury + 10;
            
            let fullYear;
            if (year <= cutoffYear) {
                fullYear = currentCentury + year;
            } else {
                fullYear = currentCentury - 100 + year;
            }
            
            if (month < 1 || month > 12) {
                input.classList.add('is-invalid');
                messageDiv.textContent = 'Bulan tidak sah dalam nombor kad pengenalan.';
                return;
            }
            
            if (day < 1 || day > 31) {
                input.classList.add('is-invalid');
                messageDiv.textContent = 'Hari tidak sah dalam nombor kad pengenalan.';
                return;
            }
            
            // Check if date is valid
            const testDate = new Date(fullYear, month - 1, day);
            if (testDate.getFullYear() !== fullYear || 
                testDate.getMonth() !== month - 1 || 
                testDate.getDate() !== day) {
                input.classList.add('is-invalid');
                messageDiv.textContent = 'Tarikh tidak sah dalam nombor kad pengenalan.';
                return;
            }
            
            // Validate birth place code
            const birthPlace = ic.substring(6, 8);
            if (!isValidBirthPlace(birthPlace)) {
                input.classList.add('is-invalid');
                messageDiv.textContent = 'Kod tempat lahir tidak sah dalam nombor kad pengenalan.';
                return;
            }
            
            // If all validations pass
            input.classList.add('is-valid');
            messageDiv.textContent = '';
        }
        
        function isValidBirthPlace(birthPlace) {
            const validCodes = [
                '01', '02', '03', '04', '05', '06', '07', '08', '09', '10',
                '11', '12', '13', '14', '15', '16', '21', '22', '23', '24',
                '25', '26', '27', '28', '29', '30', '31', '32', '33', '34',
                '35', '36', '37', '38', '39', '40', '41', '42', '43', '44',
                '45', '46', '47', '48', '49', '50', '51', '52', '53', '54',
                '55', '56', '57', '58', '59', '82', '83'
            ];
            return validCodes.includes(birthPlace);
        }
    </script>
@endsection
