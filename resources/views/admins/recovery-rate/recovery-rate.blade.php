@extends('layouts.layout-ipjpsm-nicepage')

@section('content')

    <link href="{{ asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('https://code.jquery.com/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js') }}"></script>

    <script class="">
        $(document).ready(function() {
            $('#example').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "bFilter": false
            });
        });
    </script>

    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->

    <div class="container-fluid" style="width:100%">

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
                                                    <a href="{{ $breadcrumb['link'] }}" style="color: white !important;" onMouseOver="this.style.color='lightblue'" onMouseOut="this.style.color='white'"> {{ $breadcrumb['name'] }}
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

                <div class="card">
                    <div class="card-body">
                        <form action="" method="get">
                            <div class="card-header"
                                style="text-align:center; background-color: #a0e4ff !important; font-size: 130%; font-weight: bold;">
                                KEMASKINI SENARAI RECOVERY RATE
                            </div>

                            <br>
                            <div class="">
                                <table id="example" class="display" style="width:100%;text-align:center">
                                    <thead>
                                        <tr>
                                            <th style="width:5%">Bil.</th>
                                            <th style="text-align:center;">Shuttle</th>
                                            <th style="text-align:center; font-style: italic">Min. Recovery Rate</th>
                                            <th style="text-align:center; font-style: italic">Max. Recovery Rate</th>

                                            <th style="text-align:center;style=width:20%">Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recovery_rate as $data)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                @if($data->shuttle_type == 3)
                                                    <td style="text-align:left"> 3 (Kilang Papan) </td>
                                                @elseif($data->shuttle_type == 4)
                                                    <td style="text-align:left"> 4 (Kilang Papan Lapis/Venir)</td>
                                                @elseif($data->shuttle_type == 5)
                                                    <td style="text-align:left"> 5 (Kilang Kayu Kumai)</td>
                                                @else
                                                    <td>{{ $data->shuttle_type }}</td>
                                                @endif()
                                                <td>{{ number_format($data->min_recovery_rate, 2) }}</td>
                                                <td>{{ number_format($data->max_recovery_rate, 2) }}</td>
                                                <td>
                                                    <a href="{{ route('recovery-rate.edit', $data->id) }}"
                                                        class="mr-1 btn btn-success"><i class="fas fa-pencil-alt"
                                                            title="Kemaskini"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>

                    <a href="{{ route('home') }}" class="btn btn-primary">Kembali</a>
                            </div>
                        </form>
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

@endsection
