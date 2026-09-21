@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $labels = require base_path('lang/' . $locale . '.php');
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $labels['become_vendor'] ?? 'كن تاجراً' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .register-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .navbar {
            background: #fff;
            box-shadow: 0 2px 8px rgba(51, 88, 230, 0.07);
        }
        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .btn-primary-custom {
            background-color: #3358e6;
            border-color: #3358e6;
        }
        .btn-primary-custom:hover {
            background-color: #2846c5;
            border-color: #2846c5;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    @include('partials.navbar')

    <!-- Register Content -->
    <div class="container">
        <div class="register-card">
            <h1 class="text-center mb-4">{{ $labels['become_vendor'] ?? 'كن تاجراً' }}</h1>
            <p class="text-center text-muted mb-4">{{ $labels['vendor_register_desc'] ?? 'سجل كتاجر في منصتنا وابدأ في بيع منتجاتك' }}</p>

            <form action="{{ route('vendor.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">{{ $labels['name'] ?? 'الاسم' }}</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">{{ $labels['email'] ?? 'البريد الإلكتروني' }}</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">{{ $labels['password'] ?? 'كلمة المرور' }}</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">{{ $labels['confirm_password'] ?? 'تأكيد كلمة المرور' }}</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="store_name" class="form-label">{{ $labels['store_name'] ?? 'اسم المتجر' }}</label>
                    <input type="text" class="form-control" id="store_name" name="store_name" required>
                </div>

                <div class="mb-3">
                    <label for="store_description" class="form-label">{{ $labels['store_description'] ?? 'وصف المتجر' }}</label>
                    <textarea class="form-control" id="store_description" name="store_description" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="logo" class="form-label">{{ $labels['store_logo'] ?? 'شعار المتجر' }}</label>
                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="bank_name" class="form-label">{{ $labels['bank_name'] ?? 'اسم البنك' }}</label>
                        <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="account_number" class="form-label">{{ $labels['account_number'] ?? 'رقم الحساب' }}</label>
                        <input type="text" class="form-control" id="account_number" name="account_number" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="iban" class="form-label">{{ $labels['iban'] ?? 'الرقم الدولي للحساب البنكي (IBAN)' }}</label>
                    <input type="text" class="form-control" id="iban" name="iban">
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            {{ $labels['accept_terms'] ?? 'أوافق على الشروط والأحكام' }}
                        </label>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary-custom btn-lg">{{ $labels['register_vendor'] ?? 'سجل كتاجر' }}</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
