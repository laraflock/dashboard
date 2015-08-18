{{-- Extends Auth Layout --}}
@extends($viewNamespace . '::layouts.auth')

{{-- Meta Title --}}
@section('title', trans('dashboard::dashboard.register.title'))

{{-- Login Box Section --}}
@section('login-box-body')
    <p class="login-box-msg">{{ trans('dashboard::dashboard.register.form_title') }}</p>
    {!! BootForm::open()->post()->action(route('auth.register')) !!}
    {!! BootForm::email(trans('dashboard::dashboard.form.email'), 'email')->placeholder(trans('dashboard::dashboard.form.email_placeholder'))->autofocus() !!}
    {!! BootForm::password(trans('dashboard::dashboard.form.password'), 'password')->placeholder(trans('dashboard::dashboard.form.password_placeholder')) !!}
    {!! BootForm::password(trans('dashboard::dashboard.form.confirm_password'), 'password_confirmation')->placeholder(trans('dashboard::dashboard.form.confirm_password_placeholder')) !!}
    <div class="row">
        <div class="col-xs-8"></div>
        <div class="col-xs-4">
            {!! BootForm::submit(trans('dashboard::dashboard.buttons.register'), 'register')->addClass('btn btn-primary btn-block btn-flat') !!}
        </div>
    </div>
    {!! BootForm::close() !!}
    <div class="text-center">
        {{ trans('dashboard::dashboard.register.have_account') }} <a href="{{ route('auth.login') }}">{{ trans('dashboard::dashboard.register.login') }}</a>
    </div>
@stop