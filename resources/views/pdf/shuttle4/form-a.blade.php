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
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
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
        
        .info-section {
            margin-bottom: 20px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 8px;
            align-items: center;
        }
        
        .info-label {
            width: 200px;
            font-weight: bold;
            color: #333;
        }
        
        .info-value {
            flex: 1;
            border-bottom: 1px solid #ccc;
            padding-bottom: 2px;
        }
        
        .section-title {
            background-color: #f5f5f5;
            padding: 8px;
            margin: 20px 0 10px 0;
            font-weight: bold;
            border-left: 4px solid #28a745;
        }
        
        .footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 10px;
            color: #666;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 11px;
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
            <div class="info-label">No. SSM:</div>
            <div class="info-value">{{ $shuttle->no_ssm }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tahun:</div>
            <div class="info-value">{{ $formA->tahun }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Status:</div>
            <div class="info-value">
                {{ $formA->status }}
                <span class="status-badge {{ $formA->status == 'Lulus' ? 'status-lulus' : 'status-dihantar' }}">
                    {{ $formA->status }}
                </span>
            </div>
        </div>
    </div>

    <div class="section-title">Maklumat Kilang</div>
    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Alamat Kilang:</div>
            <div class="info-value">
                {{ $shuttle->alamat_kilang_1 }}<br>
                {{ $shuttle->alamat_kilang_2 }}<br>
                {{ $shuttle->alamat_kilang_poskod }} {{ $shuttle->alamat_kilang_daerah }}
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Alamat Surat Menyurat:</div>
            <div class="info-value">
                {{ $shuttle->alamat_surat_menyurat_1 }}<br>
                {{ $shuttle->alamat_surat_menyurat_2 }}<br>
                {{ $shuttle->alamat_surat_menyurat_poskod }} {{ $shuttle->alamat_surat_menyurat_daerah }}
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">No. Telefon:</div>
            <div class="info-value">{{ $shuttle->no_telefon }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">No. Faks:</div>
            <div class="info-value">{{ $shuttle->no_faks }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Email:</div>
            <div class="info-value">{{ $shuttle->email }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Website:</div>
            <div class="info-value">{{ $shuttle->website }}</div>
        </div>
    </div>

    <div class="section-title">Maklumat Syarikat</div>
    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Tarikh Penubuhan:</div>
            <div class="info-value">{{ $shuttle->tarikh_tubuh ? date('d/m/Y', strtotime($shuttle->tarikh_tubuh)) : '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tarikh Mula Beroperasi:</div>
            <div class="info-value">{{ $shuttle->tarikh_operasi ? date('d/m/Y', strtotime($shuttle->tarikh_operasi)) : '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Taraf Syarikat:</div>
            <div class="info-value">{{ $shuttle->taraf_syarikat_catatan }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Status Hak Milik:</div>
            <div class="info-value">{{ $shuttle->status_hak_milik }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Status Warganegara:</div>
            <div class="info-value">{{ $shuttle->status_warganegara }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Nilai Harta:</div>
            <div class="info-value">RM {{ number_format($shuttle->nilai_harta, 2) }}</div>
        </div>
    </div>

    <div class="footer">
        Dicetak pada: {{ $print_date }}
    </div>
</body>
</html>
