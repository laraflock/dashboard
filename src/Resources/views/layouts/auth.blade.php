<!DOCTYPE html>
<html lang="en">
<head>
    @include('dashboard::global.head')
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel">
                @include('flash::message')
            </div>
            <div class="panel panel-default">
                @yield('content')
            </div>
        </div>
    </div>
</div>
@include('dashboard::global.footer')
</body>
</html>