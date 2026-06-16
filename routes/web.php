<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth as AuthFacade;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request as HttpRequest;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\SupportAdminController;

// الصفحات العامة
Route::view('/blog', 'blog.index')->name('blog.index');
Route::view('/contact', 'support')->name('contact');
Route::view('/about', 'about')->name('about');

// مسارات العروض
Route::get('/offers', function() {
    $offers = \App\Models\Product::whereNotNull('old_price')
        ->where('offer_end', '>', now())
        ->latest()
        ->get();
    
    // بيانات السلة
    $cartItems = session()->get('cart', []);
    $cartCount = count($cartItems);
    $total = 0;
    $discount = 0;
    
    foreach ($cartItems as $item) {
        $total += $item->price * $item->quantity;
        if ($item->old_price) {
            $discount += ($item->old_price - $item->price) * $item->quantity;
        }
    }
    
    return view('offers', compact('offers', 'cartItems', 'cartCount', 'total', 'discount'));
})->name('offers');

// مسارات السلة
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// مسارات الدفع
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');

// مسارات المراجعات
Route::post('/products/{product}/review', [ProductReviewController::class, 'store'])->name('products.review');

// الصفحة الرئيسية
Route::get('/', [ProductController::class, 'index'])->name('home');

// صفحة الترحيب
Route::get('/welcome', function() {
    return view('welcome');
})->name('welcome');

// مسارات نظام الدعم الفني
Route::middleware(['auth'])->group(function () {
    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/landing', [SupportController::class, 'landing'])->name('landing');
        Route::get('/', [SupportController::class, 'index'])->name('index');
        Route::post('/create', [SupportController::class, 'createSession'])->name('create');
        Route::get('/chat/{id}', [SupportController::class, 'chat'])->name('chat');
        Route::post('/send/{id}', [SupportController::class, 'sendMessage'])->name('send');
        Route::post('/end/{id}', [SupportController::class, 'endSession'])->name('end');
        Route::get('/messages/{id}', [SupportController::class, 'getNewMessages'])->name('messages');
        
        // مسارات لوحة تحكم موظفي الدعم
        Route::prefix('agent')->name('agent.')->middleware(['auth', 'support.agent'])->group(function () {
            Route::get('/dashboard', [SupportAdminController::class, 'dashboard'])->name('dashboard');
            Route::get('/session/{id}', [SupportAdminController::class, 'showSession'])->name('session');
            Route::get('/professional-chat/{id}', [SupportAdminController::class, 'professionalChat'])->name('professional-chat');
            Route::post('/assign/{id}', [SupportAdminController::class, 'assignSession'])->name('assign');
            Route::post('/send/{id}', [SupportAdminController::class, 'sendMessage'])->name('send');
            Route::post('/reply/{id}', [SupportAdminController::class, 'addReply'])->name('reply');
            Route::post('/close/{id}', [SupportAdminController::class, 'closeSession'])->name('close');
            Route::get('/messages/{id}', [SupportAdminController::class, 'getNewMessages'])->name('messages');
            
            // مسارات إدارة الردود الجاهزة
            Route::get('/reply-templates', [SupportAdminController::class, 'replyTemplates'])->name('reply-templates');
            Route::post('/reply-templates', [SupportAdminController::class, 'createReplyTemplate'])->name('reply-templates.create');
            Route::put('/reply-templates/{id}', [SupportAdminController::class, 'updateReplyTemplate'])->name('reply-templates.update');
            Route::delete('/reply-templates/{id}', [SupportAdminController::class, 'deleteReplyTemplate'])->name('reply-templates.delete');
            Route::get('/reply-templates/json', [SupportAdminController::class, 'getReplyTemplatesJson'])->name('reply-templates.json');
        });
        
        // مسارات التقارير
        Route::get('/reports', [SupportAdminController::class, 'reports'])->name('reports');
        Route::get('/filter', [SupportAdminController::class, 'filterSessions'])->name('filter');
    });
});

// صفحة المنتجات ولوحة التحكم تتطلب تسجيل الدخول
Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // مسارات لوحة تحكم المدير
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
        Route::get('/admin/products/create', function() {
            return view('admin.products.create_new');
        })->name('admin.products.create');
        Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
        Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
        Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('products.delete');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::put('/users/{id}', [AdminController::class, 'updateUserRole'])->name('users.update');
    });
});

// Password reset routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// مسارات المصادقة
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::get('/registration-success', function() {
    return view('registration-success');
})->name('registration.success')->middleware('auth');
