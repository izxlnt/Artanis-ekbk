<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 18px;
        }
        
        .header h2 {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        
        .company-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .company-info h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        
        .info-row {
            margin-bottom: 5px;
        }
        
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .summary-table th,
        .summary-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        
        .summary-table th {
            background-color: #368cee;
            color: white;
            font-weight: bold;
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .month-name {
            font-weight: bold;
            text-align: center;
        }
        
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        
        .footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 10px;
            color: #666;
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
        <h2>PENYATA SHUTTLE 4 - KILANG PAPAN LAPIS/VENIR</h2>
        <h2>BORANG 4E - PENYATA KEMASUKAN BAHAN MENTAH</h2>
    </div>

    <div class="company-info">
        <h3>Maklumat Kilang</h3>
        <div class="info-row">
            <span class="info-label">Nama Kilang:</span>
            {{ $shuttle->nama_kilang }}
        </div>
        <div class="info-row">
            <span class="info-label">No. Lesen:</span>
            {{ $shuttle->no_lesen }}
        </div>
        <div class="info-row">
            <span class="info-label">No. SSM:</span>
            {{ $shuttle->no_ssm }}
        </div>
        <div class="info-row">
            <span class="info-label">Tahun:</span>
            {{ $year }}
        </div>
    </div>

    <table class="summary-table">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Status</th>
                <th>Jumlah Kemasukan (m³)</th>
                <th>Bilangan Spesis</th>
                <th>Tarikh Kemaskini</th>
            </tr>
        </thead>
        <tbody>
            @php
                $monthNames = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
                    5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember'
                ];
                $totalKemasukan = 0;
                $totalSpesis = 0;
            @endphp
            
            @foreach($list as $data)
                @php
                    $kemasukan = $data->kemasukanBahan->sum('jumlah_kemasukan') ?? 0;
                    $spesis = $data->kemasukanBahan->count() ?? 0;
                    $totalKemasukan += $kemasukan;
                    $totalSpesis += $spesis;
                @endphp
                <tr>
                    <td class="month-name">{{ $monthNames[$data->bulan] }}</td>
                    <td class="{{ $data->status == 'Lulus' ? 'status-completed' : 'status-pending' }}">
                        {{ $data->status }}
                    </td>
                    <td>{{ number_format($kemasukan, 2) }}</td>
                    <td>{{ $spesis }}</td>
                    <td>{{ $data->updated_at ? $data->updated_at->format('d/m/Y') : '-' }}</td>
                </tr>
            @endforeach
            
            <tr class="total-row">
                <td colspan="2">JUMLAH KESELURUHAN</td>
                <td>{{ number_format($totalKemasukan, 2) }}</td>
                <td>{{ $totalSpesis }}</td>
                <td>-</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p><strong>Nota:</strong> Senarai ini hanya menunjukkan borang-borang yang telah selesai diisi dan dihantar.</p>
        <p><strong>Jumlah Borang Selesai:</strong> {{ $list->count() }} daripada 12 bulan</p>
    </div>

    <div class="footer">
        Dicetak pada: {{ $print_date }}
    </div>
</body>
</html>
