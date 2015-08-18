{{-- Extends Auth Layout --}}
@extends($viewNamespace . '::layouts.auth')

{{-- Meta Title --}}
@section('title', trans('dashboard::dashboard.unauthorized.title'))

{{-- Login Box Section --}}
@section('login-box-body')
    <div class="text-center">
        <h3><i class="fa fa-lock"></i> {{ trans('dashboard::dashboard.unauthorized.access') }}</h3>
    </div>
    <div class="text-center">
        {{ trans('dashboard::dashboard.unauthorized.message') }}
    </div>
@stop