<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use App\Models\PlatformUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminUser::create([
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);

        PlatformUser::create([
            'username' => 'user',
            'password' => bcrypt('password'),
        ]);
    }
}
