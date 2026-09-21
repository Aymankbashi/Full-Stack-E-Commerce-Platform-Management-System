<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * عرض قائمة الطلبات
     */
    public function index()
    {
        // الحصول على طلبات المستخدم
        $orders = Order::where('user_id', Auth::id())->latest()->get();

        return view('orders', compact('orders'));
    }

    /**
     * عرض تفاصيل طلب معين
     */
    public function show($id)
    {
        $order = Order::where('id', $id)
                     ->where('user_id', Auth::id())
                     ->firstOrFail();

        return view('orders.show', compact('order'));
    }

    /**
     * إنشاء طلب جديد
     */
    public function store(Request $request)
    {
        // الحصول على عناصر السلة من الجلسة
        $cartItems = session()->get('cart', []);

        // التحقق من أن السلة ليست فارغة
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'السلة فارغة');
        }

        // حساب الإجمالي
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // إنشاء الطلب
        $order = new Order();
        $order->user_id = Auth::id();
        $order->total = $total;
        $order->status = 'pending';
        $order->save();

        // إضافة المنتجات إلى الطلب
        foreach ($cartItems as $itemId => $item) {
            $order->products()->attach($itemId, [
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        // مسح السلة
        session()->forget('cart');

        return redirect()->route('orders.show', $order->id)
                        ->with('success', 'تم إنشاء الطلب بنجاح');
    }
}
