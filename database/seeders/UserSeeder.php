<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Criação do usuário administrador
        DB::table('users')->insert([
            'name' => 'root@root',
            'email' => 'root@root',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Criação do usuário comum
        DB::table('users')->insert([
            'name' => 'user@user',
            'email' => 'user@user',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
