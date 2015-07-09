@extends($viewNamespace . '::layouts.auth')
@section('title', 'Access Denied - Dashboard')
@section('content')
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-lock"></i> Unauthorized Access</h3>
    </div>
    <div class="panel-body text-center">
        There was an error with your request.
    </div>
@stop