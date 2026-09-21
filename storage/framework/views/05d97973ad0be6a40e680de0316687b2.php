<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استعادة كلمة المرور</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #232f3e 0%, #37475a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .reset-container {
            background: #fff;
            padding: 2.5rem 2rem;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(51, 88, 230, 0.15);
            width: 100%;
            max-width: 400px;
        }
        .reset-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #232f3e;
            font-weight: 700;
        }
        .form-group {
            margin-bottom: 1.2rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
        }
        input[type="email"] {
            width: 100%;
            padding: 0.7rem 0.9rem;
            border: 1px solid #dbeafe;
            border-radius: 8px;
            font-size: 1rem;
            background: #f8fafc;
            transition: border 0.2s;
        }
        input[type="email"]:focus {
            border-color: #f0c14b;
            outline: none;
        }
        .btn-reset {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(90deg, #f0c14b 0%, #ddb347 100%);
            color: #232f3e;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-reset:hover {
            background: linear-gradient(90deg, #ddb347 0%, #f0c14b 100%);
        }
        .error {
            color: #e53e3e;
            background: #fff0f0;
            border: 1px solid #e53e3e;
            border-radius: 6px;
            padding: 0.7rem 1rem;
            margin-bottom: 1rem;
            text-align: right;
        }
        .status {
            color: #38a169;
            background: #f0fff4;
            border: 1px solid #38a169;
            border-radius: 6px;
            padding: 0.7rem 1rem;
            margin-bottom: 1rem;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <h2>استعادة كلمة المرور</h2>
        <?php if(session('status')): ?>
            <div class="status"><?php echo e(session('status')); ?></div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="error">
                <ul style="margin:0; padding-right:1.2rem;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo e(route('password.email')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
            </div>
            <button type="submit" class="btn-reset">إرسال رابط الاستعادة</button>
        </form>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\laravel-store-project\resources\views/auth/passwords/email.blade.php ENDPATH**/ ?>