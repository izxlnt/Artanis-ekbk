<!DOCTYPE html>
<html lang="ms" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Penyelenggaraan Sistem - SISTEM eSHUTTLE</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo.png') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a472a 0%, #2d6a4f 40%, #40916c 70%, #52b788 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 680px;
            width: 100%;
        }

        .card {
            background: #ffffff;
            border-radius: 16px;
            padding: 50px 48px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.25);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #1a472a, #40916c, #74c69d);
        }

        .logo-wrapper {
            margin-bottom: 28px;
        }

        .logo-wrapper img {
            height: 64px;
            object-fit: contain;
        }

        .icon-wrapper {
            width: 96px;
            height: 96px;
            background: linear-gradient(135deg, #d8f3dc, #b7e4c7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            animation: pulse 2.5s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(64, 145, 108, 0.3); }
            50% { transform: scale(1.05); box-shadow: 0 0 0 12px rgba(64, 145, 108, 0); }
        }

        .icon-wrapper svg {
            width: 48px;
            height: 48px;
            color: #2d6a4f;
        }

        .badge {
            display: inline-block;
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffc107;
            border-radius: 20px;
            padding: 5px 16px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1a472a;
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .subtitle {
            font-size: 15px;
            color: #6c757d;
            margin-bottom: 32px;
            line-height: 1.7;
        }

        .divider {
            border: none;
            border-top: 1px solid #e9ecef;
            margin: 28px 0;
        }

        .info-box {
            background: #f8fffe;
            border: 1px solid #d8f3dc;
            border-radius: 10px;
            padding: 20px 24px;
            margin-bottom: 28px;
            text-align: left;
        }

        .info-box p {
            font-size: 14px;
            color: #495057;
            line-height: 1.7;
            margin-bottom: 6px;
        }

        .info-box p:last-child {
            margin-bottom: 0;
        }

        .info-box strong {
            color: #1a472a;
        }

        .date-box {
            background: linear-gradient(135deg, #e9f5ec, #d8f3dc);
            border: 1px solid #b7e4c7;
            border-radius: 10px;
            padding: 18px 24px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            text-align: left;
        }

        .date-box .date-icon {
            font-size: 28px;
            flex-shrink: 0;
        }

        .date-box .date-content {
            flex: 1;
        }

        .date-box .date-label {
            font-size: 11px;
            font-weight: 700;
            color: #2d6a4f;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 4px;
        }

        .date-box .date-range {
            font-size: 14px;
            font-weight: 600;
            color: #1a472a;
        }

        .date-box .date-range span {
            color: #40916c;
            margin: 0 6px;
        }

        .contact-section {
            margin-top: 8px;
        }

        .contact-section p {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 8px;
        }

        .contact-link {
            color: #2d6a4f;
            text-decoration: none;
            font-weight: 600;
        }

        .contact-link:hover {
            text-decoration: underline;
        }

        .footer-text {
            margin-top: 32px;
            font-size: 12px;
            color: #adb5bd;
        }

        .footer-text strong {
            color: #6c757d;
        }

        @media (max-width: 480px) {
            .card {
                padding: 36px 24px;
            }

            h1 {
                font-size: 22px;
            }

            .date-box {
                flex-direction: column;
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">

            <div class="logo-wrapper">
                <img src="{{ asset('logo.png') }}" alt="Logo eSHUTTLE" onerror="this.style.display='none'">
            </div>

            <div class="icon-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l5.653-4.655m5.833-4.329l1.354-1.354a2.652 2.652 0 013.586 3.586l-1.354 1.354M8.834 10.84l-1.77-1.77a2.652 2.652 0 00-3.586 3.586l1.354 1.354" />
                </svg>
            </div>

            <span class="badge">&#9888; Penyelenggaraan Sistem</span>

            <h1>Sistem Sedang Dalam<br>Penyelenggaraan</h1>

            <p class="subtitle">
                {{ $message ?? 'Kami sedang menjalankan kerja-kerja penyelenggaraan bagi memastikan sistem beroperasi dengan lebih baik. Kami memohon maaf atas sebarang kesulitan yang ditimbulkan.' }}
            </p>

            <hr class="divider">

            @if($start || $end)
            <div class="date-box">
                <div class="date-icon">&#128197;</div>
                <div class="date-content">
                    <div class="date-label">Tempoh Penyelenggaraan</div>
                    <div class="date-range">
                        @if($start && $end)
                            {{ \Carbon\Carbon::parse($start)->format('d/m/Y, h:i A') }}
                            <span>&#8594;</span>
                            {{ \Carbon\Carbon::parse($end)->format('d/m/Y, h:i A') }}
                        @elseif($start)
                            Bermula {{ \Carbon\Carbon::parse($start)->format('d/m/Y, h:i A') }}
                        @elseif($end)
                            Dijangka selesai {{ \Carbon\Carbon::parse($end)->format('d/m/Y, h:i A') }}
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <div class="info-box">
                @if($start && $end)
                    <p>&#128337; <strong>Jangkaan masa siap:</strong> {{ \Carbon\Carbon::parse($end)->format('d/m/Y, h:i A') }}</p>
                @else
                    <p>&#128337; <strong>Jangkaan masa siap:</strong> Sistem akan kembali beroperasi tidak lama lagi.</p>
                @endif
                <p>&#128204; <strong>Status:</strong> Kerja-kerja penyelenggaraan sedang berjalan.</p>
                <p>&#128274; <strong>Akses:</strong> Sistem tidak dapat diakses buat sementara waktu.</p>
            </div>

            <div class="contact-section">
                <p>Untuk sebarang pertanyaan, sila hubungi pihak pentadbir sistem:</p>
                <p>
                    <a href="mailto:admin@eshuttle.gov.my" class="contact-link">&#9993; admin@eshuttle.gov.my</a>
                </p>
            </div>

            <p class="footer-text">
                &copy; {{ date('Y') }} <strong>SISTEM eSHUTTLE</strong> &mdash; Institut Penyelidikan Jenis-Jenis Pokok Sabah &amp; Sarawak Malaysia
            </p>

            <p style="margin-top: 16px; font-size: 11px;">
                <a href="/login" style="color: #adb5bd; text-decoration: none;">
                    Pentadbir sistem? <span style="text-decoration: underline;">Log masuk di sini</span>
                </a>
            </p>
        </div>
    </div>
</body>
</html>
