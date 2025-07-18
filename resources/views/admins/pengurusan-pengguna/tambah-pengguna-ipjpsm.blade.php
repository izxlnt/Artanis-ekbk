@extends($layout)



@section('content')
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



    <div>
        <div class="card-header"
            style="text-align:center; background-color: #e9cac2 !important; font-size: 130%; font-weight: bold;">
            Tambah Pengguna Modul
        </div>

        <form action="{{ route('tambah-pengurusan-pengguna.store') }}" style="background-color:white"
            class="validation-wizard wizard-circle m-t-40" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">

                <h4 class="card-title" style="text-align: center">Maklumat Pengguna</h4>
                <hr>

                <div class="form-group row">
                    <label for="fname" class="text-right col-sm-3 control-label col-form-label">No. Kad Pengenalan
                        (pengguna)</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="kad_pengenalan" name='kad_pengenalan' placeholder="No. Kad Pengenalan"
                            maxlength="12" onkeypress="return isNumberKey(event)" value="{{ old('kad_pengenalan') }}"
                            oninput="validateMalaysianIC(this)">
                        <div id="ic-validation-message" class="invalid-feedback"></div>
                        @error('kad_pengenalan')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- <div class="form-group row">
                    <label for="lname" class="text-right col-sm-3 control-label col-form-label">Peranan</label>
                    <div class="col-sm-9">
                        <select class="form-control" name='peranan'>
                            <option disabled selected hidden value="">Pilih Peranan</option>
                            <option>Pentadbir Modul</option>
                            <option>Pengguna Biasa</option>
                        </select>
                    </div>
                </div> --}}
                @if (auth()->user()->kategori_pengguna == 'BPE')
                    <div class="form-group row">
                        <label for="lname" class="text-right col-sm-3 control-label col-form-label">Kategori
                            Pengguna</label>
                        <div class="col-sm-9">
                            <select class="form-control" name='kategori_pengguna' id="kategori" onchange="showkategori()">
                                <option disabled selected hidden value="">Pilih Kategori Pengguna</option>
                                <option value="BPE">Ibu Pejabat Jabatan Perhutanan Semenanjung Malaysia (IPJPSM)</option>
                                <option value="JPN">Jabatan Perhutanan Negeri (JPN)</option>
                                <option value="PHD">Pejabat Hutan Daerah (PHD)</option>
                            </select>
                            @error('kategori_pengguna')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @elseif(auth()->user()->kategori_pengguna == 'BPM')
                    <div class="form-group row">
                        <label for="lname" class="text-right col-sm-3 control-label col-form-label">Kategori
                            Pengguna</label>
                        <div class="col-sm-9">
                            <select class="form-control" name='kategori_pengguna' id="kategori" onchange="showkategori()">
                                <option disabled selected hidden value="">Pilih Kategori Pengguna</option>
                                <option value="BPM">Bahagian Pengurusan Maklumat (BPM)</option>
                                <option value="BPE">Ibu Pejabat Jabatan Perhutanan Semenanjung Malaysia (IPJPSM)</option>
                                <option value="JPN">Jabatan Perhutanan Negeri (JPN)</option>
                                <option value="PHD">Pejabat Hutan Daerah (PHD)</option>
                            </select>
                            @error('kategori_pengguna')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endif


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
                <div class="form-group row">
                    <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Nama Penuh</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name='name' placeholder="Nama Penuh" value="{{ old('name') }}">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Gelaran Jawatan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="cono1" name='jawatan' placeholder="Gelaran Jawatan" value="{{ old('jawatan') }}">
                        @error('jawatan')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div id="negeri_container" style="display: none;">
                    <div class="form-group row">
                        <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Negeri</label>
                        <div class="col-md-9">
                            <select class="form-control" id="negeri_id" name="negeri_id" onchange="ajax_daerah(this)">
                                <option disabled selected hidden value="">Pilih Negeri
                                </option>
                                @foreach (App\Models\Daerah::select('negeri', 'id')->distinct()->orderBy('negeri')->get()->unique('negeri')
        as $data)
                                    <option value="{{ $data->id }}">
                                        {{ $data->negeri }}
                                    </option>
                                @endforeach
                            </select>
                            @error('negeri_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>

                <div id="daerah_container" style="display: none;">
                    <div class="form-group row">
                        <label for="fname" class="text-right col-sm-3 control-label col-form-label">Daerah Hutan</label>
                        <div class="col-md-9">
                            <select class="form-control" id="daerah_id" name='daerah_id' placeholder="Daerah">
                                <option value="" selected hidden disabled>Sila Pilih
                                    Daerah Hutan</option>


                            </select>
                            @error('daerah_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div id="ipjpsm_container" style="display: none;">
                    <div class="form-group row">
                        <label for="cono1" class="text-right col-sm-3 control-label col-form-label">Bahagian</label>
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
                            @error('bahagian')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cono1" class="text-right col-sm-3 control-label col-form-label">No. Telefon</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="cono1" name='no_telefon' placeholder="No. Telefon"
                            maxlength="11" onkeypress="return isNumberKey(event)" value="{{ old('no_telefon') }}">
                        @error('no_telefon')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cono1" class="text-right col-sm-3 control-label col-form-label required">Emel</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" name='email' placeholder="Emel"
                            title="Sila isikan butiran ini." value="{{ old('email') }}"
                            oninput="validateEmail(this)">
                        <div id="email-validation-message" class="invalid-feedback"></div>
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <hr>

            <div class="card-body">
                <div class="text-right form-group m-b-0">
                    {{-- <button type="submit" class="btn btn-primary">Tiada Pengeluaran</button> --}}

                    <a href="{{ route('home') }}" class="btn btn-primary">Kembali</a>

                    <button type="button" class="btn btn-primary" alt="default" data-toggle="modal"
                        data-target="#confirmation_borang_a">
                        HANTAR</button>
                </div>
            </div>


            <div class="modal fade" id="confirmation_borang_a" tabindex="-1" role="dialog"
                aria-labelledby="confirmation_borang_aTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#f3ce8f  !important">
                            <h5 class="modal-title " id="exampleModalLongTitle"><i style="color:rgb(255, 255, 0)"
                                    class="fas fa-exclamation-triangle"></i>&nbspPENGESAHAN
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <span class="text-center"><b>Adakah anda pasti ingin menambah pengguna ini?</b></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">HANTAR</button>
                        </div>
                    </div>
                </div>
            </div>


        </form>

    </div>


    <script>
        function showkategori() {
            var kategori = $('#kategori').val();

            console.log(kategori);
            if (kategori == "BPE") {
                document.getElementById('ipjpsm_container').style.display = "block";
            } else {
                document.getElementById('ipjpsm_container').style.display = "none";
            }

            if (kategori == "PHD" || kategori == "JPN") {
                document.getElementById('negeri_container').style.display = "block";
            } else {
                document.getElementById('negeri_container').style.display = "none";
            }

            if (kategori == "PHD") {
                document.getElementById('daerah_container').style.display = "block";
            } else {
                document.getElementById('daerah_container').style.display = "none";
            }


        }
    </script>

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
