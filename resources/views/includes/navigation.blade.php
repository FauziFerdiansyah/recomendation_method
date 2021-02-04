<!-- begin::navigation -->
<div class="horizontal-navigation">
    <ul>
        <li class="{{ Request::segment(2) === null ? 'open' : '' }}">
            <a href="{{ route('dashboard') }}">
                <i class="mr-2" data-feather="activity"></i> Dashboards
            </a>
        </li>
        <li class="{{ Request::segment(2) === 'users' ? 'open' : '' }}">
            <a href="{{ route('user_index') }}">
                <i class="mr-2" data-feather="users"></i> Users
            </a>
        </li>
        <li class="{{ Request::segment(2) === 'categories' ? 'open' : '' }}">
            <a href="{{ route('category_index') }}">
                <i class="mr-2" data-feather="slack"></i> Category
            </a>
        </li>
    </ul>
</div>
<!-- end::navigation -->