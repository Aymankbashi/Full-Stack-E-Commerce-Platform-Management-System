<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class CartController extends Controller
{
    public function checkout()
    {
        return view('checkout');
    }

    public function processCheckout(Request $request)
    {
        // هنا يمكن حفظ الطلب في قاعدة البيانات لاحقاً
        session()->forget('cart');
        return redirect()->route('home')->with('success', 'تم تأكيد الطلب بنجاح!');
    }

    public function index()
    {
        return view('cart.index');
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $quantities = $request->input('quantities', []);
        foreach ($quantities as $id => $qty) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = max(1, (int)$qty);
            }
        }
        session(['cart' => $cart]);
        return back()->with('success', 'تم تحديث السلة');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);
        return back()->with('success', 'تم حذف المنتج من السلة');
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $qty = $request->input('quantity', 1);
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $qty;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $qty,
            ];
        }
        session(['cart' => $cart]);
        return back()->with('success', 'تمت إضافة المنتج إلى السلة');
    }
}
