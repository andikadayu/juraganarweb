<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(50)->create();
        User::create([
            'name' => 'JuraganAR Admin',
            'email' => 'admin@juraganar.com',
            'email_verified_at' => now(),
            'password' => Hash::make('lajurkanan'), // password
            'remember_token' => Str::random(10),
            'alamat' => 'Malang',
            'no_telp' => '081231231231',
            'role' => 'superadmin',
            'is_active' => 1
        ]);
    }
}
