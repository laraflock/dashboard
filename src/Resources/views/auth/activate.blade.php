@extends('dashboard::layouts.auth')
@section('title', 'Activate Account - Dashboard')
@section('content')
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-lock"></i> Activate Account</h3>
    </div>
    <div class="panel-body">
        {!! BootForm::open()->post()->action(route('auth.activate')) !!}
        <fieldset>
            {!! BootForm::email('E-mail', 'email')->placeholder('E-mail address')->defaultValue($email)->autofocus() !!}
            {!! BootForm::password('Password', 'password')->placeholder('Password') !!}
            {!! BootForm::text('Activation Code', 'activation_code')->placeholder('Enter Code Here')->defaultValue($code) !!}
            {!! BootForm::submit('Login', 'login')->addClass('btn btn-lg btn-success btn-block') !!}
            {!! BootForm::close() !!}
        </fieldset>
    </div>
    <div class="panel-footer text-right">
        <a href="#">Resend Code?</a>
    </div>
@stop