<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VendorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // التأكد من أن المستخدم مسجل الدخول ودوره تاجر
        if (!auth()->check() || !auth()->user()->hasRole('vendor')) {
            // إذا لم يكن المستخدم تاجر، يتم إعادة توجيهه إلى الصفحة الرئيسية
            return redirect()->route('home')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        return $next($request);
    }
}
