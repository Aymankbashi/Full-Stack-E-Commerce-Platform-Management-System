<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * عرض لوحة تحكم الإدارة
     */
    public function dashboard()
    {
        $products = Product::latest()->get();

        // إحصائيات المستخدمين
        $allUsers = User::all();
        $activeUsers = User::where('is_active', 1)->count();
        $inactiveUsers = User::where('is_active', 0)->count();
        $supportAgents = User::where('role', 'support_agent')->count();
        $recentUsers = User::latest()->take(5)->get();

        // إحصائيات المنتجات
        $productCount = Product::count();

        // إحصائيات الدعم الفني
        $activeSupportSessions = \App\Models\SupportSession::where('status', 'active')->count();
        $recentSupportSessions = \App\Models\SupportSession::with('user')
            ->latest()
            ->take(5)
            ->get();

        // إحصائيات الطلبات (قيم تجريبية)
        $orderCount = 0;
        $revenue = 0;

        return view('admin.dashboard', compact(
            'products',
            'allUsers',
            'activeUsers',
            'inactiveUsers',
            'supportAgents',
            'recentUsers',
            'productCount',
            'activeSupportSessions',
            'recentSupportSessions',
            'orderCount',
            'revenue'
        ));
    }

    /**
     * عرض نموذج إضافة منتج جديد
     */
    public function createProduct()
    {
        return view('admin.products.create');
    }

    /**
     * حفظ منتج جديد
     */
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'min_quantity' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'offer_end' => 'nullable|date|after:now',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'description' => $request->description,
            'category' => $request->category,
            'min_quantity' => $request->min_quantity,
            'image' => $imagePath,
            'offer_end' => $request->offer_end,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'تم إضافة المنتج بنجاح');
    }

    /**
     * عرض نموذج تعديل منتج
     */
    public function editProduct(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * تحديث منتج
     */
    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'min_quantity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'offer_end' => 'nullable|date|after:now',
        ]);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'description' => $request->description,
            'category' => $request->category,
            'min_quantity' => $request->min_quantity,
            'offer_end' => $request->offer_end,
        ];

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.dashboard')
            ->with('success', 'تم تحديث المنتج بنجاح');
    }

    /**
     * حذف منتج
     */
    public function deleteProduct(Product $product)
    {
        // حذف الصورة
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'تم حذف المنتج بنجاح');
    }

    /**
     * عرض قائمة المستخدمين
     */
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /**
     * تحديث صلاحية المستخدم
     */
    public function updateUserRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,support_agent,user',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'تم تحديث صلاحية المستخدم بنجاح');
    }
}
