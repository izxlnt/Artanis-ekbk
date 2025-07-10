<style>
    table {
      border-collapse: collapse;
    }

    td, th {
      border: 1px solid black;
      padding: 5px;
    }

    th {
        background-color: lightgrey;
    }

</style>
<div class="container-fluid">

    <div class="row">

        <div class="col-12">


            <div class="card">
                {{-- <div class="text-center card-header" style="background-color: #f3ce8f">{{ $title }}</div> --}}
                <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} Bagi Tahun {{ $tahun }}</div>
                <div class="card-body">

                    <div class="table-responsive" style="padding-top: 15px;">
                        <table id="example" class="table table-bordered" style=" width: 100%;">
                            @if($shuttle == 'shuttle3' || $shuttle == 'shuttle5')
                                <thead>
                                    <tr class="text-center">

                                        <th style="">Bil</th>
                                        <th style="">Negeri</th>
                                        <th style="">Harta Tetap</th>

                                    </tr>
                                </thead>
                            @endif

                            @php
                                $jumlah_setiap_negeri = 0;
                            @endphp

                            <tbody>

                                @foreach ($results as $result)
                                    <tr>
                                        <td class="text-center" style=" text-align: center;">{{ $loop->iteration }}</td>
                                        <td class="text-left" style=" text-align: left;">{{ $result->negeri_keterangan }}</td>
                                        <td class="text-right" style=" text-align: right;">
                                            RM {{ number_format($result->rekod_nilaiharta, 2) }}
                                            @php
                                                $jumlah_setiap_negeri += $result->rekod_nilaiharta;
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                            <tfoot>
                                <tr class="text-center" style="background-color: lightgray;">
                                    <td style=""></td>
                                    <td class="text-left" style=" text-align: left;"><b>JUMLAH</b></td>
                                    <td class="text-right" style=" text-align: right;"><b>RM {{ number_format($jumlah_setiap_negeri, 2) }}</b></td>
                                </tr>
                            </tfoot>
                        </table>



                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
