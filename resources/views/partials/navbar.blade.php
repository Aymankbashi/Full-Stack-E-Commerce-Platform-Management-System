<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-shop"></i> {{ $labels['site_title'] ?? 'متجر الإلكتروني' }}
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <form class="d-flex search-bar" action="{{ route('products.index') }}" method="GET">
                <input class="form-control" type="search" name="q" placeholder="{{ $labels['search_placeholder'] ?? 'ابحث عن المنتجات...' }}">
                <button class="btn" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">
                        <i class="bi bi-grid"></i> {{ $labels['view_products'] ?? 'المنتجات' }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('blog.index') }}">
                        <i class="bi bi-journal-text"></i> {{ $labels['blog'] ?? 'المدونة' }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}">
                        <i class="bi bi-info-circle"></i> {{ $labels['about'] ?? 'حول المتجر' }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">
                        <i class="bi bi-headset"></i> {{ $labels['contact'] ?? 'دعم فني' }}
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2">
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
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-in-right"></i> {{ $labels['login'] ?? 'تسجيل الدخول' }}
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary-custom btn-sm">
                        <i class="bi bi-person-plus"></i> {{ $labels['register'] ?? 'إنشاء حساب' }}
                    </a>
                @else
                    <!-- قائمة الرغبات -->
                    <a href="{{ route('wishlist') }}" class="btn btn-outline-light btn-sm" title="{{ $labels['wishlist'] ?? 'قائمة الرغبات' }}">
                        <i class="bi bi-heart"></i>
                    </a>

                    <!-- حسابي -->
                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-light btn-sm" title="{{ $labels['dashboard'] ?? 'لوحة التحكم' }}">
                        <i class="bi bi-person-circle"></i>
                    </a>

                    <!-- قائمة المستخدم -->
                    <div class="dropdown">
                        <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-{{ $dir }}">
                            <li>
                                <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> {{ $labels['dashboard'] ?? 'لوحة التحكم' }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('wishlist') }}">
                                    <i class="bi bi-heart"></i> {{ $labels['wishlist'] ?? 'قائمة الرغبات' }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('orders') }}">
                                    <i class="bi bi-receipt"></i> {{ $labels['my_orders'] ?? 'طلباتي' }}
                                </a>
                            </li>
                            @if(Auth::user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-gear"></i> {{ $labels['admin_panel'] ?? 'لوحة تحكم المدير' }}
                                    </a>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> {{ $labels['logout'] ?? 'تسجيل الخروج' }}
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
