@extends('layouts/basic')


{{-- Page content --}}
@section('content')

    <form role="form" action="{{ url('/login') }}" method="POST" autocomplete="{{ (config('auth.login_autocomplete') === true) ? 'on' : 'off'  }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />


        <!-- this is a hack to prevent Chrome from trying to autocomplete fields -->
        <input type="text" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" aria-hidden="true">
        <input type="password" name="password_fake" id="password_fake" value="" style="display:none;" aria-hidden="true">

        <div>

                    @if (($snipeSettings->google_login=='1') && ($snipeSettings->google_client_id!='') && ($snipeSettings->google_client_secret!=''))
                        <a href="{{ route('google.redirect')  }}" class="btn btn-google btn-block" style="margin-bottom:12px;">
                            <i class="fa-brands fa-google"></i>
                            {{ trans('auth/general.google_login') }}
                        </a>
                        <div style="display:flex;align-items:center;gap:12px;margin:8px 0 16px;opacity:.8">
                            <div style="height:1px;background:#e5e7eb;flex:1"></div>
                            <div style="font-size:12px;color:#6b7280;">{{ strtoupper(trans('general.or')) }}</div>
                            <div style="height:1px;background:#e5e7eb;flex:1"></div>
                        </div>
                    @endif

                    {{-- Title already displayed in the layout header; omit duplicate to keep it clean --}}

                    <div class="login-box-body" style="background:transparent;padding:0;">
                            <div class="row">

                                @if ($snipeSettings->login_note)
                                    <div class="col-md-12">
                                        <div class="alert alert-info">
                                            {!!  Helper::parseEscapedMarkedown($snipeSettings->login_note)  !!}
                                        </div>
                                    </div>
                                @endif

                                <!-- Notifications -->
                                @include('notifications')

                                @if (!config('app.require_saml'))
                                <div class="col-md-12">
                                    <!-- CSRF Token -->


                                    <fieldset name="login" aria-label="login">
                                        <legend></legend>

                                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }} login-field">
                                            <label for="username">
                                                {{ trans('admin/users/table.username')  }}
                                            </label>
                                            <div class="input-wrap">
                                                <input class="form-control login-input" placeholder="{{ trans('admin/users/table.username')  }}" name="username" type="text" id="username" autocomplete="{{ (config('auth.login_autocomplete') === true) ? 'on' : 'off'  }}" autofocus>
                                            </div>
                                            {!! $errors->first('username', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                                        </div>
                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} login-field" style="margin-top:6px;">
                                            <label for="password">
                                                {{ trans('admin/users/table.password')  }}
                                            </label>
                                            <div class="input-wrap">
                                                <input class="form-control login-input" placeholder="{{ trans('admin/users/table.password')  }}" name="password" type="password" id="password" autocomplete="{{ (config('auth.login_autocomplete') === true) ? 'on' : 'off'  }}">
                                                <span class="icon-right" onclick="(function(){const el=document.getElementById('password'); const ico=this.querySelector('i'); const show=el.type==='password'; el.type=show?'text':'password'; ico.classList.toggle('fa-eye', !show); ico.classList.toggle('fa-eye-slash', show);}).call(this)" style="cursor:pointer"><i class="fa-regular fa-eye-slash"></i></span>
                                            </div>
                                            {!! $errors->first('password', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                                        </div>
                                        <div class="form-group" style="margin-top:6px;display:flex;align-items:center;justify-content:space-between;">
                                            <label class="switch" style="user-select:none;">
                                                <input name="remember" type="checkbox" value="1" id="remember">
                                                <span>{{ trans('auth/general.remember_me')  }}</span>
                                            </label>
                                        </div>
                                    </fieldset>
                                </div> <!-- end col-md-12 -->
                                @endif
                            </div> <!-- end row -->

                            @if (!config('app.require_saml') && $snipeSettings->saml_enabled)
                            <div class="row">
                                <div class="text-right col-md-12">
                                    <a href="{{ route('saml.login')  }}">{{ trans('auth/general.saml_login')  }}</a>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="box-footer" style="background:transparent;border:none;padding-top:12px;">
                            @if (config('app.require_saml'))
                                <a class="btn btn-primary btn-block" href="{{ route('saml.login')  }}">{{ trans('auth/general.saml_login')  }}</a>
                            @else
                                <button class="btn btn-primary btn-block" type="submit" id="submit" style="height:44px;">
                                    {{ trans('auth/general.login')  }}
                                </button>
                            @endif

                            {{-- Forgot password link intentionally removed per branding request --}}

                        </div>

                    </div> <!-- end login box -->
        </div>
    </form>

@stop