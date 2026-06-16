@extends('layouts.app')

@section('title', 'الدعم الفني')

@section('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #3358e6 0%, #4f8cff 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 20px 20px;
    }

    .feature-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border: 1px solid #e8e8e8;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .feature-icon {
        width: 50px;
        height: 50px;
        background: #f0f4ff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.5rem;
        color: #3358e6;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border: 1px solid #e8e8e8;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #3358e6;
        margin-bottom: 0.5rem;
    }

    .category-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid #e8e8e8;
    }

    .category-card:hover {
        border-color: #3358e6;
        background: #f0f4ff;
    }

    .category-icon {
        width: 40px;
        height: 40px;
        background: #3358e6;
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .faq-item {
        background: white;
        border-radius: 8px;
        margin-bottom: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .faq-question {
        padding: 1rem 1.5rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        color: #333;
    }

    .faq-answer {
        padding: 0 1.5rem 1.5rem;
        color: #666;
        display: none;
    }

    .faq-item.active .faq-answer {
        display: block;
    }

    .faq-item.active .faq-question {
        background: #f0f4ff;
        color: #3358e6;
    }
</style>
@endsection

@section('content')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-3">مرحباً بك في مركز الدعم الفني</h1>
                <p class="lead mb-4">نحن هنا لمساعدتك في حل أي مشكلة قد تواجهها. فريقنا جاهز للرد على استفساراتك وتقديم الحلول المناسبة.</p>
                @guest
                    <a href="{{ route('login') }}" class="btn btn-light btn-lg">تسجيل الدخول للبدء</a>
                @else
                    <a href="{{ route('support.index') }}" class="btn btn-light btn-lg">بدء محادثة جديدة</a>
                @endguest
            </div>
            <div class="col-md-4 text-center">
                <i class="bi bi-headset" style="font-size: 8rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <!-- الإحصائيات -->
    <div class="row mb-5">
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-number">95%</div>
                <div class="text-muted">نسبة رضا العملاء</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-number">5 دقائق</div>
                <div class="text-muted">متوسط وقت الاستجابة</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-number">24/7</div>
                <div class="text-muted">خدمة متواصلة</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-number">1000+</div>
                <div class="text-muted">مشكلة تم حلها</div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- الميزات -->
        <div class="col-lg-6 mb-4">
            <h3 class="mb-4">كيف يمكننا مساعدتك؟</h3>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <h5>دردشة فورية</h5>
                <p class="text-muted mb-0">تواصل مع فريق الدعم الفني عبر الدردشة المباشرة للحصول على مساعدة فورية.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-ticket-detailed"></i>
                </div>
                <h5>نظام التذاكر</h5>
                <p class="text-muted mb-0">أنشئ تذكرة لمتابعة مشكلتك وستصلك إشعارات بكل تحديثات الحالة.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-book"></i>
                </div>
                <h5>قاعدة المعرفة</h5>
                <p class="text-muted mb-0">استكشف مقالاتنا التعليمية والأسئلة الشائعة للحصول على إجابات فورية.</p>
            </div>
        </div>

        <!-- التصنيفات -->
        <div class="col-lg-6 mb-4">
            <h3 class="mb-4">اختر فئة المشكلة</h3>
            <div class="category-card" onclick="selectCategory('technical')">
                <div class="d-flex align-items-center">
                    <div class="category-icon me-3">
                        <i class="bi bi-laptop"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">مشاكل تقنية</h5>
                        <p class="text-muted mb-0">مشاكل في الموقع، التطبيق، أو الأنظمة</p>
                    </div>
                </div>
            </div>

            <div class="category-card" onclick="selectCategory('billing')">
                <div class="d-flex align-items-center">
                    <div class="category-icon me-3">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">مشاكل في الفواتير</h5>
                        <p class="text-muted mb-0">استفسارات حول الدفع والفواتير</p>
                    </div>
                </div>
            </div>

            <div class="category-card" onclick="selectCategory('account')">
                <div class="d-flex align-items-center">
                    <div class="category-icon me-3">
                        <i class="bi bi-person"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">مشاكل في الحساب</h5>
                        <p class="text-muted mb-0">تسجيل الدخول، الملف الشخصي، الإعدادات</p>
                    </div>
                </div>
            </div>

            <div class="category-card" onclick="selectCategory('order')">
                <div class="d-flex align-items-center">
                    <div class="category-icon me-3">
                        <i class="bi bi-cart"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">مشاكل في الطلبات</h5>
                        <p class="text-muted mb-0">تتبع الطلبات، الإرجاع، الاستبدال</p>
                    </div>
                </div>
            </div>

            <div class="category-card" onclick="selectCategory('other')">
                <div class="d-flex align-items-center">
                    <div class="category-icon me-3">
                        <i class="bi bi-question-circle"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">استفسارات أخرى</h5>
                        <p class="text-muted mb-0">أي استفسار لا يندرج تحت الفئات السابقة</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الأسئلة الشائعة -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">الأسئلة الشائعة</h3>

            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-question">
                    كيف يمكنني تتبع طلبي؟
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    يمكنك تتبع حالة طلبك من خلال الدخول إلى حسابك ثم الانتقال إلى صفحة "طلباتي". ستجد هناك جميع طلباتك مع حالتها الحالية. يمكنك أيضاً استخدام رقم الطلب في صفحة تتبع الطلبات.
                </div>
            </div>

            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-question">
                    ما هي طرق الدفع المتاحة؟
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    نقبل عدة طرق للدفع تشمل: الدفع عند الاستلام، البطاقات الائتمانية (Visa, MasterCard)، Apple Pay، والتحويل البنكي. جميع طرق الدفع آمنة ومحمية.
                </div>
            </div>

            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-question">
                    كيف أسترجع منتجاً؟
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    يمكنك طلب إرجاع المنتج خلال 14 يوماً من تاريخ الاستلام. اذهب إلى صفحة "طلباتك"، اختر الطلب المطلوب، واضغط على "طلب إرجاع". سيقوم فريقنا بمراجعة طلبك والتواصل معك لإتمام العملية.
                </div>
            </div>

            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-question">
                    كم يستغرق وقت التوصيل؟
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    عادة ما يستغرق التوصيل من 2-5 أيام عمل داخل المدن الرئيسية، و3-7 أيام عمل للمناطق الأخرى. يمكنك اختيار التوصيل السريع مقابل رسوم إضافية للحصول على المنتج في اليوم التالي.
                </div>
            </div>

            <div class="faq-item" onclick="toggleFaq(this)">
                <div class="faq-question">
                    كيف يمكنني الاتصال بخدمة العملاء؟
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    يمكنك التواصل معنا عبر عدة طرق: الدردشة المباشرة على الموقع، إرسال بريد إلكتروني إلى support@example.com، أو الاتصال بنا على الرقم 9200 12345. فريقنا متاح للرد على استفساراتك على مدار الساعة.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleFaq(element) {
        element.classList.toggle('active');
        const icon = element.querySelector('.bi-chevron-down');
        if (element.classList.contains('active')) {
            icon.classList.remove('bi-chevron-down');
            icon.classList.add('bi-chevron-up');
        } else {
            icon.classList.remove('bi-chevron-up');
            icon.classList.add('bi-chevron-down');
        }
    }

    function selectCategory(category) {
        @guest
            window.location.href = '{{ route('login') }}';
        @else
            window.location.href = '{{ route('support.index') }}?category=' + category;
        @endguest
    }
</script>
@endsection
