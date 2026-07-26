<!DOCTYPE html>
<html lang="ms" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Kawalan Sistem - SISTEM eSHUTTLE</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo.png') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #1c1f26;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container { max-width: 560px; width: 100%; }

        .card {
            background: #ffffff;
            border-radius: 16px;
            padding: 44px 40px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.35);
        }

        h1 {
            font-size: 22px;
            font-weight: 700;
            color: #1c1f26;
            margin-bottom: 4px;
        }

        .subtitle {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 28px;
        }

        .status-box {
            border-radius: 10px;
            padding: 18px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .status-box.unlocked { background: #e7f1ea; border: 1px solid #a8d5b8; }
        .status-box.locked { background: #f8d7da; border: 1px solid #d98a91; }

        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .status-box.unlocked .status-dot { background: #276548; }
        .status-box.locked .status-dot { background: #91403f; }

        .status-text { flex: 1; }
        .status-label { font-size: 15px; font-weight: 700; }
        .status-box.unlocked .status-label { color: #1a472a; }
        .status-box.locked .status-label { color: #4a1a1a; }
        .status-meta { font-size: 12px; color: #6c757d; margin-top: 2px; }

        .flash {
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 13px;
            margin-bottom: 20px;
        }
        .flash.success { background: #e7f1ea; color: #1a472a; border: 1px solid #a8d5b8; }
        .flash.error { background: #f8d7da; color: #4a1a1a; border: 1px solid #d98a91; }

        .key-box {
            background: #1c1f26;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 24px;
            text-align: center;
        }
        .key-box .key-label {
            font-size: 11px;
            color: #9aa1ab;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 8px;
        }
        .key-box .key-value {
            font-family: 'Courier New', monospace;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 2px;
            color: #f4d35e;
        }

        label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #1c1f26;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
            margin-top: 14px;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 11px 14px;
            font-size: 14px;
            font-family: inherit;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            outline: none;
        }
        input[type="text"]:focus, textarea:focus { border-color: #91403f; }
        textarea { resize: vertical; min-height: 60px; }

        button {
            width: 100%;
            padding: 14px;
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 18px;
            transition: opacity 0.15s ease;
        }
        button:hover { opacity: 0.9; }

        button.lock-btn { background: linear-gradient(135deg, #6a2d2d, #91403f); }
        button.unlock-btn { background: linear-gradient(135deg, #1a472a, #2d6a4f); }

        .hint {
            font-size: 12px;
            color: #9aa1ab;
            margin-top: 8px;
        }

        .footer-text {
            margin-top: 24px;
            font-size: 11px;
            color: #adb5bd;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Kawalan Sistem</h1>
            <p class="subtitle">Pautan peribadi — jangan kongsi dengan sesiapa.</p>

            @if (session('success'))
                <div class="flash success">{{ session('success') }}</div>
            @endif
            @error('panel')
                <div class="flash error">{{ $message }}</div>
            @enderror

            @if ($license->is_locked)
                <div class="status-box locked">
                    <div class="status-dot"></div>
                    <div class="status-text">
                        <div class="status-label">Sistem Dikunci</div>
                        <div class="status-meta">
                            Sejak {{ $license->locked_at ? $license->locked_at->format('d/m/Y, h:i A') : '-' }}
                            @if ($license->locked_reason)
                                &middot; {{ $license->locked_reason }}
                            @endif
                        </div>
                    </div>
                </div>

                @if ($key)
                    <div class="key-box">
                        <div class="key-label">Kod Akses Awam (pilihan untuk diberi kepada orang lain)</div>
                        <div class="key-value">{{ $key }}</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('system-control.unlock', $token) }}">
                    @csrf
                    <button type="submit" class="unlock-btn">Buka Sistem Sekarang</button>
                </form>
                <p class="hint">
                    @if ($key)
                        Butang ini membuka terus tanpa perlu menaip kod di atas.
                    @else
                        Klik untuk membuka terus. (Kod akses awam tidak tersedia kerana LICENSE_SECRET belum ditetapkan — tidak diperlukan untuk guna panel ini.)
                    @endif
                </p>
            @else
                <div class="status-box unlocked">
                    <div class="status-dot"></div>
                    <div class="status-text">
                        <div class="status-label">Sistem Aktif</div>
                        <div class="status-meta">
                            @if ($license->unlocked_at)
                                Terakhir dibuka {{ $license->unlocked_at->format('d/m/Y, h:i A') }}
                            @else
                                Boleh diakses seperti biasa
                            @endif
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('system-control.lock', $token) }}">
                    @csrf
                    <label for="reason">Sebab (peribadi sahaja, tidak dipaparkan)</label>
                    <input type="text" id="reason" name="reason" placeholder="cth: Bayaran tertunggak">

                    <label for="message">Mesej dipaparkan kepada pengguna (pilihan)</label>
                    <textarea id="message" name="message" placeholder="Biar kosong untuk mesej lalai"></textarea>

                    <button type="submit" class="lock-btn">Kunci Sistem Sekarang</button>
                </form>
            @endif

            <p class="footer-text">&copy; {{ date('Y') }} SISTEM eSHUTTLE</p>
        </div>
    </div>
</body>
</html>
