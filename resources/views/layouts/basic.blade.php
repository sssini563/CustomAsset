<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <style>
        :root {
            --accent: {{ $snipeSettings->header_color ?? '#0ea5b7' }};
            --card-bg: rgba(255,255,255,0.78);
            --text-900: #111827; /* gray-900 */
            --text-600: #4b5563; /* gray-600 */
        }
        body.login-page:before {
            content: '';
            position: fixed; inset: 0; pointer-events: none; z-index: 0;
            background: radial-gradient(1200px 600px at 20% -10%, rgba(0,0,0,.35), transparent 60%),
                        radial-gradient(800px 400px at 120% 110%, rgba(0,0,0,.25), transparent 60%),
                        linear-gradient(rgba(0,0,0,.25), rgba(0,0,0,.25));
        }
        .login-card {
            width:100%; max-width:440px; background:var(--card-bg); border-radius:18px;
            box-shadow:0 20px 40px rgba(0,0,0,.35); overflow:hidden; position:relative; z-index:1;
            border:1px solid rgba(255,255,255,.35);
        }
    .login-title { font-weight:700; font-size:20px; color:var(--text-900); margin-top:6px; letter-spacing:.2px; }
        .login-sub { color:var(--text-600); font-size:13px; margin-top:2px; }
    .login-input { border-radius:12px; border:1px solid #e5e7eb; padding:12px 44px 12px 44px; height:auto; }
        .login-input:focus { outline:none; border-color: var(--accent); box-shadow:0 0 0 4px color-mix(in srgb, var(--accent) 25%, transparent); }
    .login-field { margin-bottom:12px; }
    .input-wrap { position:relative; }
    .input-wrap .icon-left { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#9ca3af; }
    .input-wrap .icon-right { position:absolute; right:10px; top:50%; transform:translateY(-50%); color:#9ca3af; }
    .btn-primary { background: var(--accent); border-color: var(--accent); border-radius:12px; padding:10px 14px; font-weight:700; box-shadow:0 6px 16px color-mix(in srgb, var(--accent) 25%, transparent); }
        .btn-primary:hover { filter: brightness(0.95); }
        .btn-google { background:#fff; color:#1f2937; border-radius:12px; border:1px solid #e5e7eb; padding:10px 14px; font-weight:600; }
        .btn-google:hover { background:#f9fafb; }
        .switch { display:inline-flex; align-items:center; gap:8px; cursor:pointer; }
        .switch input { appearance:none; width:38px; height:22px; background:#e5e7eb; border-radius:999px; position:relative; outline:none; transition:.2s; }
        .switch input:checked { background:var(--accent); }
        .switch input:before { content:''; position:absolute; width:18px; height:18px; top:2px; left:2px; background:#fff; border-radius:50%; transition:.2s; box-shadow:0 1px 2px rgba(0,0,0,.25); }
        .switch input:checked:before { transform:translateX(16px); }
        .help-link a { color:#f3f4f6; }
        .help-link a:hover { text-decoration:underline; }
    </style>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ ($snipeSettings) && ($snipeSettings->site_name) ? $snipeSettings->site_name : 'Snipe-IT' }}</title>

    <link rel="shortcut icon" type="image/ico" href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->favicon)) : config('app.url').'/favicon.ico' }}">
    {{-- stylesheets --}}
    <link rel="stylesheet" href="{{ url(mix('css/dist/all.css')) }}">

    <script nonce="{{ csrf_token() }}">
        window.snipeit = {
            settings: {
                "per_page": 50
            }
        };
    </script>


    @if (($snipeSettings) && ($snipeSettings->header_color))
        <style>
        .main-header .navbar, .main-header .logo {
        background-color: {{ $snipeSettings->header_color }};
        background: -webkit-linear-gradient(top,  {{ $snipeSettings->header_color }} 0%,{{ $snipeSettings->header_color }} 100%);
        background: linear-gradient(to bottom, {{ $snipeSettings->header_color }} 0%,{{ $snipeSettings->header_color }} 100%);
        border-color: {{ $snipeSettings->header_color }};
        }
        .skin-blue .sidebar-menu > li:hover > a, .skin-blue .sidebar-menu > li.active > a {
        border-left-color: {{ $snipeSettings->header_color }};
        }
        </style>
    @endif

    @if (($snipeSettings) && ($snipeSettings->custom_css))
        <style>
            {!! $snipeSettings->show_custom_css() !!}
        </style>
    @endif

</head>

@php $bg = ($snipeSettings && $snipeSettings->login_background) ? Storage::disk('public')->url(e($snipeSettings->login_background)) : null; @endphp
<body class="hold-transition login-page" style="min-height:100vh; overflow:hidden; {{ $bg ? 'background:url('.$bg.') center/cover no-repeat fixed;' : 'background:linear-gradient(120deg,#0f2027,#203a43,#2c5364);' }}">

    <div style="display:flex;align-items:center;justify-content:center;min-height:100vh;padding:24px;">
        <div class="login-card" style="backdrop-filter:saturate(180%) blur(8px)">
            <div style="padding:24px 24px 0; text-align:center;">
                @if (($snipeSettings) && ($snipeSettings->logo!=''))
                    <a href="{{ config('app.url') }}">
                        <img id="login-logo" style="max-height:100px;object-fit:contain" src="{{ Storage::disk('public')->url('').e($snipeSettings->logo) }}" alt="{{ $snipeSettings->site_name }}">
                    </a>
                @endif
                <div class="login-title">{{ $snipeSettings->site_name ?? 'Welcome' }}</div>
                <div class="login-sub">Masuk untuk melanjutkan</div>
            </div>
            <div style="padding:24px;">
                <!-- Content -->
                @yield('content')
            </div>
        </div>
    </div>

    <div class="text-center help-link" style="padding: 20px; color: #f9fafb;">
        @if (($snipeSettings) && ($snipeSettings->privacy_policy_link!=''))
        <a target="_blank" rel="noopener" href="{{  $snipeSettings->privacy_policy_link }}" target="_new">{{ trans('admin/settings/general.privacy_policy') }}</a>
    @endif
    </div>

    {{-- Javascript files --}}
    <script src="{{ url(mix('js/dist/all.js')) }}" nonce="{{ csrf_token() }}"></script>


    @stack('js')
</body>

</html>
