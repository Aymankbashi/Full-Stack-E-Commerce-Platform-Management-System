<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\VendorController;

/*
|--------------------------------------------------------------------------
| Temporary Route for Creating Admin Account
|--------------------------------------------------------------------------
|
| This route is used to create an admin account with the specified credentials.
| After creating the account, you can delete this file.
|
*/

// Route for creating admin account
Route::get('/create-admin', function () {
    // Check if admin already exists
    if (App\Models\User::where('email', 'aymankabashi@gmail.com')->exists()) {
        return 'Admin account already exists!';
    }

    // Create admin user
    $user = App\Models\User::create([
        'name' => 'ايمن كباشي',
        'email' => 'aymankabashi@gmail.com',
        'password' => bcrypt('adminstar')
    ]);

    // Create admin role if it doesn't exist
    $role = App\Models\Role::firstOrCreate([
        'name' => 'admin'
    ], [
        'description' => 'المدير العام للمنصة'
    ]);

    // Assign role to user
    $user->roles()->sync([$role->id]);

    return 'Admin account created successfully!';
});
