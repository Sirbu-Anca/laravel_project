<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('backend.layout_head')
</head>
<body>
@include('backend.layout_navbar')
<div class="container-fluid">
    <div class="row">
        @include('backend.layout_sidebar')
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            @foreach (['success', 'warning', 'danger'] as $log_status)
                @if (session()->has($log_status))
                    <div class="alert alert-{{ $log_status }}">
                        {{ session()->get($log_status) }}
                    </div>
                @endif
            @endforeach
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 w-100">@yield('header', 'Welcome!')</h1>
            </div>
            <div class="row">
                <div class="col-10 offset-2">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
