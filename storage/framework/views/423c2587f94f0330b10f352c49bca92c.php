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
    <title><?php echo $__env->yieldContent('title', $labels['site_title']); ?></title>
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
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
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
                                <?php if(Auth::user()->role === 'admin'): ?>
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

    <!-- Content -->
    <?php echo $__env->yieldContent('content'); ?>

    <!-- Footer -->
    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\laravel-store-project\resources\views/layouts/app.blade.php ENDPATH**/ ?>