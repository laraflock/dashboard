{{-- Extends Auth Layout --}}
@extends($viewNamespace . '::layouts.auth')

{{-- Meta Title --}}
@section('title', trans('laraflock.dashboard.register.title'))

{{-- Login Box Section --}}
@section('login-box-body')
    <p class="login-box-msg">{{ trans('laraflock.dashboard.register.form_title') }}</p>
    {!! BootForm::open()->post()->action(route('auth.register')) !!}
    {!! BootForm::email(trans('laraflock.dashboard.form.email'), 'email')->placeholder(trans('laraflock.dashboard.form.email_placeholder'))->autofocus() !!}
    {!! BootForm::password(trans('laraflock.dashboard.form.password'), 'password')->placeholder(trans('laraflock.dashboard.form.password_placeholder')) !!}
    {!! BootForm::password(trans('laraflock.dashboard.form.confirm_password'), 'password_confirmation')->placeholder(trans('laraflock.dashboard.form.confirm_password_placeholder')) !!}
    <div class="row">
        <div class="col-xs-8"></div>
        <div class="col-xs-4">
            {!! BootForm::submit(trans('laraflock.dashboard.buttons.register'), 'register')->addClass('btn btn-primary btn-block btn-flat') !!}
        </div>
    </div>
    {!! BootForm::close() !!}
    <div class="text-center">
        {{ trans('laraflock.dashboard.register.have_account') }} <a href="{{ route('auth.login') }}">{{ trans('laraflock.dashboard.register.login') }}</a>
    </div>
@stop