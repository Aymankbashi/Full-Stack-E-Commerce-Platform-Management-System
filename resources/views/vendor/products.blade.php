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
    <title>{{ $labels['my_products'] ?? 'منتجاتي' }}</title>
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
        .page-header {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        .product-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
            transition: transform 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .product-details {
            padding: 1.5rem;
        }
        .product-name {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .product-price {
            color: #3358e6;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        .product-category {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .product-status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .status-active {
            background: #d1fae5;
            color: #065f46;
        }
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        .product-actions {
            display: flex;
            justify-content: space-between;
        }
        .empty-products {
            text-align: center;
            padding: 3rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
        }
        .empty-products i {
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

    <!-- Products Content -->
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>{{ $labels['my_products'] ?? 'منتجاتي' }}</h1>
            <a href="{{ route('vendor.createProduct') }}" class="btn btn-primary-custom">
                <i class="bi bi-plus-circle"></i> {{ $labels['add_product'] ?? 'إضافة منتج' }}
            </a>
        </div>

        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                        <div class="product-details">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <div class="product-price">
                                @if($product->old_price)
                                    <span class="text-decoration-line-through text-muted">${{ number_format($product->old_price, 2) }}</span>
                                @endif
                                ${{ number_format($product->price, 2) }}
                            </div>
                            <div class="product-category">{{ $product->category }}</div>

                            <span class="product-status status-{{ $product->status }}">
                                {{ $labels['product_status_' . $product->status] ?? $product->status }}
                            </span>

                            <div class="product-actions">
                                <a href="{{ route('vendor.editProduct', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> {{ $labels['edit'] ?? 'تعديل' }}
                                </a>
                                <form action="{{ route('vendor.destroyProduct', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ $labels['confirm_delete'] ?? 'هل أنت متأكد من الحذف؟' }}')">
                                        <i class="bi bi-trash"></i> {{ $labels['delete'] ?? 'حذف' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        @else
            <div class="empty-products">
                <i class="bi bi-box"></i>
                <h2>{{ $labels['no_products'] ?? 'لم تقم بإضافة أي منتجات بعد' }}</h2>
                <p class="text-muted">{{ $labels['add_product_desc'] ?? 'ابدأ بإضافة منتجات لعرضها في متجرك' }}</p>
                <a href="{{ route('vendor.createProduct') }}" class="btn btn-primary">{{ $labels['add_product'] ?? 'إضافة منتج' }}</a>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
