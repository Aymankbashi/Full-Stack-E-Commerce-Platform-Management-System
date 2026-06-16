<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $dir ?? 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($product) ? ($labels['edit_product'] ?? 'تعديل المنتج') : ($labels['add_product'] ?? 'إضافة منتج') }} - MyStore</title>
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .form-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 30px;
        }

        .form-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eaeded;
        }

        .form-header h2 {
            font-size: 1.5rem;
            color: #232f3e;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #565959;
            font-size: 0.9rem;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section h3 {
            font-size: 1.1rem;
            color: #232f3e;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ff9900;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #0F1111;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="email"],
        .form-group input[type="url"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d5d9d9;
            border-radius: 4px;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #ff9900;
            box-shadow: 0 0 0 2px rgba(255,153,0,0.2);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-group small {
            display: block;
            margin-top: 5px;
            color: #565959;
            font-size: 0.85rem;
        }

        .image-preview {
            margin-top: 15px;
            display: none;
        }

        .image-preview.show {
            display: block;
        }

        .image-preview img {
            max-width: 200px;
            max-height: 200px;
            border: 1px solid #d5d9d9;
            border-radius: 4px;
            object-fit: contain;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            font-size: 0.95rem;
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

        .btn-secondary {
            background: #f0f2f2;
            color: #0F1111;
        }

        .btn-secondary:hover {
            background: #e3e6e6;
        }

        .btn-danger {
            background: #d00;
            color: #fff;
        }

        .btn-danger:hover {
            background: #b00;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            padding-top: 20px;
            border-top: 1px solid #eaeded;
        }

        .error {
            color: #c40000;
            background: #fff0f0;
            border: 1px solid #c40000;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .success {
            color: #067d62;
            background: #f0fff4;
            border: 1px solid #067d62;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .header-bottom {
                flex-wrap: wrap;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
                justify-content: center;
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
            <a href="/admin/products" class="nav-link active">
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
        </div>
    </div>

    <div class="main-content">
        <div class="form-container">
            <div class="form-header">
                <h2>{{ isset($product) ? ($labels['edit_product'] ?? 'تعديل المنتج') : ($labels['add_product'] ?? 'إضافة منتج') }}</h2>
                <p>{{ $labels['product_form_description'] ?? 'املأ النموذج أدناه لإضافة أو تعديل المنتج' }}</p>
            </div>

            @if ($errors->any())
                <div class="error">
                    <ul style="margin: 0; padding-right: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  id="productForm">
                @csrf
                @isset($product)
                    @method('PUT')
                @endisset

                <div class="form-section">
                    <h3>{{ $labels['basic_info'] ?? 'المعلومات الأساسية' }}</h3>

                    <div class="form-group">
                        <label for="name">{{ $labels['product_name'] ?? 'اسم المنتج' }} *</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $product->name ?? '') }}" 
                               required>
                        <small>{{ $labels['product_name_help'] ?? 'أدخل اسم المنتج بوضوح' }}</small>
                    </div>

                    <div class="form-group">
                        <label for="category">{{ $labels['category'] ?? 'التصنيف' }} *</label>
                        <select id="category" name="category" required>
                            <option value="">{{ $labels['select_category'] ?? 'اختر التصنيف' }}</option>
                            <option value="إلكترونيات" {{ old('category', $product->category ?? '') === 'إلكترونيات' ? 'selected' : '' }}>
                                {{ $labels['electronics'] ?? 'إلكترونيات' }}
                            </option>
                            <option value="ملابس" {{ old('category', $product->category ?? '') === 'ملابس' ? 'selected' : '' }}>
                                {{ $labels['clothing'] ?? 'ملابس' }}
                            </option>
                            <option value="أجهزة منزلية" {{ old('category', $product->category ?? '') === 'أجهزة منزلية' ? 'selected' : '' }}>
                                {{ $labels['home_appliances'] ?? 'أجهزة منزلية' }}
                            </option>
                            <option value="كتب" {{ old('category', $product->category ?? '') === 'كتب' ? 'selected' : '' }}>
                                {{ $labels['books'] ?? 'كتب' }}
                            </option>
                            <option value="رياضة" {{ old('category', $product->category ?? '') === 'رياضة' ? 'selected' : '' }}>
                                {{ $labels['sports'] ?? 'رياضة' }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">{{ $labels['description'] ?? 'الوصف' }} *</label>
                        <textarea id="description" 
                                  name="description" 
                                  required>{{ old('description', $product->description ?? '') }}</textarea>
                        <small>{{ $labels['description_help'] ?? 'اكتب وصفاً تفصيلياً للمنتج' }}</small>
                    </div>
                </div>

                <div class="form-section">
                    <h3>{{ $labels['pricing_stock'] ?? 'التسعير والمخزون' }}</h3>

                    <div class="form-group">
                        <label for="price">{{ $labels['price'] ?? 'السعر' }} *</label>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               step="0.01" 
                               min="0"
                               value="{{ old('price', $product->price ?? '') }}" 
                               required>
                        <small>{{ $labels['price_help'] ?? 'أدخل سعر المنتج بالدولار' }}</small>
                    </div>

                    <div class="form-group">
                        <label for="compare_price">{{ $labels['compare_price'] ?? 'سعر المقارنة' }}</label>
                        <input type="number" 
                               id="compare_price" 
                               name="compare_price" 
                               step="0.01" 
                               min="0"
                               value="{{ old('compare_price', $product->compare_price ?? '') }}">
                        <small>{{ $labels['compare_price_help'] ?? 'السعر الأصلي قبل الخصم (اختياري)' }}</small>
                    </div>

                    <div class="form-group">
                        <label for="stock">{{ $labels['stock'] ?? 'المخزون' }}</label>
                        <input type="number" 
                               id="stock" 
                               name="stock" 
                               min="0"
                               value="{{ old('stock', $product->stock ?? 0) }}">
                        <small>{{ $labels['stock_help'] ?? 'عدد الوحدات المتوفرة' }}</small>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $product->is_active ?? 1) ? 'checked' : '' }}>
                            {{ $labels['product_active'] ?? 'المنتج نشط' }}
                        </label>
                        <small>{{ $labels['product_active_help'] ?? 'إظهار المنتج في المتجر' }}</small>
                    </div>
                </div>

                <div class="form-section">
                    <h3>{{ $labels['product_images'] ?? 'صور المنتج' }}</h3>

                    <div class="form-group">
                        <label for="image">{{ $labels['main_image'] ?? 'الصورة الرئيسية' }} *</label>
                        <input type="file" 
                               id="image" 
                               name="image" 
                               accept="image/*"
                               @isset($product)
                               @else
                               required
                               @endisset>
                        <small>{{ $labels['image_help'] ?? 'PNG, JPG, GIF حتى 5MB' }}</small>

                        @isset($product)
                            <div class="image-preview show">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            </div>
                        @endisset
                    </div>

                    <div class="form-group">
                        <label for="gallery">{{ $labels['additional_images'] ?? 'صور إضافية' }}</label>
                        <input type="file" 
                               id="gallery" 
                               name="gallery[]" 
                               accept="image/*" 
                               multiple>
                        <small>{{ $labels['gallery_help'] ?? 'يمكنك إضافة صور إضافية للمنتج' }}</small>
                    </div>
                </div>

                <div class="form-section">
                    <h3>{{ $labels['seo_settings'] ?? 'إعدادات SEO' }}</h3>

                    <div class="form-group">
                        <label for="meta_title">{{ $labels['meta_title'] ?? 'عنوان الصفحة' }}</label>
                        <input type="text" 
                               id="meta_title" 
                               name="meta_title" 
                               value="{{ old('meta_title', $product->meta_title ?? '') }}">
                        <small>{{ $labels['meta_title_help'] ?? 'عنوان الصفحة لمحركات البحث (حتى 60 حرف)' }}</small>
                    </div>

                    <div class="form-group">
                        <label for="meta_description">{{ $labels['meta_description'] ?? 'وصف الصفحة' }}</label>
                        <textarea id="meta_description" 
                                  name="meta_description" 
                                  rows="3">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
                        <small>{{ $labels['meta_description_help'] ?? 'وصف الصفحة لمحركات البحث (حتى 160 حرف)' }}</small>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        {{ isset($product) ? ($labels['update_product'] ?? 'تحديث المنتج') : ($labels['save_product'] ?? 'حفظ المنتج') }}
                    </button>
                    <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        {{ $labels['cancel'] ?? 'إلغاء' }}
                    </a>
                    @isset($product)
                        <form action="{{ route('admin.products.destroy', $product->id) }}" 
                              method="POST" 
                              style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger"
                                    onclick="return confirm('{{ $labels['confirm_delete_product'] ?? 'هل أنت متأكد من حذف هذا المنتج؟' }}')">
                                <i class="fas fa-trash"></i>
                                {{ $labels['delete_product'] ?? 'حذف المنتج' }}
                            </button>
                        </form>
                    @endisset
                </div>
            </form>
        </div>
    </div>
</body>
</html>