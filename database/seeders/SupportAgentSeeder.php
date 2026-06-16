<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SupportAgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء مستخدم موظف دعم فني تجريبي
        User::create([
            'name' => 'موظف الدعم الفني',
            'email' => 'support@example.com',
            'password' => Hash::make('password123'),
            'role' => 'support_agent',
            'is_active' => true,
        ]);
    }
}
