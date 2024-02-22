<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Usuário root
        User::create([
            'name' => 'root@root',
            'email' => 'root@root',
            'password' => Hash::make('root@root'),
            'is_admin' => true,
        ]);

        // Usuário normal
        User::create([
            'name' => 'user@user',
            'email' => 'user@user',
            'password' => Hash::make('user@user'),
            'is_admin' => false,
        ]);
    }
}
