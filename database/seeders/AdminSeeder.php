<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrNew([
            'email' => 'admin@gmail.com',
        ]);

        $admin->name = 'Administrator';
        $admin->password = Hash::make('12341234');
        $admin->role = 'admin';
        $admin->email_verified_at = now();

        $admin->save();
    }
}