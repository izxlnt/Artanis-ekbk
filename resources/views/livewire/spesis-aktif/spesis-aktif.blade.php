<div>

    <link href="{{ asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css') }}" rel="stylesheet" />


    <script src="{{ asset('https://code.jquery.com/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js') }}"></script>

    <script class="">
        $(document).ready(function() {
            @foreach ($kumpulan_kayu as $data)
            $('#example{{ $data->id }}').DataTable({
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
            @endforeach
        });
    </script>
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid" style="width:100%">

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="card-header"
                            style="text-align:center; background-color: #a0e4ff !important; font-size: 130%; font-weight: bold;">
                            KEMASKINI SENARAI SPESIES AKTIF
                        </div>
                        <br>
                        {{-- <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist">
                                @foreach ($kumpulan_kayu as $data)
                                  <li role="presentation" class="{{ $data->id == 1 ? 'active' : '' }}">
                                    <a href="#home{{ $data->id }}" aria-controls="home" role="tab" data-toggle="tab">{{ $data->keterangan }}</a>
                                  </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                             @foreach ($kumpulan_kayu as $data)
                                  <div role="tabpanel" class="tab-pane {{ $data->id == 1 ? 'active' : '' }}" id="home{{ $data->id }}" class="active">
                                    <ul>
                                      @foreach ($spesis as $element)
                                         <li>{{ $element->keterangan}}</li>
                                      @endforeach
                                    </ul>
                                  </div>
                             @endforeach
                            </div>
                          </div> --}}

                        {{-- <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist" style="font-size:12px">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="berat-tab" data-toggle="tab" href="#berat"
                                            role="tab" aria-controls="berat" aria-selected="true">Kayu Keras Berat (KKB
                                            / HHW)</a>
                                    </li>
                                    <li class="nav-item">
                                                <a class="nav-link " id="sederhana-tab" data-toggle="tab" href="#sederhana" role="tab" aria-controls="sederhana" aria-selected="false">Kayu Keras Sederhana (KKS / MHW)</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " id="ringan-tab" data-toggle="tab" href="#ringan" role="tab" aria-controls="ringan" aria-selected="false">Kayu Keras Ringan (KKR / LHW)</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " id="lembut-tab" data-toggle="tab" href="#lembut" role="tab" aria-controls="lembut" aria-selected="false">Kayu Lembut (Kayu Lembut / Softwood)</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " id="lain_lain-tab" data-toggle="tab" href="#lain_lain" role="tab" aria-controls="lain_lain" aria-selected="false">Lain-lain (Lain-lain)</a>
                                            </li>

                                </ul>
                            </div>
                        </div> --}}

                          <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist" style="font-size:12px">
                                    @foreach ($kumpulan_kayu as $data)
                                    <li class="nav-item">
                                        <a class="nav-link" href="#home{{ $data->id }}" aria-controls="home" aria-selected="false" role="tab" data-toggle="tab">{{ $data->keterangan }}</a>
                                            </li>
                                            @endforeach
                                </ul>
                            </div>
                        </div>


                        <div class="tab-content">
                                 {{-- <div class="tab-pane active" role="tabpanel" class="tab-pane {{ $data->id == 1 ? 'active' : '' }}" id="home{{ $data->id }}" class="active">
                                   <ul>
                                     @foreach ($spesis as $element)
                                        <li>{{ $element->keterangan}}</li>
                                     @endforeach
                                   </ul>
                                 </div>
                           </div> --}}

                           @foreach ($kumpulan_kayu as $data)
                           <div class="tab-pane {{ $data->id == 1 ? 'active' : '' }}" id="home{{ $data->id }}" role="tabpanel" aria-labelledby="berat-tab"><br>
                            <div class="">
                                <table id="example{{ $data->id }}" class="display" style="width:100%;text-align:center">
                                    <thead>
                                        <tr>
                                            <th>Spesis ID</th>
                                            <th style="text-align:center">Nama Tempatan</th>
                                            <th style="text-align:center">Nama Saintifik</th>
                                            <th style="text-align:center;">Kod</th>
                                            <th style="text-align:center;">Aktif</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($spesis as $data2)
                                        @if($data2->kumpulan_kayu_id == $data->id )
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td style="text-align:left;">{{ $data2->nama_tempatan }}</td>
                                            <td style="text-align:left;">{{ $data2->nama_saintifik }}</td>
                                            <td>{{ $data2->kod }}</td>
                                            <td>
                                                <div style="text-align:center">
                                                    <input type="checkbox" id="vehicle1" name="aktif" {{ $data2->aktif == 1 ? 'checked' : '' }} wire:click='updateActive({{ $data2->id }})'>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        @empty

                                        @endforelse


                                    </tbody>
                                </table>
                                <br>
                                <a href="{{ route('home') }}" class="btn btn-primary" >Kembali</a>
                                {{-- <a class="btn btn-primary" href=""> Tambah </a> --}}
                            </div>
                        </div>
                        @endforeach

                        {{-- <div class="tab-content">
                            <div class="tab-pane active" id="berat" role="tabpanel" aria-labelledby="berat-tab"><br>
                                <div class="">
                                    <table id="example" class="display" style="width:100%;text-align:center">
                                        <thead>
                                            <tr>
                                                <th>Bil.</th>
                                                <th style="text-align:center">Nama Tempatan</th>
                                                <th style="text-align:center">Nama Saintifik</th>
                                                <th style="text-align:center;">Kod</th>
                                                <th style="text-align:center;">Aktif</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($list as $data)
                                            <tr>
                                                <td>{{ $data->id }}</td>
                                                <td>{{ $data->nama_tempatan }}</td>
                                                <td>{{ $data->nama_saintifik }}</td>
                                                <td>{{ $data->kod }}</td>
                                                <td>
                                                    <div style="text-align:center">
                                                        <input type="checkbox" id="vehicle1" name="aktif" {{ $data->aktif == 1 ? 'checked' : '' }} wire:click='updateActive({{ $data->id }})'>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty

                                            @endforelse


                                        </tbody>
                                    </table>
                                    <br>
                                    <a class="btn btn-primary" href=""> Tambah </a>
                                </div>
                            </div>

                            <div class="tab-pane" id="sederhana" role="tabpanel" aria-labelledby="sederhana-tab"><br>
                                    <div class="">
                                        <table id="example1" class="display" style="width:100%;text-align:center">
                                            <thead>
                                                <tr>
                                                    <th>Bil.</th>
                                                    <th style="text-align:center">Nama Tempatan 2</th>
                                                    <th style="text-align:center">Nama Saintifik</th>
                                                    <th style="text-align:center;">Kod</th>
                                                    <th style="text-align:center;">Aktif</th>



                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1.</td>
                                                    <td>Pembuat & pengilang perabot dan tanggam (Joinery)</td>
                                                    <td>ABCDEF</td>
                                                    <td>ABCDEF</td>
                                                    <td>
                                                        <div style="text-align:center">
                                                            <input type="checkbox" id="vehicle1" name="vehicle1"
                                                                value="Bike">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>1.</td>
                                                    <td>Pembuat & pengilang perabot dan tanggam (Joinery)</td>
                                                    <td>ABCDEF</td>
                                                    <td>ABCDEF</td>
                                                    <td>
                                                        <div style="text-align:center">
                                                            <input type="checkbox" id="vehicle1" name="vehicle1"
                                                                value="Bike">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>


                                        </table>
                                        <br>
                                        <a class="btn btn-primary" href=""> Tambah </a>
                                    </div>
                                </div>

                                <div class="tab-pane" id="ringan" role="tabpanel" aria-labelledby="ringan-tab"><br>
                                    <div class="">
                                        <table id="example2" class="display" style="width:100%;text-align:center">
                                            <thead>
                                                <tr>
                                                    <th>Bil.</th>
                                                    <th style="text-align:center">Nama Tempatan 3</th>
                                                    <th style="text-align:center">Nama Saintifik</th>
                                                    <th style="text-align:center;">Kod</th>
                                                    <th style="text-align:center;">Aktif</th>



                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1.</td>
                                                    <td>Pembuat & pengilang perabot dan tanggam (Joinery)</td>
                                                    <td>ABCDEF</td>
                                                    <td>ABCDEF</td>
                                                    <td>
                                                        <div style="text-align:center">
                                                            <input type="checkbox" id="vehicle1" name="vehicle1"
                                                                value="Bike">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>1.</td>
                                                    <td>Pembuat & pengilang perabot dan tanggam (Joinery)</td>
                                                    <td>ABCDEF</td>
                                                    <td>ABCDEF</td>
                                                    <td>
                                                        <div style="text-align:center">
                                                            <input type="checkbox" id="vehicle1" name="vehicle1"
                                                                value="Bike">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>


                                        </table>
                                        <br>
                                        <a class="btn btn-primary" href=""> Tambah </a>
                                    </div>
                                </div>

                                <div class="tab-pane" id="lembut" role="tabpanel" aria-labelledby="lembut-tab"><br>
                                    <div class="">
                                        <table id="example3" class="display" style="width:100%;text-align:center">
                                            <thead>
                                                <tr>
                                                    <th>Bil.</th>
                                                    <th style="text-align:center">Nama Tempatan 4</th>
                                                    <th style="text-align:center">Nama Saintifik</th>
                                                    <th style="text-align:center;">Kod</th>
                                                    <th style="text-align:center;">Aktif</th>



                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1.</td>
                                                    <td>Pembuat & pengilang perabot dan tanggam (Joinery)</td>
                                                    <td>ABCDEF</td>
                                                    <td>ABCDEF</td>
                                                    <td>
                                                        <div style="text-align:center">
                                                            <input type="checkbox" id="vehicle1" name="vehicle1"
                                                                value="Bike">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>1.</td>
                                                    <td>Pembuat & pengilang perabot dan tanggam (Joinery)</td>
                                                    <td>ABCDEF</td>
                                                    <td>ABCDEF</td>
                                                    <td>
                                                        <div style="text-align:center">
                                                            <input type="checkbox" id="vehicle1" name="vehicle1"
                                                                value="Bike">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>


                                        </table>
                                        <br>
                                        <a class="btn btn-primary" href=""> Tambah </a>
                                    </div>
                                </div>
                            <div class="tab-pane" id="lain_lain" role="tabpanel" aria-labelledby="lain_lain-tab"><br>
                                    <div class="">
                                        <table id="example4" class="display" style="width:100%;text-align:center">
                                            <thead>
                                                <tr>
                                                    <th>Bil.</th>
                                                    <th style="text-align:center">Nama Tempatan 5</th>
                                                    <th style="text-align:center">Nama Saintifik</th>
                                                    <th style="text-align:center;">Kod</th>
                                                    <th style="text-align:center;">Aktif</th>



                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1.</td>
                                                    <td>Pembuat & pengilang perabot dan tanggam (Joinery)</td>
                                                    <td>ABCDEF</td>
                                                    <td>ABCDEF</td>
                                                    <td>
                                                        <div style="text-align:center">
                                                            <input type="checkbox" id="vehicle1" name="vehicle1"
                                                                value="Bike">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>1.</td>
                                                    <td>Pembuat & pengilang perabot dan tanggam (Joinery)</td>
                                                    <td>ABCDEF</td>
                                                    <td>ABCDEF</td>
                                                    <td>
                                                        <div style="text-align:center">
                                                            <input type="checkbox" id="vehicle1" name="vehicle1"
                                                                value="Bike">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>


                                        </table>
                                        <br>
                                        <a class="btn btn-primary" href=""> Tambah </a>
                                    </div>
                                </div>
                        </div> --}}
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
