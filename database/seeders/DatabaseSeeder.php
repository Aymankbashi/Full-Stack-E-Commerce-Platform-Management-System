<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // إنشاء حساب أدمن
        User::firstOrCreate(
            ['email' => 'aymnkokbashi@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => '123456789',
                'role' => 'admin',
            ]
        );

        $this->call([
            ProductSeeder::class,
            SupportAgentSeeder::class,
        ]);
    }
}
