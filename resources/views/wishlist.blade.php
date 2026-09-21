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
    <title>{{ $labels['wishlist'] ?? 'قائمة الرغبات' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .wishlist-header {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
        }
        .wishlist-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: transform 0.3s;
        }
        .wishlist-card:hover {
            transform: translateY(-5px);
        }
        .wishlist-image {
            height: 200px;
            object-fit: cover;
        }
        .wishlist-price {
            color: #3358e6;
            font-weight: 700;
            font-size: 1.2rem;
        }
        .wishlist-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }
        .empty-wishlist {
            text-align: center;
            padding: 3rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
        }
        .empty-wishlist i {
            font-size: 4rem;
            color: #ccc;
            margin-bottom: 1rem;
        }
        .navbar {
            background: #fff;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    @include('partials.navbar')

    <!-- Wishlist Content -->
    <div class="container">
        <div class="wishlist-header">
            <h1>{{ $labels['wishlist'] ?? 'قائمة الرغبات' }}</h1>
            <p class="text-muted">{{ $labels['wishlist_desc'] ?? 'المنتجات التي أضفتها إلى قائمة الرغبات' }}</p>
        </div>

        @if($wishlistItems && count($wishlistItems) > 0)
            <div class="row">
                @foreach($wishlistItems as $item)
                    <div class="col-md-4">
                        <div class="wishlist-card">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="wishlist-image w-100">
                            <div class="p-3">
                                <h3>{{ $item->name }}</h3>
                                <p class="wishlist-price">${{ $item->price }}</p>
                                @if($item->old_price)
                                    <p class="text-muted text-decoration-line-through">${{ $item->old_price }}</p>
                                @endif
                                <p class="text-muted">{{ $item->category }}</p>
                                <div class="wishlist-actions">
                                    <a href="{{ route('products.show', $item->id) }}" class="btn btn-primary">{{ $labels['view_product'] ?? 'عرض المنتج' }}</a>
                                    <form action="{{ route('cart.add', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-success">{{ $labels['add_to_cart'] ?? 'أضف للسلة' }}</button>
                                    </form>
                                    <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-wishlist">
                <i class="bi bi-heart"></i>
                <h2>{{ $labels['empty_wishlist'] ?? 'قائمة الرغبات فارغة' }}</h2>
                <p class="text-muted">{{ $labels['empty_wishlist_desc'] ?? 'لم تضف أي منتجات إلى قائمة الرغبات بعد' }}</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">{{ $labels['continue_shopping'] ?? 'متابعة التسوق' }}</a>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
