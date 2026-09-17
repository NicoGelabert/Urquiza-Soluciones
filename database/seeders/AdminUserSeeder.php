<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Administrador',
                'email' => env('ADMIN_EMAIL', 'admin@urquizasoluciones.es'),
                'password' => env('ADMIN_PASSWORD', 'password'),
            ],
            [
                'name' => 'Administrador 2',
                'email' => env('ADMIN2_EMAIL', 'admin2@urquizasoluciones.es'),
                'password' => env('ADMIN2_PASSWORD', 'password'),
            ],
        ];

        foreach ($admins as $admin) {
            User::query()->updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'password' => Hash::make($admin['password']),
                    'email_verified_at' => now(),
                ],
            );
        }
    }
}
