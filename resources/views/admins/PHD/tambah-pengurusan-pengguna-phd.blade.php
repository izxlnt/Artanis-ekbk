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
                        <input type="text" class="form-control" name='kad_pengenalan' placeholder="No. Kad Pengenalan">
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
                        <input type="text" class="form-control" id="cono1" name='email' placeholder="Email">
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
    </script>

@endsection
