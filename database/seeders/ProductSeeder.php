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
            // إلكترونيات
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
                'name' => 'شاشة كمبيوتر 27 بوصة',
                'price' => 1299.99,
                'old_price' => 1499.99,
                'image' => 'products/monitor.txt',
                'description' => 'شاشة كمبيوتر عالية الدقة 27 بوصة مع دقة 4K وألوان دقيقة. مثالية للعمل والألعاب.',
                'category' => 'إلكترونيات',
                'min_quantity' => 1,
            ],
            [
                'name' => 'جهاز تلفاز ذكي 65 بوصة',
                'price' => 3499.99,
                'old_price' => 3999.99,
                'image' => 'products/tv.txt',
                'description' => 'تلفاز ذكي 65 بوصة بدقة 4K مع نظام تشغيل ذكي واتصال بالإنترنت. يدعم تطبيقات البث المباشر.',
                'category' => 'إلكترونيات',
                'min_quantity' => 1,
            ],
            [
                'name' => 'جهاز تتبع اللياقة البدنية',
                'price' => 249.99,
                'old_price' => null,
                'image' => 'products/fitness-tracker.txt',
                'description' => 'جهاز تتبع اللياقة البدنية مع مراقبة النوم، عدد الخطوات، والمسافة. مقاومة للماء.',
                'category' => 'إلكترونيات',
                'min_quantity' => 1,
            ],
            
            // إكسسوارات
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
                'name' => 'حامل هاتف للسيارة',
                'price' => 79.99,
                'old_price' => 99.99,
                'image' => 'products/phone-holder.txt',
                'description' => 'حامل هاتف للسيارة مع مغناطيس قوي وضبط زاوية 360 درجة. مثالي للسلامة أثناء القيادة.',
                'category' => 'إكسسوارات',
                'min_quantity' => 1,
            ],
            [
                'name' => 'كابل USB-C سريع',
                'price' => 39.99,
                'old_price' => null,
                'image' => 'products/usb-c-cable.txt',
                'description' => 'كابل USB-C بطول 1.5 متر يدعم الشحن السريع ونقل البيانات بسرعة عالية.',
                'category' => 'إكسسوارات',
                'min_quantity' => 1,
            ],
            
            // أزياء
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
                'name' => 'ساعة يد كلاسيكية',
                'price' => 799.99,
                'old_price' => 999.99,
                'image' => 'products/classic-watch.txt',
                'description' => 'ساعة يد كلاسيكية من الفولاذ المقاوم للصدأ مع حركة سويسرية دقيقة. مثالية للمناسبات الرسمية.',
                'category' => 'أزياء',
                'min_quantity' => 1,
            ],
            [
                'name' => 'نظارات شمسية عصرية',
                'price' => 299.99,
                'old_price' => null,
                'image' => 'products/sunglasses.txt',
                'description' => 'نظارات شمسية من التيتانيوم مع حماية UV400. تصميم عصري يناسب الوجوه المختلفة.',
                'category' => 'أزياء',
                'min_quantity' => 1,
            ],
            [
                'name' => 'حزام جلدي أصلي',
                'price' => 149.99,
                'old_price' => 199.99,
                'image' => 'products/leather-belt.txt',
                'description' => 'حزام جلدي أصلي من جلد البقر عالي الجودة. مثالي للملابس الرسمية والعملية.',
                'category' => 'أزياء',
                'min_quantity' => 1,
            ],
            [
                'name' => 'نظارات واقية للشمس',
                'price' => 199.99,
                'old_price' => null,
                'image' => 'products/sport-sunglasses.txt',
                'description' => 'نظارات واقية للرياضات الخارجية مع حماية UV400 ومقاومة للصدمات. مثالية للرياضات.',
                'category' => 'أزياء',
                'min_quantity' => 1,
            ],
            
            // منزل ومطبخ
            [
                'name' => 'مكواة بخارية احترافية',
                'price' => 299.99,
                'old_price' => 399.99,
                'image' => 'products/steam-iron.txt',
                'description' => 'مكواة بخارية احترافية مع نظام التحكم في درجة الحرارة. مثالية للملابس الحريرية والقطنية.',
                'category' => 'منزل ومطبخ',
                'min_quantity' => 1,
            ],
            [
                'name' => 'مضخة ماء كهربائية',
                'price' => 149.99,
                'old_price' => null,
                'image' => 'products/water-pump.txt',
                'description' => 'مضخة ماء كهربائية قوية لسحب الماء من الأبار أو الخزانات. سهلة الاستخدام وموثوقة.',
                'category' => 'منزل ومطبخ',
                'min_quantity' => 1,
            ],
            [
                'name' => 'مروحة سقف سايلنت',
                'price' => 399.99,
                'old_price' => 499.99,
                'image' => 'products/ceiling-fan.txt',
                'description' => 'مروحة سقف هادئة مع ثلاث سرعات وتصميم عصري. مثالية للتبريد الصيفي دون ضوضاء.',
                'category' => 'منزل ومطبخ',
                'min_quantity' => 1,
            ],
            [
                'name' => 'مصباح LED ذكي',
                'price' => 129.99,
                'old_price' => 159.99,
                'image' => 'products/smart-bulb.txt',
                'description' => 'مصباح LED ذكي قابل للتحكم بالتطبيق أو الصوت. يدعم تغيير الألوان والتوقيت.',
                'category' => 'منزل ومطبخ',
                'min_quantity' => 1,
            ],
            [
                'name' => 'مكيف هواء محمول',
                'price' => 1299.99,
                'old_price' => 1599.99,
                'image' => 'products/portable-ac.txt',
                'description' => 'مكيف هواء محمول قوي مع نظام تبريد فائق. مثالي للغرف الصغيرة والمكاتب.',
                'category' => 'منزل ومطبخ',
                'min_quantity' => 1,
            ],
            
            // صحّة وتجميل
            [
                'name' => 'موزع صابون تلقائي',
                'price' => 79.99,
                'old_price' => null,
                'image' => 'products/soap-dispenser.txt',
                'description' => 'موزع صابون تلقائي بالحركة. مثالي للمطابخ والحمامات مع تصميم أنيق وحديث.',
                'category' => 'صحّة وتجميل',
                'min_quantity' => 1,
            ],
            [
                'name' => 'فرشاة أسنان كهربائية',
                'price' => 199.99,
                'old_price' => 249.99,
                'image' => 'products/electric-toothbrush.txt',
                'description' => 'فرشاة أسنان كهربائية مع 5 أوضاع تنظيف مختلفة. بطارية تدوم حتى أسبوعين.',
                'category' => 'صحّة وتجميل',
                'min_quantity' => 1,
            ],
            [
                'name' => 'جهاز قياس ضغط الدم',
                'price' => 249.99,
                'old_price' => null,
                'image' => 'products/blood-pressure.txt',
                'description' => 'جهاز قياس ضغط الدم الإلكتروني دقيق وسهل الاستخدام. مع شاشة كبيرة وتخزين القراءات.',
                'category' => 'صحّة وتجميل',
                'min_quantity' => 1,
            ],
            [
                'name' => 'مكواة شعر احترافية',
                'price' => 349.99,
                'old_price' => 449.99,
                'image' => 'products/hair-straightener.txt',
                'description' => 'مكواة شعر احترافية مع تكنولوجيا أيونية لمنع التمزق. مثالية للشعر الكثيف والمجعد.',
                'category' => 'صحّة وتجميل',
                'min_quantity' => 1,
            ],
            [
                'name' => 'مكواة تجعيد الشعر',
                'price' => 199.99,
                'old_price' => null,
                'image' => 'products/curling-iron.txt',
                'description' => 'مكواة تجعيد الشعر بحجم 32 مم مع درجات حرارة قابلة للتعديل. مثالية لعمل تصاميم شعر جذابة.',
                'category' => 'صحّة وتجميل',
                'min_quantity' => 1,
            ],
            
            // سيارات
            [
                'name' => 'ممسحة زجاج أمامية ذكية',
                'price' => 199.99,
                'old_price' => 249.99,
                'image' => 'products/smart-wiper.txt',
                'description' => 'ممسحة زجاج أمامية ذكية مع حساس مطر تلقائي. تعمل بسرعات مختلفة حسب كمية المطر.',
                'category' => 'سيارات',
                'min_quantity' => 1,
            ],
            [
                'name' => 'مقعد سيارة للطفل',
                'price' => 599.99,
                'old_price' => 799.99,
                'image' => 'products/car-seat.txt',
                'description' => 'مقعد سيارة للطفل مع حماية جانبية مزدوجة ومقعد قابل للتعديل. مثالي للأطفال حتى عمر 12 سنة.',
                'category' => 'سيارات',
                'min_quantity' => 1,
            ],
            [
                'name' => 'مبرد ماء للسيارة',
                'price' => 149.99,
                'old_price' => null,
                'image' => 'products/car-cooler.txt',
                'description' => 'مبرد ماء للسيارة يعمل بالطاقة الشمسية. يحافظ على مشروباتك باردة في الصيف.',
                'category' => 'سيارات',
                'min_quantity' => 1,
            ],
            [
                'name' => 'جهاز إنذار للسيارة',
                'price' => 899.99,
                'old_price' => 1099.99,
                'image' => 'products/car-alarm.txt',
                'description' => 'جهاز إنذار للسيارة مع حساس حركة وتحكم عن بعد. حماية متكاملة للسيارة من السرقة.',
                'category' => 'سيارات',
                'min_quantity' => 1,
            ],
            [
                'name' => 'مكبر صوت لاسلكي للسيارة',
                'price' => 399.99,
                'old_price' => 499.99,
                'image' => 'products/car-speaker.txt',
                'description' => 'مكبر صوت لاسلكي للسيارة مع بلوتوث 5.0. يدعم استقبال المكالمات الصوتية بوضوح.',
                'category' => 'سيارات',
                'min_quantity' => 1,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
