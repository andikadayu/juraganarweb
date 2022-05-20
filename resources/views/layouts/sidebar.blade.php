<nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
    <ul class="app-menu list-unstyled accordion" id="menu-accordion">
        <li class="nav-item">
            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
            <a class="nav-link @yield('dashboard-active')" href="{{route('home')}}">
                <span class="nav-icon">
                    <i class="fas fa-home" style="font-size: 18px;"></i>
                </span>
                <span class="nav-link-text">Dashboard</span>
            </a>
            <!--//nav-link-->
        </li>
        <li class="nav-item">
            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
            <a class="nav-link @yield('users-active')" href="{{route('users')}}">
                <span class="nav-icon">
                    <i class="fas fa-users" style="font-size: 18px;"></i>
                </span>
                <span class="nav-link-text">Manage Users</span>
            </a>
            <!--//nav-link-->
        </li>
        <li class="nav-item">
            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
            <a class="nav-link @yield('shopee-active')" href="{{route('shopee')}}">
                <span class="nav-icon">
                    <i class="fas fa-shopping-cart" style="font-size: 18px;"></i>
                </span>
                <span class="nav-link-text">Shopee Scrapper</span>
            </a>
            <!--//nav-link-->
        </li>
        <!--//nav-item-->


        <!--//nav-item-->
    </ul>
    <!--//app-menu-->
</nav>