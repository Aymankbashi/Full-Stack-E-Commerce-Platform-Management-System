<?php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $labels = require base_path('lang/' . $locale . '.php');
?>
<!DOCTYPE html>
<html lang="<?php echo e($locale); ?>" dir="<?php echo e($dir); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($labels['view_products']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Cairo', sans-serif;
            background: #eaeded;
            margin: 0;
            padding: 0;
        }

        /* Amazon-style Header */
        .amazon-header {
            background: #131921;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .amazon-logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .amazon-logo span {
            color: #febd69;
        }

        .amazon-search {
            flex: 1;
            max-width: 800px;
            margin: 0 20px;
            display: flex;
            border-radius: 4px;
            overflow: hidden;
        }

        .amazon-search input {
            flex: 1;
            padding: 10px 15px;
            border: none;
            outline: none;
            font-size: 1rem;
        }

        .amazon-search button {
            background: #febd69;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.2s;
        }

        .amazon-search button:hover {
            background: #f3a847;
        }

        .amazon-nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .amazon-nav a {
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .amazon-nav a:hover {
            color: #febd69;
        }

        .amazon-nav .cart {
            display: flex;
            align-items: center;
            gap: 5px;
            background: #febd69;
            padding: 8px 15px;
            border-radius: 4px;
        }

        /* Hero Section */
        .amazon-hero {
            background: linear-gradient(to bottom, #131921, #232f3e);
            padding: 40px 20px;
            text-align: center;
            color: #fff;
            margin-bottom: -150px;
            position: relative;
            z-index: 1;
        }

        .amazon-hero h1 {
            font-size: 2.5rem;
            margin: 0;
            padding-bottom: 10px;
        }

        .amazon-hero p {
            font-size: 1.2rem;
            margin: 0;
            opacity: 0.9;
        }

        /* Products Section */
        .amazon-products {
            background: #fff;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
            z-index: 2;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .amazon-products h2 {
            font-size: 1.8rem;
            color: #007185;
            margin: 0 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 10px;
        }

        .product-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.2s, transform 0.2s;
            cursor: pointer;
        }

        .product-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: contain;
            margin-bottom: 15px;
            background: #f7f7f7;
            border-radius: 4px;
        }

        .product-category {
            color: #565959;
            font-size: 0.85rem;
            margin-bottom: 5px;
        }

        .product-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #007185;
            margin-bottom: 10px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-rating {
            color: #ffa41c;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .product-rating span {
            color: #007185;
            font-size: 0.85rem;
            margin-left: 5px;
        }

        .product-price {
            display: flex;
            align-items: baseline;
            gap: 10px;
            margin-bottom: 10px;
        }

        .product-price .current {
            font-size: 1.5rem;
            font-weight: 700;
            color: #B12704;
        }

        .product-price .old {
            font-size: 1rem;
            color: #565959;
            text-decoration: line-through;
        }

        .product-price .discount {
            font-size: 0.9rem;
            color: #B12704;
        }

        .product-desc {
            color: #565959;
            font-size: 0.9rem;
            margin-bottom: 15px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-min {
            color: #565959;
            font-size: 0.85rem;
            margin-bottom: 15px;
        }

        .product-actions {
            margin-top: auto;
            display: flex;
            gap: 10px;
        }

        .btn {
            flex: 1;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-primary {
            background: #ffd814;
            color: #0F1111;
        }

        .btn-primary:hover {
            background: #f7ca00;
        }

        .btn-secondary {
            background: #f0f2f2;
            color: #0F1111;
        }

        .btn-secondary:hover {
            background: #e3e6e6;
        }

        /* Footer */
        .amazon-footer {
            background: #232f3e;
            color: #fff;
            padding: 40px 20px;
            margin-top: 40px;
            text-align: center;
        }

        .amazon-footer a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
        }

        .amazon-footer a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .amazon-header {
                flex-wrap: wrap;
                padding: 10px;
            }

            .amazon-search {
                order: 3;
                width: 100%;
                margin: 10px 0 0 0;
                max-width: none;
            }

            .amazon-nav {
                gap: 10px;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 15px;
            }

            .product-card {
                padding: 10px;
            }

            .product-image {
                height: 150px;
            }

            .product-name {
                font-size: 1rem;
            }

            .product-price .current {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body style="direction: <?php echo e($dir); ?>;">
    <!-- Amazon-style Header -->
    <div class="amazon-header">
        <a href="/" class="amazon-logo">
            MyStore<span>.com</span>
        </a>

        <div class="amazon-search">
            <form action="<?php echo e(route('products.index')); ?>" method="GET" style="display: flex; width: 100%;">
                <input type="text" name="search" placeholder="<?php echo e($labels['search'] ?? 'ابحث عن منتجات...'); ?>" value="<?php echo e(request('search')); ?>">
                <button type="submit"><?php echo e($labels['search_btn'] ?? 'بحث'); ?></button>
            </form>
        </div>

        <div class="amazon-nav">
            <a href="/dashboard"><?php echo e($labels['dashboard'] ?? 'لوحة التحكم'); ?></a>
            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('login')); ?>"><?php echo e($labels['login']); ?></a>
                <a href="<?php echo e(route('register')); ?>?admin=1"><?php echo e($labels['register']); ?></a>
            <?php else: ?>
                <a href="#"><?php echo e(Auth::user()->name); ?></a>
                <form method="POST" action="<?php echo e(route('logout')); ?>" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" style="background:none;border:none;color:#fff;cursor:pointer;font-size:0.9rem;"><?php echo e($labels['logout'] ?? 'تسجيل الخروج'); ?></button>
                </form>
            <?php endif; ?>
            <a href="/cart" class="cart">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span><?php echo e($labels['cart'] ?? 'السلة'); ?></span>
            </a>

        </div>
    </div>

    <!-- Hero Section -->
    <div class="amazon-hero">
        <h1><?php echo e($labels['welcome'] ?? 'مرحباً بك في متجرنا'); ?></h1>
        <p><?php echo e($labels['hero_text'] ?? 'اكتشف أفضل المنتجات بأفضل الأسعار'); ?></p>
        <a href="<?php echo e(route('welcome')); ?>" class="btn btn-outline-light">
            <i class="bi bi-arrow-right"></i> العودة للرئيسية
        </a>
    </div>

    <!-- Products Section -->
    <div class="amazon-products">
        <h2><?php echo e($labels['featured_products'] ?? 'المنتجات المميزة'); ?></h2>

        <div class="products-grid">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="product-card">
                    <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" class="product-image">
                    <div class="product-category"><?php echo e($product->category); ?></div>
                    <div class="product-name"><?php echo e($product->name); ?></div>
                    <div class="product-rating">
                        ★★★★☆ <span>(4.5)</span>
                    </div>
                    <div class="product-price">
                        <span class="current">$<?php echo e(number_format($product->price, 2)); ?></span>
                        <?php if($product->old_price): ?>
                            <span class="old">$<?php echo e(number_format($product->old_price, 2)); ?></span>
                            <span class="discount">
                                <?php echo e(round((($product->old_price - $product->price) / $product->old_price) * 100)); ?>%
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="product-desc"><?php echo e($product->description); ?></div>
                    <div class="product-min"><?php echo e($labels['min_quantity'] ?? 'الحد الأدنى للكمية'); ?>: <?php echo e($product->min_quantity); ?></div>
                    <div class="product-actions">
                        <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST" style="display: flex; flex: 1;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary" style="width: 100%;">
                                <?php echo e($labels['add_to_cart'] ?? 'أضف للسلة'); ?>

                            </button>
                        </form>
                        <a href="<?php echo e(route('products.show', $product->id)); ?>" class="btn btn-secondary" style="display: flex; align-items: center; justify-content: center; text-decoration: none;">
                            <?php echo e($labels['view_details'] ?? 'التفاصيل'); ?>

                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #565959;">
                    <?php echo e($labels['no_products'] ?? 'لا توجد منتجات حالياً.'); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Amazon-style Footer -->
    <div class="amazon-footer">
        <a href="/"><?php echo e($labels['home'] ?? 'الرئيسية'); ?></a>
        <a href="/about"><?php echo e($labels['about'] ?? 'من نحن'); ?></a>
        <a href="/support"><?php echo e($labels['support'] ?? 'الدعم'); ?></a>
        <a href="/terms"><?php echo e($labels['terms'] ?? 'الشروط والأحكام'); ?></a>
        <a href="/privacy"><?php echo e($labels['privacy'] ?? 'سياسة الخصوصية'); ?></a>
        <p style="margin-top: 20px; color: #999;">© 2024 MyStore.com <?php echo e($labels['all_rights'] ?? 'جميع الحقوق محفوظة'); ?></p>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\laravel-store-project\resources\views/products/index.blade.php ENDPATH**/ ?>