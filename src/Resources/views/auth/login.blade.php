{{-- Extends Auth Layout --}}
@extends($viewNamespace . '::layouts.auth')

{{-- Meta Title --}}
@section('title', trans('laraflock.dashboard.login.title'))

{{-- Login Box Section --}}
@section('login-box-body')
    <p class="login-box-msg">{{ trans('laraflock.dashboard.login.form_title') }}</p>
    {!! BootForm::open()->post()->action(route('auth.login')) !!}
    <fieldset>
        {!! BootForm::email(trans('laraflock.dashboard.form.email'), 'email')->placeholder(trans('laraflock.dashboard.form.email_placeholder'))->autofocus() !!}
        {!! BootForm::password(trans('laraflock.dashboard.form.password'), 'password')->placeholder(trans('laraflock.dashboard.form.password_placeholder')) !!}
    </fieldset>
    <div class="row">
        <div class="col-xs-8">
            <div class="checkbox">
                {!! BootForm::checkbox(trans('laraflock.dashboard.form.remember_me'), 'remember')->checked() !!}
            </div>
        </div>
        <div class="col-xs-4">
            {!! BootForm::submit(trans('laraflock.dashboard.buttons.login'), 'login')->addClass('btn btn-primary btn-block btn-flat') !!}
        </div>
    </div>
    {!! BootForm::close() !!}
    @if(config('laraflock.dashboard.registration'))
        <a href="#">{{ trans('laraflock.dashboard.login.forgot_pass') }}</a><br>
        <a href="{{ route('auth.register') }}" class="text-center">{{ trans('laraflock.dashboard.login.register') }}</a>
    @endif
@stop