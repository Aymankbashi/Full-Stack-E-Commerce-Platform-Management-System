@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $labels = require base_path('lang/' . $locale . '.php');
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $labels['blog'] ?? 'المدونة' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background: #f4f7fa; margin: 0; padding: 0; }
        .container { max-width: 900px; margin: 2rem auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 16px rgba(51,88,230,0.08); padding: 2rem; }
        h2 { color: #3358e6; margin-bottom: 2rem; }
        .blog-list { display: flex; flex-wrap: wrap; gap: 2rem; }
        .blog-card { background: #f8fafc; border-radius: 12px; box-shadow: 0 2px 8px rgba(51,88,230,0.07); padding: 1.2rem 2rem; min-width: 260px; flex: 1 1 260px; }
        .blog-title { color: #3358e6; font-size: 1.2rem; font-weight: bold; margin-bottom: 0.7rem; }
        .blog-date { color: #888; font-size: 0.95rem; margin-bottom: 0.5rem; }
        .blog-excerpt { color: #333; font-size: 1rem; margin-bottom: 0.7rem; }
        .read-more { color: #3358e6; text-decoration: underline; font-weight: 600; }
    </style>
</head>
<body style="direction: {{ $dir }};">
    <div class="container">
        <h2>{{ $labels['blog'] ?? 'المدونة' }}</h2>
        <div class="blog-list">
            <div class="blog-card">
                <div class="blog-title">أهم نصائح التسوق الإلكتروني</div>
                <div class="blog-date">2026-03-31</div>
                <div class="blog-excerpt">تعرف على أفضل الطرق لتسوق آمن وذكي عبر الإنترنت.</div>
                <a href="#" class="read-more">اقرأ المزيد</a>
            </div>
            <div class="blog-card">
                <div class="blog-title">كيف تختار المنتج المناسب؟</div>
                <div class="blog-date">2026-03-25</div>
                <div class="blog-excerpt">دليل عملي لمساعدتك في اختيار المنتجات التي تلبي احتياجاتك.</div>
                <a href="#" class="read-more">اقرأ المزيد</a>
            </div>
            <div class="blog-card">
                <div class="blog-title">تحديثات وعروض المتجر</div>
                <div class="blog-date">2026-03-15</div>
                <div class="blog-excerpt">تابع آخر العروض والتخفيضات على منتجاتنا.</div>
                <a href="#" class="read-more">اقرأ المزيد</a>
            </div>
        </div>
    </div>
</body>
</html>
