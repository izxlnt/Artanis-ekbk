<!DOCTYPE html>
<html lang="ms" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akses Sistem Disekat - SISTEM eSHUTTLE</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo.png') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4a1a1a 0%, #6a2d2d 40%, #91403f 70%, #b85252 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 560px;
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
            background: linear-gradient(90deg, #4a1a1a, #91403f, #c96b6b);
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
            background: linear-gradient(135deg, #f8d7da, #f1b0b7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
        }

        .icon-wrapper svg {
            width: 44px;
            height: 44px;
            color: #6a2d2d;
        }

        .badge {
            display: inline-block;
            background: #f8d7da;
            color: #6a2d2d;
            border: 1px solid #d98a91;
            border-radius: 20px;
            padding: 5px 16px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 26px;
            font-weight: 700;
            color: #4a1a1a;
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

        form {
            text-align: left;
        }

        label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #4a1a1a;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 8px;
        }

        input[type="text"] {
            width: 100%;
            padding: 14px 16px;
            font-size: 16px;
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
            text-align: center;
            text-transform: uppercase;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            margin-bottom: 8px;
            outline: none;
            transition: border-color 0.15s ease;
        }

        input[type="text"]:focus {
            border-color: #91403f;
        }

        .error-text {
            color: #91403f;
            font-size: 13px;
            margin-bottom: 16px;
        }

        button {
            width: 100%;
            padding: 14px;
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
            background: linear-gradient(135deg, #6a2d2d, #91403f);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 12px;
            transition: opacity 0.15s ease;
        }

        button:hover {
            opacity: 0.9;
        }

        .footer-text {
            margin-top: 32px;
            font-size: 12px;
            color: #adb5bd;
            text-align: center;
        }

        @media (max-width: 480px) {
            .card {
                padding: 36px 24px;
            }

            h1 {
                font-size: 21px;
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
            </div>

            <span class="badge">&#128274; Akses Disekat</span>

            <h1>Sistem Tidak Dapat Diakses</h1>

            <p class="subtitle">
                {{ $lockedMessage ?? 'Akses kepada sistem ini telah disekat buat sementara waktu. Sila hubungi pihak pentadbir sistem untuk maklumat lanjut.' }}
            </p>

            <hr class="divider">

            <form method="POST" action="{{ route('system-locked.unlock') }}">
                @csrf
                <label for="unlock_key">Kod Akses</label>
                <input type="text" id="unlock_key" name="unlock_key" placeholder="XXXX-XXXX-XXXX-XXXX" autocomplete="off" autofocus>
                @error('unlock_key')
                    <div class="error-text">{{ $message }}</div>
                @enderror
                <button type="submit">Buka Sistem</button>
            </form>

            <p class="footer-text">
                &copy; {{ date('Y') }} <strong>SISTEM eSHUTTLE</strong>
            </p>
        </div>
    </div>
</body>
</html>
