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
                <i class="mr-2" data-feather="smile"></i> Users
            </a>
        </li>
        <li class="{{ Request::segment(2) === 'categories' ? 'open' : '' }}">
            <a href="{{ route('category_index') }}">
                <i class="mr-2" data-feather="slack"></i> Categories
            </a>
        </li>
        <li class="{{ Request::segment(2) === 'products' ? 'open' : '' }}">
            <a href="{{ route('product_index') }}">
                <i class="mr-2" data-feather="package"></i> Products
            </a>
        </li>
        <li class="{{ Request::segment(2) === 'customers' ? 'open' : '' }}">
            <a href="{{ route('customer_index') }}">
                <i class="mr-2" data-feather="users"></i> Customers
            </a>
        </li>
        <li class="{{ Request::segment(2) === 'reviews' ? 'open' : '' }}">
            <a href="{{ route('review_index') }}">
                <i class="mr-2" data-feather="star"></i> Reviews
            </a>
        </li>
        <li class="{{ Request::segment(2) === 'methods' ? 'open' : '' }}">
            <a href="{{ route('method_index') }}">
                <i class="mr-2" data-feather="airplay"></i> Calculation
            </a>
        </li>
    </ul>
</div>
<!-- end::navigation -->