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
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(25px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .login-header {
            background: linear-gradient(135deg, rgba(60, 141, 188, 0.75) 0%, rgba(44, 110, 159, 0.75) 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
            backdrop-filter: blur(10px);
        }

        .login-logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 15px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            overflow: hidden;
            padding: 10px;
        }

        .login-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
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
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .login-field {
            margin-bottom: 20px;
        }

        .login-field label {
            display: block;
            margin-bottom: 8px;
            color: #1f2937;
            font-weight: 600;
            font-size: 14px;
        }

        .input-wrap {
            position: relative;
        }

        .login-input {
            width: 100%;
            height: 48px;
            padding: 12px 16px;
            border: 2px solid rgba(229, 231, 235, 0.5);
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(5px);
        }

        .login-input:focus {
            outline: none;
            border-color: #3c8dbc;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 4px rgba(60, 141, 188, 0.15);
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
            color: #3c8dbc;
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
            accent-color: #3c8dbc;
        }

        .btn-primary {
            width: 100%;
            height: 50px;
            background: linear-gradient(135deg, #3c8dbc 0%, #2c6e9f 100%) !important;
            border: none !important;
            border-radius: 12px;
            color: white !important;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(60, 141, 188, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(60, 141, 188, 0.5);
            background: linear-gradient(135deg, #337ca8 0%, #255a82 100%) !important;
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-google {
            width: 100%;
            height: 48px;
            background: rgba(255, 255, 255, 0.7) !important;
            border: 2px solid rgba(229, 231, 235, 0.5) !important;
            border-radius: 12px;
            color: #374151 !important;
            font-size: 15px;
            font-weight: 500;
            display: flex !important;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none !important;
            backdrop-filter: blur(5px);
        }

        .btn-google:hover {
            background: rgba(255, 255, 255, 0.9) !important;
            border-color: #3c8dbc !important;
            color: #3c8dbc !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(60, 141, 188, 0.3);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-top: 15px;
            font-size: 14px;
        }

        .alert-info {
            background: #dbeafe !important;
            border: 1px solid #93c5fd !important;
            color: #1e40af !important;
        }

        .alert-success {
            background: #d1fae5 !important;
            border: 1px solid #6ee7b7 !important;
            color: #047857 !important;
        }

        .alert-danger {
            background: #fee2e2 !important;
            border: 1px solid #fca5a5 !important;
            color: #dc2626 !important;
        }

        .alert-warning {
            background: #fef3c7 !important;
            border: 1px solid #fcd34d !important;
            color: #d97706 !important;
        }

        .alert-msg {
            display: block;
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
        }

        .has-error .login-input {
            border-color: #ef4444 !important;
            background: #fef2f2 !important;
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
</head>

@php $bg = ($snipeSettings && $snipeSettings->login_background) ? Storage::disk('public')->url(e($snipeSettings->login_background)) : null; @endphp

<body class="hold-transition login-page"
    style="min-height:100vh; margin:0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; {{ $bg ? 'background:url(' . $bg . ') center/cover no-repeat fixed;' : 'background: linear-gradient(135deg, #3c8dbc 0%, #2c6e9f 100%);' }}">

    <div class="login-container">
        @yield('content')
    </div>

    <script src="{{ url(mix('js/dist/all.js')) }}" nonce="{{ csrf_token() }}"></script>
    @stack('js')
</body>

</html>
