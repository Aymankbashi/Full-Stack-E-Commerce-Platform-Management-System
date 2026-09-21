@php
    $locale = app()->getLocale();
    $labels = require base_path('lang/' . $locale . '.php');
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $vendor->store_name }} - {{ $labels['vendor_dashboard'] ?? 'لوحة تحكم التاجر' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: #f4f7fa;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .dashboard-header {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
            display: flex;
            align-items: center;
        }
        .vendor-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1.5rem;
        }
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
        }
        .stat-card.primary::before {
            background: #3358e6;
        }
        .stat-card.success::before {
            background: #28a745;
        }
        .stat-card.warning::before {
            background: #ffc107;
        }
        .stat-card.danger::before {
            background: #dc3545;
        }
        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #3358e6;
        }
        .stat-card.primary .stat-icon {
            color: #3358e6;
        }
        .stat-card.success .stat-icon {
            color: #28a745;
        }
        .stat-card.warning .stat-icon {
            color: #ffc107;
        }
        .stat-card.danger .stat-icon {
            color: #dc3545;
        }
        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .dashboard-nav {
            background: #fff;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
        }
        .dashboard-nav .nav-link {
            color: #495057;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
        }
        .dashboard-nav .nav-link:hover {
            background: rgba(51, 88, 230, 0.1);
        }
        .dashboard-nav .nav-link.active {
            background: #3358e6;
            color: #fff;
        }
        .dashboard-content {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
            margin-bottom: 2rem;
        }
        .top-products {
            margin-top: 2rem;
        }
        .product-card {
            background: #f8fafc;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        .product-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        .product-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 1rem;
        }
        .product-info {
            flex-grow: 1;
        }
        .product-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .product-sales {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .navbar {
            background: #fff;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
        }
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 2rem;
        }
        .recent-orders {
            margin-top: 2rem;
        }
        .order-card {
            background: #f8fafc;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .order-info {
            display: flex;
            align-items: center;
        }
        .order-number {
            font-weight: 600;
            margin-right: 1rem;
        }
        .order-customer {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .order-amount {
            font-weight: 600;
            color: #3358e6;
        }
        .order-status {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        .status-processing {
            background: #dbeafe;
            color: #1e40af;
        }
        .status-shipped {
            background: #d1fae5;
            color: #065f46;
        }
        .status-delivered {
            background: #e0e7ff;
            color: #4338ca;
        }
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .action-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(51, 88, 230, 0.15);
        }
        .action-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #3358e6;
        }
        .action-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .action-description {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: #fff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
        }
        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                text-align: center;
            }
            .vendor-logo {
                margin-right: 0;
                margin-bottom: 1rem;
            }
            .dashboard-stats {
                grid-template-columns: 1fr;
            }
            .product-card {
                flex-direction: column;
                text-align: center;
            }
            .product-image {
                margin-right: 0;
                margin-bottom: 1rem;
            }
            .order-card {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    @include('partials.navbar')

    <!-- Dashboard Content -->
    <div class="container">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <img src="{{ asset('storage/' . $vendor->logo) }}" alt="{{ $vendor->store_name }}" class="vendor-logo">
            <div>
                <h1>{{ $vendor->store_name }}</h1>
                <p class="text-muted">{{ $vendor->store_description }}</p>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> {{ $labels['vendor_status_' . $vendor->status] ?? $vendor->status }}
                </div>
            </div>
        </div>

        <!-- Dashboard Stats -->
        <div class="dashboard-stats">
            <div class="stat-card primary">
                <div class="stat-icon">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="stat-value">{{ number_format($totalSales, 2) }} ر.س</div>
                <div class="stat-label">{{ $labels['total_sales'] ?? 'إجمالي المبيعات' }}</div>
            </div>

            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="bi bi-cart3"></i>
                </div>
                <div class="stat-value">{{ $totalOrders }}</div>
                <div class="stat-label">{{ $labels['total_orders'] ?? 'إجمالي الطلبات' }}</div>
            </div>

            <div class="stat-card warning">
                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-value">{{ $totalCustomers }}</div>
                <div class="stat-label">{{ $labels['total_customers'] ?? 'إجمالي العملاء' }}</div>
            </div>

            <div class="stat-card danger">
                <div class="stat-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="stat-value">{{ $totalProducts }}</div>
                <div class="stat-label">{{ $labels['total_products'] ?? 'إجمالي المنتجات' }}</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div class="action-title">{{ $labels['add_product'] ?? 'إضافة منتج' }}</div>
                <div class="action-description">{{ $labels['add_product_desc'] ?? 'أضف منتجات جديدة لمتجرك' }}</div>
            </div>
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="action-title">{{ $labels['view_reports'] ?? 'عرض التقارير' }}</div>
                <div class="action-description">{{ $labels['view_reports_desc'] ?? 'تحليل أداء متجرك' }}</div>
            </div>
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="action-title">{{ $labels['manage_customers'] ?? 'إدارة العملاء' }}</div>
                <div class="action-description">{{ $labels['manage_customers_desc'] ?? 'عرض قائمة العملاء' }}</div>
            </div>
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="action-title">{{ $labels['settings'] ?? 'الإعدادات' }}</div>
                <div class="action-description">{{ $labels['settings_desc'] ?? 'تعديل إعدادات المتجر' }}</div>
            </div>
        </div>

        <!-- Dashboard Navigation -->
        <div class="dashboard-nav">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('vendor.dashboard') }}">
                        {{ $labels['dashboard'] ?? 'الرئيسية' }}
                        @if($newOrdersCount > 0)
                            <span class="notification-badge">{{ $newOrdersCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('vendor.products') }}">
                        {{ $labels['my_products'] ?? 'منتجاتي' }}
                        @if($lowStockCount > 0)
                            <span class="notification-badge">{{ $lowStockCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('vendor.orders') }}">
                        {{ $labels['my_orders'] ?? 'طلباتي' }}
                        @if($pendingOrdersCount > 0)
                            <span class="notification-badge">{{ $pendingOrdersCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('vendor.customers') }}">
                        {{ $labels['my_customers'] ?? 'عملائي' }}
                    </a>
                </li>
            </ul>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Sales Chart -->
            <div class="mb-4">
                <h2>{{ $labels['sales_chart'] ?? 'مبيعات الشهر الحالي' }}</h2>
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Top Products -->
            <div class="mb-4">
                <h2>{{ $labels['top_products'] ?? 'أفضل المنتجات مبيعاً' }}</h2>
                @if($topProducts->count() > 0)
                    <div class="top-products">
                        @foreach($topProducts as $product)
                            <div class="product-card">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                                <div class="product-info">
                                    <div class="product-name">{{ $product->name }}</div>
                                    <div class="product-sales">{{ $labels['sales_count'] ?? 'عدد المبيعات' }}: {{ $product->orderItems_count }}</div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold">{{ number_format($product->price, 2) }} ر.س</div>
                                    <a href="{{ route('vendor.editProduct', $product->id) }}" class="btn btn-sm btn-outline-primary">{{ $labels['edit'] ?? 'تعديل' }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> {{ $labels['no_products'] ?? 'لم تقم بإضافة أي منتجات بعد' }}
                    </div>
                @endif
            </div>

            <!-- Recent Orders -->
            <div class="recent-orders">
                <h2>{{ $labels['recent_orders'] ?? 'الطلبات الأخيرة' }}</h2>
                @if($recentOrders->count() > 0)
                    @foreach($recentOrders as $order)
                        <div class="order-card">
                            <div class="order-info">
                                <div class="order-number">#{{ $order->id }}</div>
                                <div class="order-customer">{{ $order->user->name }}</div>
                            </div>
                            <div class="order-amount">{{ number_format($order->total, 2) }} ر.س</div>
                            <div class="order-status status-{{ $order->status }}">
                                {{ $labels['order_status_' . $order->status] ?? $order->status }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> {{ $labels['no_orders'] ?? 'لا توجد طلبات حالياً' }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sales Chart
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'],
                    datasets: [{
                        label: '{{ $labels['sales_amount'] ?? 'مبلغ المبيعات' }}',
                        data: {{ $salesData }},
                        borderColor: '#3358e6',
                        backgroundColor: 'rgba(51, 88, 230, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value + ' ر.س';
                                }
                            }
                        }
                    }
                }
            });

            // Add click handlers to action cards
            document.querySelectorAll('.action-card').forEach(card => {
                card.addEventListener('click', function() {
                    const title = this.querySelector('.action-title').textContent;

                    if(title.includes('{{ $labels['add_product'] ?? 'إضافة منتج' }}')) {
                        window.location.href = '{{ route("vendor.createProduct") }}';
                    } else if(title.includes('{{ $labels['view_reports'] ?? 'عرض التقارير' }}')) {
                        window.location.href = '{{ route("vendor.reports") }}';
                    } else if(title.includes('{{ $labels['manage_customers'] ?? 'إدارة العملاء' }}')) {
                        window.location.href = '{{ route("vendor.customers") }}';
                    } else if(title.includes('{{ $labels['settings'] ?? 'الإعدادات' }}')) {
                        window.location.href = '{{ route("vendor.settings") }}';
                    }
                });
            });
        });
    </script>
</body>
</html>
