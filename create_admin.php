<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

// إنشاء المستخدم
$user = User::create([
    'name' => 'ايمن كباشي',
    'email' => 'aymankabashi@gmail.com',
    'password' => Hash::make('adminstar')
]);

// إنشاء دور المدير العام
$adminRole = Role::create([
    'name' => 'admin',
    'description' => 'المدير العام للمنصة'
]);

// إنشاء الصلاحيات اللازمة
$permissions = [
    'manage_vendors',
    'manage_products',
    'manage_orders',
    'view_financial_reports'
];

foreach ($permissions as $permission) {
    Permission::create([
        'name' => $permission,
        'description' => 'صلاحية ' . $permission
    ]);
}

// الحصول على IDs الصلاحيات
$permissionIds = Permission::pluck('id')->toArray();

// ربط الصلاحيات بالدور
$adminRole->permissions()->sync($permissionIds);

// ربط الدور بالمستخدم
$user->roles()->sync([$adminRole->id]);

echo 'تم إنشاء حساب المدير العام بنجاح!';
