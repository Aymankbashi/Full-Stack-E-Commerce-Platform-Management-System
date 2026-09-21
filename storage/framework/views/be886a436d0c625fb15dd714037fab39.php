
<?php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $labels = require base_path('lang/' . $locale . '.php');
    $cart = session('cart', []);
    $cartCount = array_sum(array_column($cart, 'quantity'));
?>
<!DOCTYPE html>
<html lang="<?php echo e($locale); ?>" dir="<?php echo e($dir); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($labels['site_title']); ?></title>
    <meta name="description" content="<?php echo e($labels['site_title']); ?> - أفضل متجر إلكتروني لشراء المنتجات بأمان وسهولة">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f5f5f5;
        }
        .navbar {
            background: #232f3e !important;
            padding: 0.5rem 0;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: #fff !important;
        }
        .navbar-brand:hover {
            color: #f0c14b !important;
        }
        .search-bar {
            max-width: 600px;
            flex: 1;
            margin: 0 2rem;
        }
        .search-bar input {
            border-radius: 4px 0 0 4px;
            border: none;
            padding: 0.6rem 1rem;
        }
        .search-bar button {
            border-radius: 0 4px 4px 0;
            background: #f0c14b;
            border: 1px solid #a88734;
            padding: 0.6rem 1.5rem;
        }
        .search-bar button:hover {
            background: #ddb347;
        }
        .hero-banner {
            background: linear-gradient(135deg, #232f3e 0%, #37475a 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }
        .hero-banner h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .category-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 1px solid #e0e0e0;
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .category-icon {
            font-size: 2.5rem;
            color: #232f3e;
            margin-bottom: 1rem;
        }
        .offer-banner {
            background: linear-gradient(135deg, #f0c14b 0%, #f7dfa5 100%);
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }
        .product-card {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
        }
        .product-card:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .product-img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            margin-bottom: 1rem;
        }
        .price {
            font-size: 1.5rem;
            color: #B12704;
            font-weight: 700;
        }
        .old-price {
            text-decoration: line-through;
            color: #565959;
            margin-left: 0.5rem;
        }
        .btn-primary-custom {
            background: #f0c14b;
            border: 1px solid #a88734;
            color: #111;
            font-weight: 600;
        }
        .btn-primary-custom:hover {
            background: #ddb347;
            color: #111;
        }
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #232f3e;
        }
        .quick-nav-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .quick-nav-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .quick-nav-card h5 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #232f3e;
        }
        .quick-nav-card h5 i {
            color: #f0c14b;
            margin-left: 0.5rem;
        }
        .quick-nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .quick-nav-list li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .quick-nav-list li:last-child {
            border-bottom: none;
        }
        .quick-nav-list a {
            color: #007185;
            text-decoration: none;
            transition: all 0.3s ease;
            display: block;
        }
        .quick-nav-list a:hover {
            color: #c7511f;
            padding-<?php echo e($dir === 'rtl' ? 'right' : 'left'); ?>: 0.5rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                <i class="bi bi-shop"></i> <?php echo e($labels['site_title']); ?>

            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="d-flex search-bar" action="<?php echo e(route('products.index')); ?>" method="GET">
                    <input class="form-control" type="search" name="q" placeholder="<?php echo e($labels['search_placeholder']); ?>">
                    <button class="btn" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('products.index')); ?>">
                            <i class="bi bi-grid"></i> <?php echo e($labels['view_products']); ?>

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('blog.index')); ?>">
                            <i class="bi bi-journal-text"></i> <?php echo e($labels['blog']); ?>

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('about')); ?>">
                            <i class="bi bi-info-circle"></i> <?php echo e($labels['about']); ?>

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('contact')); ?>">
                            <i class="bi bi-headset"></i> <?php echo e($labels['contact']); ?>

                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">


                    <!-- Cart -->
                    <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-outline-light position-relative">
                        <i class="bi bi-cart3"></i>
                        <?php if($cartCount > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php echo e($cartCount); ?>

                            </span>
                        <?php endif; ?>
                    </a>

                    <!-- Auth Links -->
                    <?php if(auth()->guard()->guest()): ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-box-arrow-in-right"></i> <?php echo e($labels['login']); ?>

                        </a>
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-primary-custom btn-sm">
                            <i class="bi bi-person-plus"></i> <?php echo e($labels['register']); ?>

                        </a>
                    <?php else: ?>
                        <!-- قائمة الرغبات -->
                        <a href="<?php echo e(route('wishlist')); ?>" class="btn btn-outline-light btn-sm" title="<?php echo e($labels['wishlist']); ?>">
                            <i class="bi bi-heart"></i>
                        </a>
                        
                        <!-- حسابي -->
                        <a href="<?php echo e(route('user.dashboard')); ?>" class="btn btn-outline-light btn-sm" title="<?php echo e($labels['dashboard']); ?>">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        
                        <!-- قائمة المستخدم -->
                        <div class="dropdown">
                            <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i>
                                <?php echo e(Auth::user()->name); ?>

                            </button>
                            <ul class="dropdown-menu dropdown-menu-<?php echo e($dir); ?>">
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('user.dashboard')); ?>">
                                        <i class="bi bi-speedometer2"></i> <?php echo e($labels['dashboard']); ?>

                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('wishlist')); ?>">
                                        <i class="bi bi-heart"></i> <?php echo e($labels['wishlist']); ?>

                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('orders')); ?>">
                                        <i class="bi bi-receipt"></i> <?php echo e($labels['my_orders']); ?>

                                    </a>
                                </li>
                                <?php if(Auth::user()->isRole('admin')): ?>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">
                                            <i class="bi bi-gear"></i> <?php echo e($labels['admin_panel']); ?>

                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> <?php echo e($labels['logout']); ?>

                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Banner -->
    <div class="hero-banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><?php echo e($labels['welcome']); ?></h1>
                    <p class="lead">اكتشف أفضل المنتجات بأسعار منافسة</p>
                    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary-custom btn-lg">
                        <?php echo e($labels['view_products']); ?>

                    </a>
                    <a href="<?php echo e(route('welcome')); ?>" class="btn btn-outline-light btn-lg ms-2">
                        العروض
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <div class="container mb-5">
        <h2 class="section-title"><?php echo e($labels['categories']); ?></h2>
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="category-card text-center">
                    <i class="bi bi-laptop category-icon"></i>
                    <h5>الإلكترونيات</h5>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="category-card text-center">
                    <i class="bi bi-tshirt category-icon"></i>
                    <h5>الملابس</h5>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="category-card text-center">
                    <i class="bi bi-house category-icon"></i>
                    <h5>الأجهزة المنزلية</h5>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="category-card text-center">
                    <i class="bi bi-book category-icon"></i>
                    <h5>الكتب</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Special Offers -->
    <div class="container mb-5">
        <div class="offer-banner">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2><?php echo e($labels['special_offers']); ?></h2>
                    <p class="lead mb-0">خصم يصل إلى 50% على المنتجات المختارة</p>
                </div>
                <div class="col-md-4 text-center">
                    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-dark btn-lg">
                        تسوق الآن
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="container mb-5">
        <h2 class="section-title"><?php echo e($labels['testimonials']); ?></h2>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">"خدمة رائعة وسرعة في التوصيل!"</p>
                        <footer class="blockquote-footer">أحمد</footer>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">"منتجات عالية الجودة وأسعار مناسبة."</p>
                        <footer class="blockquote-footer">سارة</footer>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">"تجربة تسوق ممتازة وسهولة في الدفع."</p>
                        <footer class="blockquote-footer">محمد</footer>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Navigation -->
    <div class="container mb-4">
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="quick-nav-card">
                    <h5><i class="bi bi-grid"></i> <?php echo e($labels['categories']); ?></h5>
                    <ul class="quick-nav-list">
                        <li><a href="<?php echo e(route('products.index')); ?>">الإلكترونيات</a></li>
                        <li><a href="<?php echo e(route('products.index')); ?>">الملابس</a></li>
                        <li><a href="<?php echo e(route('products.index')); ?>">الأجهزة المنزلية</a></li>
                        <li><a href="<?php echo e(route('products.index')); ?>">الكتب</a></li>
                        <li><a href="<?php echo e(route('products.index')); ?>">الرياضة</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="quick-nav-card">
                    <h5><i class="bi bi-cart3"></i> <?php echo e($labels['cart']); ?></h5>
                    <ul class="quick-nav-list">
                        <li><a href="<?php echo e(route('cart.index')); ?>">عرض السلة</a></li>
                        <li><a href="<?php echo e(route('checkout')); ?>">إتمام الشراء</a></li>
                        <li><a href="<?php echo e(route('products.index')); ?>">متابعة التسوق</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="quick-nav-card">
                    <h5><i class="bi bi-info-circle"></i> معلومات</h5>
                    <ul class="quick-nav-list">
                        <li><a href="<?php echo e(route('about')); ?>"><?php echo e($labels['about']); ?></a></li>
                        <li><a href="<?php echo e(route('contact')); ?>"><?php echo e($labels['contact']); ?></a></li>
                        <li><a href="<?php echo e(route('blog.index')); ?>"><?php echo e($labels['blog']); ?></a></li>
                        <li><a href="#">سياسة الخصوصية</a></li>
                        <li><a href="#">الشروط والأحكام</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="quick-nav-card">
                    <h5><i class="bi bi-person-circle"></i> حسابي</h5>
                    <ul class="quick-nav-list">
                        <?php if(auth()->guard()->guest()): ?>
                            <li><a href="<?php echo e(route('login')); ?>"><?php echo e($labels['login']); ?></a></li>
                            <li><a href="<?php echo e(route('register')); ?>"><?php echo e($labels['register']); ?></a></li>
                        <?php else: ?>
                            <li><a href="<?php echo e(route('user.dashboard')); ?>"><?php echo e($labels['dashboard']); ?></a></li>
                            <li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e($labels['admin_panel']); ?></a></li>
                            <li><a href="<?php echo e(route('logout')); ?>"><?php echo e($labels['logout']); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\laravel-store-project\resources\views/welcome.blade.php ENDPATH**/ ?>