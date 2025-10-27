@extends('layouts/basic')

{{-- Page content --}}
@section('content')

    <div class="login-card">
        <!-- Login Header -->
        <div class="login-header">
            <div class="login-logo">
                @if ($snipeSettings && $snipeSettings->logo != '')
                    <img src="{{ Storage::disk('public')->url(e($snipeSettings->logo)) }}"
                        alt="{{ $snipeSettings->site_name ?? 'Logo' }}">
                @else
                    <i class="fas fa-shield-alt" style="font-size: 50px; color: white;"></i>
                @endif
            </div>
            <h1>{{ $snipeSettings->site_name ?? 'Snipe-IT' }}</h1>
            <p>{{ trans('auth/general.login_prompt') ?? 'Sign in to your account' }}</p>
        </div>

        <!-- Login Body -->
        <div class="login-body">
            <form role="form" action="{{ url('/login') }}" method="POST"
                autocomplete="{{ config('auth.login_autocomplete') === true ? 'on' : 'off' }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <!-- Chrome autofill prevention -->
                <input type="text" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;"
                    aria-hidden="true">
                <input type="password" name="password_fake" id="password_fake" value="" style="display:none;"
                    aria-hidden="true">

                <!-- Google Login -->
                @if (
                    $snipeSettings->google_login == '1' &&
                        $snipeSettings->google_client_id != '' &&
                        $snipeSettings->google_client_secret != '')
                    <a href="{{ route('google.redirect') }}" class="btn-google">
                        <i class="fa-brands fa-google" style="font-size: 18px;"></i>
                        <span>{{ trans('auth/general.google_login') }}</span>
                    </a>
                    <div style="display:flex;align-items:center;gap:12px;margin:20px 0;">
                        <div style="height:1px;background:#e5e7eb;flex:1"></div>
                        <div style="font-size:12px;color:#9ca3af;font-weight:500;">{{ strtoupper(trans('general.or')) }}
                        </div>
                        <div style="height:1px;background:#e5e7eb;flex:1"></div>
                    </div>
                @endif

                @if (!config('app.require_saml'))
                    <fieldset name="login" aria-label="login">
                        <legend></legend>

                        <!-- Username Field -->
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }} login-field">
                            <label for="username">
                                <i class="fas fa-user" style="margin-right: 6px; color: #9ca3af;"></i>
                                {{ trans('admin/users/table.username') }}
                            </label>
                            <div class="input-wrap">
                                <input class="form-control login-input"
                                    placeholder="{{ trans('admin/users/table.username') }}" name="username" type="text"
                                    id="username"
                                    autocomplete="{{ config('auth.login_autocomplete') === true ? 'on' : 'off' }}"
                                    autofocus>
                            </div>
                            {!! $errors->first(
                                'username',
                                '<span class="alert-msg"><i class="fas fa-exclamation-circle"></i> :message</span>',
                            ) !!}
                        </div>

                        <!-- Password Field -->
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} login-field">
                            <label for="password">
                                <i class="fas fa-lock" style="margin-right: 6px; color: #9ca3af;"></i>
                                {{ trans('admin/users/table.password') }}
                            </label>
                            <div class="input-wrap">
                                <input class="form-control login-input"
                                    placeholder="{{ trans('admin/users/table.password') }}" name="password" type="password"
                                    id="password"
                                    autocomplete="{{ config('auth.login_autocomplete') === true ? 'on' : 'off' }}">
                                <span class="icon-right"
                                    onclick="(function(){const el=document.getElementById('password'); const ico=this.querySelector('i'); const show=el.type==='password'; el.type=show?'text':'password'; ico.classList.toggle('fa-eye', !show); ico.classList.toggle('fa-eye-slash', show);}).call(this)"
                                    style="cursor:pointer">
                                    <i class="fa-regular fa-eye-slash"></i>
                                </span>
                            </div>
                            {!! $errors->first(
                                'password',
                                '<span class="alert-msg"><i class="fas fa-exclamation-circle"></i> :message</span>',
                            ) !!}
                        </div>

                        <!-- Remember Me -->
                        <div class="form-group login-field" style="margin-bottom: 24px;">
                            <label class="switch">
                                <input name="remember" type="checkbox" value="1" id="remember">
                                <span>{{ trans('auth/general.remember_me') }}</span>
                            </label>
                        </div>
                    </fieldset>
                @endif

                <!-- SAML Login Link -->
                @if (!config('app.require_saml') && $snipeSettings->saml_enabled)
                    <div style="text-align: center; margin-bottom: 20px;">
                        <a href="{{ route('saml.login') }}"
                            style="color: #667eea; text-decoration: none; font-size: 14px; font-weight: 500;">
                            {{ trans('auth/general.saml_login') }}
                        </a>
                    </div>
                @endif

                <!-- Submit Button -->
                @if (config('app.require_saml'))
                    <a class="btn btn-primary btn-block" href="{{ route('saml.login') }}">
                        {{ trans('auth/general.saml_login') }}
                    </a>
                @else
                    <button class="btn btn-primary btn-block" type="submit" id="submit">
                        <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>
                        {{ trans('auth/general.login') }}
                    </button>
                @endif

                <!-- Login Note -->
                @if ($snipeSettings->login_note)
                    <div class="alert alert-info">
                        {!! Helper::parseEscapedMarkedown($snipeSettings->login_note) !!}
                    </div>
                @endif

                <!-- Error Notifications Only (no success messages) -->
                @if (session('error') || $errors->count() > 0)
                    @if (session('error'))
                        <div class="alert alert-danger" style="margin-top: 15px;">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        </div>
                    @endif
                @endif
            </form>
        </div>
    </div>

@stop
