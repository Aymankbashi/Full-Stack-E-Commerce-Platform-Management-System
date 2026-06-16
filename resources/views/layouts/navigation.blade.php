@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $labels = require base_path('lang/' . $locale . '.php');
    $cart = session('cart', []);
    $cartCount = array_sum(array_column($cart, 'quantity'));
@endphp

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-shop"></i>
            {{ $labels['site_title'] }}
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house"></i> {{ $labels['welcome'] }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                        <i class="bi bi-grid"></i> {{ $labels['view_products'] }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('blog*') ? 'active' : '' }}" href="{{ route('blog.index') }}">
                        <i class="bi bi-journal-text"></i> {{ $labels['blog'] }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        <i class="bi bi-info-circle"></i> {{ $labels['about'] }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                        <i class="bi bi-headset"></i> {{ $labels['contact'] }}
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">


                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="btn btn-outline-light position-relative">
                    <i class="bi bi-cart3"></i>
                    @if($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- Auth Links -->
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="bi bi-box-arrow-in-right"></i> {{ $labels['login'] }}
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light">
                        <i class="bi bi-person-plus"></i> {{ $labels['register'] }}
                    </a>
                @else
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-{{ $dir }}">
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> {{ $labels['dashboard'] }}
                                </a>
                            </li>
                            @if(Auth::user()->is_admin)
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-gear"></i> {{ $labels['admin_panel'] }}
                                </a>
                            </li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> {{ $labels['logout'] }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

<style>
    .navbar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .navbar-brand {
        font-weight: 700;
        font-size: 1.5rem;
    }
    .nav-link {
        font-weight: 500;
        transition: all 0.3s ease;
        margin: 0 5px;
        border-radius: 5px;
    }
    .nav-link:hover,
    .nav-link.active {
        background: rgba(255,255,255,0.2);
    }
    .btn-outline-light:hover {
        background: rgba(255,255,255,0.2);
    }
</style>
