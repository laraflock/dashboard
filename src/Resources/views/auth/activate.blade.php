@extends($viewNamespace . '::layouts.auth')
@section('title', 'Activate Account - Dashboard')
@section('login-box-body')
    <p class="login-box-msg">Activate Account</p>
    {!! BootForm::open()->post()->action(route('auth.activate')) !!}
    <fieldset>
        {!! BootForm::email('E-mail', 'email')->placeholder('E-mail address')->defaultValue($email)->autofocus() !!}
        {!! BootForm::text('Activation Code', 'activation_code')->placeholder('Enter Code Here')->defaultValue($code) !!}
    </fieldset>
    <div class="row">
        <div class="col-xs-8"></div>
        <div class="col-xs-4">
            {!! BootForm::submit('Activate', 'activate')->addClass('btn btn-primary btn-block btn-flat') !!}
        </div>
    </div>
    {!! BootForm::close() !!}
    <div class="text-center">
        <a href="#">Resend Code?</a>
    </div>
@stop