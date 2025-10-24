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
    style="min-height:100vh; {{ $bg ? 'background:url(' . $bg . ') center/cover no-repeat fixed;' : '' }}">

    @yield('content')

    <script src="{{ url(mix('js/dist/all.js')) }}" nonce="{{ csrf_token() }}"></script>
    @stack('js')
</body>

</html>
