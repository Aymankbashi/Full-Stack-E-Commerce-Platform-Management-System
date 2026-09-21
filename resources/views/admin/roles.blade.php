<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $dir ?? 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $labels['manage_roles'] ?? 'إدارة الأدوار' }} - MyStore</title>
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

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: #fff;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #eaeded;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 {
            margin: 0;
            color: #232f3e;
        }

        .modal-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #232f3e;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #d5d9d9;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #ff9900;
            box-shadow: 0 0 0 2px rgba(255,153,0,0.2);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 20px;
            border-top: 1px solid #eaeded;
        }

        .permissions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .permission-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border: 1px solid #eaeded;
            border-radius: 4px;
        }

        .permission-item input[type="checkbox"] {
            width: auto;
        }

        @media (max-width: 768px) {
            .header-bottom {
                flex-wrap: wrap;
            }

            .section-header {
                flex-direction: column;
                align-items: stretch;
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
            <a href="/admin/users" class="nav-link">
                <i class="fas fa-users"></i>
                {{ $labels['users'] ?? 'المستخدمون' }}
            </a>
            <a href="/admin/roles" class="nav-link active">
                <i class="fas fa-user-tag"></i>
                {{ $labels['roles'] ?? 'الأدوار' }}
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
                <h2><i class="fas fa-user-tag"></i> {{ $labels['manage_roles'] ?? 'إدارة الأدوار' }}</h2>
                <button class="btn btn-primary" onclick="openModal()">
                    <i class="fas fa-plus"></i> {{ $labels['add_role'] ?? 'إضافة دور جديد' }}
                </button>
            </div>
            <div class="section-content">
                <table>
                    <thead>
                        <tr>
                            <th>{{ $labels['role_name'] ?? 'اسم الدور' }}</th>
                            <th>{{ $labels['description'] ?? 'الوصف' }}</th>
                            <th>{{ $labels['users_count'] ?? 'عدد المستخدمين' }}</th>
                            <th>{{ $labels['actions'] ?? 'الإجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <span class="role-badge admin">المدير</span>
                            </td>
                            <td>يمكن الوصول إلى جميع أقسام الإدارة</td>
                            <td>2</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm" onclick="editRole(1)">
                                        <i class="fas fa-edit"></i> {{ $labels['edit'] ?? 'تعديل' }}
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteRole(1)">
                                        <i class="fas fa-trash"></i> {{ $labels['delete'] ?? 'حذف' }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="role-badge support_agent">دعم فني</span>
                            </td>
                            <td>يمكن الوصول إلى قسم الدعم الفني والطلبات</td>
                            <td>5</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm" onclick="editRole(2)">
                                        <i class="fas fa-edit"></i> {{ $labels['edit'] ?? 'تعديل' }}
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteRole(2)">
                                        <i class="fas fa-trash"></i> {{ $labels['delete'] ?? 'حذف' }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="role-badge user">مستخدم عادي</span>
                            </td>
                            <td>مستخدم عادي يمكنه الشراء والمراجعة</td>
                            <td>25</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm" onclick="editRole(3)">
                                        <i class="fas fa-edit"></i> {{ $labels['edit'] ?? 'تعديل' }}
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteRole(3)">
                                        <i class="fas fa-trash"></i> {{ $labels['delete'] ?? 'حذف' }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Role Modal -->
    <div id="roleModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">{{ $labels['add_role'] ?? 'إضافة دور جديد' }}</h3>
                <button class="btn btn-danger" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="roleForm">
                    <div class="form-group">
                        <label for="roleName">{{ $labels['role_name'] ?? 'اسم الدور' }}</label>
                        <input type="text" id="roleName" name="roleName" required>
                    </div>
                    <div class="form-group">
                        <label for="roleDescription">{{ $labels['description'] ?? 'الوصف' }}</label>
                        <textarea id="roleDescription" name="roleDescription" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>{{ $labels['permissions'] ?? 'الصلاحيات' }}</label>
                        <div class="permissions-grid">
                            <div class="permission-item">
                                <input type="checkbox" id="perm1" name="permissions[]" value="view_users">
                                <label for="perm1">{{ $labels['view_users'] ?? 'عرض المستخدمين' }}</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm2" name="permissions[]" value="add_users">
                                <label for="perm2">{{ $labels['add_users'] ?? 'إضافة مستخدمين' }}</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm3" name="permissions[]" value="edit_users">
                                <label for="perm3">{{ $labels['edit_users'] ?? 'تعديل مستخدمين' }}</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm4" name="permissions[]" value="delete_users">
                                <label for="perm4">{{ $labels['delete_users'] ?? 'حذف مستخدمين' }}</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm5" name="permissions[]" value="view_products">
                                <label for="perm5">{{ $labels['view_products'] ?? 'عرض المنتجات' }}</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm6" name="permissions[]" value="add_products">
                                <label for="perm6">{{ $labels['add_products'] ?? 'إضافة منتجات' }}</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm7" name="permissions[]" value="edit_products">
                                <label for="perm7">{{ $labels['edit_products'] ?? 'تعديل منتجات' }}</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm8" name="permissions[]" value="delete_products">
                                <label for="perm8">{{ $labels['delete_products'] ?? 'حذف منتجات' }}</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm9" name="permissions[]" value="view_orders">
                                <label for="perm9">{{ $labels['view_orders'] ?? 'عرض الطلبات' }}</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm10" name="permissions[]" value="manage_orders">
                                <label for="perm10">{{ $labels['manage_orders'] ?? 'إدارة الطلبات' }}</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm11" name="permissions[]" value="view_reports">
                                <label for="perm11">{{ $labels['view_reports'] ?? 'عرض التقارير' }}</label>
                            </div>
                            <div class="permission-item">
                                <input type="checkbox" id="perm12" name="permissions[]" value="manage_roles">
                                <label for="perm12">{{ $labels['manage_roles'] ?? 'إدارة الأدوار' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">
                            {{ $labels['cancel'] ?? 'إلغاء' }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ $labels['save'] ?? 'حفظ' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('roleModal').classList.add('active');
            document.getElementById('modalTitle').textContent = '{{ $labels['add_role'] ?? 'إضافة دور جديد' }}';
        }

        function closeModal() {
            document.getElementById('roleModal').classList.remove('active');
            document.getElementById('roleForm').reset();
        }

        function editRole(id) {
            document.getElementById('roleModal').classList.add('active');
            document.getElementById('modalTitle').textContent = '{{ $labels['edit_role'] ?? 'تعديل الدور' }}';

            // Here you would typically load the role data into the form
            // For now, we'll just show the modal
        }

        function deleteRole(id) {
            if (confirm('{{ $labels['confirm_delete_role'] ?? 'هل أنت متأكد من حذف هذا الدور؟' }}')) {
                // Here you would typically send a request to delete the role
                alert('{{ $labels['role_deleted_successfully'] ?? 'تم حذف الدور بنجاح' }}');
            }
        }

        document.getElementById('roleForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Here you would typically send a request to save the role
            alert('{{ $labels['role_saved_successfully'] ?? 'تم حفظ الدور بنجاح' }}');
            closeModal();
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('roleModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>