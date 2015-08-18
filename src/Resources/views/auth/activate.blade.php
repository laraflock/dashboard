{{-- Extends Auth Layout --}}
@extends($viewNamespace . '::layouts.auth')

{{-- Meta Title --}}
@section('title', trans('laraflock.dashboard.activate.title'))

{{-- Login Box Section --}}
@section('login-box-body')
    <p class="login-box-msg">{{ trans('laraflock.dashboard.activate.form_title') }}</p>
    {!! BootForm::open()->post()->action(route('auth.activate')) !!}
    <fieldset>
        {!! BootForm::email(trans('laraflock.dashboard.form.email'), 'email')->placeholder(trans('laraflock.dashboard.form.email_placeholder'))->defaultValue($email)->autofocus() !!}
        {!! BootForm::text(trans('laraflock.dashboard.form.activation_code'), 'activation_code')->placeholder(trans('laraflock.dashboard.form.activation_code_placeholder'))->defaultValue($code) !!}
    </fieldset>
    <div class="row">
        <div class="col-xs-8"></div>
        <div class="col-xs-4">
            {!! BootForm::submit(trans('laraflock.dashboard.buttons.activate'), 'activate')->addClass('btn btn-primary btn-block btn-flat') !!}
        </div>
    </div>
    {!! BootForm::close() !!}
    <div class="text-center">
        <a href="#">{{ trans('laraflock.dashboard.activate.resend_code') }}</a>
    </div>
@stop