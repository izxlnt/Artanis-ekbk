<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.2;
            margin: 0;
            padding: 15px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 16px;
        }
        
        .header h2 {
            margin: 5px 0;
            color: #666;
            font-size: 12px;
        }
        
        .info-section {
            margin-bottom: 15px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 5px;
            align-items: center;
        }
        
        .info-label {
            width: 150px;
            font-weight: bold;
            color: #333;
        }
        
        .info-value {
            flex: 1;
            border-bottom: 1px solid #ccc;
            padding-bottom: 1px;
        }
        
        .section-title {
            background-color: #f5f5f5;
            padding: 6px;
            margin: 15px 0 10px 0;
            font-weight: bold;
            border-left: 4px solid #007bff;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 9px;
        }
        
        .data-table th, .data-table td {
            border: 1px solid #333;
            padding: 4px;
            text-align: center;
        }
        
        .data-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        
        .data-table .text-left {
            text-align: left;
        }
        
        .data-table .text-right {
            text-align: right;
        }
        
        .footer {
            position: fixed;
            bottom: 15px;
            right: 15px;
            font-size: 8px;
            color: #666;
        }
        
        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            margin-left: 10px;
        }
        
        .status-dihantar {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-lulus {
            background-color: #cce5ff;
            color: #004085;
        }
        
        .summary-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <h2>Sistem Pelaporan Kilang Kayu</h2>
    </div>

    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Nama Kilang:</div>
            <div class="info-value">{{ $shuttle->nama_kilang }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">No. Lesen:</div>
            <div class="info-value">{{ $shuttle->no_lesen }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tahun:</div>
            <div class="info-value">{{ $formC->tahun }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Bulan:</div>
            <div class="info-value">
                @php
                    $bulan_nama = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
                        5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember'
                    ];
                @endphp
                {{ $bulan_nama[$formC->bulan] }}
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Status:</div>
            <div class="info-value">
                {{ $formC->status }}
                <span class="status-badge {{ $formC->status == 'Lulus' ? 'status-lulus' : 'status-dihantar' }}">
                    {{ $formC->status }}
                </span>
            </div>
        </div>
    </div>

    <div class="section-title">Kemasukan Bahan Mentah</div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th rowspan="2">No.</th>
                <th rowspan="2">Spesis</th>
                <th rowspan="2">Kumpulan Kayu</th>
                <th rowspan="2">Baki Stok Bulan Lepas (m³)</th>
                <th rowspan="2">Kemasukan Kayu (m³)</th>
                <th rowspan="2">Jumlah Stok Kayu Balak (m³)</th>
                <th colspan="2">Kayu Dimasukkan ke Dalam Jentera (m³)</th>
                <th rowspan="2">Baki Stok Bulan Hadapan (m³)</th>
            </tr>
            <tr>
                <th>Masuk</th>
                <th>Keluar</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
                $total_baki_lepas = 0;
                $total_kemasukan = 0;
                $total_stok = 0;
                $total_masuk = 0;
                $total_keluar = 0;
                $total_baki_hadapan = 0;
            @endphp
            
            @foreach($kemasukanBahan as $item)
                @php
                    $spesis = $species->where('id', $item->spesis_id)->first();
                    $kumpulan = $kumpulanKayu->where('id', $spesis->kumpulan_kayu_id ?? 0)->first();
                    
                    $total_baki_lepas += $item->baki_stok ?? 0;
                    $total_kemasukan += $item->kayu_masuk ?? 0;
                    $total_stok += $item->jumlah_stok_kayu_balak ?? 0;
                    $total_masuk += $item->proses_masuk ?? 0;
                    $total_keluar += $item->proses_keluar ?? 0;
                    $total_baki_hadapan += $item->baki_stok_kehadapan ?? 0;
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td class="text-left">{{ $spesis->nama_spesis ?? '-' }}</td>
                    <td class="text-left">{{ $kumpulan->nama_kumpulan ?? '-' }}</td>
                    <td class="text-right">{{ number_format($item->baki_stok ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($item->kayu_masuk ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($item->jumlah_stok_kayu_balak ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($item->proses_masuk ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($item->proses_keluar ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($item->baki_stok_kehadapan ?? 0, 2) }}</td>
                </tr>
            @endforeach
            
            <tr class="summary-row">
                <td colspan="3">JUMLAH KESELURUHAN</td>
                <td class="text-right">{{ number_format($total_baki_lepas, 2) }}</td>
                <td class="text-right">{{ number_format($total_kemasukan, 2) }}</td>
                <td class="text-right">{{ number_format($total_stok, 2) }}</td>
                <td class="text-right">{{ number_format($total_masuk, 2) }}</td>
                <td class="text-right">{{ number_format($total_keluar, 2) }}</td>
                <td class="text-right">{{ number_format($total_baki_hadapan, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ $print_date }}
    </div>
</body>
</html>
