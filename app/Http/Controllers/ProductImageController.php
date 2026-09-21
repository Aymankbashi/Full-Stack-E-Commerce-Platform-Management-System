<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductImageController extends Controller
{
    /**
     * عرض صفحة إدارة صور المنتجات
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.product-images', compact('products'));
    }

    /**
     * تحديث صور المنتجات بناءً على أسمائها
     */
    public function updateImages()
    {
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

                $updatedCount++;
            } else {
                $notFoundCount++;
            }
        }

        return redirect()->route('admin.product-images')
            ->with('success', "تم تحديث صور {$updatedCount} منتج ولم يتم العثور على صور لـ {$notFoundCount} منتج");
    }

    /**
     * تعيين صور عشوائية للمنتجات التي لا تحتوي على صور
     */
    public function assignRandomImages()
    {
        // الحصول على جميع المنتجات التي لا تحتوي على صورة
        $productsWithoutImages = Product::whereNull('image')->get();

        if ($productsWithoutImages->count() === 0) {
            return redirect()->route('admin.product-images')
                ->with('info', 'جميع المنتجات لديها صور بالفعل');
        }

        // الحصول على جميع ملفات الصور في مجلد المنتجات
        $imageFiles = Storage::disk('public')->files('products');

        // تصفية الملفات لتشمل فقط الصور (تجاهل الملفات النصية)
        $imageFiles = array_filter($imageFiles, function($file) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            return in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });

        if (count($imageFiles) === 0) {
            return redirect()->route('admin.product-images')
                ->with('error', 'لم يتم العثور على أي صور في مجلد المنتجات');
        }

        $assignedCount = 0;
        foreach ($productsWithoutImages as $product) {
            if (count($imageFiles) > 0) {
                // اختيار صورة عشوائية
                $randomFile = $imageFiles[array_rand($imageFiles)];
                $imageName = basename($randomFile);

                // تعيين الصورة للمنتج
                $product->image = $imageName;
                $product->save();

                $assignedCount++;
            }
        }

        return redirect()->route('admin.product-images')
            ->with('success', "تم تعيين صور عشوائية لـ {$assignedCount} منتج");
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
