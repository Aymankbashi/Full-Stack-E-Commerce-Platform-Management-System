<!DOCTYPE html>
@php
    $locale = app()->getLocale();
    $labels = require base_path('lang/' . $locale . '.php');
@endphp
<html lang="{{ $locale }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $labels['register'] ?? 'إنشاء حساب جديد' }}</title>
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
            background: linear-gradient(135deg, #232f3e 0%, #37475a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            padding: 1rem 0;
        }
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        body::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }
        .register-container {
            background: #fff;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 1;
            margin: 0 auto;
            overflow: hidden;
            box-sizing: border-box;
            height: fit-content;
        }
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .logo {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.5rem;
            text-decoration: none;
        }
        .logo span {
            color: #f0c14b;
        }
        .register-container h2 {
            color: #2d3436;
            font-weight: 700;
            margin-top: 0.5rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #495057;
            font-weight: 500;
        }
        .input-group {
            position: relative;
        }
        .input-group i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
            font-size: 1rem;
        }
        .input-group i.left {
            left: 1rem;
            z-index: 2;
        }
        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%;
            padding: 0.8rem 2.5rem 0.8rem 2.5rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            background: #f8f9fa;
            transition: all 0.3s ease;
            box-sizing: border-box;
            position: relative;
            z-index: 1;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, select:focus {
            border-color: #f0c14b;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(240, 193, 75, 0.1);
            outline: none;
        }
        .btn-register {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #f0c14b 0%, #ddb347 100%);
            color: #232f3e;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(240, 193, 75, 0.3);
            margin-top: 1rem;
            min-height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(240, 193, 75, 0.4);
        }
        .success {
            color: #27ae60;
            background: #e6fff2;
            border: 1px solid #27ae60;
            border-radius: 8px;
            padding: 0.8rem 1rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        .error {
            color: #e74c3c;
            background: #fff0f0;
            border: 1px solid #e74c3c;
            border-radius: 8px;
            padding: 0.8rem 1rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        .links {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #e9ecef;
        }
        .links a {
            color: #f0c14b;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .links a:hover {
            color: #ddb347;
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            .register-container {
                padding: 1.5rem;
                margin: 1rem auto;
                max-width: 90%;
            }
        }
        @media (max-width: 480px) {
            body {
                padding: 0.5rem 0;
            }
            .register-container {
                padding: 1.2rem;
                margin: 0 auto;
                max-width: 95%;
            }
            .logo {
                font-size: 1.8rem;
            }
            .register-container h2 {
                font-size: 1.4rem;
            }
            .btn-register {
                font-size: 1.1rem;
                padding: 1rem;
            }
        }
        @media (max-width: 320px) {
            .register-container {
                padding: 1rem;
                margin: 0 auto;
                max-width: 95%;
            }
            .logo {
                font-size: 1.6rem;
            }
            .register-container h2 {
                font-size: 1.2rem;
                margin-bottom: 1.5rem;
            }
            input[type="text"], input[type="email"], input[type="password"], select {
                padding: 0.7rem 1.5rem 0.7rem 0.8rem;
                font-size: 0.9rem;
            }
            .btn-register {
                padding: 0.9rem;
                font-size: 1rem;
                margin-top: 1rem;
            }
            .form-group {
                margin-bottom: 1.2rem;
            }
        }
    </style>
</head>
@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $labels = require base_path('lang/' . $locale . '.php');
@endphp

<body>
    <div class="register-container">
        <div class="register-header">
            <a href="/" class="logo">MyStore<span>.com</span></a>
            <h2>{{ $labels['register'] ?? 'إنشاء حساب جديد' }}</h2>
        </div>
        @if (session('success'))
            <div class="success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="error">
                <i class="fas fa-exclamation-circle"></i>
                <ul style="margin:0; padding-{{ $dir === 'rtl' ? 'right' : 'left' }}:1.2rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ url('/register') }}">
            @csrf
            <div class="form-group">
                <label for="name">{{ $labels['name'] ?? 'الاسم الكامل' }}</label>
                <div class="input-group">
                    <i class="fas fa-user left"></i>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <label for="email">{{ $labels['email'] ?? 'البريد الإلكتروني' }}</label>
                <div class="input-group">
                    <i class="fas fa-envelope left"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password">{{ $labels['password'] ?? 'كلمة المرور' }}</label>
                <div class="input-group">
                    <i class="fas fa-lock left"></i>
                    <input type="password" id="password" name="password" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password_confirmation">{{ $labels['password_confirmation'] ?? 'تأكيد كلمة المرور' }}</label>
                <div class="input-group">
                    <i class="fas fa-lock left"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>
            <div class="form-group">
                <label for="role">{{ $labels['user_role'] ?? 'دور المستخدم' }}</label>
                <div class="input-group">
                    <i class="fas fa-user-tag left"></i>
                    <select id="role" name="role" required>
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>{{ $labels['customer_role'] ?? 'عميل' }}</option>
                        <option value="vendor" {{ old('role') === 'vendor' ? 'selected' : '' }}>{{ $labels['vendor_role'] ?? 'تاجر' }}</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i>
                {{ $labels['register'] ?? 'إنشاء حساب' }}
            </button>
        </form>
        <div class="links">
            <a href="{{ route('login') }}">{{ $labels['login'] ?? 'لديك حساب بالفعل؟' }}</a>
        </div>
    </div>
</body>
</html>
