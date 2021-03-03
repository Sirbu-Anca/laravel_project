<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">{{config('app.name', 'Laravel')}}</a>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-outline-primary">{{ __('Sign out' }}</button>
            </form>
        </li>
    </ul>
</header>
