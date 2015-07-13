@extends($viewNamespace . '::layouts.auth')
@section('title', 'Access Denied - Dashboard')
@section('login-box-body')
    <div class="text-center">
        <h3><i class="fa fa-lock"></i> Unauthorized Access</h3>
    </div>
    <div class="text-center">
        There was an error with your request.
    </div>
@stop