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
    <title>{{ $labels['my_orders'] ?? 'طلباتي' }}</title>
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
        .orders-header {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
        }
        .order-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }
        .order-header {
            background: #f8fafc;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .order-status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        .status-shipped {
            background: #dbeafe;
            color: #1e40af;
        }
        .status-delivered {
            background: #d1fae5;
            color: #065f46;
        }
        .order-products {
            padding: 1.5rem;
        }
        .order-product {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .order-product:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 1rem;
        }
        .empty-orders {
            text-align: center;
            padding: 3rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
        }
        .empty-orders i {
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

    <!-- Orders Content -->
    <div class="container">
        <div class="orders-header">
            <h1>{{ $labels['my_orders'] ?? 'طلباتي' }}</h1>
            <p class="text-muted">{{ $labels['orders_desc'] ?? 'إدارة طلباتك السابقة والجديدة' }}</p>
        </div>

        @if($orders && count($orders) > 0)
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header d-flex justify-content-between align-items-center">
                        <div>
                            <h3>{{ $labels['order_number'] ?? 'رقم الطلب' }}: #{{ $order->id }}</h3>
                            <p class="text-muted mb-0">{{ $labels['order_date'] ?? 'تاريخ الطلب' }}: {{ date('Y-m-d', strtotime($order->created_at)) }}</p>
                        </div>
                        <span class="order-status status-{{ $order->status }}">
                            {{ $labels[$order->status] ?? $order->status }}
                        </span>
                    </div>

                    <div class="order-products">
                        @foreach($order->products as $product)
                            <div class="order-product">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                                <div class="flex-grow-1">
                                    <h5>{{ $product->name }}</h5>
                                    <p class="text-muted">{{ $product->category }}</p>
                                </div>
                                <div class="text-end">
                                    <p class="mb-0">{{ $product->pivot->quantity }} × ${{ $product->price }}</p>
                                    <p class="fw-bold mb-0">${{ $product->pivot->quantity * $product->price }}</p>
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                            <div>
                                <h4>{{ $labels['order_total'] ?? 'إجمالي الطلب' }}: ${{ $order->total }}</h4>
                            </div>
                            <div>
                                @if($order->status === 'pending')
                                    <a href="{{ route('checkout') }}" class="btn btn-primary">{{ $labels['pay_now'] ?? 'الدفع الآن' }}</a>
                                @endif
                                <a href="#" class="btn btn-outline-secondary">{{ $labels['view_details'] ?? 'عرض التفاصيل' }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-orders">
                <i class="bi bi-receipt"></i>
                <h2>{{ $labels['no_orders'] ?? 'لا توجد طلبات' }}</h2>
                <p class="text-muted">{{ $labels['no_orders_desc'] ?? 'لم تقم بطلب أي منتجات بعد' }}</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">{{ $labels['start_shopping'] ?? 'ابدأ التسوق' }}</a>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
