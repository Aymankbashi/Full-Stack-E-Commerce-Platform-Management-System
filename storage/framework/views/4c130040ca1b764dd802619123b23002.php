<!DOCTYPE html>
<?php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $labels = require base_path('lang/' . $locale . '.php');
?>
<html lang="<?php echo e($locale); ?>" dir="<?php echo e($dir); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($labels['register'] ?? 'إنشاء حساب جديد'); ?></title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        .register-container {
            background: #fff;
            padding: 2.5rem 2rem;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 1;
        }
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .logo {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 0.5rem;
            text-decoration: none;
        }
        .logo span {
            color: #764ba2;
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
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 0.8rem 2.5rem 0.8rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        .btn-register {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
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
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .links a:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            .register-container {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }
        }
    </style>
</head>
<?php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $labels = require base_path('lang/' . $locale . '.php');
?>

<body>
    <div class="register-container">
        <div class="register-header">
            <a href="/" class="logo">MyStore<span>.com</span></a>
            <h2><?php echo e($labels['register'] ?? 'إنشاء حساب جديد'); ?></h2>
        </div>
        <?php if(session('success')): ?>
            <div class="success">
                <i class="fas fa-check-circle"></i>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="error">
                <i class="fas fa-exclamation-circle"></i>
                <ul style="margin:0; padding-<?php echo e($dir === 'rtl' ? 'right' : 'left'); ?>:1.2rem;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo e(url('/register')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="name"><?php echo e($labels['name'] ?? 'الاسم الكامل'); ?></label>
                <div class="input-group">
                    <i class="fas fa-user left"></i>
                    <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <label for="email"><?php echo e($labels['email'] ?? 'البريد الإلكتروني'); ?></label>
                <div class="input-group">
                    <i class="fas fa-envelope left"></i>
                    <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password"><?php echo e($labels['password'] ?? 'كلمة المرور'); ?></label>
                <div class="input-group">
                    <i class="fas fa-lock left"></i>
                    <input type="password" id="password" name="password" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password_confirmation"><?php echo e($labels['password_confirmation'] ?? 'تأكيد كلمة المرور'); ?></label>
                <div class="input-group">
                    <i class="fas fa-lock left"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>
            <input type="hidden" name="admin" value="<?php echo e(request('admin', '0')); ?>">
            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i>
                <?php echo e($labels['register'] ?? 'إنشاء حساب'); ?>

            </button>
        </form>
        <div class="links">
            <a href="<?php echo e(route('login')); ?>"><?php echo e($labels['login'] ?? 'لديك حساب بالفعل؟'); ?></a>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\laravel-store-project\resources\views/register.blade.php ENDPATH**/ ?>