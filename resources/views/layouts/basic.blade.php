<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $snipeSettings && $snipeSettings->site_name ? $snipeSettings->site_name : 'Snipe-IT' }}</title>

    <link rel="shortcut icon" type="image/ico"
        href="{{ $snipeSettings && $snipeSettings->favicon != '' ? Storage::disk('public')->url(e($snipeSettings->favicon)) : config('app.url') . '/favicon.ico' }}">
    <link rel="stylesheet" href="{{ url(mix('css/dist/all.css')) }}">

    @if ($snipeSettings && $snipeSettings->header_color)
        <style>
            .main-header .navbar,
            .main-header .logo {
                background-color: {{ $snipeSettings->header_color }};
                background: -webkit-linear-gradient(top, {{ $snipeSettings->header_color }} 0%, {{ $snipeSettings->header_color }} 100%);
                background: linear-gradient(to bottom, {{ $snipeSettings->header_color }} 0%, {{ $snipeSettings->header_color }} 100%);
                border-color: {{ $snipeSettings->header_color }};
            }

            .sidebar-menu>li:hover>a,
            .sidebar-menu>li.active>a {
                border-left-color: {{ $snipeSettings->header_color }};
            }
        </style>
    @endif

    @if ($snipeSettings && $snipeSettings->custom_css)
        <style>
            {!! $snipeSettings->show_custom_css() !!}
        </style>
    @endif
</head>

@php $bg = ($snipeSettings && $snipeSettings->login_background) ? Storage::disk('public')->url(e($snipeSettings->login_background)) : null; @endphp

<body class="hold-transition login-page"
    style="min-height:100vh; margin:0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; {{ $bg ? 'background:url(' . $bg . ') center/cover no-repeat fixed;' : 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' }}">

    <style>
        .login-page {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            animation: fadeInUp 0.6s ease-out;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            backdrop-filter: blur(10px);
        }

        .login-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .login-header p {
            margin: 8px 0 0;
            font-size: 14px;
            opacity: 0.9;
        }

        .login-body {
            padding: 35px 30px;
        }

        .login-field {
            margin-bottom: 20px;
        }

        .login-field label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 500;
            font-size: 14px;
        }

        .input-wrap {
            position: relative;
        }

        .login-input {
            width: 100%;
            height: 48px;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .login-input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .icon-right {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            transition: color 0.2s;
        }

        .icon-right:hover {
            color: #667eea;
        }

        .switch {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-size: 14px;
            color: #6b7280;
        }

        .switch input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .btn-primary {
            width: 100%;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-google {
            width: 100%;
            height: 48px;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            color: #374151;
            font-size: 15px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-google:hover {
            background: #f9fafb;
            border-color: #667eea;
            color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-info {
            background: #dbeafe;
            border: 1px solid #93c5fd;
            color: #1e40af;
        }

        .alert-msg {
            display: block;
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
        }

        .has-error .login-input {
            border-color: #ef4444;
            background: #fef2f2;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 480px) {
            .login-header {
                padding: 30px 20px;
            }

            .login-body {
                padding: 25px 20px;
            }

            .login-header h1 {
                font-size: 24px;
            }
        }
    </style>

    <div class="login-container">
        @yield('content')
    </div>

    <script src="{{ url(mix('js/dist/all.js')) }}" nonce="{{ csrf_token() }}"></script>
    @stack('js')
</body>

</html>
