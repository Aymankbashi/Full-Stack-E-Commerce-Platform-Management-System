<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $dir ?? 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $labels['admin_dashboard'] ?? 'لوحة تحكم الإدارة' }} - MyStore</title>
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s;
            cursor: pointer;
            border: 1px solid #f0f0f0;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-color: #ff9900;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.products {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            color: #1976d2;
        }

        .stat-icon.users {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            color: #388e3c;
        }

        .stat-icon.support {
            background: linear-gradient(135deg, #e1f5fe 0%, #b3e5fc 100%);
            color: #0288d1;
        }

        .stat-icon.orders {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            color: #f57c00;
        }

        .stat-icon.revenue {
            background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%);
            color: #c2185b;
        }

        .stat-icon.vendors {
            background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
            color: #7b1fa2;
        }

        .stat-info h3 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 5px;
            font-weight: 700;
        }

        .stat-info p {
            color: #666;
            font-size: 0.9rem;
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

        .btn-outline {
            background: transparent;
            border: 1px solid #ff9900;
            color: #ff9900;
        }

        .btn-outline:hover {
            background: #ff9900;
            color: #fff;
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

        .user-info-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ff9900;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: #333;
        }

        .user-email {
            font-size: 0.85rem;
            color: #666;
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

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-buttons .btn {
            padding: 6px 12px;
            font-size: 0.85rem;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            padding: 20px;
        }

        .pagination a {
            padding: 8px 16px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            text-decoration: none;
            color: #333;
            transition: all 0.2s;
        }

        .pagination a:hover {
            background: #ff9900;
            border-color: #ff9900;
            color: #fff;
        }

        .pagination .active {
            background: #ff9900;
            border-color: #ff9900;
            color: #fff;
        }

        .filter-section {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-box {
            flex: 1;
            min-width: 200px;
        }

        .filter-box label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
        }

        .filter-box select,
        .filter-box input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.9rem;
        }

        .filter-box select:focus,
        .filter-box input:focus {
            outline: none;
            border-color: #ff9900;
            box-shadow: 0 0 0 2px rgba(255,153,0,0.2);
        }

        .quick-actions {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .quick-action-card {
            flex: 1;
            min-width: 200px;
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            border: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .quick-action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-color: #ff9900;
        }

        .quick-action-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .quick-action-icon.blue {
            background: #e3f2fd;
            color: #1976d2;
        }

        .quick-action-icon.green {
            background: #e8f5e9;
            color: #388e3c;
        }

        .quick-action-icon.orange {
            background: #fff3e0;
            color: #f57c00;
        }

        .quick-action-icon.purple {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .quick-action-info h4 {
            font-size: 1rem;
            margin-bottom: 5px;
            color: #333;
        }

        .quick-action-info p {
            font-size: 0.85rem;
            color: #666;
        }

        .chart-container {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border: 1px solid #f0f0f0;
            height: 300px;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .chart-header h3 {
            font-size: 1.1rem;
            color: #333;
        }

        .chart-actions {
            display: flex;
            gap: 10px;
        }

        .chart-actions .btn {
            padding: 6px 12px;
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .header-bottom {
                flex-wrap: wrap;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            table {
                display: block;
                overflow-x: auto;
            }

            .filter-section,
            .quick-actions {
                flex-direction: column;
            }

            .filter-box {
                width: 100%;
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
                    <span class="role-badge admin">
                        {{ $labels['admin'] ?? 'مدير' }}
                    </span>
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
            <a href="/admin/dashboard" class="nav-link active">
                <i class="fas fa-tachometer-alt"></i>
                {{ $labels['dashboard'] ?? 'لوحة التحكم' }}
            </a>
            <a href="/admin/vendors" class="nav-link">
                <i class="fas fa-store"></i>
                {{ $labels['vendors'] ?? 'التجار' }}
            </a>
            <a href="/admin/users" class="nav-link">
                <i class="fas fa-users"></i>
                {{ $labels['users'] ?? 'المستخدمون' }}
            </a>
            <a href="/admin/products" class="nav-link">
                <i class="fas fa-box"></i>
                {{ $labels['products'] ?? 'المنتجات' }}
            </a>
            <a href="/admin/orders" class="nav-link">
                <i class="fas fa-shopping-cart"></i>
                {{ $labels['orders'] ?? 'الطلبات' }}
            </a>
            <a href="/admin/reports" class="nav-link">
                <i class="fas fa-chart-bar"></i>
                {{ $labels['reports'] ?? 'التقارير' }}
            </a>
        </div>
    </div>

    <div class="main-content">
        <!-- الإحصائيات الرئيسية -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon products">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalProducts }}</h3>
                    <p>{{ $labels['total_products'] ?? 'إجمالي المنتجات' }}</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalUsers }}</h3>
                    <p>{{ $labels['total_users'] ?? 'إجمالي المستخدمين' }}</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon vendors">
                    <i class="fas fa-store"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalVendors }}</h3>
                    <p>{{ $labels['total_vendors'] ?? 'إجمالي التجار' }}</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orders">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalOrders }}</h3>
                    <p>{{ $labels['total_orders'] ?? 'إجمالي الطلبات' }}</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon revenue">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-info">
                    <h3>${{ number_format($totalSales, 2) }}</h3>
                    <p>{{ $labels['total_sales'] ?? 'إجمالي المبيعات' }}</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon revenue">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <h3>${{ number_format($totalCommission, 2) }}</h3>
                    <p>{{ $labels['total_commission'] ?? 'إجمالي العمولات' }}</p>
                </div>
            </div>
        </div>

        <!-- الرسوم البيانية -->
        <div class="chart-container">
            <div class="chart-header">
                <h3>{{ $labels['sales_chart'] ?? 'مبيعات الشهر' }}</h3>
                <div class="chart-actions">
                    <button class="btn btn-outline btn-sm">يوم</button>
                    <button class="btn btn-primary btn-sm">شهر</button>
                    <button class="btn btn-outline btn-sm">سنة</button>
                </div>
            </div>
            <div id="sales-chart" style="width: 100%; height: 250px;"></div>
        </div>

        <!-- أقسام سريعة -->
        <div class="quick-actions">
            <div class="quick-action-card">
                <div class="quick-action-icon blue">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="quick-action-info">
                    <h4>{{ $labels['add_new_user'] ?? 'إضافة مستخدم جديد' }}</h4>
                    <p>{{ $labels['add_new_user_desc'] ?? 'أنشئ حساب مستخدم جديد' }}</p>
                </div>
            </div>

            <div class="quick-action-card">
                <div class="quick-action-icon green">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="quick-action-info">
                    <h4>{{ $labels['approve_vendors'] ?? 'موافقة على تجار' }}</h4>
                    <p>{{ $labels['approve_vendors_desc'] ?? 'اعتماد طلبات التجار الجديدة' }}</p>
                </div>
            </div>

            <div class="quick-action-card">
                <div class="quick-action-icon orange">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="quick-action-info">
                    <h4>{{ $labels['manage_products'] ?? 'إدارة المنتجات' }}</h4>
                    <p>{{ $labels['manage_products_desc'] ?? 'مراجعة المنتجات الجديدة' }}</p>
                </div>
            </div>

            <div class="quick-action-card">
                <div class="quick-action-icon purple">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="quick-action-info">
                    <h4>{{ $labels['view_reports'] ?? 'عرض التقارير' }}</h4>
                    <p>{{ $labels['view_reports_desc'] ?? 'مراجعة التقارير المالية' }}</p>
                </div>
            </div>
        </div>

        <!-- قسم المستخدمين -->
        <div class="content-section">
            <div class="section-header">
                <h2>
                    <i class="fas fa-users"></i>
                    {{ $labels['recent_users'] ?? 'آخر المستخدمين' }}
                </h2>
                <a href="/admin/users" class="btn btn-primary">
                    <i class="fas fa-list"></i>
                    {{ $labels['view_all'] ?? 'عرض الكل' }}
                </a>
            </div>

            <div class="filter-section">
                <div class="filter-box">
                    <label>{{ $labels['filter_by_role'] ?? 'حسب الصلاحية' }}</label>
                    <select>
                        <option value="all">{{ $labels['all_roles'] ?? 'كل الصلاحيات' }}</option>
                        <option value="admin">{{ $labels['admin'] ?? 'مدير' }}</option>
                        <option value="vendor">{{ $labels['vendor'] ?? 'تاجر' }}</option>
                        <option value="user">{{ $labels['user'] ?? 'مستخدم' }}</option>
                    </select>
                </div>

                <div class="filter-box">
                    <label>{{ $labels['filter_by_status'] ?? 'حسب الحالة' }}</label>
                    <select>
                        <option value="all">{{ $labels['all_status'] ?? 'كل الحالات' }}</option>
                        <option value="active">{{ $labels['active'] ?? 'نشط' }}</option>
                        <option value="inactive">{{ $labels['inactive'] ?? 'غير نشط' }}</option>
                    </select>
                </div>

                <div class="filter-box">
                    <label>{{ $labels['search'] ?? 'بحث' }}</label>
                    <input type="text" placeholder="{{ $labels['search_placeholder'] ?? 'ابحث باسم أو بريد إلكتروني' }}">
                </div>
            </div>

            <div class="section-content">
                <table>
                    <thead>
                        <tr>
                            <th>{{ $labels['user'] ?? 'المستخدم' }}</th>
                            <th>{{ $labels['role'] ?? 'الصلاحية' }}</th>
                            <th>{{ $labels['status'] ?? 'الحالة' }}</th>
                            <th>{{ $labels['joined'] ?? 'انضمام' }}</th>
                            <th>{{ $labels['actions'] ?? 'إجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="user-info-cell">
                                    <div class="user-avatar">م</div>
                                    <div class="user-details">
                                        <div class="user-name">محمد أحمد</div>
                                        <div class="user-email">mohamed@example.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="role-badge vendor">تاجر</span>
                            </td>
                            <td>
                                <span class="status-badge active">نشط</span>
                            </td>
                            <td>15/06/2023</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                        {{ $labels['edit'] ?? 'تعديل' }}
                                    </button>
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-ban"></i>
                                        {{ $labels['suspend'] ?? 'إيقاف' }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="user-info-cell">
                                    <div class="user-avatar">س</div>
                                    <div class="user-details">
                                        <div class="user-name">سارة علي</div>
                                        <div class="user-email">sara@example.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="role-badge user">مستخدم</span>
                            </td>
                            <td>
                                <span class="status-badge active">نشط</span>
                            </td>
                            <td>18/06/2023</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                        {{ $labels['edit'] ?? 'تعديل' }}
                                    </button>
                                    <button class="btn btn-success btn-sm">
                                        <i class="fas fa-user-shield"></i>
                                        {{ $labels['promote'] ?? 'ترقية' }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="user-info-cell">
                                    <div class="user-avatar">ع</div>
                                    <div class="user-details">
                                        <div class="user-name">عمر سالم</div>
                                        <div class="user-email">omar@example.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="role-badge admin">مدير</span>
                            </td>
                            <td>
                                <span class="status-badge active">نشط</span>
                            </td>
                            <td>10/06/2023</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                        {{ $labels['edit'] ?? 'تعديل' }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="pagination">
                    <a href="#" class="active">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#">...</a>
                    <a href="#">10</a>
                    <a href="#">التالي</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // إنشاء الرسم البياني للمبيعات
        const salesCtx = document.getElementById('sales-chart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
                datasets: [{
                    label: 'المبيعات',
                    data: [12000, 19000, 15000, 25000, 22000, 30000],
                    borderColor: '#ff9900',
                    backgroundColor: 'rgba(255, 153, 0, 0.1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // إضافة وظائف للأزرار السريعة
        document.querySelectorAll('.quick-action-card').forEach(card => {
            card.addEventListener('click', function() {
                const title = this.querySelector('h4').textContent;
                alert(`تم النقر على: ${title}`);
            });
        });
    </script>
</body>
</html>