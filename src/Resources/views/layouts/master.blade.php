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
            <b>{{ trans('laraflock.dashboard.global.version') }}</b> {{ trans('laraflock.dashboard.global.version_num') }}
        </div>
        <strong>{{ trans('laraflock.dashboard.global.copyright') }} &copy; {{ date('Y') }} {{ trans('laraflock.dashboard.global.credits') }}.</strong> {{ trans('laraflock.dashboard.global.rights_reserved') }}
    </footer>
</div>
@include($viewNamespace . '::global.footer-scripts')
@yield('footer-extras')
</body>
</html>