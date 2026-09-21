<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $dir ?? 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $labels['manage_users'] ?? 'إدارة المستخدمين' }} - MyStore</title>
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

        .search-box {
            display: flex;
            gap: 10px;
            flex: 1;
            max-width: 400px;
        }

        .search-box input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #d5d9d9;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .search-box input:focus {
            outline: none;
            border-color: #ff9900;
            box-shadow: 0 0 0 2px rgba(255,153,0,0.2);
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

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
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
            position: sticky;
            top: 0;
        }

        tr:hover {
            background: #f7f7f7;
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
            color: #232f3e;
        }

        .user-email {
            font-size: 0.85rem;
            color: #565959;
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
            border: 1px solid #d5d9d9;
            border-radius: 4px;
            text-decoration: none;
            color: #0F1111;
            transition: all 0.2s;
        }

        .pagination a:hover {
            background: #f7f7f7;
            border-color: #ff9900;
        }

        .pagination .active {
            background: #ff9900;
            border-color: #ff9900;
        }

        @media (max-width: 768px) {
            .header-bottom {
                flex-wrap: wrap;
            }

            .section-header {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                max-width: 100%;
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
        <div class="content-section">
            <div class="section-header">
                <h2>{{ $labels['manage_users'] ?? 'إدارة المستخدمين' }}</h2>
                <div class="search-box">
                    <form action="{{ route('admin.users') }}" method="GET" style="display: flex; gap: 10px; width: 100%;">
                        <input type="text" name="search" placeholder="{{ $labels['search_users'] ?? 'ابحث عن مستخدم...' }}" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="section-content">
                @if(session('success'))
                    <div class="alert alert-success" style="background: #f0fff4; border: 1px solid #067d62; color: #067d62; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if($users->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>{{ $labels['user'] ?? 'المستخدم' }}</th>
                            <th>{{ $labels['role'] ?? 'الدور' }}</th>
                            <th>{{ $labels['created_at'] ?? 'تاريخ الإنشاء' }}</th>
                            <th>{{ $labels['status'] ?? 'الحالة' }}</th>
                            <th>{{ $labels['actions'] ?? 'الإجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="user-info-cell">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="user-details">
                                        <div class="user-name">{{ $user->name }}</div>
                                        <div class="user-email">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
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
                            </td>
                            <td>
                                <span class="status-badge {{ $user->is_active ?? true ? 'active' : 'inactive' }}">
                                    {{ $user->is_active ?? true ? ($labels['active'] ?? 'نشط') : ($labels['inactive'] ?? 'غير نشط') }}
                                </span>
                            </td>
                            <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : '-' }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> عرض
                                    </a>
                                    <form action="{{ route('admin.users.role.update', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <select name="role" style="padding: 6px 12px; border: 1px solid #d5d9d9; border-radius: 4px; font-size: 0.85rem;">
                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>{{ $labels['user'] ?? 'مستخدم' }}</option>
                                            <option value="vendor" {{ $user->role === 'vendor' ? 'selected' : '' }}>{{ $labels['vendor'] ?? 'تاجر' }}</option>
                                            <option value="support_agent" {{ $user->role === 'support_agent' ? 'selected' : '' }}>{{ $labels['support_agent'] ?? 'دعم فني' }}</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>{{ $labels['admin'] ?? 'مدير' }}</option>
                                        </select>
                                        <button type="submit" class="btn btn-success" style="padding: 6px 12px; font-size: 0.85rem;">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                    </form>
                                    @if($user->id !== Auth::id())
                                        @if($user->is_active)
                                            <form action="{{ route('admin.users.status.update', $user->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="status" value="deactivate">
                                                <button type="submit" class="btn btn-warning" style="padding: 6px 12px; font-size: 0.85rem;">
                                                    <i class="fas fa-ban"></i> تعطيل
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.users.status.update', $user->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="status" value="activate">
                                                <button type="submit" class="btn btn-success" style="padding: 6px 12px; font-size: 0.85rem;">
                                                    <i class="fas fa-check"></i> تفعيل
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('{{ $labels['confirm_delete_user'] ?? 'هل أنت متأكد من حذف هذا المستخدم؟' }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.85rem;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div style="text-align: center; padding: 40px; color: #565959;">
                    <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 15px; color: #999;"></i>
                    <p>{{ $labels['no_users'] ?? 'لا يوجد مستخدمين حالياً' }}</p>
                </div>
                @endif

                @if($users->hasPages())
                <div class="pagination">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
