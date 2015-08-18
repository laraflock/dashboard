<!DOCTYPE html>
<html lang="en">
<head>
    @include($viewNamespace . '::global.head')
    @yield('header-extras')
</head>
<body class="login-page">
<div class="login-box">

    {{-- Login Logo or Text --}}
    <div class="login-logo">
        <a href="{{ route('dashboard.index') }}">{{ config('laraflock.dashboard.title') }}</a>
    </div>

    {{-- Login Box Body --}}
    <div class="login-box-body">
        @include('flash::message')
        @yield('login-box-body')
    </div>
</div>
@yield('footer-extras')
@include($viewNamespace . '::global.footer-scripts')
</body>
</html>