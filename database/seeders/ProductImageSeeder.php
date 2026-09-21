<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('بدء عملية تعيين الصور للمنتجات...');

        // الحصول على جميع المنتجات
        $products = Product::all();
        $updatedCount = 0;
        $notFoundCount = 0;

        // الحصول على جميع ملفات الصور في مجلد المنتجات
        $imageFiles = Storage::disk('public')->files('products');

        foreach ($products as $product) {
            $imageName = $this->findMatchingImage($product->name, $imageFiles);

            if ($imageName) {
                // تحديث المنتج بصورة جديدة
                $product->image = $imageName;
                $product->save();

                $this->command->info("تم تعيين الصورة {$imageName} للمنتج {$product->name}");
                $updatedCount++;
            } else {
                $this->command->warn("لم يتم العثور على صورة للمنتج: {$product->name}");
                $notFoundCount++;
            }
        }

        $this->command->info("اكتملت العملية بنجاح!");
        $this->command->info("تم تعيين صور لـ {$updatedCount} منتج");
        $this->command->info("لم يتم العثور على صور لـ {$notFoundCount} منتج");
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

        // إذا لم يتم العثور على تطابق، ارجع null
        return null;
    }
}
