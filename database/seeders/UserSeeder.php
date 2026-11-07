<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrNew([
            'email' => 'user@gmail.com',
        ]);

        $user->name = 'Pengguna Demo';
        $user->password = Hash::make('12341234');
        $user->role = 'user';
        $user->email_verified_at = now();

        $user->save();
    }
}
