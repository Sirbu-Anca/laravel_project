<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('back_panel.products*') ? 'active' : '' }}  "
               href="{{ route('backend.products.index') }}">
                <span data-feather="users"></span>
                <i class="fas fa-user-friends"></i>
                {{ __('Products') }}
            </a>
            <a class="nav-link {{ request()->routeIs('back_panel.orders*') ? 'active' : '' }}  "
               href="{{ route('backend.orders.index') }}">
                <span data-feather="users"></span>
                <i class="fas fa-user-friends"></i>
                {{ __('Orders') }}
            </a>
        </ul>
    </div>
</nav>
