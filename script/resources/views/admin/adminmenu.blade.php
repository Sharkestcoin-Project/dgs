@can('dashboard-read')
<li class="menu-header">{{ __('Dashboard') }}</li>
<li class="{{ Request::is('admin/dashboard*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i>
        <span>{{ __('Dashboard') }}</span>
    </a>
</li>
@endcan

@can('plans-read')
<li class="menu-header">{{ __('Manage Plan & Payments') }}</li>
<li class="dropdown {{ Request::is('admin/plan*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fas fa-clipboard-list"></i>
        <span>{{ __('Manage Plan') }}</span>
    </a>
    <ul class="dropdown-menu">
        @can('plans-create')
        <li class="{{ Request::is('admin/plans/create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.plans.create') }}">{{ __('Create Plan') }}</a>
        </li>
        @endcan
        <li class="{{ Request::is('admin/plans') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.plans.index') }}">{{ __('Manage Plans') }}</a>
        </li>
    </ul>
</li>
@endcan

@can('payout-methods-read', 'payouts-read')
<li class="dropdown {{ request()->is('admin/payout-methods*') || request()->is('admin/payouts*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fas fa-money-check-alt"></i>
        <span>{{ __('Payouts') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="{{ request()->is('admin/payout-methods*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.payout-methods.index') }}">
                {{ __('Method') }}
            </a>
        </li>
        @can('payouts-read')
        <li class="{{ request()->is('admin/payouts*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.payouts.index') }}">
                {{ __('Payouts') }}
            </a>
        </li>
        @endcan
    </ul>
</li>
@endcan

@can('orders-read')
<li class="{{ Request::is('admin/orders*') ? 'active' : '' }}">
    <a href="{{ route('admin.orders.index') }}" class="nav-link">
        <i class="fas fa-th-list"></i>
        <span>{{ __('Subscription Orders') }}</span>
    </a>
</li>
@endcan

@can('products-read')
<li class="{{ Request::is('admin/products*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.products.index') }}">
        <i class="fab fa-product-hunt"></i>
        <span>{{ __('Products') }}</span>
    </a>
</li>
@endcan

@can('user-plans-read')
<li class="{{ Request::is('admin/subscriptions*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.subscriptions.index') }}">
        <i class="fa fa-user" aria-hidden="true"></i>
        <span>{{ __('User Plans') }}</span>
    </a>
</li>
@endcan

@can('product-orders-read')
<li class="{{ Request::is('admin/product-orders*') ? 'active' : '' }}">
    <a href="{{ route('admin.product-orders.index') }}" class="nav-link">
        <i class="fa fa-list"></i>
        <span>{{ __('Product Orders') }}</span>
    </a>
</li>
@endcan

@can('users-read')
<li class="menu-header">{{ __('User Management') }}</li>
<li class="dropdown {{ Request::is('admin/users*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fas fa-users"></i>
        <span>{{ __('Users') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="{{ Request::is('admin.users.create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.users.create') }}">
                {{ __('Create User') }}
            </a>
        </li>
        <li class="{{ Request::is('admin.users.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
                {{ __('Manage Users') }}
            </a>
        </li>
    </ul>
</li>
@endcan

<li class="menu-header">{{ __('Website Management') }}</li>
@can('media-read')
<li class="{{ Request::is('admin/media*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.media.list') }}">
        <i class="far fa-file-image"></i>
        <span>{{ __('Media') }}</span>
    </a>
</li>
@endcan

@can('reviews-read')
<li class="{{ Request::is('admin/review*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fas fa-comments"></i>
        <span>{{ __('Reviews') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link" href="{{ route('admin.reviews.create') }}">{{ __('Create Review') }}</a>
        </li>
        <li>
            <a class="nav-link" href="{{ route('admin.reviews.index') }}">{{ __('Review List') }}</a>
        </li>
    </ul>
</li>
@endcan

@can('blog-read')
<li class="{{ Request::is('admin/blog*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fab fa-blogger"></i>
        <span>{{ __('Blog') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link" href="{{ route('admin.blog.create') }}">{{ __('Blog Create') }}</a>
        </li>
        <li>
            <a class="nav-link" href="{{ route('admin.blog.index') }}">{{ __('Blog List') }}</a>
        </li>
    </ul>
</li>
@endcan

@can('pages-read')
<li class="{{ Request::is('admin/page*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fas fa-file"></i>
        <span>{{ __('Page') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link" href="{{ route('admin.page.create') }}">{{ __('Page Create') }}</a>
        </li>
        <li>
            <a class="nav-link" href="{{ route('admin.page.index') }}">{{ __('Page List') }}</a>
        </li>
    </ul>
</li>
@endcan

@can('website-read')
<li class="nav-item dropdown {{ Request::is('admin/settings/website/*') ? 'show active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fas fa-desktop"></i>
        <span>{{ __('Website') }}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="{{ Request::routeIs('admin.settings.website.logo.index') ? 'active' : '' }}">
            <a href="{{ route('admin.settings.website.logo.index') }}" class="nav-link">
                <span>{{ __('Logo') }}</span>
            </a>
        </li>
        <li class="{{ Request::routeIs('admin.settings.website.heading.index') ? 'active' : '' }}">
            <a href="{{ route('admin.settings.website.heading.index') }}" class="nav-link">
                <span>{{ __('Heading') }}</span>
            </a>
        </li>
        <li class="{{ Request::routeIs('admin.settings.website.footer.index') ? 'active' : '' }}">
            <a href="{{ route('admin.settings.website.footer.index') }}" class="nav-link">
                <span>{{ __('Footer') }}</span>
            </a>
        </li>
        <li class="{{ Request::routeIs('admin.settings.website.trusted-partner.index') ? 'active' : '' }}">
            <a href="{{ route('admin.settings.website.trusted-partner.index') }}" class="nav-link">
                <span>{{ __('Trusted Partner') }}</span>
            </a>
        </li>
        <li class="{{ Request::routeIs('admin.settings.website.faq.index') ? 'active' : '' }}">
            <a href="{{ route('admin.settings.website.faq.index') }}" class="nav-link">
                <span>{{ __('FAQ') }}</span>
            </a>
        </li>
        <li class="{{ Request::routeIs('admin.settings.website.our-services.index') ? 'active' : '' }}">
            <a href="{{ route('admin.settings.website.our-services.index') }}" class="nav-link">
                <span>{{ __('Our Services') }}</span>
            </a>
        </li>
        <li class="{{ Request::routeIs('admin.settings.website.term.index') ? 'active' : '' }}">
            <a href="{{ route('admin.settings.website.term.index') }}" class="nav-link">
                <span>{{ __('Update Term of Services') }}</span>
            </a>
        </li>
        <li class="{{ Request::routeIs('admin.settings.website.demo.index') ? 'active' : '' }}">
            <a href="{{ route('admin.settings.website.demo.index') }}" class="nav-link">
                <span>{{ __('Update Demo Product') }}</span>
            </a>
        </li>
    </ul>
</li>
@endcan

@can('settings-read')
<li class="menu-header">{{ __('Settings') }}</li>
<li class="nav-item dropdown {{ Request::is('admin/settings', 'admin/language/*', 'admin/menu/*') ? 'show active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
        <i class="fas fa-cogs"></i>
        <span>{{ __('Settings') }}</span>
    </a>
    <ul class="dropdown-menu">
        @can('languages-read')
        <li class="{{ Request::is('admin/language') ? 'active' : '' }}">
            <a href="{{ route('admin.language.index') }}" class="nav-link"><span>{{ __('Languages') }}</span></a>
        </li>
        @endcan
        @can('menus-read')
        <li><a class="nav-link" href="{{ route('admin.menu.index') }}">{{ __('Menu Settings') }}</a></li>
        @endcan
        @can('seo-read')
        <li><a class="nav-link" href="{{ route('admin.seo.index') }}">{{ __('SEO Settings') }}</a></li>
        @endcan
        @can('system-settings-read')
        <li><a class="nav-link" href="{{ route('admin.env.index') }}">{{ __('System Settings') }}</a></li>
        @endcan
        @can('cron-settings-read')
        <li><a class="nav-link" href="{{ route('admin.cron.index') }}">{{ __('Cron Settings') }}</a></li>
        @endcan
        @can('currencies-read')
        <li class="{{ Request::is('admin/currencies*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.currencies.index') }}">{{ __('Currencies') }}</a>
        </li>
        @endcan
        @can('taxes-read')
        <li class="{{ Request::is('admin/taxes*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.taxes.index') }}">{{ __('Taxes') }}</a>
        </li>
        @endcan
        @can('gateways-read')
        <li class="{{ Request::is('admin/payment-gateways*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.payment-gateways.index') }}">{{ __('Payment Gateways') }}</a>
        </li>
        @endcan
        @can('roles-read')
        <li class="{{ Request::is('admin/roles*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.roles.index') }}">{{ __('Roles') }}</a>
        </li>
        @endcan
        @can('roles-assign-read')
        <li class="{{ Request::is('admin/assign-role*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.assign-role.index') }}">{{ __('Assign Role') }}</a>
        </li>
        @endcan
    </ul>
</li>
@endcan
