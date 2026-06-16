<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application\'s database with sample products.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'لابتوب برو ماكس',
                'price' => 5999.99,
                'old_price' => 6999.99,
                'image' => 'products/laptop.txt',
                'description' => 'لابتوب احترافي مع معالج Intel Core i7 وذاكرة 16GB وشاشة 15.6 بوصة عالية الدقة. مثالي للمهام الثقيلة والبرمجة والألعاب.',
                'category' => 'إلكترونيات',
                'min_quantity' => 1,
            ],
            [
                'name' => 'سماعة بلوتوث لاسلكية',
                'price' => 299.99,
                'old_price' => 399.99,
                'image' => 'products/headphones.txt',
                'description' => 'سماعة بلوتوث عالية الجودة مع عزل ضوضاء ممتاز وبطارية تدوم حتى 30 ساعة من الاستخدام المتواصل.',
                'category' => 'إكسسوارات',
                'min_quantity' => 1,
            ],
            [
                'name' => 'ساعة ذكية برو',
                'price' => 899.99,
                'old_price' => 1099.99,
                'image' => 'products/smartwatch.txt',
                'description' => 'ساعة ذكية متطورة مع تتبع النشاط البدني، مراقبة القلب، وإشعارات الهاتف الذكي. مقاومة للماء حتى 50 متر.',
                'category' => 'إلكترونيات',
                'min_quantity' => 1,
            ],
            [
                'name' => 'كاميرا احترافية DSLR',
                'price' => 4499.99,
                'old_price' => 5299.99,
                'image' => 'products/camera.txt',
                'description' => 'كاميرا احترافية بدقة 24 ميجابكسل مع عدسة 18-55mm. مثالية للتصوير الفوتوغرافي الاحترافي والفيديو.',
                'category' => 'إلكترونيات',
                'min_quantity' => 1,
            ],
            [
                'name' => 'حقيبة ظهر عصرية',
                'price' => 199.99,
                'old_price' => 249.99,
                'image' => 'products/backpack.txt',
                'description' => 'حقيبة ظهر عصرية ومتينة مع جيوب متعددة وحماية للابتوب. مثالية للسفر والعمل اليومي.',
                'category' => 'أزياء',
                'min_quantity' => 1,
            ],
            [
                'name' => 'شاحن لاسلكي سريع',
                'price' => 149.99,
                'old_price' => 199.99,
                'image' => 'products/charger.txt',
                'description' => 'شاحن لاسلكي سريع يدعم الشحن السريع حتى 15 واط. متوافق مع معظم الهواتف الذكية.',
                'category' => 'إكسسوارات',
                'min_quantity' => 1,
            ],
            [
                'name' => 'لوحة مفاتيح ميكانيكية',
                'price' => 399.99,
                'old_price' => 499.99,
                'image' => 'products/keyboard.txt',
                'description' => 'لوحة مفاتيح ميكانيكية RGB مع مفاتيح مخصصة للألعاب. مثالية للاعبين المحترفين والمبرمجين.',
                'category' => 'إلكترونيات',
                'min_quantity' => 1,
            ],
            [
                'name' => 'ماوس ألعاب لاسلكي',
                'price' => 249.99,
                'old_price' => 299.99,
                'image' => 'products/mouse.txt',
                'description' => 'ماوس ألعاب لاسلكي مع حساسية عالية وأزرار قابلة للتخصيص. بطارية تدوم حتى 70 ساعة.',
                'category' => 'إلكترونيات',
                'min_quantity' => 1,
            ],
            [
                'name' => 'طقم سماعات أذن',
                'price' => 179.99,
                'old_price' => 229.99,
                'image' => 'products/earbuds.txt',
                'description' => 'طقم سماعات أذن لاسلكية مع عزل ضوضاء ممتاز وصوت عالي الجودة. تدعم المساعد الصوتي.',
                'category' => 'إكسسوارات',
                'min_quantity' => 1,
            ],
            [
                'name' => 'شاشة كمبيوتر 27 بوصة',
                'price' => 1299.99,
                'old_price' => 1499.99,
                'image' => 'products/monitor.txt',
                'description' => 'شاشة كمبيوتر عالية الدقة 27 بوصة مع دقة 4K وألوان دقيقة. مثالية للعمل والألعاب.',
                'category' => 'إلكترونيات',
                'min_quantity' => 1,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
