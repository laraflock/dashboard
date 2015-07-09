<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ route('dashboard.index') }}">{{ config('odotmedia.dashboard.title') }}</a>
    </div>
    {{-- Top Right Navigation --}}
    @include($viewNamespace . '::global.nav-top-right')
    {{-- Sidebar Navigation --}}
    @include($viewNamespace . '::global.nav-sidebar')
</nav>