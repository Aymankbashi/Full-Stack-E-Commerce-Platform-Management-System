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