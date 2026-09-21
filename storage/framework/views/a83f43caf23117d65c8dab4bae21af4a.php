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
    <title><?php echo e($product->name); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 2rem auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(51, 88, 230, 0.08);
            padding: 2rem 1.5rem;
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
        }
        .product-image {
            flex: 1 1 320px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .product-image img {
            max-width: 320px;
            max-height: 320px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.10);
        }
        .product-details {
            flex: 2 1 400px;
        }
        .product-name {
            font-size: 2rem;
            font-weight: 700;
            color: #3358e6;
            margin-bottom: 1rem;
        }
        .product-desc {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 1.2rem;
        }
        .product-price {
            color: #e53e3e;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .product-old-price {
            color: #888;
            font-size: 1.1rem;
            text-decoration: line-through;
            margin-right: 0.7rem;
        }
        .product-category {
            background: #f4f7fa;
            color: #3358e6;
            font-size: 1rem;
            border-radius: 6px;
            padding: 0.2rem 0.9rem;
            margin-bottom: 1rem;
            display: inline-block;
        }
        .product-actions {
            margin-top: 1.5rem;
            display: flex;
            gap: 1rem;
        }
        .btn {
            background: linear-gradient(90deg, #4f8cff 0%, #3358e6 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 700;
            padding: 0.7rem 2.2rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn:hover {
            background: linear-gradient(90deg, #3358e6 0%, #4f8cff 100%);
        }
        .reviews {
            margin-top: 2.5rem;
        }
        .reviews-title {
            color: #3358e6;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .review {
            background: #f8fafc;
            border-radius: 8px;
            padding: 1rem 1.2rem;
            margin-bottom: 1rem;
        }
        .review-author {
            color: #3358e6;
            font-weight: 600;
            margin-top: 0.5rem;
        }
        .lang-switch {
            margin-bottom: 1.5rem;
            text-align: left;
        }
        .lang-switch a {
            color: #3358e6;
            text-decoration: none;
            margin: 0 0.3rem;
            font-weight: 600;
        }
    </style>
</head>
<body style="direction: <?php echo e($dir); ?>;">

    <div class="container">
        <div class="product-image">
            <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="صورة المنتج">
        </div>
        <div class="product-details">
            <div class="product-category"><?php echo e($product->category); ?></div>
            <div class="product-name"><?php echo e($product->name); ?></div>
            <div class="product-desc"><?php echo e($product->description); ?></div>
            <div>
                <?php if($product->old_price): ?>
                    <span class="product-old-price">$<?php echo e($product->old_price); ?></span>
                <?php endif; ?>
                <span class="product-price">$<?php echo e($product->price); ?></span>
            </div>
            <div class="product-actions">
                <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="number" name="quantity" value="1" min="1" style="width:60px; margin-left:1rem;">
                    <button type="submit" class="btn"><?php echo e($labels['cart'] ?? 'أضف إلى السلة'); ?></button>
                </form>
                
                <!-- زر إضافة للمفضلة -->
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('login', ['intended' => request()->url()])); ?>" class="btn btn-outline-danger" style="margin-left:1rem;">
                        <i class="bi bi-heart"></i> <?php echo e($labels['wishlist'] ?? 'إضافة للمفضلة'); ?>

                    </a>
                <?php else: ?>
                    <form action="<?php echo e(route('wishlist.add', $product->id)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-outline-danger" style="margin-left:1rem;">
                            <i class="bi bi-heart"></i> <?php echo e($labels['wishlist'] ?? 'إضافة للمفضلة'); ?>

                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container reviews">
        <div class="reviews-title"><?php echo e($labels['testimonials'] ?? 'تقييمات العملاء'); ?></div>
        <?php $__empty_1 = true; $__currentLoopData = $product->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="review">
                <div class="review-author"><?php echo e($review->user->name ?? 'مستخدم'); ?></div>
                <div><?php echo e(str_repeat('★', $review->rating)); ?><?php echo e(str_repeat('☆', 5 - $review->rating)); ?></div>
                <div><?php echo e($review->comment); ?></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div><?php echo e($labels['no_reviews'] ?? 'لا توجد مراجعات بعد.'); ?></div>
        <?php endif; ?>
        <div class="add-review" style="margin-top:2rem;">
            <?php if(auth()->guard()->guest()): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> <?php echo e($labels['login_to_review'] ?? 'يجب تسجيل الدخول لإضافة مراجعة'); ?> 
                    <a href="<?php echo e(route('login', ['intended' => request()->url()])); ?>" class="btn btn-primary btn-sm ms-2"><?php echo e($labels['login']); ?></a>
                </div>
            <?php else: ?>
                <form action="<?php echo e(route('products.review', $product->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <label><?php echo e($labels['add_review'] ?? 'أضف مراجعتك'); ?></label>
                    <textarea name="comment" rows="3" required></textarea>
                    <label><?php echo e($labels['rating'] ?? 'التقييم'); ?></label>
                    <select name="rating" required>
                        <option value="5">5</option>
                        <option value="4">4</option>
                        <option value="3">3</option>
                        <option value="2">2</option>
                        <option value="1">1</option>
                    </select>
                    <button type="submit" class="btn"><?php echo e($labels['add_review'] ?? 'أضف مراجعتك'); ?></button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\laravel-store-project\resources\views/products/show.blade.php ENDPATH**/ ?>