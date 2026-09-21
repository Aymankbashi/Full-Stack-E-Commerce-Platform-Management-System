<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('login');
    }

    // Handle login submission
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // التحويل إلى الصفحة التي كان يقصدها المستخدم
            $intendedUrl = $request->session()->pull('url.intended', '/welcome');
            
            // التحويل إلى لوحة التحكم المناسبة حسب دور المستخدم
            if (Auth::user()->role === 'admin' || Auth::user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role === 'vendor' || Auth::user()->hasRole('vendor')) {
                return redirect()->route('vendor.dashboard');
            } elseif (Auth::user()->role === 'support_agent' || Auth::user()->hasRole('support_agent')) {
                return redirect()->route('support.agent.dashboard');
            }
            
            // التحويل إلى الصفحة المقصودة أو الصفحة الرئيسية
            // إذا كان المستخدم تاجر، يتم توجيهه إلى لوحة تحكمه مباشرة
            if (Auth::user()->role === 'vendor' || Auth::user()->hasRole('vendor')) {
                return redirect()->route('vendor.dashboard');
            }
            return redirect()->intended($intendedUrl);
        }

        return back()->withErrors([
            'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
        ])->onlyInput('email');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // Show registration form
    public function showRegistrationForm()
    {
        return view('register');
    }

    // Handle registration submission
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', 'string', 'in:user,vendor,admin'],
        ]);

        // التحقق من دور المستخدم
        $role = $request->input('role', 'user');
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,
        ]);

        // إذا كان المستخدم تاجر، قم بإنشاء سجل Vendor له
        if ($role === 'vendor') {
            // الحصول على البيانات الإضافية للتاجر من الطلب
            $vendorData = $request->validate([
                'phone' => ['required', 'string', 'max:20'],
                'shop_name' => ['required', 'string', 'max:255'],
                'shop_url' => ['nullable', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
            ]);

            // إنشاء سجل Vendor
            $vendor = Vendor::create([
                'user_id' => $user->id,
                'store_name' => $vendorData['shop_name'],
                'store_description' => $vendorData['description'] ?? null,
                'status' => 'pending', // وضع "قيد الانتظار" حتى يوافق عليه الـ Admin
            ]);

            // إضافة دور التاجر للمستخدم
            $vendorRole = Role::firstOrCreate([
                'name' => 'vendor'
            ], [
                'description' => 'تاجر'
            ]);
            $user->roles()->sync([$vendorRole->id]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        // التحويل إلى الصفحة التي كان يقصدها المستخدم
        $intendedUrl = $request->session()->pull('url.intended', '/welcome');
        
        // التحويل إلى لوحة التحكم المناسبة حسب دور المستخدم
        if ($user->role === 'admin' || $user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'vendor' || $user->hasRole('vendor')) {
            return redirect()->route('vendor.dashboard')->with('success', 'تم إنشاء حسابك بنجاح. سيتم مراجعة طلبك وإبلاغك بالموافقة قريباً.');
        } elseif ($user->role === 'support_agent' || $user->hasRole('support_agent')) {
            return redirect()->route('support.agent.dashboard');
        }
        
        // التحويل إلى الصفحة المقصودة أو صفحة النجاح
        return redirect()->intended($intendedUrl);
    }
}
