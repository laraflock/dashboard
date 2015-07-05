@extends('dashboard::layouts.auth')
@section('title', 'Login - Dashboard')
@section('content')
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-lock"></i> Login</h3>
    </div>
    <div class="panel-body">
        {!! BootForm::open()->post()->action(route('auth.login')) !!}
        <fieldset>
            {!! BootForm::email('E-mail', 'email')->placeholder('E-mail address')->autofocus() !!}
            {!! BootForm::password('Password', 'password')->placeholder('Password') !!}
            {!! BootForm::checkbox('Remember me', 'remember')->checked() !!}
            {!! BootForm::submit('Login', 'login')->addClass('btn btn-lg btn-success btn-block') !!}
            {!! BootForm::close() !!}
        </fieldset>
    </div>
    @if(config('odotmedia.dashboard.registration'))
        <div class="panel-footer text-right">
            <a href="{{ route('auth.register') }}">Sign Up</a> | <a href="#">Forgot Password?</a>
        </div>
    @endif
@stop