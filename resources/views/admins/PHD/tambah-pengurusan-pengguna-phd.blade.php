@extends('layouts.layout-phd-nicepage')


@section('content')

    <div>
        <div class="card-header"
            style="text-align:center; background-color: #e9cac2 !important; font-size: 130%; font-weight: bold;">
            Tambah Pengguna Modul
        </div>

        <form action="{{ route('phd.tambah-pengurusan-pengguna.store') }}" class="validation-wizard wizard-circle m-t-40"
            method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <h4 class="card-title">Maklumat Pengguna</h4>
                <hr>

                <div class="form-group row">
                    <label for="fname" class="text-right col-sm-3 control-label col-form-label">No. Kad Pengenalan
                        (pengguna)</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="kad_pengenalan" name='kad_pengenalan' placeholder="No. Kad Pengenalan"
                               maxlength="12" onkeypress="return onlyNumberKey(event)" 
                               oninput="validateMalaysianIC(this)">
                        <div id="ic-validation-message" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lname" class="text-right col-sm-3 control-label col-form-label">Peranan</label>
                    <div class="col-sm-9">
                        <select class="form-control" name='peranan'>
                            <option disabled selected hidden value="">Pilih Peranan</option>
                            <option>Pentadbir Modul</option>
                            <option>Pengguna Biasa</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email1" class="text-right col-sm-3 control-label col-form-label">Status</label>
                    <div class="col-sm-9">
                        <select class="form-control" name='status'>
                            <option disabled selected hidden value="">Pilih Status</option>
                            <option value='1'>Aktif</option>
                            <option value='0'>Tak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Nama Penuh</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="cono1" name='name' placeholder="Nama Penuh">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Gelaran Jawatan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="cono1" name='jawatan' placeholder="Gelaran Jawatan">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Negeri</label>
                    <div class="col-sm-9">
                        <select class="form-control" name='negeri'>
                            <option disabled selected hidden value="">Pilih Negeri</option>
                            <option>Johor</option>
                            <option>Kedah</option>
                            <option>Kelantan</option>
                            <option>Melaka</option>
                            <option>Negeri Sembilan</option>
                            <option>Pahang</option>
                            <option>Perak</option>
                            <option>Perlis</option>
                            <option>Pulau Pinang</option>
                            <option>Selangor</option>
                            <option>Terengganu</option>
                            <option>Wilayah Persekutuan Kuala Lumpur</option>
                        </select>
                    </div>
                </div>
                {{-- <div class="form-group row">
                    <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Bahagian (Sekiranya
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
                <div class="form-group row">
                    <label for="cono1" class="text-right col-sm-3 control-label col-form-label">No. Telefon</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="cono1" name='no_telefon' placeholder="No. Telefon">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" name='email' placeholder="Email"
                               oninput="validateEmail(this)">
                        <div id="email-validation-message" class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="card-body">
                <div class="text-right form-group m-b-0">
                    <button type="button" class="btn btn-dark waves-effect waves-light">Batal</button>
                    <button type="submit" class="btn btn-info waves-effect waves-light">Tambah</button>
                </div>
            </div>
        </form>

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
