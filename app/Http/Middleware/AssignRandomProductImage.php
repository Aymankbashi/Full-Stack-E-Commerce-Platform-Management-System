<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssignRandomProductImage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // الحصول على جميع المنتجات التي لا تحتوي على صورة
        $productsWithoutImages = Product::whereNull('image')->get();

        if ($productsWithoutImages->count() > 0) {
            $this->info("تم العثور على {$productsWithoutImages->count()} منتج بدون صورة، سيتم تعيين صور عشوائية لها");

            // الحصول على جميع ملفات الصور في مجلد المنتجات
            $imageFiles = Storage::disk('public')->files('products');

            // تصفية الملفات لتشمل فقط الصور (تجاهل الملفات النصية)
            $imageFiles = array_filter($imageFiles, function($file) {
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                return in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
            });

            foreach ($productsWithoutImages as $product) {
                if (count($imageFiles) > 0) {
                    // اختيار صورة عشوائية
                    $randomFile = $imageFiles[array_rand($imageFiles)];
                    $imageName = basename($randomFile);

                    // تعيين الصورة للمنتج
                    $product->image = $imageName;
                    $product->save();

                    $this->info("تم تعيين الصورة {$imageName} للمنتج {$product->name}");
                }
            }
        }

        return $next($request);
    }

    /**
     * إضافة رسالة إلى سجل النظام
     */
    private function info($message)
    {
        // يمكنك استخدام Laravel logger هنا إذا أردت
        // logger($message);
        // أو طباعة الرسالة في حالة تشغيل هذا الوسيط من خلال سطر الأوامر
        if (app()->runningInConsole()) {
            echo $message . PHP_EOL;
        }
    }
}
