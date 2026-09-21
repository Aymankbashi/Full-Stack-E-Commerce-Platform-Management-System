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
    <title><?php echo e($labels['contact'] ?? 'دعم العملاء'); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background: #f4f7fa; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 2rem auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 16px rgba(51,88,230,0.08); padding: 2rem; }
        h2 { color: #3358e6; margin-bottom: 1.5rem; }
        .section-title { color: #3358e6; font-size: 1.1rem; font-weight: bold; margin-bottom: 1rem; }
        ul { padding-right: 1.5rem; }
        li { margin-bottom: 0.7rem; }
        .faq { margin-bottom: 2rem; }
        .contact-info { margin-top: 2rem; }
        .chat-btn { background: linear-gradient(90deg, #4f8cff 0%, #3358e6 100%); color: #fff; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: 700; padding: 0.7rem 2.2rem; cursor: pointer; transition: background 0.2s; }
        .chat-btn:hover { background: linear-gradient(90deg, #3358e6 0%, #4f8cff 100%); }
    </style>
</head>
<body style="direction: <?php echo e($dir); ?>;">
    <div class="container">
        <h2><?php echo e($labels['contact'] ?? 'دعم العملاء'); ?></h2>
        <div class="section-title"><?php echo e($labels['faq'] ?? 'الأسئلة الشائعة'); ?></div>
        <div class="faq">
            <ul>
                <li>كيف يمكنني تتبع طلبي؟<br><span style="color:#888;">يمكنك تتبع حالة الطلب من خلال صفحة حسابك أو التواصل مع الدعم.</span></li>
                <li>ما هي طرق الدفع المتاحة؟<br><span style="color:#888;">نقبل الدفع عند الاستلام وبطاقات الائتمان.</span></li>
                <li>كيف أسترجع منتجًا؟<br><span style="color:#888;">يمكنك طلب الإرجاع خلال 14 يومًا من الاستلام عبر صفحة الطلبات.</span></li>
            </ul>
        </div>
        <div class="section-title"><?php echo e($labels['contact_options'] ?? 'خيارات التواصل'); ?></div>
        <div class="contact-info">
            <a href="<?php echo e(route('support.landing')); ?>" class="chat-btn" style="display:inline-block;text-decoration:none;"><?php echo e($labels['chat_support'] ?? 'الدعم عبر الدردشة'); ?></a>
            <div style="margin-top:1rem;"><?php echo e($labels['phone'] ?? 'رقم الهاتف'); ?>: <b>9200 12345</b></div>
            <div style="margin-top:0.5rem;"><?php echo e($labels['email'] ?? 'البريد الإلكتروني'); ?>: <b>support@example.com</b></div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\laravel-store-project\resources\views/support.blade.php ENDPATH**/ ?>