<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public const ADMIN_EMAIL = 'admin@goalpass.local';

    public const ADMIN_PASSWORD = 'Admin@123';

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => self::ADMIN_EMAIL],
            [
                'name' => 'Admin',
                'password' => Hash::make(self::ADMIN_PASSWORD),
                'is_admin' => true,
            ]
        );

        $this->command?->info('Admin user ready.');
        $this->command?->line('Login URL: /admin/login');
        $this->command?->line('Email: '.self::ADMIN_EMAIL);
        $this->command?->line('Password: '.self::ADMIN_PASSWORD);
    }
}
