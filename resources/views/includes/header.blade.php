<!-- begin::header -->
<div class="header d-print-none">
    <div class="header-left">
        <div class="navigation-toggler">
            <a href="#" data-action="navigation-toggler">
                <i data-feather="menu"></i>
            </a>
        </div>
        <div class="header-logo">
            <a href="/">
                <img class="logo" src="{{URL::asset('/img/logo.png')}}" alt="Logo" />
            </a>
        </div>
    </div>

    <div class="header-body">
        <div class="header-body-left">
            <div class="page-title">
                <h4> @yield('title_web') </h4>
            </div>
        </div>
        <div class="header-body-right">
            <ul class="navbar-nav">
                <!-- begin::header fullscreen -->
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link" title="Fullscreen" data-toggle="fullscreen">
                        <i class="maximize" data-feather="maximize"></i>
                        <i class="minimize" data-feather="minimize"></i>
                    </a>
                </li>
                <!-- end::header fullscreen -->

                <!-- BEGIN: User -->
                <li class="nav-item">
                    <a href="#" title="Logout" class="nav-link" data-toggle="dropdown">
                        <i data-feather="log-out"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-big">
                        <div class="p-3 border-top text-right">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" 
                                class="btn btn-primary btn-block mt-2 text-white">
                                Sign Out <i class="ti-shift-right ml-2"></i>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </li>
                <!-- END: User -->

            </ul>

            <!-- begin::mobile header toggler -->
            <ul class="navbar-nav d-flex align-items-center">
                <li class="nav-item header-toggler">
                    <a href="#" class="nav-link">
                        <i data-feather="arrow-down"></i>
                    </a>
                </li>
            </ul>
            <!-- end::mobile header toggler -->
        </div>
    </div>
</div>
<!-- end::header -->