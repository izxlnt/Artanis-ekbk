<div style="overflow-x: auto;">
    <table>
        <tr style="height:50px;background-color:#f8dbee;">
            <th style="text-align:center;" colspan="2" rowspan="4">Kategori Pekerja</th>
            <th style="text-align:center;" colspan="4">Warganegara Malaysia</th>
            <th style="text-align:center;" colspan="2" rowspan="3">Bukan <br>Warganegara <br>Malaysia</th>
            <th style="text-align:center;" colspan="3" rowspan="3">Jumlah Pekerja</th>
            <th style="text-align:center;" colspan="3" rowspan="3">Purata Bayaran Gaji dan <br>Upah
                Per Pekerja<br> (Sebulan) <br> (RM/ bulan / pekerja)</th>
            <th style="text-align:center;" colspan="3" rowspan="3">Jumlah Bayaran Gaji
                dan Upah <br>(Sebulan) <br>(RM)</th>
        </tr>
        <tr style="height:50px;background-color:#f8dbee;">
            <th style="text-align:center;" colspan="2" rowspan="2">Bumiputera</th>
            <th style="text-align:center;" colspan="2" rowspan="2">Bukan Bumiputera</th>
        </tr>
        <tr style="height:50px;background-color:#f8dbee;"></tr>
        <tr style="height:50px;background-color:#f8dbee;">
            <th style="text-align:center;">L</th>
            <th style="text-align:center;">P</th>
            <th style="text-align:center;">L</th>
            <th style="text-align:center;">P</th>
            <th style="text-align:center;width:70px;">L</th>
            <th style="text-align:center;width:70px;">P</th>
            <th style="text-align:center;">L</th>
            <th style="text-align:center;">P</th>
            <th style="text-align:center;width:100px;">L+P</th>
            <th style="text-align:center;width:80px;">L</th>
            <th style="text-align:center;width:80px;">P</th>
            <th style="text-align:center;width:90px;">L+P</th>
            <th style="text-align:center;width:100px;">L</th>
            <th style="text-align:center;width:100px;">P</th>
            <th style="text-align:center;width:110px;">L+P</th>
        </tr>
        <tr style="height:50px;background-color:#f8dbee;">
            <th style="text-align:center;" colspan="2">(01)</th>
            <th style="text-align:center;">(02)</th>
            <th style="text-align:center;">(03)</th>
            <th style="text-align:center;">(04)</th>
            <th style="text-align:center;">(05)</th>
            <th style="text-align:center;width:70px;">(06)</th>
            <th style="text-align:center;width:70px;">(07)</th>
            <th style="text-align:center;">(08) =<br>(02)+(04)+(06)</th>
            <th style="text-align:center;">(09) =<br>(03)+(05)+(07)</th>
            <th style="text-align:center;width:100px;">(10) =<br>(08)+(09)</th>
            <th style="text-align:center;width:80px;">(11)</th>
            <th style="text-align:center;width:80px;">(12)</th>
            <th style="text-align:center;width:90px;">(13) =<br>(11)+(12)</th>
            <th style="text-align:center;width:100px;">(14) =<br>(08)*(11)</th>
            <th style="text-align:center;width:100px;">(15) =<br>(09)*(12)</th>
            <th style="text-align:center;width:110px;">(16) =<br>(14)+(15)</th>
        </tr>

        @foreach ($kategori_pekerja as $key => $data)
            <tr style="height:50px;">
                <td style="text-align:left;">{{ $data->keterangan }}</td>
                <td style="text-align:center;width:30px;">{{ $key + 1 }}</td>
                <td style="text-align:center;padding:5px;">
                    <input type="text" size="3" style="text-align:center;width:100%;"
                        value="{{ $pekerja_wargabumi_lelaki[$key] ?? '' }}"
                        wire:model.lazy='pekerja_wargabumi_lelaki.{{ $key }}'
                        onkeypress="return isNumberKey(event)">
                </td>
                <td style="text-align:center;padding:5px;">
                    <input type="text" size="3" style="text-align:center;width:100%;"
                        value="{{ $pekerja_wargabumi_perempuan[$key] ?? '' }}"
                        wire:model.lazy='pekerja_wargabumi_perempuan.{{ $key }}'
                        onkeypress="return isNumberKey(event)">
                </td>
                <td style="text-align:center;padding:5px;">
                    <input type="text" size="3" style="text-align:center;width:100%;"
                        value="{{ $pekerja_bukan_wargabumi_lelaki[$key] ?? '' }}"
                        wire:model.lazy='pekerja_bukan_wargabumi_lelaki.{{ $key }}'
                        onkeypress="return isNumberKey(event)">
                </td>
                <td style="text-align:center;padding:5px;">
                    <input type="text" size="3" style="text-align:center;width:100%;"
                        value="{{ $pekerja_bukan_wargabumi_perempuan[$key] ?? '' }}"
                        wire:model.lazy='pekerja_bukan_wargabumi_perempuan.{{ $key }}'
                        onkeypress="return isNumberKey(event)">
                </td>
                <td style="text-align:center;padding:5px;">
                    <input type="text" size="3" style="text-align:center;width:100%;"
                        value="{{ $pekerja_asing_lelaki[$key] ?? '' }}"
                        wire:model.lazy='pekerja_asing_lelaki.{{ $key }}'
                        onkeypress="return isNumberKey(event)">
                </td>
                <td style="text-align:center;padding:5px;">
                    <input type="text" size="3" style="text-align:center;width:100%;"
                        value="{{ $pekerja_asing_perempuan[$key] ?? '' }}"
                        wire:model.lazy='pekerja_asing_perempuan.{{ $key }}'
                        onkeypress="return isNumberKey(event)">
                </td>
                <td style="text-align:center;padding:5px;background-color: #f8dbee;">
                    <input type="text" readonly size="3" style="text-align:center;width:100%;background-color:#f8dbee;border:none;"
                        value="{{ $jumlah_lelaki[$key] ?? '' }}"
                        wire:model='jumlah_lelaki.{{ $key }}'>
                </td>
                <td style="text-align:center;padding:5px;background-color: #f8dbee;">
                    <input type="text" readonly size="3" style="text-align:center;width:100%;background-color:#f8dbee;border:none;"
                        value="{{ $jumlah_perempuan[$key] ?? '' }}"
                        wire:model='jumlah_perempuan.{{ $key }}'>
                </td>
                <td style="text-align:center;padding:5px;background-color: #f8dbee;">
                    <input type="text" readonly size="3" style="text-align:center;width:100%;background-color:#f8dbee;border:none;"
                        value="{{ $jumlah_pekerja[$key] ?? '' }}"
                        wire:model='jumlah_pekerja.{{ $key }}'>
                </td>
                <td style="text-align:center;padding:5px;">
                    <input type="text" size="3" style="text-align:center;width:100%;"
                        value="{{ $gaji_lelaki[$key] ?? '' }}"
                        wire:model.lazy='gaji_lelaki.{{ $key }}'
                        onkeypress="return isNumberKey(event)">
                </td>
                <td style="text-align:center;padding:5px;">
                    <input type="text" size="3" style="text-align:center;width:100%;"
                        value="{{ $gaji_perempuan[$key] ?? '' }}"
                        wire:model.lazy='gaji_perempuan.{{ $key }}'
                        onkeypress="return isNumberKey(event)">
                </td>
                <td style="text-align:center;padding:5px;background-color: #f8dbee;">
                    <input type="text" readonly size="3" style="text-align:center;width:100%;background-color:#f8dbee;border:none;"
                        value="{{ $gaji_lelaki_perempuan[$key] ?? '' }}"
                        wire:model='gaji_lelaki_perempuan.{{ $key }}'>
                </td>
                <td style="text-align:center;padding:5px;background-color: #f8dbee;">
                    <input type="text" readonly size="3" style="text-align:center;width:100%;background-color:#f8dbee;border:none;"
                        value="{{ $total_gaji_lelaki[$key] ?? '' }}"
                        wire:model='total_gaji_lelaki.{{ $key }}'>
                </td>
                <td style="text-align:center;padding:5px;background-color: #f8dbee;">
                    <input type="text" readonly size="3" style="text-align:center;width:100%;background-color:#f8dbee;border:none;"
                        value="{{ $total_gaji_perempuan[$key] ?? '' }}"
                        wire:model='total_gaji_perempuan.{{ $key }}'>
                </td>
                <td style="text-align:center;padding:5px;background-color: #f8dbee;">
                    <input type="text" readonly size="3" style="text-align:center;width:100%;background-color:#f8dbee;border:none;"
                        value="{{ $total_gaji[$key] ?? '' }}"
                        wire:model='total_gaji.{{ $key }}'>
                </td>
            </tr>
        @endforeach

        <tr style="height:50px;background-color:#f8dbee;font-weight:bold;">
            <td style="text-align:center;padding:5px;" colspan="2"><b>Jumlah</b></td>
            <td style="text-align:center;padding:5px;">{{ $total_bumi_lelaki }}</td>
            <td style="text-align:center;padding:5px;">{{ $total_bumi_perempuan }}</td>
            <td style="text-align:center;padding:5px;">{{ $total_bukanbumi_lelaki }}</td>
            <td style="text-align:center;padding:5px;">{{ $total_bukanbumi_perempuan }}</td>
            <td style="text-align:center;padding:5px;">{{ $total_asing_lelaki }}</td>
            <td style="text-align:center;padding:5px;">{{ $total_asing_perempuan }}</td>
            <td style="text-align:center;padding:5px;">{{ $total_pekerja_lelaki }}</td>
            <td style="text-align:center;padding:5px;">{{ $total_pekerja_perempuan }}</td>
            <td style="text-align:center;padding:5px;">{{ $total_pekerja }}</td>
            <td style="text-align:center;padding:5px;">{{ number_format((float) $jumlah_gaji_lelaki, 2) }}</td>
            <td style="text-align:center;padding:5px;">{{ number_format((float) $jumlah_gaji_perempuan, 2) }}</td>
            <td style="text-align:center;padding:5px;">{{ number_format((float) $jumlah_lelaki_perempuan, 2) }}</td>
            <td style="text-align:center;padding:5px;">{{ number_format((float) $jumlah_total_lelaki, 2) }}</td>
            <td style="text-align:center;padding:5px;">{{ number_format((float) $jumlah_total_perempuan, 2) }}</td>
            <td style="text-align:center;padding:5px;">{{ number_format((float) $jumlah_total_gaji, 2) }}</td>
        </tr>
    </table>

    {{-- No separate "Simpan" button - each field auto-saves to the
    _laporan columns on blur (see calcJumlahPekerjaLelaki/Perempuan), so a
    typed correction is already recorded the moment it's set. Only Reset
    needs a distinct action, since it discards those corrections. --}}
    <div class="text-center form-group m-b-0" style="margin-top: 15px;">
        <button type="button" wire:click="resetToOriginal" class="btn btn-secondary"
            onclick="if(!confirm('Kembalikan semua nilai kepada rekod lama (data asal yang dihantar oleh IBK)? Sebarang pembetulan akan hilang.')){ event.stopImmediatePropagation(); return false; }">
            Reset Kepada Rekod Lama
        </button>
    </div>
</div>
