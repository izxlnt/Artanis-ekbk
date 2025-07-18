<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <title>Sistem eShuttle</title>
    <!-- Custom CSS -->
    <link href="{{ asset('nice-admin/dist/css/style.min.css') }}" rel="stylesheet">
    <!-- Toaster CSS -->
    <link href="{{ asset('nice-admin/assets/libs/toastr/build/toastr.min.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <style>
        .required:after {
            content: " *";
            color: red;
        }

    </style>
</head>

<body>
    <div class="main-wrapper" style="background:url({{ asset('/bghutan.png') }});background-size:cover;">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 p-1 text-center text-wrap p-lg-5 d-flex align-items-center"
                style="background-image: linear-gradient(to right top, #f3ce8f, #f5d296, #f7d79d, #f9dba5, #fbdfac, #fce2b2, #fde6b7, #fee9bd, #feecc3, #feefc8, #fff1ce, #fff4d4);">
                <div class="">
                    <div class="text w-200">
                        <span class="db"><img src="{{ asset('/jata.png') }}" style="width:30%"
                                alt="logo" /></span>
                        <span class="db"><img src="{{ asset('/logo.png') }}" style="width:30%"
                                alt="logo" /></span>

                        <h3 class="text-center">Sistem</h3>
                        <h1 class="text-center">eShuttle</h1>
                        <br>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="auth-wrapper d-flex no-block justify-content-center align-items-center">

                    <div class="row" style="width: 1000px;">
                        <div class="col-md-12">
                            {{-- @if ($errors->any())
                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                    @endif --}}
                            <div class="card" style="background: #d0edfdcc;">
                                <div class="card-header text-center bg-info" style="font-weight: bold;">Pendaftaran
                                    Pejabat Hutan
                                    Daerah (PHD)</div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md"></div>
                                        <div class="col-md-8">
                                            <div class="legend" style="border:2px solid; text-align:center;">

                                               <b> Medan-medan bertanda<span style="color:red"> <b> * </b></span>adalah wajib diisi</b>


                                            </div>
                                        </div>
                                        <div class="col-md"></div>

                                    </div>
                                    <br>

                                    <form action="{{ route('daftar.phd.create') }}">
                                        @csrf

                                        <input type="hidden" name="jenis_pengguna" value="PHD">
                                        <div class="form-group row">
                                            <label for="cono1"
                                                class="text-right col-sm-3 control-label col-form-label required">Negeri</label>
                                            <div class="col-md-9">
                                                <select class="form-control" id="negeri_id" name="negeri_id"
                                                    onchange="ajax_daerah(this)">
                                                    <option disabled selected hidden value="">Sila Pilih Negeri
                                                    </option>
                                                    @foreach (App\Models\Daerah::select('negeri','id')->distinct()->orderBy('negeri')->get()->unique('negeri') as $data)

                                                        <option value="{{ $data->id }}">{{ $data->negeri }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('negeri_id')
                                                    <div class="alert alert-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label for="fname"
                                                class="text-right col-sm-3 control-label col-form-label required">Daerah
                                                Hutan</label>
                                            <div class="col-md-9">
                                                <select class="form-control" id="daerah_id" name='daerah_id'
                                                    placeholder="Daerah">
                                                    <option value="" selected hidden disabled>Sila Pilih
                                                        Daerah Hutan</option>


                                                </select>
                                                @error('daerah_id')
                                                    <div class="alert alert-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group row">
                                            <label for="cono1"
                                                class="text-right col-sm-3 control-label col-form-label required">Nama
                                                Pengguna</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="Nama Pengguna" value="{{ old('name') }}">
                                                @error('name')
                                                    <div class="alert alert-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <label for="fname"
                                                class="text-right col-sm-3 control-label col-form-label required"> No.
                                                Kad
                                                Pengenalan</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="login_id"
                                                    name='login_id' placeholder="No. Kad Pengenalan (cth: 890123101234)"
                                                    maxlength="12" minlength="12"
                                                    onkeypress="return onlyNumberKey(event)"
                                                    oninput="validateMalaysianIC(this)"
                                                    value="{{ old('login_id') }}">
                                                <p>
                                                    <small>* Sila masukkan 12 digit nombor kad pengenalan tanpa ruang atau sengkang.</small>
                                                </p>
                                                <div id="ic-validation-message" style="color: red; font-size: 12px; margin-top: 5px;"></div>>
                                                @error('login_id')
                                                    <div class="alert alert-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>

                                </div>
                                <div class="form-group row">
                                    <label for="cono1"
                                        class="text-right col-sm-3 control-label col-form-label required">Jawatan</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name='jawatan'>
                                            <option value="" selected hidden disabled>Sila Pilih Jawatan</option>
                                            <option value="Pegawai Daerah Hutan" >Pegawai Hutan Daerah/Jajahan</option>
                                            <option value="Penolong Pegawai Daerah/Jajahan" >Penolong Pegawai Hutan Daerah/Jajahan</option>
                                        </select>

                                            @error('jawatan')
                                            <div class="alert alert-danger">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                        {{-- <div class="form-group row">
                                            <label for="cono1"
                                                class="text-right col-sm-3 control-label col-form-label required">Jawatan</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="jawatan" name='jawatan'
                                                    placeholder="Jawatan" value="{{ old('jawatan') }}">
                                                @error('jawatan')
                                                    <div class="alert alert-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>--}}

                                        </div>


                                        <div class="form-group row">
                                            <label for="cono1"
                                                class="text-right col-sm-3 control-label col-form-label required">Emel</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" id="email" name='email'
                                                    placeholder="Emel" value="{{ old('email') }}" 
                                                    oninput="validateEmail(this)">
                                                <div id="email-validation-message" class="invalid-feedback"></div>
                                                @error('email')
                                                    <div class="alert alert-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <label for="cono1"
                                                class="text-right col-sm-3 control-label col-form-label required">No.
                                                Telefon</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="no_telefon" maxlength="11"
                                                    name='no_telefon' placeholder="No. Telefon"
                                                    onkeypress="return onlyNumberKey(event)"
                                                    value="{{ old('no_telefon') }}">
                                                @error('no_telefon')
                                                    <div class="alert alert-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>

                                        </div>



                                        <br>
                                        <div class="row" style="padding-top: 15px;">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4"></div>
                                            <div class="col-md-2"></div>

                                            <div class="col-md-2" style="text-align:left !important;">
                                                <button class="btn btn-primary" type="button" data-toggle="modal"
                                                    data-target="#confirmation_daftar_phd_modal">HANTAR</button>
                                            </div>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="confirmation_daftar_phd_modal" tabindex="-1"
                                            role="dialog" aria-labelledby="confirmation_daftar_phd_modalTitle"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info">
                                                        <h5 class="modal-title " id="exampleModalLongTitle"><i
                                                            style="color:rgb(255, 255, 0)"
                                                            class="fas fa-exclamation-triangle"></i>&nbspPENDAFTARAN
                                                    </h5>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <span class="text-center"><b>Anda pasti maklumat ini
                                                            tepat?</span>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Kembali</button>
                                                        <button type="submit" class="btn btn-success">HANTAR</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="form-group row">
                                    <label for="lname"
                                        class="text-right col-sm-3 control-label col-form-label">Peranan</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name='peranan'>
                                            <option disabled selected hidden value="">Pilih Peranan</option>
                                            <option>Pentadbir Modul</option>
                                            <option>Pengguna Biasa</option>
                                        </select>
                                    </div>
                                </div> --}}

                                        {{-- <div class="form-group row">
                                    <label for="lname" class="text-right col-sm-3 control-label col-form-label">Kategori
                                        Pengguna</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name='kategori_pengguna'>
                                            <option disabled selected hidden value="">Pilih Kategori Pengguna</option>
                                            <option>BPM</option>
                                            <option>IPJPSM</option>
                                            <option>PHD</option>
                                            <option>JPN</option>
                                        </select>
                                    </div>
                                </div> --}}

                                        {{-- <div class="form-group row">
                                        <label for="email1" class="text-right col-sm-3 control-label col-form-label">Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name='status'>
                                                <option disabled  selected hidden value="">Pilih Status</option>
                                                <option value ='1'>Aktif</option>
                                                <option value ='0'>Tak Aktif</option>
                                            </select>
                                        </div>
                                    </div> --}}







                                        {{-- <br>
                                <div class="form-group row">
                                    <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Bahagian
                                        (Sekiranya
                                        IPJPSM)</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name='bahagian'>
                                            <option disabled selected hidden value="">Pilih bahagian</option>
                                            <option>Bahagian Forest Eco-Park &amp; Hutan Taman Negeri</option>
                                            <option>Bahagian Hal Ehwal Antarabangsa</option>
                                            <option>Bahagian Kejuruteraan Hutan</option>
                                            <option>Bahagian Khidmat Pengurusan</option>
                                            <option>Bahagian Ladang Hutan &amp; Perlindungan Hutan</option>
                                            <option>Bahagian Latihan Perhutanan</option>
                                            <option>Bahagian Penguatkuasaan Hutan</option>
                                            <option>Bahagian Pengurusan Hutan</option>
                                            <option>Bahagian Pengurusan Maklumat</option>
                                            <option>Bahagian Perancangan &amp; Ekonomi Hutan</option>
                                            <option>Bahagian Perundangan dan Pendakwaan</option>
                                            <option>Bahagian Silvikultur &amp; Pemeliharaan Biologi Hutan</option>
                                            <option>Bahagian Teknikal dan Industri Kayu</option>
                                            <option>Jabatan Perhutanan Negeri</option>
                                            <option>Unit Integriti Perhutanan</option>
                                            <option>Unit Komunikasi Korporat &amp; Perhubungan Awam</option>
                                        </select>
                                    </div>
                                </div> --}}




                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="{{ asset('nice-admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>

    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('nice-admin/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>


    <script src="{{ asset('nice-admin/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();
        // ==============================================================
        // Login and Recover Password
        // ==============================================================
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
    </script>

    {{-- toaster --}}
    <script src="{{ asset('nice-admin/assets/libs/toastr/build/toastr.min.js') }}"></script>
    <script src="{{ asset('nice-admin/assets/extra-libs/toastr/toastr-init.js') }}"></script>

    {{-- toaster display --}}
    <script>
        @if (Session::get('success'))
            toastr.success('{{ session('success') }}', 'Berjaya', { "progressBar": true });
        @elseif ($message = Session::get('error'))
            toastr.error('{{ session('error') }}', 'Ralat', { "progressBar": true });
        @endif
    </script>

    <script>
        function onlyNumberKey(evt) {

            // Only ASCII charactar in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }

        function validateMalaysianIC(input) {
            const ic = input.value.replace(/[\s-]/g, ''); // Remove spaces and dashes
            const messageDiv = document.getElementById('ic-validation-message');
            
            // Clear previous validation styling
            input.classList.remove('is-invalid', 'is-valid');
            
            if (ic.length === 0) {
                messageDiv.textContent = '';
                return;
            }
            
            // Check if IC is exactly 12 digits
            if (!/^\d{12}$/.test(ic)) {
                input.classList.add('is-invalid');
                messageDiv.textContent = 'Nombor kad pengenalan mesti 12 digit.';
                return;
            }
            
            // Extract parts
            const year = ic.substr(0, 2);
            const month = ic.substr(2, 2);
            const day = ic.substr(4, 2);
            const birthPlace = ic.substr(6, 2);
            
            // Validate date
            if (!isValidDate(year, month, day)) {
                input.classList.add('is-invalid');
                messageDiv.textContent = 'Tarikh lahir dalam kad pengenalan tidak sah.';
                return;
            }
            
            // Validate birth place
            if (!isValidBirthPlace(birthPlace)) {
                input.classList.add('is-invalid');
                messageDiv.textContent = 'Kod negeri dalam kad pengenalan tidak sah.';
                return;
            }
            
            // Validate check digit - Skip for now as different algorithms exist
            // if (!isValidCheckDigit(ic)) {
            //     input.classList.add('is-invalid');
            //     messageDiv.textContent = 'Nombor kad pengenalan tidak sah (digit semak salah).';
            //     return;
            // }
            
            // If all validations pass
            input.classList.add('is-valid');
            messageDiv.textContent = '';
        }
        
        function isValidDate(year, month, day) {
            const currentYear = new Date().getFullYear();
            const currentCentury = Math.floor(currentYear / 100) * 100;
            let fullYear = currentCentury + parseInt(year);
            
            // If the year is greater than current year, it's from previous century
            if (fullYear > currentYear) {
                fullYear -= 100;
            }
            
            const date = new Date(fullYear, parseInt(month) - 1, parseInt(day));
            return date.getFullYear() === fullYear && 
                   date.getMonth() === parseInt(month) - 1 && 
                   date.getDate() === parseInt(day);
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
        
        function isValidCheckDigit(ic) {
            const weights = [2, 1, 2, 1, 2, 1, 2, 1, 2, 1, 2];
            let sum = 0;
            
            for (let i = 0; i < 11; i++) {
                const digit = parseInt(ic[i]);
                const product = digit * weights[i];
                sum += (product > 9) ? (product - 9) : product;
            }
            
            const remainder = sum % 10;
            const checkDigit = (remainder === 0) ? 0 : (10 - remainder);
            
            return checkDigit === parseInt(ic[11]);
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
    </script>

<script>
    function ajax_daerah(select) {
        negeri = select.value;
        console.log(negeri);

        //clear jenis_data selection
        $("#daerah_id").empty();
        //initialize selection
        $("#daerah_id").append('<option value="" selected disabled hidden>Sila Pilih Daerah</option>');

        $.ajax({
            type: "get",
            url: "/register/ajax/fetch-daerah/" + negeri, //penting
            success: function(respond) {
                Object.entries(respond).forEach(([key, val]) => {
                    $("#daerah_id").append('<option value="' + val.id + '">' +
                        val.daerah_hutan + '</option>');
                });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown);
            }
        });
    }
</script>
</body>

</html>
