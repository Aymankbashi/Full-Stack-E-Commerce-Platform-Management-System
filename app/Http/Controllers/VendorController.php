<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    /**
     * عرض صفحة تسجيل التاجر
     */
    public function create()
    {
        return view("vendor.register");
    }

    /**
     * حفظ بيانات التاجر الجديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "store_name" => "required|string|max:255",
            "store_description" => "nullable|string",
            "bank_name" => "required|string|max:255",
            "account_number" => "required|string|max:255",
            "iban" => "nullable|string|max:255",
        ]);

        // إنشاء بيانات المستخدم
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        // إنشاء بيانات التاجر
        $vendor = Vendor::create([
            "user_id" => $user->id,
            "store_name" => $validated["store_name"],
            "store_description" => $validated["store_description"],
            "bank_name" => $validated["bank_name"],
            "account_number" => $validated["account_number"],
            "iban" => $validated["iban"],
            "status" => "pending", // وضع "قيد الانتظار" حتى يوافق عليه الـ Admin
        ]);

        // إضافة دور التاجر للمستخدم
        $user->roles()->attach(2); // افتراض أن دور التاجر له ID = 2

        // تسجيل الدخول
        Auth::login($user);

        return redirect()->route("vendor.dashboard")->with("success", "تم إنشاء حساب التاجر بنجاح. سيتم مراجعة طلبك وإبلاغك بالموافقة قريباً.");
    }

    /**
     * عرض لوحة تحكم التاجر
     */
    public function dashboard()
    {
        // التأكد من أن المستخدم دوره تاجر وحسابه نشط
        if (!Auth::user()->hasRole("vendor") || !Auth::user()->vendor->isActive()) {
            abort(403, "ليس لديك صلاحية للوصول إلى هذه الصفحة");
        }

        $vendor = Auth::user()->vendor;

        // إحصائيات التاجر
        $totalSales = $vendor->orderItems()->sum("vendor_earnings");
        $totalOrders = $vendor->orderItems()->count();
        $balance = $vendor->balance;

        // المنتجات الأكثر مبيعاً
        $topProducts = $vendor->products()
            ->withCount("orderItems")
            ->orderBy("order_items_count", "desc")
            ->take(5)
            ->get();
            
        // آخر الطلبات
        $recentOrders = $vendor->orderItems()
            ->with(["order"])
            ->latest()
            ->take(5)
            ->get();

        return view("vendor.dashboard", compact("vendor", "totalSales", "totalOrders", "balance", "topProducts", "recentOrders"));
    }

    /**
     * عرض منتجات التاجر
     */
    public function products()
    {
        // التأكد من أن المستخدم دوره تاجر وحسابه نشط
        if (!Auth::user()->hasRole("vendor") || !Auth::user()->vendor->isActive()) {
            abort(403, "ليس لديك صلاحية للوصول إلى هذه الصفحة");
        }

        $products = Auth::user()->vendor->products()
            ->withCount("orderItems")
            ->latest()
            ->paginate(10);
        return view("vendor.products", compact("products"));
    }

    /**
     * إضافة منتج جديد
     */
    public function createProduct()
    {
        return view("vendor.products.create");
    }

    /**
     * حفظ منتج جديد
     */
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "description" => "required|string",
            "price" => "required|numeric|min:0",
            "old_price" => "nullable|numeric|min:0",
            "category" => "required|string|max:255",
            "image" => "required|image|mimes:jpeg,png,jpg,gif|max:2048",
            "min_quantity" => "nullable|integer|min:1",
            "offer_end" => "nullable|date",
        ]);

        // حفظ الصورة
        $imagePath = $request->file("image")->store("products", "public");

        // إنشاء المنتج
        $product = Auth::user()->vendor->products()->create([
            "name" => $validated["name"],
            "description" => $validated["description"],
            "price" => $validated["price"],
            "old_price" => $validated["old_price"],
            "category" => $validated["category"],
            "image" => $imagePath,
            "min_quantity" => $validated["min_quantity"],
            "offer_end" => $validated["offer_end"],
            "status" => "pending", // المنتج ينتظر موافقة Admin
        ]);

        return redirect()->route("vendor.products")->with("success", "تم إضافة المنتج بنجاح. سيتم مراجعته وإبلاغك بالموافقة قريباً.");
    }

    /**
     * تعديل منتج
     */
    public function editProduct($id)
    {
        $product = Auth::user()->vendor->products()->findOrFail($id);
        return view("vendor.products.edit", compact("product"));
    }

    /**
     * تحديث منتج
     */
    public function updateProduct(Request $request, $id)
    {
        $product = Auth::user()->vendor->products()->findOrFail($id);

        $validated = $request->validate([
            "name" => "required|string|max:255",
            "description" => "required|string",
            "price" => "required|numeric|min:0",
            "old_price" => "nullable|numeric|min:0",
            "category" => "required|string|max:255",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
            "min_quantity" => "nullable|integer|min:1",
            "offer_end" => "nullable|date",
        ]);

        // تحديث الصورة إذا تم تحميلها
        if ($request->hasFile("image")) {
            $imagePath = $request->file("image")->store("products", "public");
            $product->image = $imagePath;
        }

        // تحديث البيانات
        $product->update($validated);

        return redirect()->route("vendor.products")->with("success", "تم تحديث المنتج بنجاح.");
    }

    /**
     * حذف منتج
     */
    public function destroyProduct($id)
    {
        $product = Auth::user()->vendor->products()->findOrFail($id);
        $product->delete();

        return redirect()->route("vendor.products")->with("success", "تم حذف المنتج بنجاح.");
    }

    /**
     * عرض طلبات التاجر
     */
    public function orders()
    {
        // التأكد من أن المستخدم دوره تاجر وحسابه نشط
        if (!Auth::user()->hasRole("vendor") || !Auth::user()->vendor->isActive()) {
            abort(403, "ليس لديك صلاحية للوصول إلى هذه الصفحة");
        }

        // الحصول على عناصر الطلب التي تنتمي للتاجر
        $orderItems = Auth::user()->vendor->orderItems()
            ->with(["order", "product"])
            ->latest()
            ->paginate(10);

        return view("vendor.orders", compact("orderItems"));
    }

    /**
     * تحديث حالة عنصر الطلب
     */
    public function updateOrderItemStatus(Request $request, $id)
    {
        $orderItem = Auth::user()->vendor->orderItems()->findOrFail($id);

        $validated = $request->validate([
            "status" => "required|in:pending,shipped,delivered",
        ]);

        $orderItem->update($validated);

        return redirect()->back()->with("success", "تم تحديث حالة الطلب بنجاح.");
    }

    /**
     * عرض طلب التفاصيل
     */
    public function showOrder($id)
    {
        // التأكد من أن المستخدم دوره تاجر وحسابه نشط
        if (!Auth::user()->hasRole("vendor") || !Auth::user()->vendor->isActive()) {
            abort(403, "ليس لديك صلاحية للوصول إلى هذه الصفحة");
        }

        $order = Auth::user()->vendor->orderItems()->where("order_id", $id)->with(["order", "product"])->first();

        if (!$order) {
            abort(404, "الطلب غير موجود");
        }

        return view("vendor.order-details", compact("order"));
    }

    /**
     * تحديث حالة الطلب
     */
    public function updateOrderStatus(Request $request, $id)
    {
        // التأكد من أن المستخدم دوره تاجر وحسابه نشط
        if (!Auth::user()->hasRole("vendor") || !Auth::user()->vendor->isActive()) {
            abort(403, "ليس لديك صلاحية للوصول إلى هذه الصفحة");
        }

        $order = Auth::user()->vendor->orderItems()->where("order_id", $id)->first();

        if (!$order) {
            abort(404, "الطلب غير موجود");
        }

        $validated = $request->validate([
            "status" => "required|in:pending,shipped,delivered",
        ]);

        $order->update($validated);

        return redirect()->back()->with("success", "تم تحديث حالة الطلب بنجاح.");
    }

    /**
     * عرض قائمة العملاء
     */
    public function customers()
    {
        // التأكد من أن المستخدم دوره تاجر وحسابه نشط
        if (!Auth::user()->hasRole("vendor") || !Auth::user()->vendor->isActive()) {
            abort(403, "ليس لديك صلاحية للوصول إلى هذه الصفحة");
        }

        // الحصول على العملاء الذين قاموا بطلبات من هذا التاجر
        $customers = User::whereHas("orders", function ($query) {
            $query->whereHas("orderItems", function ($itemQuery) {
                $itemQuery->where("vendor_id", Auth::user()->vendor->id);
            });
        })->paginate(10);

        return view("vendor.customers", compact("customers"));
    }

    /**
     * عرض صفحة التقارير
     */
    public function reports()
    {
        // التأكد من أن المستخدم دوره تاجر وحسابه نشط
        if (!Auth::user()->hasRole("vendor") || !Auth::user()->vendor->isActive()) {
            abort(403, "ليس لديك صلاحية للوصول إلى هذه الصفحة");
        }

        $vendor = Auth::user()->vendor;

        // إحصائيات التاجر
        $totalSales = $vendor->orderItems()->sum("vendor_earnings");
        $totalOrders = $vendor->orderItems()->count();
        $balance = $vendor->balance;

        // المنتجات الأكثر مبيعاً
        $topProducts = $vendor->products()
            ->withCount("orderItems")
            ->orderBy("order_items_count", "desc")
            ->take(5)
            ->get();

        // المبيعات الشهرية
        $monthlySales = $vendor->orderItems()
            ->selectRaw("MONTH(created_at) as month, SUM(vendor_earnings) as total")
            ->whereYear("created_at", date("Y"))
            ->groupBy("month")
            ->get();

        return view("vendor.reports", compact("vendor", "totalSales", "totalOrders", "balance", "topProducts", "monthlySales"));
    }

    /**
     * عرض صفحة الإعدادات
     */
    public function settings()
    {
        // التأكد من أن المستخدم دوره تاجر وحسابه نشط
        if (!Auth::user()->hasRole("vendor") || !Auth::user()->vendor->isActive()) {
            abort(403, "ليس لديك صلاحية للوصول إلى هذه الصفحة");
        }

        return view("vendor.settings", ['vendor' => Auth::user()->vendor]);
    }

    /**
     * تحديث الإعدادات
     */
    public function updateSettings(Request $request)
    {
        // التأكد من أن المستخدم دوره تاجر وحسابه نشط
        if (!Auth::user()->hasRole("vendor") || !Auth::user()->vendor->isActive()) {
            abort(403, "ليس لديك صلاحية للوصول إلى هذه الصفحة");
        }

        $validated = $request->validate([
            "store_name" => "required|string|max:255",
            "store_description" => "nullable|string",
            "phone" => "required|string|max:20",
            "shop_url" => "nullable|string|max:255",
        ]);

        // تحديث بيانات التاجر
        Auth::user()->vendor->update($validated);

        return redirect()->route("vendor.settings")->with("success", "تم تحديث الإعدادات بنجاح.");
    }
}
