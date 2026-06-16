@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $labels = require base_path('lang/' . $locale . '.php');
    $cart = session('cart', []);
    $total = 0;
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $labels['cart'] ?? 'عربة التسوق' }}</title>
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
<body style="direction: {{ $dir }};">
    <div class="container">
        <h2>{{ $labels['cart'] ?? 'عربة التسوق' }}</h2>
        @if(count($cart) > 0)
        <form action="{{ route('cart.update') }}" method="POST">
            @csrf
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>{{ $labels['view_products'] ?? 'المنتج' }}</th>
                        <th>{{ $labels['price'] ?? 'السعر' }}</th>
                        <th>{{ $labels['quantity'] ?? 'الكمية' }}</th>
                        <th>{{ $labels['total'] ?? 'الإجمالي' }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                        @php $itemTotal = $item['price'] * $item['quantity']; $total += $itemTotal; @endphp
                        <tr>
                            <td><img src="{{ asset('storage/' . $item['image']) }}" class="product-img"></td>
                            <td>{{ $item['name'] }}</td>
                            <td>${{ $item['price'] }}</td>
                            <td><input type="number" name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}" min="1" style="width:60px;"></td>
                            <td>${{ $itemTotal }}</td>
                            <td><a href="{{ route('cart.remove', $id) }}" class="btn" style="background:#fff;color:#e53e3e;border:1px solid #e53e3e;">&times;</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="total">{{ $labels['total'] ?? 'الإجمالي' }}: ${{ $total }}</div>
            <div class="checkout">
                <button type="submit" class="btn">{{ $labels['update_cart'] ?? 'تحديث السلة' }}</button>
                <a href="{{ route('checkout') }}" class="btn">{{ $labels['checkout'] ?? 'الدفع' }}</a>
            </div>
        </form>
        @else
            <div>{{ $labels['cart_empty'] ?? 'سلة التسوق فارغة.' }}</div>
        @endif
    </div>
</body>
</html>
