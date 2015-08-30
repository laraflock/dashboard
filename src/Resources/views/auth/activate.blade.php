{{-- Extends Auth Layout --}}
@extends($viewNamespace . '::layouts.auth')

{{-- Meta Title --}}
@section('title', trans('dashboard::dashboard.activate.title'))

{{-- Login Box Section --}}
@section('login-box-body')
    <p class="login-box-msg">{{ trans('dashboard::dashboard.activate.form_title') }}</p>
    {!! BootForm::open()->post()->action(route('auth.activate')) !!}
    <fieldset>
        {!! BootForm::email(trans('dashboard::dashboard.form.email'), 'email')->placeholder(trans('dashboard::dashboard.form.email_placeholder'))->defaultValue($email)->autofocus() !!}
        {!! BootForm::text(trans('dashboard::dashboard.form.activation_code'), 'activation_code')->placeholder(trans('dashboard::dashboard.form.activation_code_placeholder'))->defaultValue($code) !!}
    </fieldset>
    <div class="row">
        <div class="col-xs-8"></div>
        <div class="col-xs-4">
            {!! BootForm::submit(trans('dashboard::dashboard.buttons.activate'), 'activate')->addClass('btn btn-primary btn-block btn-flat') !!}
        </div>
    </div>
    {!! BootForm::close() !!}
    <div class="text-center">
        <a href="#">{{ trans('dashboard::dashboard.activate.resend_code') }}</a>
    </div>
@stop