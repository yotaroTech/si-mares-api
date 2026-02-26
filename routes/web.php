<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Temporary debug route - remove after fixing admin login
Route::get('/debug-admin', function () {
    $user = \App\Models\User::where('email', 'admin@simares.com')->first();
    if (!$user) return response()->json(['error' => 'admin user not found']);

    $panel = \Filament\Facades\Filament::getPanel('admin');

    return response()->json([
        'name' => $user->name,
        'role_raw' => $user->getRawOriginal('role'),
        'role_cast' => $user->role ? get_class($user->role) . '::' . $user->role->value : null,
        'role_is_super_admin' => $user->role === \App\Enums\UserRole::SuperAdmin,
        'can_access_panel' => $user->canAccessPanel($panel),
        'password_check' => \Illuminate\Support\Facades\Hash::check('SimaresAdmin2026!', $user->password),
    ]);
});
