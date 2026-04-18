<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — E-Rapor PKBM</title>
    <meta name="description" content="Login ke sistem E-Rapor PKBM - Pusat Kegiatan Belajar Masyarakat">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #c8d0e0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 900px;
            min-height: 500px;
            border-radius: 24px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            background: #dce4f0;
            padding: 36px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .logo-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            border-radius: 50px;
            padding: 8px 18px;
            width: fit-content;
            font-size: 13px;
            font-weight: 500;
            color: #1a1a2e;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .logo-badge svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .left-content {
            padding: 20px 0;
        }

        .left-title {
            font-size: 32px;
            font-weight: 800;
            color: #1a1a2e;
            letter-spacing: -0.5px;
            margin-bottom: 14px;
            line-height: 1.2;
        }

        .left-desc {
            font-size: 13.5px;
            color: #4a5568;
            line-height: 1.7;
            max-width: 300px;
            text-align: justify;
        }

        .left-footer {
            font-size: 12px;
            color: #4a5568;
            line-height: 1.6;
        }

        /* ── RIGHT PANEL ── */
        .right-panel {
            background: #a8b4cc;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a2e;
        }

        .form-group input {
            width: 100%;
            height: 46px;
            background: #fff;
            border: 2px solid transparent;
            border-radius: 8px;
            padding: 0 16px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #1a1a2e;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            border-color: #4a6fa5;
        }

        .form-group input.is-invalid {
            border-color: #e53e3e;
        }

        .error-msg {
            font-size: 12px;
            color: #c53030;
            margin-top: 4px;
            background: rgba(197,48,48,0.1);
            border-radius: 6px;
            padding: 6px 10px;
        }

        .btn-login {
            width: 120px;
            height: 44px;
            background: #fff;
            color: #1a1a2e;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1px;
            cursor: pointer;
            align-self: center;
            margin-top: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        }

        .btn-login:hover {
            background: #1a1a2e;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        @media (max-width: 640px) {
            .login-card { grid-template-columns: 1fr; }
            .left-panel { padding: 28px 24px; }
            .right-panel { padding: 36px 24px; }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <!-- LEFT PANEL -->
        <div class="left-panel">
            <div class="logo-badge">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3L2 8L12 13L22 8L12 3Z" fill="#1a1a2e"/>
                    <path d="M2 8V16M22 8V16M6 10.5V17C6 17 8 20 12 20C16 20 18 17 18 17V10.5" stroke="#1a1a2e" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Pusat Kegiatan Belajar Masyarakat
            </div>

            <div class="left-content">
                <h1 class="left-title">E-RAPOR PKBM</h1>
                <p class="left-desc">
                    Pusat pendidikan non-formal untuk meningkatkan pengetahuan
                    dan keterampilan masyarakat.
                </p>
            </div>

            <div class="left-footer">
                Jika ada kendala silahkan hubungi nomor dibawah ini<br>
                08XX-XXXX-XXXX
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="right-panel">
            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        autocomplete="username"
                        class="{{ $errors->has('username') ? 'is-invalid' : '' }}"
                        required
                    >
                    @error('username')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: 8px;">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="current-password"
                        required
                    >
                    @error('password')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display:flex; justify-content:center; margin-top: 28px;">
                    <button type="submit" class="btn-login">LOGIN</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
