@extends($viewNamespace . '::layouts.auth')
@section('title', 'Login - Dashboard')
@section('login-box-body')
    <p class="login-box-msg">Login</p>
    {!! BootForm::open()->post()->action(route('auth.login')) !!}
    <fieldset>
        {!! BootForm::email('E-mail', 'email')->placeholder('E-mail address')->autofocus() !!}
        {!! BootForm::password('Password', 'password')->placeholder('Password') !!}
    </fieldset>
    <div class="row">
        <div class="col-xs-8">
            <div class="checkbox">
                {!! BootForm::checkbox('Remember me', 'remember')->checked() !!}
            </div>
        </div>
        <div class="col-xs-4">
            {!! BootForm::submit('Login', 'login')->addClass('btn btn-primary btn-block btn-flat') !!}
        </div>
    </div>
    {!! BootForm::close() !!}
    @if(config('laraflock.dashboard.registration'))
        <a href="#">I forgot my password</a><br>
        <a href="{{ route('auth.register') }}" class="text-center">Register a new membership</a>
    @endif
@stop