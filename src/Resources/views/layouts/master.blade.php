<!DOCTYPE html>
<html lang="en">
<head>
    @include($viewNamespace . '::global.head')
    @yield('header-extras')
</head>
<body class="{{ config('laraflock.dashboard.theme') }} sidebar-mini">
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
            <b>{{ trans('dashboard::dashboard.global.version') }}</b> {{ trans('dashboard::dashboard.global.version_num') }}
        </div>
        <strong>{{ trans('dashboard::dashboard.global.copyright') }} &copy; {{ date('Y') }} {{ trans('dashboard::dashboard.global.credits') }}.</strong> {{ trans('dashboard::dashboard.global.rights_reserved') }}
    </footer>
</div>
@include($viewNamespace . '::global.footer-scripts')
@yield('footer-extras')
</body>
</html>