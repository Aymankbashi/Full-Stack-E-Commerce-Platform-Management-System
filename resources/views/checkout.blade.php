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
    <title>{{ $labels['checkout'] ?? 'الدفع' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background: #f4f7fa; margin: 0; padding: 0; }
        .container { max-width: 900px; margin: 2rem auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 16px rgba(51,88,230,0.08); padding: 2rem; }
        h2 { color: #3358e6; margin-bottom: 2rem; }
        .section-title { color: #3358e6; font-size: 1.1rem; font-weight: bold; margin-bottom: 1rem; }
        .form-group { margin-bottom: 1.2rem; }
        label { display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500; }
        input, select { width: 100%; padding: 0.7rem 0.9rem; border: 1px solid #dbeafe; border-radius: 8px; font-size: 1rem; background: #f8fafc; margin-bottom: 0.5rem; }
        .btn { background: linear-gradient(90deg, #4f8cff 0%, #3358e6 100%); color: #fff; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: 700; padding: 0.7rem 2.2rem; cursor: pointer; transition: background 0.2s; }
        .btn:hover { background: linear-gradient(90deg, #3358e6 0%, #4f8cff 100%); }
        .order-summary { margin-top: 2rem; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 1rem; }
        th, td { padding: 0.7rem; border-bottom: 1px solid #e5e7eb; text-align: center; }
        th { background: #f4f7fa; color: #3358e6; font-weight: bold; }
        .total { font-size: 1.2rem; color: #e53e3e; font-weight: bold; text-align: right; }
    </style>
</head>
<body style="direction: {{ $dir }};">
    <div class="container">
        <h2>{{ $labels['checkout'] ?? 'الدفع' }}</h2>
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="section-title">{{ $labels['shipping_info'] ?? 'معلومات الشحن' }}</div>
            <div class="form-group">
                <label>{{ $labels['name'] ?? 'الاسم الكامل' }}</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>{{ $labels['address'] ?? 'العنوان' }}</label>
                <input type="text" name="address" required>
            </div>
            <div class="form-group">
                <label>{{ $labels['phone'] ?? 'رقم الهاتف' }}</label>
                <input type="text" name="phone" required>
            </div>
            <div class="section-title">{{ $labels['payment_method'] ?? 'طريقة الدفع' }}</div>
            <div class="form-group">
                <select name="payment_method" required>
                    <option value="cod">{{ $labels['cash_on_delivery'] ?? 'الدفع عند الاستلام' }}</option>
                    <option value="card">{{ $labels['credit_card'] ?? 'بطاقة ائتمان' }}</option>
                </select>
            </div>
            <div class="order-summary">
                <div class="section-title">{{ $labels['order_summary'] ?? 'ملخص الطلب' }}</div>
                <table>
                    <thead>
                        <tr>
                            <th>{{ $labels['view_products'] ?? 'المنتج' }}</th>
                            <th>{{ $labels['quantity'] ?? 'الكمية' }}</th>
                            <th>{{ $labels['price'] ?? 'السعر' }}</th>
                            <th>{{ $labels['total'] ?? 'الإجمالي' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $item)
                            @php $itemTotal = $item['price'] * $item['quantity']; $total += $itemTotal; @endphp
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>${{ $item['price'] }}</td>
                                <td>${{ $itemTotal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="total">{{ $labels['total'] ?? 'الإجمالي' }}: ${{ $total }}</div>
            </div>
            <button type="submit" class="btn">{{ $labels['confirm_order'] ?? 'تأكيد الطلب' }}</button>
        </form>
    </div>
</body>
</html>
