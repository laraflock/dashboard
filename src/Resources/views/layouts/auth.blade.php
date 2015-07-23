<!DOCTYPE html>
<html lang="en">
<head>
    @include($viewNamespace . '::global.head')
    @yield('header-extras')
</head>
<body class="login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('dashboard.index') }}">{{ config('laraflock.dashboard.title') }}</a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        @include('flash::message')
        @yield('login-box-body')
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
@yield('footer-extras')
@include($viewNamespace . '::global.footer-scripts')
</body>
</html>