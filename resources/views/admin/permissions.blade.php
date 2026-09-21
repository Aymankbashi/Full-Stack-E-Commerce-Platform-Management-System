<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $dir ?? 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $labels['manage_permissions'] ?? 'إدارة الأذونات' }} - MyStore</title>
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
            background: #f3f3f3;
            min-height: 100vh;
        }

        .admin-header {
            background: #232f3e;
            color: #fff;
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header-top {
            background: #131921;
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
        }

        .logo span {
            color: #ff9900;
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
        }

        .header-bottom {
            background: #232f3e;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-link {
            color: #fff;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background 0.2s;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link:hover, .nav-link.active {
            background: #37475a;
        }

        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .content-section {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .section-header {
            padding: 20px;
            border-bottom: 1px solid #eaeded;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
        }

        .section-header h2 {
            font-size: 1.3rem;
            color: #232f3e;
            margin: 0;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #ff9900;
            color: #0F1111;
        }

        .btn-primary:hover {
            background: #e88b00;
        }

        .btn-danger {
            background: #d00;
            color: #fff;
        }

        .btn-danger:hover {
            background: #b00;
        }

        .btn-success {
            background: #067d62;
            color: #fff;
        }

        .btn-success:hover {
            background: #056a53;
        }

        .section-content {
            padding: 20px;
            overflow-x: auto;
        }

        .permission-category {
            margin-bottom: 30px;
        }

        .category-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            background: #f7f7f7;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 4px solid #ff9900;
        }

        .category-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #232f3e;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .permissions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }

        .permission-card {
            background: #fff;
            border: 1px solid #eaeded;
            border-radius: 8px;
            padding: 15px;
            transition: all 0.2s;
        }

        .permission-card:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .permission-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .permission-name {
            font-weight: 600;
            color: #232f3e;
            font-size: 0.95rem;
        }

        .permission-description {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 10px;
        }

        .permission-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .toggle-switch {
            position: relative;
            width: 50px;
            height: 24px;
            background: #ccc;
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .toggle-switch.active {
            background: #ff9900;
        }

        .toggle-switch::after {
            content: "";
            position: absolute;
            top: 2px;
            left: 2px;
            width: 20px;
            height: 20px;
            background: #fff;
            border-radius: 50%;
            transition: transform 0.2s;
        }

        .toggle-switch.active::after {
            transform: translateX(26px);
        }

        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-box input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #d5d9d9;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .search-box input:focus {
            outline: none;
            border-color: #ff9900;
            box-shadow: 0 0 0 2px rgba(255,153,0,0.2);
        }

        .filter-group {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 15px;
            border: 1px solid #d5d9d9;
            border-radius: 4px;
            background: #fff;
            color: #333;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-btn:hover, .filter-btn.active {
            background: #ff9900;
            color: #fff;
            border-color: #ff9900;
        }

        .bulk-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: #f7f7f7;
            border-radius: 8px;
        }

        .bulk-actions select {
            padding: 8px 15px;
            border: 1px solid #d5d9d9;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .bulk-actions button {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            background: #ff9900;
            color: #fff;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.2s;
        }

        .bulk-actions button:hover {
            background: #e88b00;
        }

        @media (max-width: 768px) {
            .header-bottom {
                flex-wrap: wrap;
            }

            .permissions-grid {
                grid-template-columns: 1fr;
            }

            .bulk-actions {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <div class="header-top">
            <a href="/" class="logo">MyStore<span>.com</span></a>
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
            <a href="/admin/users" class="nav-link">
                <i class="fas fa-users"></i>
                {{ $labels['users'] ?? 'المستخدمون' }}
            </a>
            <a href="/admin/roles" class="nav-link">
                <i class="fas fa-user-tag"></i>
                {{ $labels['roles'] ?? 'الأدوار' }}
            </a>
            <a href="/admin/permissions" class="nav-link active">
                <i class="fas fa-shield-alt"></i>
                {{ $labels['permissions'] ?? 'الأذونات' }}
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="content-section">
            <div class="section-header">
                <h2><i class="fas fa-shield-alt"></i> {{ $labels['manage_permissions'] ?? 'إدارة الأذونات' }}</h2>
                <div>
                    <button class="btn btn-primary">
                        <i class="fas fa-plus"></i> {{ $labels['add_permission'] ?? 'إضافة إذن جديد' }}
                    </button>
                </div>
            </div>
            <div class="section-content">
                <div class="search-box">
                    <input type="text" placeholder="{{ $labels['search_permissions'] ?? 'ابحث عن إذن...' }}">
                    <button class="btn btn-primary">
                        <i class="fas fa-search"></i> {{ $labels['search'] ?? 'بحث' }}
                    </button>
                </div>

                <div class="filter-group">
                    <button class="filter-btn active">{{ $labels['all'] ?? 'الكل' }}</button>
                    <button class="filter-btn">{{ $labels['active'] ?? 'نشط' }}</button>
                    <button class="filter-btn">{{ $labels['inactive'] ?? 'غير نشط' }}</button>
                </div>

                <div class="bulk-actions">
                    <div>
                        <label>{{ $labels['bulk_actions'] ?? 'إجراءات مجمعة' }}:</label>
                        <select>
                            <option>{{ $labels['select_action'] ?? 'اختر إجراء' }}</option>
                            <option>{{ $labels['activate'] ?? 'تفعيل' }}</option>
                            <option>{{ $labels['deactivate'] ?? 'إلغاء التفعيل' }}</option>
                            <option>{{ $labels['delete'] ?? 'حذف' }}</option>
                        </select>
                        <button>{{ $labels['apply'] ?? 'تطبيق' }}</button>
                    </div>
                    <div>
                        <span>{{ $labels['selected'] ?? '0' }} {{ $labels['selected_items'] ?? 'عنصر مختار' }}</span>
                    </div>
                </div>

                <!-- Permissions Dashboard -->
                <div class="permission-category">
                    <div class="category-header">
                        <div class="category-title">
                            <i class="fas fa-tachometer-alt"></i>
                            {{ $labels['dashboard_permissions'] ?? 'أذونات لوحة التحكم' }}
                        </div>
                        <div class="category-stats">
                            <span>{{ $labels['permissions_count'] ?? '5' }} {{ $labels['permissions'] ?? 'أذونات' }}</span>
                        </div>
                    </div>
                    <div class="permissions-grid">
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['view_dashboard'] ?? 'عرض لوحة التحكم' }}</div>
                                <div class="permission-toggle active"></div>
                            </div>
                            <div class="permission-description">{{ $labels['view_dashboard_desc'] ?? 'السماح للمستخدم بالوصول إلى لوحة التحكم' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                                <span class="role-badge user">مستخدم</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['manage_users'] ?? 'إدارة المستخدمين' }}</div>
                                <div class="permission-toggle"></div>
                            </div>
                            <div class="permission-description">{{ $labels['manage_users_desc'] ?? 'السماح للمستخدم بإدارة المستخدمين' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['view_reports'] ?? 'عرض التقارير' }}</div>
                                <div class="permission-toggle active"></div>
                            </div>
                            <div class="permission-description">{{ $labels['view_reports_desc'] ?? 'السماح للمستخدم بعرض التقارير' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                                <span class="role-badge user">مستخدم</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['manage_settings'] ?? 'إدارة الإعدادات' }}</div>
                                <div class="permission-toggle"></div>
                            </div>
                            <div class="permission-description">{{ $labels['manage_settings_desc'] ?? 'السماح للمستخدم بتغيير إعدادات النظام' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['export_data'] ?? 'تصدير البيانات' }}</div>
                                <div class="permission-toggle"></div>
                            </div>
                            <div class="permission-description">{{ $labels['export_data_desc'] ?? 'السماح للمستخدم بتصدير البيانات' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Permissions -->
                <div class="permission-category">
                    <div class="category-header">
                        <div class="category-title">
                            <i class="fas fa-box"></i>
                            {{ $labels['products_permissions'] ?? 'أذونات المنتجات' }}
                        </div>
                        <div class="category-stats">
                            <span>{{ $labels['permissions_count'] ?? '8' }} {{ $labels['permissions'] ?? 'أذونات' }}</span>
                        </div>
                    </div>
                    <div class="permissions-grid">
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['view_products'] ?? 'عرض المنتجات' }}</div>
                                <div class="permission-toggle active"></div>
                            </div>
                            <div class="permission-description">{{ $labels['view_products_desc'] ?? 'السماح للمستخدم بعرض المنتجات' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                                <span class="role-badge user">مستخدم</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['add_products'] ?? 'إضافة منتجات' }}</div>
                                <div class="permission-toggle"></div>
                            </div>
                            <div class="permission-description">{{ $labels['add_products_desc'] ?? 'السماح للمستخدم بإضافة منجات جديدة' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['edit_products'] ?? 'تعديل المنتجات' }}</div>
                                <div class="permission-toggle"></div>
                            </div>
                            <div class="permission-description">{{ $labels['edit_products_desc'] ?? 'السماح للمستخدم بتعديل المنتجات' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['delete_products'] ?? 'حذف المنتجات' }}</div>
                                <div class="permission-toggle"></div>
                            </div>
                            <div class="permission-description">{{ $labels['delete_products_desc'] ?? 'السماح للمستخدم بحذف المنتجات' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['manage_categories'] ?? 'إدارة الفئات' }}</div>
                                <div class="permission-toggle"></div>
                            </div>
                            <div class="permission-description">{{ $labels['manage_categories_desc'] ?? 'السماح للمستخدم بإدارة فئات المنتجات' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['approve_products'] ?? 'موافقة على المنتجات' }}</div>
                                <div class="permission-toggle"></div>
                            </div>
                            <div class="permission-description">{{ $labels['approve_products_desc'] ?? 'السماح للمستخدم بموافقة المنتجات' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['manage_inventory'] ?? 'إدارة المخزون' }}</div>
                                <div class="permission-toggle"></div>
                            </div>
                            <div class="permission-description">{{ $labels['manage_inventory_desc'] ?? 'السماح للمستخدم بإدارة المخزون' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['set_prices'] ?? 'تحديد الأسعار' }}</div>
                                <div class="permission-toggle"></div>
                            </div>
                            <div class="permission-description">{{ $labels['set_prices_desc'] ?? 'السماح للمستخدم بتحديد أسعار المنتجات' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Permissions -->
                <div class="permission-category">
                    <div class="category-header">
                        <div class="category-title">
                            <i class="fas fa-shopping-cart"></i>
                            {{ $labels['orders_permissions'] ?? 'أذونات الطلبات' }}
                        </div>
                        <div class="category-stats">
                            <span>{{ $labels['permissions_count'] ?? '6' }} {{ $labels['permissions'] ?? 'أذونات' }}</span>
                        </div>
                    </div>
                    <div class="permissions-grid">
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['view_orders'] ?? 'عرض الطلبات' }}</div>
                                <div class="permission-toggle active"></div>
                            </div>
                            <div class="permission-description">{{ $labels['view_orders_desc'] ?? 'السماح للمستخدم بعرض الطلبات' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                                <span class="role-badge user">مستخدم</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['manage_orders'] ?? 'إدارة الطلبات' }}</div>
                                <div class="permission-toggle"></div>
                            </div>
                            <div class="permission-description">{{ $labels['manage_orders_desc'] ?? 'السماح للمستخدم بإدارة الطلبات' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['process_orders'] ?? 'معالجة الطلبات' }}</div>
                                <div class="permission-toggle"></div>
                            </div>
                            <div class="permission-description">{{ $labels['process_orders_desc'] ?? 'السماح للمستخدم بمعالجة الطلبات' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['cancel_orders'] ?? 'إلغاء الطلبات' }}</div>
                                <div class="permission-toggle"></div>
                            </div>
                            <div class="permission-description">{{ $labels['cancel_orders_desc'] ?? 'السماح للمستخدم بإلغاء الطلبات' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['view_sales'] ?? 'عرض المبيعات' }}</div>
                                <div class="permission-toggle active"></div>
                            </div>
                            <div class="permission-description">{{ $labels['view_sales_desc'] ?? 'السماح للمستخدم بعرض تقارير المبيعات' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                                <span class="role-badge user">مستخدم</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['manage_shipping'] ?? 'إدارة الشحن' }}</div>
                                <div class="permission-toggle"></div>
                            </div>
                            <div class="permission-description">{{ $labels['manage_shipping_desc'] ?? 'السماح للمستخدم بإدارة شحن الطلبات' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reports Permissions -->
                <div class="permission-category">
                    <div class="category-header">
                        <div class="category-title">
                            <i class="fas fa-chart-bar"></i>
                            {{ $labels['reports_permissions'] ?? 'أذونات التقارير' }}
                        </div>
                        <div class="category-stats">
                            <span>{{ $labels['permissions_count'] ?? '4' }} {{ $labels['permissions'] ?? 'أذونات' }}</span>
                        </div>
                    </div>
                    <div class="permissions-grid">
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['view_reports'] ?? 'عرض التقارير' }}</div>
                                <div class="permission-toggle active"></div>
                            </div>
                            <div class="permission-description">{{ $labels['view_reports_desc'] ?? 'السماح للمستخدم بعرض التقارير' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                                <span class="role-badge user">مستخدم</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['generate_reports'] ?? 'إنشاء التقارير' }}</div>
                                <div class="permission-toggle"></div>
                            </div>
                            <div class="permission-description">{{ $labels['generate_reports_desc'] ?? 'السماح للمستخدم بإنشاء تقارير مخصصة' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['export_reports'] ?? 'تصدير التقارير' }}</div>
                                <div class="permission-toggle"></div>
                            </div>
                            <div class="permission-description">{{ $labels['export_reports_desc'] ?? 'السماح للمستخدم بتصدير التقارير' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                            </div>
                        </div>
                        <div class="permission-card">
                            <div class="permission-header">
                                <div class="permission-name">{{ $labels['manage_reports'] ?? 'إدارة التقارير' }}</div>
                                <div class="permission-toggle"></div>
                            </div>
                            <div class="permission-description">{{ $labels['manage_reports_desc'] ?? 'السماح للمستخدم بإدارة أنواع التقارير' }}</div>
                            <div class="permission-tags">
                                <span class="role-badge admin">مدير</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle permission switches
        document.querySelectorAll('.permission-toggle').forEach(toggle => {
            toggle.addEventListener('click', function() {
                this.classList.toggle('active');
            });
        });

        // Filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Search functionality
        document.querySelector('.search-box input').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            document.querySelectorAll('.permission-card').forEach(card => {
                const permissionName = card.querySelector('.permission-name').textContent.toLowerCase();
                const permissionDesc = card.querySelector('.permission-description').textContent.toLowerCase();

                if (permissionName.includes(searchTerm) || permissionDesc.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>