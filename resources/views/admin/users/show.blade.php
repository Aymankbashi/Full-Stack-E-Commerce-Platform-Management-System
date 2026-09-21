<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $dir ?? 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $labels['user_details'] ?? 'تفاصيل المستخدم' }} - MyStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            color: #333;
        }

        .admin-header {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-top {
            background: #ff9900;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo span {
            color: #fff;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info a {
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: color 0.2s;
        }

        .user-info a:hover {
            color: #fff;
            opacity: 0.8;
        }

        .header-bottom {
            background: #fff;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 0;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .nav-link {
            color: #333;
            text-decoration: none;
            padding: 15px 20px;
            transition: all 0.2s;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 3px solid transparent;
        }

        .nav-link:hover, .nav-link.active {
            color: #ff9900;
            border-bottom-color: #ff9900;
            background: rgba(255,153,0,0.05);
        }

        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .content-section {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            border: 1px solid #f0f0f0;
            overflow: hidden;
        }

        .section-header {
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
        }

        .section-header h2 {
            font-size: 1.3rem;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-content {
            padding: 20px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #ff9900;
            color: #fff;
        }

        .btn-primary:hover {
            background: #e88b00;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(255, 153, 0, 0.2);
        }

        .btn-danger {
            background: #d00;
            color: #fff;
        }

        .btn-danger:hover {
            background: #b00;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(221, 0, 0, 0.2);
        }

        .btn-success {
            background: #067d62;
            color: #fff;
        }

        .btn-success:hover {
            background: #056a53;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(6, 125, 98, 0.2);
        }

        .btn-secondary {
            background: #6c757d;
            color: #fff;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(108, 117, 125, 0.2);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #ff9900;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            font-size: 2rem;
        }

        .user-details {
            flex: 1;
        }

        .user-details h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 5px;
        }

        .user-details p {
            color: #666;
            margin-bottom: 5px;
        }

        .user-meta {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #666;
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .tab {
            padding: 10px 20px;
            background: none;
            border: none;
            border-bottom: 2px solid transparent;
            font-size: 0.95rem;
            color: #666;
            cursor: pointer;
            transition: all 0.2s;
        }

        .tab.active {
            color: #ff9900;
            border-bottom-color: #ff9900;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-badge.active {
            background: #e8f5e9;
            color: #388e3c;
        }

        .status-badge.inactive {
            background: #ffebee;
            color: #c62828;
        }

        .status-badge.pending {
            background: #fff3e0;
            color: #e65100;
        }

        .role-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .role-badge.admin {
            background: #e8f5e9;
            color: #388e3c;
        }

        .role-badge.vendor {
            background: #e3f2fd;
            color: #1976d2;
        }

        .role-badge.user {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #f0f0f0;
        }

        .card h4 {
            margin-bottom: 10px;
            color: #333;
        }

        .card p {
            color: #666;
            margin-bottom: 5px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            border: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-info {
            padding: 15px;
        }

        .product-name {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .product-price {
            font-size: 1.1rem;
            color: #ff9900;
            font-weight: 600;
        }

        .product-status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        .product-status.active {
            background: #e8f5e9;
            color: #388e3c;
        }

        .product-status.inactive {
            background: #ffebee;
            color: #c62828;
        }

        .order-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .order-card {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            border: 1px solid #f0f0f0;
        }

        .order-header {
            padding: 15px;
            background: #f8f9fa;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-header h4 {
            color: #333;
            margin-bottom: 5px;
        }

        .order-id {
            color: #666;
            font-size: 0.9rem;
        }

        .order-content {
            padding: 15px;
        }

        .order-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .order-item img {
            width: 50px;
            height: 50px;
            border-radius: 4px;
            object-fit: cover;
        }

        .order-item-details {
            flex: 1;
        }

        .order-item-name {
            font-size: 0.9rem;
            color: #333;
            font-weight: 500;
        }

        .order-item-price {
            color: #666;
            font-size: 0.85rem;
        }

        .order-footer {
            padding: 15px;
            background: #f8f9fa;
            border-top: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-total {
            font-weight: 600;
            color: #333;
        }

        .order-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .order-status.processing {
            background: #fff3e0;
            color: #e65100;
        }

        .order-status.completed {
            background: #e8f5e9;
            color: #388e3c;
        }

        .order-status.cancelled {
            background: #ffebee;
            color: #c62828;
        }

        @media (max-width: 768px) {
            .header-bottom {
                flex-wrap: wrap;
            }

            .user-profile {
                flex-direction: column;
                text-align: center;
            }

            .user-meta {
                flex-wrap: wrap;
                justify-content: center;
            }

            .tabs {
                flex-wrap: wrap;
            }

            .product-grid,
            .order-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <div class="header-top">
            <a href="/" class="logo">
                <i class="fas fa-store"></i>
                MyStore<span>.com</span>
            </a>
            <div class="user-info">
                <a href="/dashboard">
                    <i class="fas fa-user-circle"></i>
                    {{ Auth::user()->name }}
                </a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    {{ $labels['logout'] ?? 'تسجيل الخروج' }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
        <div class="header-bottom">
            <a href="/admin/dashboard" class="nav-link">
                <i class="fas fa-tachometer-alt"></i>
                {{ $labels['dashboard'] ?? 'لوحة التحكم' }}
            </a>
            <a href="/admin/products" class="nav-link">
                <i class="fas fa-box"></i>
                {{ $labels['products'] ?? 'المنتجات' }}
            </a>
            <a href="/admin/users" class="nav-link active">
                <i class="fas fa-users"></i>
                {{ $labels['users'] ?? 'المستخدمون' }}
            </a>
            <a href="/admin/orders" class="nav-link">
                <i class="fas fa-shopping-cart"></i>
                {{ $labels['orders'] ?? 'الطلبات' }}
            </a>
        </div>
    </div>

    <div class="main-content">
        <!-- قسم معلومات المستخدم -->
        <div class="content-section">
            <div class="section-header">
                <h2>
                    <i class="fas fa-user"></i>
                    {{ $labels['user_details'] ?? 'تفاصيل المستخدم' }}
                </h2>
                <div>
                    <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        {{ $labels['back_to_users'] ?? 'العودة للمستخدمين' }}
                    </a>
                </div>
            </div>
            <div class="section-content">
                <div class="user-profile">
                    <div class="user-avatar">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <h3>{{ $user->name }}</h3>
                        <p><i class="fas fa-envelope"></i> {{ $user->email }}</p>
                        <p><i class="fas fa-calendar"></i> {{ $labels['joined_at'] ?? 'انضمام في' }}: {{ $user->created_at->format('Y-m-d') }}</p>
                        <div class="user-meta">
                            <div class="meta-item">
                                <span class="role-badge {{ $user->role }}">
                                    @if($user->role === 'admin')
                                        {{ $labels['admin'] ?? 'مدير' }}
                                    @elseif($user->role === 'vendor')
                                        {{ $labels['vendor'] ?? 'تاجر' }}
                                    @elseif($user->role === 'support_agent')
                                        {{ $labels['support_agent'] ?? 'دعم فني' }}
                                    @else
                                        {{ $labels['user'] ?? 'مستخدم' }}
                                    @endif
                                </span>
                            </div>
                            <div class="meta-item">
                                <span class="status-badge {{ $user->is_active ? 'active' : 'inactive' }}">
                                    {{ $user->is_active ? ($labels['active'] ?? 'نشط') : ($labels['inactive'] ?? 'غير نشط') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tabs">
                    <button class="tab active" data-tab="orders">{{ $labels['orders'] ?? 'الطلبات' }}</button>
                    <button class="tab" data-tab="products">{{ $labels['products'] ?? 'المنتجات' }}</button>
                </div>

                <!-- علامات التبويب للطلبات -->
                <div id="orders" class="tab-content active">
                    @if($userOrders->count() > 0)
                        <div class="order-grid">
                            @foreach($userOrders as $order)
                                <div class="order-card">
                                    <div class="order-header">
                                        <h4>{{ $labels['order'] ?? 'طلب' }} #{{ $order->id }}</h4>
                                        <div class="order-id">{{ $labels['created_at'] ?? 'تم في' }}: {{ $order->created_at->format('Y-m-d H:i') }}</div>
                                    </div>
                                    <div class="order-content">
                                        @foreach($order->items as $item)
                                            <div class="order-item">
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                                                <div class="order-item-details">
                                                    <div class="order-item-name">{{ $item->product->name }}</div>
                                                    <div class="order-item-price">{{ $labels['quantity'] ?? 'الكمية' }}: {{ $item->quantity }} | {{ $labels['price'] ?? 'السعر' }}: ${{ number_format($item->price, 2) }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="order-footer">
                                        <div class="order-total">
                                            {{ $labels['total'] ?? 'المجموع' }}: ${{ number_format($order->total, 2) }}
                                        </div>
                                        <span class="order-status {{ $order->status }}">
                                            @if($order->status === 'processing')
                                                {{ $labels['processing'] ?? 'قيد المعالجة' }}
                                            @elseif($order->status === 'completed')
                                                {{ $labels['completed'] ?? 'مكتمل' }}
                                            @else
                                                {{ $labels['cancelled'] ?? 'ملغى' }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="card">
                            <p>{{ $labels['no_orders_found'] ?? 'لا توجد طلبات لهذا المستخدم' }}</p>
                        </div>
                    @endif
                </div>

                <!-- علامات التبويب للمنتجات -->
                <div id="products" class="tab-content">
                    @if($userProducts->count() > 0)
                        <div class="product-grid">
                            @foreach($userProducts as $product)
                                <div class="product-card">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                                    <div class="product-info">
                                        <div class="product-name">{{ $product->name }}</div>
                                        <div class="product-price">${{ number_format($product->price, 2) }}</div>
                                        <span class="product-status {{ $product->is_active ? 'active' : 'inactive' }}">
                                            {{ $product->is_active ? ($labels['active'] ?? 'نشط') : ($labels['inactive'] ?? 'غير نشط') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="card">
                            <p>{{ $labels['no_products_found'] ?? 'لا توجد منتجات لهذا المستخدم' }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // تبديل علامات التبويب
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // إزالة الفعال من كل علامات التبويب والمحتوى
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

                // إضافة الفعال للعلامة والمحتوى المحدد
                tab.classList.add('active');
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    </script>
</body>
</html>
