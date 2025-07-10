@extends('layouts.layout-phd-nicepage')

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
            <div class="col-md-12" style="padding-top: 1% ; text-align:center">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body" style="width: 100%">
                        {{-- <div class="row">
                            <div class="col-md-2">
                                <select name="form_type" class="form-control">
                                    <option value="3A">2021</option>
                                    <option value="3B">2020</option>
                                    <option value="3C">2019</option>
                                    <option value="3D">2018</option>
                                </select>
                            </div>

                         </div>
                        <br><br> --}}
                        <div><h4>SENARAI TUGASAN</h4></div>
                        <div class="table-responsive">
                            <table id="senaraitugasan" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Bil</th>
                                        <th>Nama Kilang</th>
                                        <th>Jenis Kilang</th>
                                        <th>Status</th>
                                        <th>Jenis Lampiran</th>
                                        <th>Tarikh</th>
                                        <th>Tindakan</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($formB as $data)
                                        <tr>
                                            <td></td>
                                            <td>{{ $data->nama_kilang}}</td>
                                            @if( $data->shuttle_type == '3')
                                            <td class="txt-oflo">Kilang Papan Lapis</td>
                                            @elseif( $data->shuttle_type == '4')
                                            <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                                            @else
                                            <td class="txt-oflo">Kilang Kayu Kumai</td>
                                            @endif
                                            <td>
                                                <span class="label label-warning label-rounded">{{ $data->status }}</span>
                                            </td>
                                            <td>
                                                @if( $data->shuttle_type == '3')
                                                Borang 3B
                                                @elseif($data->shuttle_type == '4')
                                                Borang 4B
                                                @else
                                                Borang 5B
                                                @endif

                                            </td>
                                            <td>{{ $data->updated_at }}</td>
                                            <td> <a href="{{ route('phd.shuttle-3-view-formB',$data->id) }}" class="mr-1 btn btn-success"><i
                                                        class="fas fa-pencil-alt"></i></a>

                                            </td>
                                    @endforeach
                                    </tr>

                                    @foreach ($formC as $data)
                                    <tr>
                                        <td></td>
                                        <td>{{ $data->nama_kilang}}</td>
                                        @if( $data->shuttle_type == '3')
                                        <td class="txt-oflo">Kilang Papan Lapis</td>
                                        @elseif( $data->shuttle_type == '4')
                                        <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                                        @else
                                        <td class="txt-oflo">Kilang Kayu Kumai</td>
                                        @endif
                                        <td>
                                            <span class="label label-warning label-rounded">{{ $data->status }}</span>
                                        </td>
                                        <td>
                                            @if( $data->shuttle_type == '3')
                                            Borang 3C
                                            @elseif($data->shuttle_type == '4')
                                            Borang 4C
                                            @else
                                            Borang 5C
                                            @endif
                                        </td>
                                        <td>{{ $data->updated_at }}</td>
                                        <td> <a href="{{ route('phd.shuttle-3-view-formC',$data->id) }}" class="mr-1 btn btn-success"><i
                                                    class="fas fa-pencil-alt"></i></a>

                                        </td>
                                @endforeach


                                @foreach ($formD as $data)
                                <tr>
                                    <td></td>
                                    <td>{{ $data->nama_kilang}}</td>
                                    @if( $data->shuttle_type == '3')
                                    <td class="txt-oflo">Kilang Papan Lapis</td>
                                    @elseif( $data->shuttle_type == '4')
                                    <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                                    @else
                                    <td class="txt-oflo">Kilang Kayu Kumai</td>
                                    @endif
                                    <td>
                                        <span class="label label-warning label-rounded">{{ $data->status }}</span>
                                    </td>
                                    <td>
                                        Borang 3D
                                    </td>
                                    <td>{{ $data->updated_at }}</td>
                                    <td> <a href="{{ route('phd.shuttle-3-view-formD',$data->id) }}" class="mr-1 btn btn-success"><i
                                                class="fas fa-pencil-alt"></i></a>

                                    </td>
                            @endforeach


                            @foreach ($form4D as $data)
                            <tr>
                                <td></td>
                                <td>{{ $data->nama_kilang}}</td>
                                @if( $data->shuttle_type == '3')
                                <td class="txt-oflo">Kilang Papan Lapis</td>
                                @elseif( $data->shuttle_type == '4')
                                <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                                @else
                                <td class="txt-oflo">Kilang Kayu Kumai</td>
                                @endif
                                <td>
                                    <span class="label label-warning label-rounded">{{ $data->status }}</span>
                                </td>
                                <td>
                                    Borang 4D
                                </td>
                                <td>{{ $data->updated_at }}</td>
                                <td> <a href="{{ route('phd.shuttle-4-view-formD',$data->id) }}" class="mr-1 btn btn-success"><i
                                            class="fas fa-pencil-alt"></i></a>

                                </td>
                        @endforeach

                        @foreach ($form4E as $data)
                            <tr>
                                <td></td>
                                <td>{{ $data->nama_kilang}}</td>
                                @if( $data->shuttle_type == '3')
                                <td class="txt-oflo">Kilang Papan Lapis</td>
                                @elseif( $data->shuttle_type == '4')
                                <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                                @else
                                <td class="txt-oflo">Kilang Kayu Kumai</td>
                                @endif
                                <td>
                                    <span class="label label-warning label-rounded">{{ $data->status }}</span>
                                </td>
                                <td>
                                    Borang 4E
                                </td>
                                <td>{{ $data->updated_at }}</td>
                                <td> <a href="{{ route('phd.shuttle-4-view-formE',$data->id) }}" class="mr-1 btn btn-success"><i
                                            class="fas fa-pencil-alt"></i></a>

                                </td>
                        @endforeach

                        @foreach ($form5D as $data)
                        <tr>
                            <td></td>
                            <td>{{ $data->nama_kilang}}</td>
                            @if( $data->shuttle_type == '3')
                            <td class="txt-oflo">Kilang Papan Lapis</td>
                            @elseif( $data->shuttle_type == '4')
                            <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                            @else
                            <td class="txt-oflo">Kilang Kayu Kumai</td>
                            @endif
                            <td>
                                <span class="label label-warning label-rounded">{{ $data->status }}</span>
                            </td>
                            <td>
                                Borang 5D
                            </td>
                            <td>{{ $data->updated_at }}</td>
                            <td> <a href="{{ route('phd.shuttle-5-view-formD',$data->id) }}" class="mr-1 btn btn-success"><i
                                        class="fas fa-pencil-alt"></i></a>

                            </td>
                    @endforeach

                    @foreach ($form5E as $data)
                    <tr>
                        <td></td>
                        <td>{{ $data->nama_kilang}}</td>
                        @if( $data->shuttle_type == '3')
                        <td class="txt-oflo">Kilang Papan Lapis</td>
                        @elseif( $data->shuttle_type == '4')
                        <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                        @else
                        <td class="txt-oflo">Kilang Kayu Kumai</td>
                        @endif
                        <td>
                            <span class="label label-warning label-rounded">{{ $data->status }}</span>
                        </td>
                        <td>
                            Borang 5E
                        </td>
                        <td>{{ $data->updated_at }}</td>
                        <td> <a href="{{ route('phd.shuttle-5-view-formE',$data->id) }}" class="mr-1 btn btn-success"><i
                                    class="fas fa-pencil-alt"></i></a>

                        </td>
                @endforeach
                                </tr>
                                </tbody>
                            </table>
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
    // document.addEventListener("DOMContentLoaded", () => {
    //     Livewire.hook('component.initialized', (component) => {
    //         console.log(component);
    //         $(document).ready(function() {
    //             $('#example').DataTable();
    //         });
    //     })
    // });
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
    function onlyNumberKey(evt) {

          // Only ASCII charactar in that range allowed
          var ASCIICode = (evt.which) ? evt.which : evt.keyCode
          if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
              return false;
          return true;
    }
</script>

<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

{{-- data table --}}
<script type="text/javascript">
// Responsive Data Table
let senaraitugasan = $("#senaraitugasan")
var t = $(senaraitugasan).DataTable({
  "responsive" : true,

  //start sini untuk print
  "dom": 'Bfrtip',
  "buttons": [
      'excel',
      {
          extend: 'pdfHtml5',
          orientation: 'landscape',
          pageSize: 'A4',
          title: 'Senarai Tugasan',
      },
      {
          extend: 'print',
          text: 'Cetak',
          pageSize: 'LEGAL',
          title: 'Senarai Tugasan',
          customize: function(win)
          {

              var last = null;
              var current = null;
              var bod = [];

              var css = '@page { size: landscape; }',
                  head = win.document.head || win.document.getElementsByTagName('head')[0],
                  style = win.document.createElement('style');

              style.type = 'text/css';
              style.media = 'print';

              if (style.styleSheet)
              {
                style.styleSheet.cssText = css;
              }
              else
              {
                style.appendChild(win.document.createTextNode(css));
              }

              head.appendChild(style);
        },
      },
  ],

  //end sini

  //ini untuk paparkan rekod per halaman
  "scrollX": true,
  "columnDefs": [ {
      "searchable": false,
      "orderable": false,
      "targets": 0
  } ],
  "order": [[ 1, 'asc' ]],
  "language": {
      "lengthMenu": "Memaparkan _MENU_ rekod per halaman",
      "zeroRecords": "Maaf, tiada rekod.",
      "info": "Memaparkan halaman _PAGE_ dari _PAGES_",
      "infoEmpty": "Tidak ada rekod yang tersedia",
      "infoFiltered": "(Ditapis dari _MAX_ jumlah rekod)",
      "search": "Carian",
      "previous": "Sebelum",
      "paginate": {
          "first":      "Pertama",
          "last":       "Terakhir",
          "next":       "Seterusnya",
          "previous":   "Sebelumnya"
      },
  },
    responsive : true,
    columnDefs: [
                  {
                      "targets": "_all", // your case first column
                      "className": "text-center",
                  },
                ],
});

t.on('order.dt search.dt', function () {
      t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            t.cell(cell).invalidate('dom');
      });
}).draw();

</script>





@endsection
