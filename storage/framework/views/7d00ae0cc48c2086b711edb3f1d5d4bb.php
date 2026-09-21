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
    <title><?php echo e($labels['about'] ?? 'حول الشركة'); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background: #f4f7fa; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 2rem auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 16px rgba(51,88,230,0.08); padding: 2rem; }
        h2 { color: #3358e6; margin-bottom: 1.5rem; }
        .section-title { color: #3358e6; font-size: 1.1rem; font-weight: bold; margin-bottom: 1rem; }
        ul { padding-right: 1.5rem; }
        li { margin-bottom: 0.7rem; }
    </style>
</head>
<body style="direction: <?php echo e($dir); ?>;">
    <div class="container">
        <h2><?php echo e($labels['about'] ?? 'حول الشركة'); ?></h2>
        <div class="section-title"><?php echo e($labels['company_intro'] ?? 'نبذة عن الشركة'); ?></div>
        <p>نحن متجر إلكتروني متخصص في تقديم أفضل المنتجات بأعلى جودة وأفضل الأسعار. نؤمن بأهمية رضا العملاء ونسعى لتقديم تجربة تسوق سهلة وآمنة.</p>
        <div class="section-title"><?php echo e($labels['shipping_policy'] ?? 'سياسة الشحن'); ?></div>
        <ul>
            <li>شحن سريع لجميع المناطق.</li>
            <li>توصيل مجاني للطلبات فوق 500 ريال.</li>
            <li>إمكانية تتبع الشحنة عبر الموقع.</li>
        </ul>
        <div class="section-title"><?php echo e($labels['return_policy'] ?? 'سياسة الإرجاع'); ?></div>
        <ul>
            <li>إرجاع مجاني خلال 14 يومًا من الاستلام.</li>
            <li>يجب أن يكون المنتج بحالته الأصلية وغير مستخدم.</li>
            <li>استرداد المبلغ خلال 5 أيام عمل بعد استلام المنتج المرتجع.</li>
        </ul>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\laravel-store-project\resources\views/about.blade.php ENDPATH**/ ?>