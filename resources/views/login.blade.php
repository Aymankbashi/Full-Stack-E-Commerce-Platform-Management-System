<!DOCTYPE html>
@php
    $locale = app()->getLocale();
    $labels = require base_path('lang/' . $locale . '.php');
@endphp
<html lang="{{ $locale }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $labels['login'] ?? 'تسجيل الدخول' }}</title>
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
            overflow: hidden;
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
        .login-container {
            background: #fff;
            padding: 2.5rem 2rem;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 1;
        }
        .login-header {
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
        .login-container h2 {
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
        .input-group i.right {
            right: 1rem;
            z-index: 2;
        }
        input[type="email"], input[type="password"] {
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
        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #f0c14b;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(240, 193, 75, 0.1);
            outline: none;
        }
        .btn-login {
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
        }
        .btn-login:hover {
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
            .login-container {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }
        }
    </style>
</head>
@php
    $locale = app()->getLocale();
    $labels = require base_path('lang/' . $locale . '.php');
@endphp

<body>
    <div class="login-container">
        <div class="login-header">
            <a href="/" class="logo">MyStore<span>.com</span></a>
            <h2>{{ $labels['login'] ?? 'تسجيل الدخول' }}</h2>
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
        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="form-group">
                <label for="email">{{ $labels['email'] ?? 'البريد الإلكتروني' }}</label>
                <div class="input-group">
                    <i class="fas fa-envelope left"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <label for="password">{{ $labels['password'] ?? 'كلمة المرور' }}</label>
                <div class="input-group">
                    <i class="fas fa-lock left"></i>
                    <input type="password" id="password" name="password" required>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i>
                {{ $labels['login'] ?? 'دخول' }}
            </button>
        </form>
        <div class="links">
            <a href="{{ route('register') }}">{{ $labels['register'] ?? 'إنشاء حساب جديد' }}</a>
            <span style="margin: 0 0.5rem;">|</span>
            <a href="{{ route('password.request') }}">{{ $labels['forgot_password'] ?? 'نسيت كلمة المرور؟' }}</a>
        </div>
    </div>
</body>
</html>
