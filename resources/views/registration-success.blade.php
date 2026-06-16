<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تهنئة باكتمال التسجيل - MyStore</title>
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
            padding: 20px;
        }

        .container {
            max-width: 900px;
            width: 100%;
        }

        .success-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-header {
            background: linear-gradient(135deg, #232f3e 0%, #37475a 100%);
            color: white;
            padding: 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .success-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 50%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .success-icon {
            font-size: 80px;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }

        .success-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .success-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .success-body {
            padding: 40px;
        }

        .welcome-message {
            text-align: center;
            margin-bottom: 40px;
        }

        .welcome-message h2 {
            color: #232f3e;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .welcome-message p {
            color: #565959;
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .feature-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: #f0c14b;
            box-shadow: 0 10px 25px rgba(240, 193, 75, 0.2);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #f0c14b 0%, #ddb347 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: #232f3e;
            font-size: 30px;
        }

        .feature-title {
            color: #232f3e;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .feature-description {
            color: #565959;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #f0c14b 0%, #ddb347 100%);
            color: #232f3e;
            border: none;
            box-shadow: 0 5px 15px rgba(240, 193, 75, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(240, 193, 75, 0.6);
        }

        .btn-outline {
            background: white;
            color: #f0c14b;
            border: 2px solid #f0c14b;
        }

        .btn-outline:hover {
            background: #f0c14b;
            color: #232f3e;
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            .success-title {
                font-size: 2rem;
            }

            .success-header {
                padding: 30px 20px;
            }

            .success-body {
                padding: 30px 20px;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-card">
            <div class="success-header">
                <i class="fas fa-check-circle success-icon"></i>
                <h1 class="success-title">تهانينا! تم إنشاء حسابك بنجاح</h1>
                <p class="success-subtitle">مرحباً بك في عالم التسوق الإلكتروني</p>
            </div>

            <div class="success-body">
                <div class="welcome-message">
                    <h2>أهلاً بك {{ auth()->user()->name }}!</h2>
                    <p>نحن سعداء بانضمامك إلينا. يمكنك الآن الاستمتاع بتجربة تسوق فريدة ومميزة على موقعنا الإلكتروني.</p>
                </div>

                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3 class="feature-title">تسوق سهل ومريح</h3>
                        <p class="feature-description">تصفح آلاف المنتجات المتنوعة واختر ما يناسبك بكل سهولة</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-percent"></i>
                        </div>
                        <h3 class="feature-title">عروض حصرية</h3>
                        <p class="feature-description">استفد من العروض والخصومات الخاصة بالمشتركين فقط</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h3 class="feature-title">توصيل سريع</h3>
                        <p class="feature-description">استمتع بخدمة توصيل سريعة وموثوقة إلى باب منزلك</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="feature-title">دعم فني متواصل</h3>
                        <p class="feature-description">فريق الدعم متواجد على مدار الساعة لخدمتك</p>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-home"></i>
                        ابدأ التسوق الآن
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline">
                        <i class="fas fa-box"></i>
                        تصفح المنتجات
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>