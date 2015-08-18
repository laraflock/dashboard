{{-- Extends Auth Layout --}}
@extends($viewNamespace . '::layouts.auth')

{{-- Meta Title --}}
@section('title', trans('laraflock.dashboard.unauthorized.title'))

{{-- Login Box Section --}}
@section('login-box-body')
    <div class="text-center">
        <h3><i class="fa fa-lock"></i> {{ trans('laraflock.dashboard.unauthorized.access') }}</h3>
    </div>
    <div class="text-center">
        {{ trans('laraflock.dashboard.unauthorized.message') }}
    </div>
@stop