<?php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $labels = require base_path('lang/' . $locale . '.php');
    $cart = session('cart', []);
    $total = 0;
?>
<!DOCTYPE html>
<html lang="<?php echo e($locale); ?>" dir="<?php echo e($dir); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($labels['cart'] ?? 'عربة التسوق'); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background: #f4f7fa; margin: 0; padding: 0; }
        .container { max-width: 900px; margin: 2rem auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 16px rgba(51,88,230,0.08); padding: 2rem; }
        h2 { color: #3358e6; margin-bottom: 2rem; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
        th, td { padding: 1rem; border-bottom: 1px solid #e5e7eb; text-align: center; }
        th { background: #f4f7fa; color: #3358e6; font-weight: bold; }
        .product-img { width: 60px; height: 60px; object-fit: contain; border-radius: 8px; }
        .btn { background: linear-gradient(90deg, #4f8cff 0%, #3358e6 100%); color: #fff; border: none; border-radius: 8px; font-size: 1rem; font-weight: 700; padding: 0.4rem 1.2rem; cursor: pointer; transition: background 0.2s; }
        .btn:hover { background: linear-gradient(90deg, #3358e6 0%, #4f8cff 100%); }
        .total { font-size: 1.3rem; color: #e53e3e; font-weight: bold; text-align: right; margin-bottom: 2rem; }
        .checkout { text-align: right; }
    </style>
</head>
<body style="direction: <?php echo e($dir); ?>;">
    <div class="container">
        <h2><?php echo e($labels['cart'] ?? 'عربة التسوق'); ?></h2>
        <?php if(count($cart) > 0): ?>
        <form action="<?php echo e(route('cart.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th><?php echo e($labels['view_products'] ?? 'المنتج'); ?></th>
                        <th><?php echo e($labels['price'] ?? 'السعر'); ?></th>
                        <th><?php echo e($labels['quantity'] ?? 'الكمية'); ?></th>
                        <th><?php echo e($labels['total'] ?? 'الإجمالي'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $itemTotal = $item['price'] * $item['quantity']; $total += $itemTotal; ?>
                        <tr>
                            <td><img src="<?php echo e(asset('storage/' . $item['image'])); ?>" class="product-img"></td>
                            <td><?php echo e($item['name']); ?></td>
                            <td>$<?php echo e($item['price']); ?></td>
                            <td><input type="number" name="quantities[<?php echo e($id); ?>]" value="<?php echo e($item['quantity']); ?>" min="1" style="width:60px;"></td>
                            <td>$<?php echo e($itemTotal); ?></td>
                            <td><a href="<?php echo e(route('cart.remove', $id)); ?>" class="btn" style="background:#fff;color:#e53e3e;border:1px solid #e53e3e;">&times;</a></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <div class="total"><?php echo e($labels['total'] ?? 'الإجمالي'); ?>: $<?php echo e($total); ?></div>
            <div class="checkout">
                <button type="submit" class="btn"><?php echo e($labels['update_cart'] ?? 'تحديث السلة'); ?></button>
                <a href="<?php echo e(route('checkout')); ?>" class="btn"><?php echo e($labels['checkout'] ?? 'الدفع'); ?></a>
            </div>
        </form>
        <?php else: ?>
            <div><?php echo e($labels['cart_empty'] ?? 'سلة التسوق فارغة.'); ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\laravel-store-project\resources\views/cart/index.blade.php ENDPATH**/ ?>