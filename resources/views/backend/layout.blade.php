
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('backend.layout_head')
</head>
<body>
@include("backend.layout_navbar")
<div class="container-fluid">
    <div class="row">
        @include('backend.layout_sidebar')
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            @foreach(['success', 'warning', 'danger'] as $log_status)
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
<script src="/docs/5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
</body>
</html>
