@extends($viewNamespace . '::layouts.auth')
@section('title', 'Register - Dashboard')
@section('login-box-body')
    <p class="login-box-msg">Register</p>
    {!! BootForm::open()->post()->action(route('auth.register')) !!}
    {!! BootForm::email('E-mail', 'email')->placeholder('E-mail address')->autofocus() !!}
    {!! BootForm::password('Password', 'password')->placeholder('Password') !!}
    {!! BootForm::password('Password', 'password_confirmation')->placeholder('Confirm Password') !!}
    <div class="row">
        <div class="col-xs-8"></div>
        <div class="col-xs-4">
            {!! BootForm::submit('Register', 'register')->addClass('btn btn-primary btn-block btn-flat') !!}
        </div>
    </div>
    {!! BootForm::close() !!}
    <div class="text-center">
        Have an account? <a href="{{ route('auth.login') }}">Sign In</a>
    </div>
@stop