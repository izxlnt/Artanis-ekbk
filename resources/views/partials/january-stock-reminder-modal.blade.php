@php
    /*
     * Variables expected:
     *   $showJanuaryStockReminder : bool — true when this Borang C page is for January
     *                               and no submitted December (previous year) Borang C exists
     *   $year                     : int|string — the year of the Borang C being filled (optional)
     */
@endphp

@if(!empty($showJanuaryStockReminder))
    <div class="modal fade" id="januari_stock_reminder_modal" tabindex="-1" role="dialog"
        aria-labelledby="januariStockReminderTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#f3ce8f !important">
                    <h5 class="modal-title" id="januariStockReminderTitle">
                        <i style="color:rgb(255, 255, 0)" class="fas fa-exclamation-triangle"></i>&nbspPERHATIAN
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><b>Bagi kilang yang memulakan pengisian data pada bulan Januari {{ $year ?? date('Y') }}:</b></p>
                    <p>
                        Sila masukkan baki stok bulan sebelumnya (Disember) ke dalam kolum
                        <b>Kemasukan Kayu Balak Ke Dalam Kawasan Kilang (kolum 03)</b>
                        sebelum menghantar data bagi memastikan pengiraan stok semasa adalah tepat.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">FAHAM</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#januari_stock_reminder_modal').modal('show');
        });
    </script>
@endif
