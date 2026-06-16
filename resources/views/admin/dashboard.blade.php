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
            display: flex;
            align-items: center;
            gap: 10px;
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
            transition: color 0.2s;
        }

        .user-info a:hover {
            color: #ff9900;
        }

        .header-bottom {
            background: #232f3e;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 20px;
            overflow-x: auto;
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
            color: #ff9900;
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
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s;
            cursor: pointer;
            border: 1px solid #e8e8e8;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.12);
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

        .stat-info h3 {
            font-size: 2rem;
            color: #232f3e;
            margin-bottom: 5px;
            font-weight: 700;
        }

        .stat-info p {
            color: #565959;
            font-size: 0.9rem;
        }

        .content-section {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            border: 1px solid #e8e8e8;
            overflow: hidden;
        }

        .section-header {
            padding: 20px;
            border-bottom: 1px solid #eaeded;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f9f9f9;
        }

        .section-header h2 {
            font-size: 1.3rem;
            color: #232f3e;
        }

        .section-content {
            padding: 20px;
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eaeded;
        }

        th {
            background: #f7f7f7;
            font-weight: 600;
            color: #232f3e;
        }

        tr:hover {
            background: #f7f7f7;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
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

        .role-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .role-badge.admin {
            background: #e8f5e9;
            color: #388e3c;
        }

        .role-badge.support_agent {
            background: #fff3e0;
            color: #e65100;
        }

        .role-badge.user {
            background: #e3f2fd;
            color: #1976d2;
        }

        .priority-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .priority-urgent {
            background: #fee;
            color: #c00;
        }

        .priority-high {
            background: #fff3e0;
            color: #e65100;
        }

        .priority-medium {
            background: #e3f2fd;
            color: #1976d2;
        }

        .priority-low {
            background: #e8f5e9;
            color: #388e3c;
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
                    <span class="role-badge {{ Auth::user()->role }}">
                        @if(Auth::user()->role === 'admin')
                            {{ $labels['admin'] ?? 'مدير' }}
                        @elseif(Auth::user()->role === 'support_agent')
                            {{ $labels['support_agent'] ?? 'موظف دعم' }}
                        @else
                            {{ $labels['user'] ?? 'مستخدم' }}
                        @endif
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
            <a href="/admin/products" class="nav-link">
                <i class="fas fa-box"></i>
                {{ $labels['products'] ?? 'المنتجات' }}
            </a>
            <a href="/admin/users" class="nav-link">
                <i class="fas fa-users"></i>
                {{ $labels['users'] ?? 'المستخدمون' }}
            </a>
            <a href="/admin/orders" class="nav-link">
                <i class="fas fa-shopping-cart"></i>
                {{ $labels['orders'] ?? 'الطلبات' }}
            </a>
            <a href="{{ route('support.agent.dashboard') }}" class="nav-link">
                <i class="fas fa-headset"></i>
                {{ $labels['support'] ?? 'الدعم الفني' }}
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon products">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $productCount ?? 0 }}</h3>
                    <p>{{ $labels['total_products'] ?? 'إجمالي المنتجات' }}</p>
                </div>
            </div>
            
            <div class="stat-card" style="cursor: pointer;" onclick="toggleUserStats()">
                <div class="stat-icon users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $allUsers->count() ?? 0 }}</h3>
                    <p>{{ $labels['total_users'] ?? 'إجمالي المستخدمين' }}</p>
                </div>
            </div>

            <div id="userStats" style="display: none; grid-column: 1 / -1;">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); color: #388e3c;">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $activeUsers ?? 0 }}</h3>
                        <p>{{ $labels['active_users'] ?? 'المستخدمون النشطون' }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%); color: #c62828;">
                        <i class="fas fa-user-times"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $inactiveUsers ?? 0 }}</h3>
                        <p>{{ $labels['inactive_users'] ?? 'المستخدمون غير النشطين' }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); color: #388e3c;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $supportAgents ?? 0 }}</h3>
                        <p>{{ $labels['support_agents'] ?? 'موظفو الدعم' }}</p>
                    </div>
                </div>
            </div>

            <div id="userStats" style="display: none; grid-column: 1 / -1;">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); color: #388e3c;">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $activeUsers ?? 0 }}</h3>
                        <p>{{ $labels['active_users'] ?? 'المستخدمون النشطون' }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%); color: #c62828;">
                        <i class="fas fa-user-times"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $inactiveUsers ?? 0 }}</h3>
                        <p>{{ $labels['inactive_users'] ?? 'المستخدمون غير النشطين' }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); color: #388e3c;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $supportAgents ?? 0 }}</h3>
                        <p>{{ $labels['support_agents'] ?? 'موظفو الدعم' }}</p>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orders">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $orderCount ?? 0 }}</h3>
                    <p>{{ $labels['total_orders'] ?? 'إجمالي الطلبات' }}</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon revenue">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-info">
                    <h3>${{ number_format($revenue ?? 0, 2) }}</h3>
                    <p>{{ $labels['total_revenue'] ?? 'إجمالي الإيرادات' }}</p>
                </div>
            </div>
            
            <div class="stat-card" onclick="window.location.href='{{ route('support.agent.dashboard') }}'" style="cursor: pointer;">
                <div class="stat-icon support">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $activeSupportSessions ?? 0 }}</h3>
                    <p>{{ $labels['active_sessions'] ?? 'جلسات الدعم النشطة' }}</p>
                </div>
            </div>
        </div>

        <div class="content-section">
            <div class="section-header">
                <h2>{{ $labels['all_products'] ?? 'جميع المنتجات' }}</h2>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    {{ $labels['add_product'] ?? 'إضافة منتج' }}
                </a>
            </div>
            <div class="section-content">
                @if(isset($products) && $products->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>{{ $labels['image'] ?? 'الصورة' }}</th>
                            <th>{{ $labels['name'] ?? 'الاسم' }}</th>
                            <th>{{ $labels['price'] ?? 'السعر' }}</th>
                            <th>{{ $labels['old_price'] ?? 'السعر القديم' }}</th>
                            <th>{{ $labels['category'] ?? 'التصنيف' }}</th>
                            <th>{{ $labels['min_quantity'] ?? 'الحد الأدنى' }}</th>
                            <th>{{ $labels['actions'] ?? 'الإجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: contain;">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td style="color: #B12704; font-weight: 700;">${{ number_format($product->price, 2) }}</td>
                            <td>
                                @if($product->old_price)
                                    <span style="text-decoration: line-through; color: #565959;">${{ number_format($product->old_price, 2) }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $product->category }}</td>
                            <td>{{ $product->min_quantity ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.8rem;" title="{{ $labels['edit'] ?? 'تعديل' }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('products.show', $product->id) }}" target="_blank" class="btn btn-success" style="padding: 5px 10px; font-size: 0.8rem;" title="{{ $labels['view'] ?? 'عرض' }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.8rem;" onclick="return confirm('{{ $labels['confirm_delete'] ?? 'هل أنت متأكد من الحذف؟' }}')" title="{{ $labels['delete'] ?? 'حذف' }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p style="text-align: center; color: #565959; padding: 20px;">
                    {{ $labels['no_products'] ?? 'لا توجد منتجات حالياً' }}
                </p>
                @endif
            </div>
        </div>

        <div class="content-section">
            <div class="section-header">
                <h2>{{ $labels['recent_users'] ?? 'المستخدمون الجدد' }}</h2>
                <a href="{{ route('admin.users') }}" class="btn btn-primary">
                    <i class="fas fa-users"></i>
                    {{ $labels['view_all'] ?? 'عرض الكل' }}
                </a>
            </div>
            <div class="section-content">
                @if($recentUsers && $recentUsers->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>{{ $labels['name'] ?? 'الاسم' }}</th>
                            <th>{{ $labels['email'] ?? 'البريد الإلكتروني' }}</th>
                            <th>{{ $labels['role'] ?? 'الدور' }}</th>
                            <th>{{ $labels['status'] ?? 'الحالة' }}</th>
                            <th>{{ $labels['created_at'] ?? 'تاريخ الإنشاء' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentUsers as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="role-badge {{ $user->role }}">
                                    @if($user->role === 'admin')
                                        {{ $labels['admin'] ?? 'مدير' }}
                                    @elseif($user->role === 'support_agent')
                                        {{ $labels['support_agent'] ?? 'موظف دعم' }}
                                    @else
                                        {{ $labels['user'] ?? 'مستخدم' }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="status-badge {{ $user->is_active ? 'active' : 'inactive' }}">
                                    {{ $user->is_active ? ($labels['active'] ?? 'نشط') : ($labels['inactive'] ?? 'غير نشط') }}
                                </span>
                            </td>
                            <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p style="text-align: center; color: #565959; padding: 20px;">
                    {{ $labels['no_users'] ?? 'لا يوجد مستخدمين جدد' }}
                </p>
                @endif
            </div>
        </div>

        <div class="content-section">
            <div class="section-header">
                <h2>{{ $labels['support_activity'] ?? 'نشاط الدعم الفني' }}</h2>
                <a href="{{ route('support.agent.dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-headset"></i>
                    {{ $labels['view_support'] ?? 'عرض الدعم الفني' }}
                </a>
            </div>
            <div class="section-content">
                @if($recentSupportSessions && $recentSupportSessions->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>{{ $labels['session_id'] ?? 'رقم الجلسة' }}</th>
                            <th>{{ $labels['user'] ?? 'المستخدم' }}</th>
                            <th>{{ $labels['subject'] ?? 'الموضوع' }}</th>
                            <th>{{ $labels['priority'] ?? 'الأولوية' }}</th>
                            <th>{{ $labels['status'] ?? 'الحالة' }}</th>
                            <th>{{ $labels['created_at'] ?? 'تاريخ الإنشاء' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentSupportSessions as $session)
                        <tr>
                            <td>#{{ $session->id }}</td>
                            <td>{{ $session->user->name ?? '-' }}</td>
                            <td>{{ $session->subject }}</td>
                            <td>
                                <span class="priority-badge priority-{{ $session->priority }}">
                                    {{ $session->priority === 'urgent' ? 'عاجلة' :
                                       ($session->priority === 'high' ? 'عالية' :
                                       ($session->priority === 'medium' ? 'متوسطة' : 'منخفضة')) }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge {{ $session->status === 'active' ? 'active' : 'inactive' }}">
                                    {{ $session->status === 'active' ? 'نشطة' : 'مغلقة' }}
                                </span>
                            </td>
                            <td>{{ $session->created_at ? $session->created_at->format('Y-m-d H:i') : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p style="text-align: center; color: #565959; padding: 20px;">
                    {{ $labels['no_sessions'] ?? 'لا توجد جلسات دعم حديثة' }}
                </p>
                @endif
            </div>
        </div>
    </div>

    <script>
        function toggleUserStats() {
            const userStats = document.getElementById('userStats');
            if (userStats.style.display === 'none') {
                userStats.style.display = 'grid';
            } else {
                userStats.style.display = 'none';
            }
        }
    </script>
</body>
</html>