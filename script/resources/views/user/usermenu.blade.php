<li class="@if(Route::is('user.dashboard')) active @endif">
    <a class="nav-link" href="{{ route('user.dashboard') }}">
        <i class="fa fa-home" aria-hidden="true"></i>
        <span>{{ __('Dashboard') }}</span>
    </a>
</li>

<li class="{{ Request::is('user/products*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('user.products.index') }}">
        <i class="fab fa-product-hunt"></i>
        <span>{{ __('Products') }}</span>
    </a>
</li>

<li class="{{ Request::is('user/promotions*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('user.promotions.index') }}">
        <i class="fas fa-percentage"></i>
        <span>{{ __('Promotions') }}</span>
    </a>
</li>

<li class="{{ Request::is('user/payout*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('user.payout.index') }}">
        <i class="fa fa-hand-holding-usd"></i>
        <span>{{ __('Payouts') }}</span>
    </a>
</li>

<li class="{{ Request::is('user/orders*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fa fa-shopping-basket"></i>
        <span>{{ __('Orders') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="{{ Route::is('user.orders.products.index') ? 'active' : ''  }}">
            <a class="nav-link" href="{{ route('user.orders.products.index') }}">{{ __('Products Log') }}</a>
        </li>
        <li class="{{ Route::is('user.orders.subscriptions.index') ? 'active' : ''  }}">
            <a class="nav-link" href="{{ route('user.orders.subscriptions.index') }}">{{ __('Subscriptions Log') }}</a>
        </li>
    </ul>
</li>

<li class="{{ Request::is('user/subscriptions*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fa fa-clipboard-list"></i>
        <span>{{ __('Subscriptions') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="{{ Route::is('user.subscriptions.index') ? 'active' : ''  }}">
            <a class="nav-link" href="{{ route('user.subscriptions.index') }}">{{ __('My Plans') }}</a>
        </li>
        <li class="{{ Route::is('user.subscribers.index') ? 'active' : ''  }}">
            <a class="nav-link" href="{{ route('user.subscribers.index') }}">{{ __('Subscribers') }}</a>
        </li>
    </ul>
</li>

<li class="{{ Request::is('user/settings*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fa fa-cog"></i>
        <span>{{ __('Settings') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="{{ route::is('user.settings.index') ? 'active':'' }}">
            <a class="nav-link" href="{{ route('user.settings.index') }}">{{ __('Settings') }}</a>
        </li>
        <li class="@if(Request::is('user/settings/subscriptions*')) active @endif">
            <a class="nav-link" href="{{ route('user.settings.subscriptions.index') }}">{{ __('Subscription') }}</a>
        </li>
        <li class="@if(Request::is('user/settings/logs-subscriptions*')) active @endif">
            <a class="nav-link" href="{{ route('user.settings.subscriptions.log') }}">{{ __('Subscription Log') }}</a>
        </li>
    </ul>
</li>
