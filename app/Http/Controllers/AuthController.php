<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
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

            // التحويل إلى لوحة التحكم المناسبة حسب دور المستخدم
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role === 'support_agent') {
                return redirect()->route('support.agent.dashboard');
            }

            return redirect()->intended('/welcome');
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
        ]);

        // التحقق من وجود معلمة admin أو support_agent في الطلب
        $role = 'user';
        if ($request->has('admin') && $request->admin == '1') {
            $role = 'admin';
        } elseif ($request->has('support_agent') && $request->support_agent == '1') {
            $role = 'support_agent';
        }
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        // التحويل إلى لوحة التحكم المناسبة حسب دور المستخدم
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'support_agent') {
            return redirect()->route('support.agent.dashboard');
        }

        return redirect()->route('registration.success');
    }
}
