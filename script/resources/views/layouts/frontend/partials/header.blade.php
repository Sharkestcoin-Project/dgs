<!-- Header Area Start -->
<header class="site-header site-header--menu-right landing-1-menu site-header--absolute site-header--sticky">
    <div class="container">
        <nav class="navbar site-navbar">
            <!-- Brand Logo-->
            <div class="brand-logo">
                <a href="{{ url('/') }}">
                    <img src="{{ get_option('logo_setting')['logo'] ?? null }}" alt="" class="dark-version-logo">
                </a>
            </div>
            <div class="menu-block-wrapper">
                <div class="menu-overlay"></div>
                <nav class="menu-block" id="append-menu-header">
                    <div class="mobile-menu-head">
                        <div class="go-back">
                            <i class="fa fa-angle-left"></i>
                        </div>
                        <div class="current-menu-title"></div>
                        <div class="mobile-menu-close">&times;</div>
                    </div>
                    <ul class="site-menu-main">
                        {{ RenderMenu('header', 'components.menu.header') }}

                        <ul class="menu-auth mobile">
                            @if(Auth::check())
                                @if(Auth::user()->role == 'user')
                                    <li><a class="reg-btn" href="{{ route('user.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                @else
                                    <li><a class="reg-btn" href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                @endif
                            @else
                                <li><a class="reg-btn" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                <li><a class="login-btn" href="{{ route('register') }}">{{ __('Sign Up') }}</a></li>
                            @endif
                        </ul>
                    </ul>
                    <ul class="menu-auth">
                        @if(Auth::check())
                            @if(Auth::user()->role == 'user')
                                <li><a class="reg-btn" href="{{ route('user.dashboard') }}">{{ __('Dashboard') }}</a></li>
                            @else
                                <li><a class="reg-btn" href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                            @endif
                        @else
                            <li><a class="reg-btn" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="login-btn" href="{{ route('register') }}">{{ __('Sign Up') }}</a></li>
                        @endif
                    </ul>
                </nav>
            </div>
            <!-- mobile menu trigger -->
            <div class="mobile-menu-trigger">
                <span></span>
            </div>
        </nav>
    </div>
</header>
<!-- header-end -->
