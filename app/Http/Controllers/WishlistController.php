<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * عرض قائمة الرغبات
     */
    public function index()
    {
        // الحصول على معرفات المنتجات من قائمة الرغبات
        $wishlistIds = session()->get('wishlist', []);

        // الحصول على تفاصيل المنتجات
        $wishlistItems = Product::whereIn('id', $wishlistIds)->get();

        return view('wishlist', compact('wishlistItems'));
    }

    /**
     * إضافة منتج إلى قائمة الرغبات
     */
    public function add($id)
    {
        $product = Product::findOrFail($id);

        // الحصول على قائمة الرغبات الحالية
        $wishlist = session()->get('wishlist', []);

        // إضافة المعرف إذا لم يكن موجوداً بالفعل
        if (!in_array($id, $wishlist)) {
            $wishlist[] = $id;
            session()->put('wishlist', $wishlist);

            return redirect()->back()->with('success', 'تمت إضافة المنتج إلى قائمة الرغبات');
        }

        return redirect()->back()->with('info', 'المنتج موجود بالفعل في قائمة الرغبات');
    }

    /**
     * إزالة منتج من قائمة الرغبات
     */
    public function remove($id)
    {
        // الحصول على قائمة الرغبات الحالية
        $wishlist = session()->get('wishlist', []);

        // إزالة المعرف إذا كان موجوداً
        if (($key = array_search($id, $wishlist)) !== false) {
            unset($wishlist[$key]);
            session()->put('wishlist', $wishlist);

            return redirect()->back()->with('success', 'تمت إزالة المنتج من قائمة الرغبات');
        }

        return redirect()->back()->with('info', 'المنتج غير موجود في قائمة الرغبات');
    }
}
