<!DOCTYPE html>
<html lang="en">
<head>
    @include($viewNamespace . '::global.head')
    @yield('header-extras')
</head>
<body class="{{ config('odotmedia.dashboard.theme') }} sidebar-mini">
<div class="wrapper">
    @include($viewNamespace . '::global.header')
    @include($viewNamespace . '::global.sidebar')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                @yield('page-title')
                <small>@yield('page-subtitle')</small>
            </h1>
        </section>
        <section class="content">
            @include('flash::message')
            @yield('content')
        </section>
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> {{ config('odotmedia.dashboard.version') }}
        </div>
        <strong>Copyright &copy; {{ date('Y') }} {{ config('odotmedia.dashboard.credits') }}.</strong> All rights reserved.
    </footer>
</div>
@include($viewNamespace . '::global.footer-scripts')
@yield('footer-extras')
</body>
</html>