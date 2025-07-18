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
            <div class="info-value">{{ $formD->tahun }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Status:</div>
            <div class="info-value">
                {{ $formD->status }}
                <span class="status-badge {{ $formD->status == 'Lulus' ? 'status-lulus' : 'status-dihantar' }}">
                    {{ $formD->status }}
                </span>
            </div>
        </div>
    </div>

    <div class="section-title">Maklumat Pekerja</div>
    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Bilangan Pekerja Tetap:</div>
            <div class="info-value">{{ $formD->bilangan_pekerja_tetap ?? 0 }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Bilangan Pekerja Sambilan:</div>
            <div class="info-value">{{ $formD->bilangan_pekerja_sambilan ?? 0 }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Bilangan Pekerja Kontrak:</div>
            <div class="info-value">{{ $formD->bilangan_pekerja_kontrak ?? 0 }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Jumlah Pekerja:</div>
            <div class="info-value">{{ ($formD->bilangan_pekerja_tetap ?? 0) + ($formD->bilangan_pekerja_sambilan ?? 0) + ($formD->bilangan_pekerja_kontrak ?? 0) }}</div>
        </div>
    </div>

    <div class="section-title">Maklumat Gaji</div>
    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Jumlah Gaji Bulanan:</div>
            <div class="info-value">RM {{ number_format($formD->jumlah_gaji_bulanan ?? 0, 2) }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Jumlah Gaji Tahunan:</div>
            <div class="info-value">RM {{ number_format($formD->jumlah_gaji_tahunan ?? 0, 2) }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Bonus Tahunan:</div>
            <div class="info-value">RM {{ number_format($formD->bonus_tahunan ?? 0, 2) }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Jumlah Keseluruhan:</div>
            <div class="info-value">RM {{ number_format(($formD->jumlah_gaji_tahunan ?? 0) + ($formD->bonus_tahunan ?? 0), 2) }}</div>
        </div>
    </div>

    <div class="section-title">Maklumat Kemudahan</div>
    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Kemudahan Perubatan:</div>
            <div class="info-value">{{ $formD->kemudahan_perubatan ?? 'Tidak Dinyatakan' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Kemudahan Latihan:</div>
            <div class="info-value">{{ $formD->kemudahan_latihan ?? 'Tidak Dinyatakan' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Kemudahan Keselamatan:</div>
            <div class="info-value">{{ $formD->kemudahan_keselamatan ?? 'Tidak Dinyatakan' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Kemudahan Rekreasi:</div>
            <div class="info-value">{{ $formD->kemudahan_rekreasi ?? 'Tidak Dinyatakan' }}</div>
        </div>
    </div>

    <div class="section-title">Maklumat Tambahan</div>
    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Jam Kerja Sehari:</div>
            <div class="info-value">{{ $formD->jam_kerja_sehari ?? 0 }} jam</div>
        </div>
        <div class="info-row">
            <div class="info-label">Hari Kerja Seminggu:</div>
            <div class="info-value">{{ $formD->hari_kerja_seminggu ?? 0 }} hari</div>
        </div>
        <div class="info-row">
            <div class="info-label">Cuti Tahunan:</div>
            <div class="info-value">{{ $formD->cuti_tahunan ?? 0 }} hari</div>
        </div>
        <div class="info-row">
            <div class="info-label">Sistem Kerja:</div>
            <div class="info-value">{{ $formD->sistem_kerja ?? 'Tidak Dinyatakan' }}</div>
        </div>
    </div>

    <div class="footer">
        Dicetak pada: {{ $print_date }}
    </div>
</body>
</html>
