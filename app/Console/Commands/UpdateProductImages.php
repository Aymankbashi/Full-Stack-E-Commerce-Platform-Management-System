<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdateProductImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:update-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'تحديث صور المنتجات بناءً على أسمائها';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('بدء تحديث صور المنتجات...');

        // الحصول على جميع المنتجات
        $products = Product::all();
        $updatedCount = 0;
        $notFoundCount = 0;

        // الحصول على جميع ملفات الصور في مجلد المنتجات
        $imageFiles = Storage::disk('public')->files('products');

        foreach ($products as $product) {
            $imageName = $this->findMatchingImage($product->name, $imageFiles);

            if ($imageName) {
                // إذا كان المنتج لديه صورة بالفعل، احذفها
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }

                // تحديث المنتج بصورة جديدة
                $product->image = $imageName;
                $product->save();

                $this->info("تم تحديث صورة المنتج: {$product->name}");
                $updatedCount++;
            } else {
                $this->warn("لم يتم العثور على صورة للمنتج: {$product->name}");
                $notFoundCount++;
            }
        }

        $this->info("اكتملت العملية بنجاح!");
        $this->info("تم تحديث صور {$updatedCount} منتج");
        $this->info("لم يتم العثور على صور لـ {$notFoundCount} منتج");

        return 0;
    }

    /**
     * البحث عن صورة تطابق اسم المنتج
     */
    private function findMatchingImage($productName, $imageFiles)
    {
        // تحويل اسم المنتج إلى صيغة مقارنة
        $productSlug = Str::slug($productName, '-');

        foreach ($imageFiles as $imageFile) {
            // الحصول على اسم الملف فقط
            $filename = basename($imageFile);

            // تجاهل الملفات النصية
            if (pathinfo($filename, PATHINFO_EXTENSION) === 'txt') {
                continue;
            }

            // البحث عن تطابق بين اسم المنتج واسم الصورة
            if (Str::contains(Str::lower($filename), Str::lower($productSlug))) {
                return $filename;
            }
        }

        // إذا لم يتم العثور على تطابق، اختر صورة عشوائية
        $imageFiles = array_filter($imageFiles, function($file) {
            return pathinfo($file, PATHINFO_EXTENSION) !== 'txt';
        });

        if (count($imageFiles) > 0) {
            $randomFile = $imageFiles[array_rand($imageFiles)];
            return basename($randomFile);
        }

        return null;
    }
}
