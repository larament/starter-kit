<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Raziul Islam',
            'email' => config('larament.super_admin.email'),
            'password' => config('larament.super_admin.password'),
            'email_verified_at' => now(),
        ]);
    }
}
