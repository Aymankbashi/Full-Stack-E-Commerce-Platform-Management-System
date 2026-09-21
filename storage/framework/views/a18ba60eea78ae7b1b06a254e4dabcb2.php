<?php
    $locale = app()->getLocale();
    $labels = require base_path('lang/' . $locale . '.php');
?>

<footer class="bg-dark text-light mt-5">
    <div class="container py-5">
        <div class="row">
            <!-- About Section -->
            <div class="col-md-4 mb-4">
                <h5 class="mb-3"><?php echo e($labels['about']); ?></h5>
                <p class="text-muted">
                    <?php echo e($labels['site_title']); ?> - متجرك الإلكتروني المفضل لجميع احتياجاتك.
                    نقدم أفضل المنتجات بأسعار منافسة مع خدمة عملاء ممتازة.
                </p>
                <div class="social-links mt-3">
                    <a href="#" class="text-light me-2"><i class="bi bi-facebook fs-4"></i></a>
                    <a href="#" class="text-light me-2"><i class="bi bi-twitter fs-4"></i></a>
                    <a href="#" class="text-light me-2"><i class="bi bi-instagram fs-4"></i></a>
                    <a href="#" class="text-light"><i class="bi bi-linkedin fs-4"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-4 mb-4">
                <h5 class="mb-3"><?php echo e($labels['categories']); ?></h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-muted text-decoration-none">الإلكترونيات</a></li>
                    <li class="mb-2"><a href="#" class="text-muted text-decoration-none">الملابس</a></li>
                    <li class="mb-2"><a href="#" class="text-muted text-decoration-none">الأجهزة المنزلية</a></li>
                    <li class="mb-2"><a href="#" class="text-muted text-decoration-none">الكتب</a></li>
                    <li class="mb-2"><a href="#" class="text-muted text-decoration-none">الرياضة</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-md-4 mb-4">
                <h5 class="mb-3"><?php echo e($labels['contact']); ?></h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="bi bi-geo-alt"></i>
                        <span class="text-muted">123 شارع التسوق، المدينة</span>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-telephone"></i>
                        <span class="text-muted">+123 456 7890</span>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-envelope"></i>
                        <span class="text-muted">info@mystore.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-4">

        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 text-muted">
                    &copy; <?php echo e(date('Y')); ?> <?php echo e($labels['site_title']); ?>. جميع الحقوق محفوظة.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="#" class="text-muted text-decoration-none me-3">سياسة الخصوصية</a>
                <a href="#" class="text-muted text-decoration-none">الشروط والأحكام</a>
            </div>
        </div>
    </div>
</footer>

<style>
    footer {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
    .social-links a {
        transition: all 0.3s ease;
    }
    .social-links a:hover {
        color: #fff !important;
        transform: translateY(-3px);
    }
    footer a {
        transition: all 0.3s ease;
    }
    footer a:hover {
        color: #fff !important;
    }
</style>
<?php /**PATH C:\xampp\htdocs\laravel-store-project\resources\views/layouts/footer.blade.php ENDPATH**/ ?>