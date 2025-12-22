@extends('layouts.layout-ipjpsm-nicepage')

@section('content')

<div>
    <link href="{{ asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('https://code.jquery.com/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js') }}"></script>

    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid" style="width: 100%;">

        @if (session()->has('message'))
        <div class="row" id="message">
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

        <div class="row">
            <div class="col-md-12" style="padding-top: 1% ; text-align:center">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body" style="width: 100%">
                                <!-- Navigation Buttons -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <a class="btn btn-primary" href="{{ route('ipjpsm.status-permohonan-shuttle-3-kilang') }}">Shuttle 3</a>
                                        <a class="btn btn-primary" href="{{ route('ipjpsm.status-permohonan-shuttle-4-kilang') }}">Shuttle 4</a>
                                        <a class="btn btn-primary" href="{{ route('ipjpsm.status-permohonan-shuttle-5-kilang') }}">Shuttle 5</a>
                                    </div>
                                </div>
                                <br><br>
                                <div>
                                    <h2>STATUS PERMOHONAN INDUSTRI BERASAS KAYU (IBK)</h2>
                                </div>
                                <div>
                                    <h3>SEMUA JENIS KILANG</h3>
                                </div>
                                <br>

                                <!-- Combined IBK Users Table -->
                                <div class="table-responsive">
                                    <table id="example" class="display" style="width:100%">
                                        <thead style="background-color:#ee8dcd">
                                            <tr>
                                                <th>Bil</th>
                                                <th>Nama</th>
                                                <th>No. IC/SSM</th>
                                                <th>No. Lesen</th>
                                                <th>Jenis Kilang</th>
                                                <th>Tarikh Permohonan</th>
                                                <th>Status</th>
                                                <th>Pengguna Kilang</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $counter = 1; @endphp
                                            
                                            {{-- Shuttle 3 Kilang Owners --}}
                                            @foreach ($shuttle3_kilang as $data)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td style="text-align:left">{{ $data->name }}</td>
                                                <td>{{ $data->login_id }}</td>
                                                <td>{{ $data->shuttle->no_lesen ?? 'N/A' }}</td>
                                                <td class="txt-oflo">Kilang Papan</td>
                                                <td>{{ $data->created_at }}</td>
                                                <td>
                                                    @if($data->is_approved == '1')
                                                        <span class="label label-success label-rounded">Lulus</span>
                                                    @else
                                                        <span class="label label-danger label-rounded">Belum Diluluskan</span>
                                                    @endif
                                                </td>
                                                <td>-</td>
                                                <td>
                                                    <a href="{{ route('ipjpsm.status-permohonan-shuttle-3-kilang') }}" 
                                                       class="mr-1 btn btn-success" data-toggle="tooltip"
                                                       data-placement="bottom" title="Lihat Detail Shuttle 3">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach

                                            {{-- Shuttle 3 Employees --}}
                                            @foreach ($shuttle3_employees as $data)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td style="text-align:left">{{ $data->name }}</td>
                                                <td>{{ $data->login_id }}</td>
                                                <td>{{ $data->shuttle->no_lesen ?? 'N/A' }}</td>
                                                <td class="txt-oflo">Kilang Papan</td>
                                                <td>{{ $data->created_at }}</td>
                                                <td>
                                                    @if($data->is_approved == '1')
                                                        <span class="label label-success label-rounded">Lulus</span>
                                                    @else
                                                        <span class="label label-danger label-rounded">Belum Diluluskan</span>
                                                    @endif
                                                </td>
                                                <td>{{ $data->pengguna_kilang->name ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('ipjpsm.status-permohonan-shuttle-3', $data->shuttle_id) }}" 
                                                       class="mr-1 btn btn-success" data-toggle="tooltip"
                                                       data-placement="bottom" title="Sahkan pengguna kilang">
                                                        <i class="fas fa-share"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach

                                            {{-- Shuttle 4 Kilang Owners --}}
                                            @foreach ($shuttle4_kilang as $data)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td style="text-align:left">{{ $data->name }}</td>
                                                <td>{{ $data->login_id }}</td>
                                                <td>{{ $data->shuttle->no_lesen ?? 'N/A' }}</td>
                                                <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                                                <td>{{ $data->created_at }}</td>
                                                <td>
                                                    @if($data->is_approved == '1')
                                                        <span class="label label-success label-rounded">Lulus</span>
                                                    @else
                                                        <span class="label label-danger label-rounded">Belum Diluluskan</span>
                                                    @endif
                                                </td>
                                                <td>-</td>
                                                <td>
                                                    <a href="{{ route('ipjpsm.status-permohonan-shuttle-4-kilang') }}" 
                                                       class="mr-1 btn btn-success" data-toggle="tooltip"
                                                       data-placement="bottom" title="Lihat Detail Shuttle 4">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach

                                            {{-- Shuttle 4 Employees --}}
                                            @foreach ($shuttle4_employees as $data)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td style="text-align:left">{{ $data->name }}</td>
                                                <td>{{ $data->login_id }}</td>
                                                <td>{{ $data->shuttle->no_lesen ?? 'N/A' }}</td>
                                                <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                                                <td>{{ $data->created_at }}</td>
                                                <td>
                                                    @if($data->is_approved == '1')
                                                        <span class="label label-success label-rounded">Lulus</span>
                                                    @else
                                                        <span class="label label-danger label-rounded">Belum Diluluskan</span>
                                                    @endif
                                                </td>
                                                <td>{{ $data->pengguna_kilang->name ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('ipjpsm.status-permohonan-shuttle-4', $data->shuttle_id) }}" 
                                                       class="mr-1 btn btn-success" data-toggle="tooltip"
                                                       data-placement="bottom" title="Sahkan pengguna kilang">
                                                        <i class="fas fa-share"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach

                                            {{-- Shuttle 5 Kilang Owners --}}
                                            @foreach ($shuttle5_kilang as $data)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td style="text-align:left">{{ $data->name }}</td>
                                                <td>{{ $data->login_id }}</td>
                                                <td>{{ $data->shuttle->no_lesen ?? 'N/A' }}</td>
                                                <td class="txt-oflo">Kilang Kayu Kumai</td>
                                                <td>{{ $data->created_at }}</td>
                                                <td>
                                                    @if($data->is_approved == '1')
                                                        <span class="label label-success label-rounded">Lulus</span>
                                                    @else
                                                        <span class="label label-danger label-rounded">Belum Diluluskan</span>
                                                    @endif
                                                </td>
                                                <td>-</td>
                                                <td>
                                                    <a href="{{ route('ipjpsm.status-permohonan-shuttle-5-kilang') }}" 
                                                       class="mr-1 btn btn-success" data-toggle="tooltip"
                                                       data-placement="bottom" title="Lihat Detail Shuttle 5">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach

                                            {{-- Shuttle 5 Employees --}}
                                            @foreach ($shuttle5_employees as $data)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td style="text-align:left">{{ $data->name }}</td>
                                                <td>{{ $data->login_id }}</td>
                                                <td>{{ $data->shuttle->no_lesen ?? 'N/A' }}</td>
                                                <td class="txt-oflo">Kilang Kayu Kumai</td>
                                                <td>{{ $data->created_at }}</td>
                                                <td>
                                                    @if($data->is_approved == '1')
                                                        <span class="label label-success label-rounded">Lulus</span>
                                                    @else
                                                        <span class="label label-danger label-rounded">Belum Diluluskan</span>
                                                    @endif
                                                </td>
                                                <td>{{ $data->pengguna_kilang->name ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('ipjpsm.status-permohonan-shuttle-5', $data->shuttle_id) }}" 
                                                       class="mr-1 btn btn-success" data-toggle="tooltip"
                                                       data-placement="bottom" title="Sahkan pengguna kilang">
                                                        <i class="fas fa-share"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- No Data Message -->
                                @if(($shuttle3_kilang->count() + $shuttle3_employees->count() + $shuttle4_kilang->count() + $shuttle4_employees->count() + $shuttle5_kilang->count() + $shuttle5_employees->count()) == 0)
                                <div class="alert alert-info text-center">
                                    <h4><i class="fas fa-info-circle"></i> Tiada Permohonan IBK Yang Perlu Diproses</h4>
                                    <p>Semua permohonan Industri Berasas Kayu telah diproses atau tiada permohonan baru.</p>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid -->
    <!-- ============================================================== -->
</div>

<script>
$(document).ready(function() {
    $('#example').DataTable();
});
</script>

@endsection