<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f5f5f5;
        }
        .navbar {
            background: #232f3e !important;
            padding: 0.5rem 0;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: #fff !important;
        }
        .navbar-brand:hover {
            color: #f0c14b !important;
        }
        .dashboard-header {
            background: linear-gradient(135deg, #232f3e 0%, #37475a 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .stat-icon {
            font-size: 2.5rem;
            color: #f0c14b;
            margin-bottom: 1rem;
        }
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #232f3e;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            font-size: 1rem;
            color: #888;
        }
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #232f3e;
        }
        .table-box {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.75rem;
            text-align: right;
            border-bottom: 1px solid #f0f0f0;
        }
        th {
            background: #f5f5f5;
            color: #232f3e;
            font-weight: 600;
        }
        .btn-primary-custom {
            background: #f0c14b;
            border: 1px solid #a88734;
            color: #111;
            font-weight: 600;
        }
        .btn-primary-custom:hover {
            background: #ddb347;
            color: #111;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f0c14b;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #232f3e;
            font-weight: 700;
            margin-left: 1rem;
        }
        .chart-container {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            height: 300px;
        }
        .activity-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .activity-item:last-child {
            border-bottom: none;
        }
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f0c14b;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 1rem;
        }
        .activity-content {
            flex: 1;
        }
        .activity-title {
            font-weight: 600;
            color: #232f3e;
            margin-bottom: 0.25rem;
        }
        .activity-time {
            font-size: 0.875rem;
            color: #888;
        }
    </style>
</head>
@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $labels = require base_path('lang/' . $locale . '.php');
@endphp

@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $labels = require base_path('lang/' . $locale . '.php');
@endphp

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-shop"></i> {{ $labels['site_title'] ?? 'متجر إلكتروني' }}
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">
                            <i class="bi bi-grid"></i> {{ $labels['view_products'] ?? 'المنتجات' }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders') }}">
                            <i class="bi bi-receipt"></i> {{ $labels['my_orders'] ?? 'طلباتي' }}
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                            <span>{{ Auth::user()->name }}</span>
                            <div class="user-avatar">{{ Auth::user()->name[0] }}</div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> {{ $labels['dashboard'] ?? 'لوحة التحكم' }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('wishlist') }}">
                                    <i class="bi bi-heart"></i> {{ $labels['wishlist'] ?? 'قائمة الرغبات' }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('orders') }}">
                                    <i class="bi bi-receipt"></i> {{ $labels['my_orders'] ?? 'طلباتي' }}
                                </a>
                            </li>
                            @if(Auth::user()->isRole('admin'))
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-gear"></i> {{ $labels['admin_panel'] ?? 'لوحة الإدارة' }}
                                    </a>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> {{ $labels['logout'] ?? 'تسجيل الخروج' }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-0">مرحباً، {{ Auth::user()->name }}</h1>
                    <p class="lead mb-0">مرحباً بك في لوحة تحكمك الشخصية</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="user-avatar" style="width: 80px; height: 80px; font-size: 2rem; margin: 0 auto;">
                        {{ Auth::user()->name[0] }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="container">
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card text-center">
                    <i class="bi bi-cart3 stat-icon"></i>
                    <div class="stat-value">12</div>
                    <div class="stat-label">إجمالي الطلبات</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card text-center">
                    <i class="bi bi-check-circle stat-icon"></i>
                    <div class="stat-value">8</div>
                    <div class="stat-label">الطلبات المكتملة</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card text-center">
                    <i class="bi bi-heart stat-icon"></i>
                    <div class="stat-value">0</div>
                    <div class="stat-label">قائمة الرغبات</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card text-center">
                    <i class="bi bi-star stat-icon"></i>
                    <div class="stat-value">0</div>
                    <div class="stat-label">المراجعات</div>
                </div>
            </div>
        </div>
        <!-- Recent Orders and Activity -->
        <div class="row">
            <div class="col-md-8">
                <div class="section-title">أحدث طلباتك</div>
                <div class="table-box">
                    <table>
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>التاريخ</th>
                                <th>المبلغ الإجمالي</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- بيانات وهمية لعرض النموذج -->
                            <tr>
                                <td>#1001</td>
                                <td>2023-06-15</td>
                                <td>245.75 ر.س</td>
                                <td>
                                    <span class="badge bg-success">مكتمل</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary-custom">عرض التفاصيل</a>
                                </td>
                            </tr>
                            <tr>
                                <td>#1002</td>
                                <td>2023-06-10</td>
                                <td>128.50 ر.س</td>
                                <td>
                                    <span class="badge bg-warning">قيد المعالجة</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary-custom">عرض التفاصيل</a>
                                </td>
                            </tr>
                            <tr>
                                <td>#1003</td>
                                <td>2023-06-05</td>
                                <td>89.99 ر.س</td>
                                <td>
                                    <span class="badge bg-secondary">جديد</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary-custom">عرض التفاصيل</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="section-title">نشاطك الأخير</div>
                <div class="table-box">
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="bi bi-cart-plus"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">تم إضافة منتج جديد إلى السلة</div>
                            <div class="activity-time">منذ ساعتين</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="bi bi-heart"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">تمت إضافة منتج إلى قائمة الرغبات</div>
                            <div class="activity-time">منذ 5 ساعات</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="bi bi-star"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">تمت كتابة مراجعة لمنتج</div>
                            <div class="activity-time">منذ يومين</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">تم استلام طلبك بنجاح</div>
                            <div class="activity-time">منذ 3 أيام</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">نشاطك خلال الشهر</div>
                <div class="chart-container">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart for user activity
        const ctx = document.getElementById('activityChart').getContext('2d');
        const activityChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['الأسبوع 1', 'الأسبوع 2', 'الأسبوع 3', 'الأسبوع 4'],
                datasets: [{
                    label: 'الطلبات',
                    data: [12, 19, 15, 25],
                    borderColor: '#f0c14b',
                    backgroundColor: 'rgba(240, 193, 75, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'المراجعات',
                    data: [5, 8, 12, 9],
                    borderColor: '#232f3e',
                    backgroundColor: 'rgba(35, 47, 62, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'نشاطك خلال الشهر'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
