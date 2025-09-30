<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto" onsubmit="return false;">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
        </ul>
        <div class="search-element">
            <input class="form-control" id="global-search" type="search" placeholder="Search menus..." aria-label="Search" data-width="250" autocomplete="off">
            <button class="btn" type="button"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
            <div class="search-result" id="search-results" style="display: none;">
                <div class="search-header">Menu Results</div>
                <div class="search-items" id="search-items-container">
                    <!-- Search results will be populated here -->
                </div>
            </div>
        </div>
    </form>
    <ul class="navbar-nav navbar-right">

        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name ?? 'User' }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Logged in 5 min ago</div>
                <a href="{{ route('profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>

                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="dropdown-item has-icon text-danger d-flex align-items-center" style="background: none; border: none; width: 100%; text-align: left;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
