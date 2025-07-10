@extends('layouts.layout-ipjpsm-nicepage')

@section('content')
    {{-- @livewire('shuttle-three.shuttle3') --}}


    <div>

        <link href="{{ asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css') }}" rel="stylesheet" />


        <script src="{{ asset('https://code.jquery.com/jquery-3.5.1.js') }}"></script>
        <script src="{{ asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js') }}"></script>

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
                        <div class="card-body" style="width: 100%">

                            <div class="text-center">
                                <h4> TETAPAN BUFFER PENGHANTARAN BORANG</h4>
                            </div>

                            <div class="table-responsive">
                                <table id="buffer_table" class="display" style="width:100%">
                                    <thead class="text-center" style="background-color:lightgray">
                                        <tr>
                                            <th>Bil</th>
                                            <th>Shuttle</th>
                                            <th>Borang</th>
                                            <th>Penangguhan</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr>
                                            <td></td>
                                            <td colspan="3"><b style="font-size: 13pt;">Tetapan Semua Borang</b></td>
                                            <td><button type="button" class="btn waves-effect waves-light btn-primary"
                                                    onclick="update_buffer(0)"><i class="fas fa-edit"></i></button></td>
                                        </tr>
                                        @foreach ($buffer as $key => $data)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>Shuttle {{ $data->shuttle }}</td>
                                                <td>Borang {{ $data->borang }}</td>
                                                <td>{{ $data->delay }} Bulan</td>
                                                <td>
                                                    <button type="button" class="btn waves-effect waves-light btn-primary"
                                                        onclick="update_buffer({{ $data->id }})"><i
                                                            class="fas fa-edit"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="update_buffer_modal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-edit"
                                                    aria-hidden="true"></i>&nbspKemaskini
                                                Buffer</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('tetapan.buffer.update') }}">
                                            @csrf
                                            <div class="modal-body">

                                                <input type="hidden" name="buffer_id" id="buffer_id">
                                                <label for="">Penangguhan untuk penghantaran borang oleh IBK:
                                                </label>
                                                <select class="form-control" name='delay' required>
                                                    <option selected disabled>Sila Pilih Bulan</option>
                                                    {{-- @for ($i = 1; $i < $currMonth; $i++)
                                                    <option value="{{ $i }}" {{ old('delay') == ' $i ' ? 'selected' : '' }}>{{ $i }} Bulan</option>
                                                    @endfor --}}
                                                    @for ($i = 1; $i <= 13; $i++)
                                                        <option value="{{ $i }}"
                                                            {{ old('delay') == $i ? 'selected' : '' }}>{{ $i }}
                                                            Bulan</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Kembali</button>
                                                <input type="hidden" name="user_id_disable" id="user_id_disable" readonly>
                                                <button type="submit" class="btn btn-success">Kemaskini</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <a class="btn btn-primary" href="{{ route('home') }}" style="color:white">Kembali</a>
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

    <script>
        function update_buffer(buffer_id) {
            $("#buffer_id").val(buffer_id);
            $("#update_buffer_modal").modal();
        }
    </script>

    <script>
        let buffer_table = $("#buffer_table")
        var t = $(buffer_table).DataTable({
            "responsive": true,
            "scrollX": true,
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "order": [
                [1, 'asc']
            ],
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
            responsive: true,
            columnDefs: [{
                "targets": "_all", // your case first column
                "className": "text-center",
            }, ],
        });

        t.on('order.dt search.dt', function() {
            t.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
                t.cell(cell).invalidate('dom');
            });
        }).draw();
    </script>
@endsection
