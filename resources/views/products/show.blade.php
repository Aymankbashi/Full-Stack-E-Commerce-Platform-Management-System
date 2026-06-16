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
    <title>{{ $product->name }}</title>
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
<body style="direction: {{ $dir }};">

    <div class="container">
        <div class="product-image">
            <img src="{{ asset('storage/' . $product->image) }}" alt="صورة المنتج">
        </div>
        <div class="product-details">
            <div class="product-category">{{ $product->category }}</div>
            <div class="product-name">{{ $product->name }}</div>
            <div class="product-desc">{{ $product->description }}</div>
            <div>
                @if($product->old_price)
                    <span class="product-old-price">${{ $product->old_price }}</span>
                @endif
                <span class="product-price">${{ $product->price }}</span>
            </div>
            <div class="product-actions">
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1" style="width:60px; margin-left:1rem;">
                    <button type="submit" class="btn">{{ $labels['cart'] ?? 'أضف إلى السلة' }}</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container reviews">
        <div class="reviews-title">{{ $labels['testimonials'] ?? 'تقييمات العملاء' }}</div>
        @forelse($product->reviews as $review)
            <div class="review">
                <div class="review-author">{{ $review->user->name ?? 'مستخدم' }}</div>
                <div>{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</div>
                <div>{{ $review->comment }}</div>
            </div>
        @empty
            <div>{{ $labels['no_reviews'] ?? 'لا توجد مراجعات بعد.' }}</div>
        @endforelse
        <div class="add-review" style="margin-top:2rem;">
            <form action="{{ route('products.review', $product->id) }}" method="POST">
                @csrf
                <label>{{ $labels['add_review'] ?? 'أضف مراجعتك' }}</label>
                <textarea name="comment" rows="3" required></textarea>
                <label>{{ $labels['rating'] ?? 'التقييم' }}</label>
                <select name="rating" required>
                    <option value="5">5</option>
                    <option value="4">4</option>
                    <option value="3">3</option>
                    <option value="2">2</option>
                    <option value="1">1</option>
                </select>
                <button type="submit" class="btn">{{ $labels['add_review'] ?? 'أضف مراجعتك' }}</button>
            </form>
        </div>
    </div>
</body>
</html>
