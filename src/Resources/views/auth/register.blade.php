@extends('dashboard::layouts.auth')
@section('title', 'Register - Dashboard')
@section('content')
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-lock"></i> Register</h3>
    </div>
    <div class="panel-body">
        {!! BootForm::open()->post()->action(route('auth.register')) !!}
        <fieldset>
            {!! BootForm::email('E-mail', 'email')->placeholder('E-mail address')->autofocus() !!}
            {!! BootForm::password('Password', 'password')->placeholder('Password') !!}
            {!! BootForm::password('Password', 'password_confirmation')->placeholder('Confirm Password') !!}
            {!! BootForm::submit('Register', 'register')->addClass('btn btn-lg btn-success btn-block') !!}
            {!! BootForm::close() !!}
        </fieldset>
    </div>
    <div class="panel-footer">
        Have an account? <a href="{{ route('auth.login') }}">Sign In</a>
    </div>
@stop