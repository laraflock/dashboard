<!DOCTYPE html>
<html lang="en">
<head>
    @include($viewNamespace . '::global.head')
    @yield('header-extras')
</head>
<body>
<div id="wrapper">
    @include($viewNamespace . '::global.nav')
    <div id="page-wrapper">
        @yield('page-wrapper')
        <div class="row">
            <div class="col-xs-12">
                <div class="text-right text-muted text-uppercase">
                    <small>Copyright &copy; {{ date('Y') }} {{ config('odotmedia.dashboard.credits') }}</small>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@include($viewNamespace . '::global.footer')
{{-- This will be a section that we can throw in scripts for certain pages --}}
@yield('footer-extras')
</body>
</html>