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
            border-left: 4px solid #e74c3c;
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
            <div class="info-value">{{ $formB->tahun }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Status:</div>
            <div class="info-value">
                {{ $formB->status }}
                <span class="status-badge {{ $formB->status == 'Lulus' ? 'status-lulus' : 'status-dihantar' }}">
                    {{ $formB->status }}
                </span>
            </div>
        </div>
    </div>

    <div class="section-title">Maklumat Pemilik/Pengurus</div>
    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Nama:</div>
            <div class="info-value">{{ $formB->nama_pemilik }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">No. KP/Passport:</div>
            <div class="info-value">{{ $formB->no_kp_passport }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Alamat:</div>
            <div class="info-value">
                {{ $formB->alamat_pemilik_1 }}<br>
                {{ $formB->alamat_pemilik_2 }}<br>
                {{ $formB->alamat_pemilik_poskod }} {{ $formB->alamat_pemilik_daerah }}
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">No. Telefon:</div>
            <div class="info-value">{{ $formB->no_telefon_pemilik }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">No. Faks:</div>
            <div class="info-value">{{ $formB->no_faks_pemilik }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Email:</div>
            <div class="info-value">{{ $formB->email_pemilik }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Jawatan:</div>
            <div class="info-value">{{ $formB->jawatan_pemilik }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tarikh Lantikan:</div>
            <div class="info-value">{{ $formB->tarikh_lantikan ? date('d/m/Y', strtotime($formB->tarikh_lantikan)) : '-' }}</div>
        </div>
    </div>

    <div class="section-title">Maklumat Wakil Syarikat</div>
    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Nama:</div>
            <div class="info-value">{{ $formB->nama_wakil }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">No. KP/Passport:</div>
            <div class="info-value">{{ $formB->no_kp_wakil }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Alamat:</div>
            <div class="info-value">
                {{ $formB->alamat_wakil_1 }}<br>
                {{ $formB->alamat_wakil_2 }}<br>
                {{ $formB->alamat_wakil_poskod }} {{ $formB->alamat_wakil_daerah }}
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">No. Telefon:</div>
            <div class="info-value">{{ $formB->no_telefon_wakil }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">No. Faks:</div>
            <div class="info-value">{{ $formB->no_faks_wakil }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Email:</div>
            <div class="info-value">{{ $formB->email_wakil }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Jawatan:</div>
            <div class="info-value">{{ $formB->jawatan_wakil }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tarikh Lantikan:</div>
            <div class="info-value">{{ $formB->tarikh_lantikan_wakil ? date('d/m/Y', strtotime($formB->tarikh_lantikan_wakil)) : '-' }}</div>
        </div>
    </div>

    <div class="footer">
        Dicetak pada: {{ $print_date }}
    </div>
</body>
</html>
