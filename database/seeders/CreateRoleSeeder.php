<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'storage',
            'login' => 'storage',
            'phone' => '927711d891',
            'password' => 'password'
        ])->assignRole('storage');
        User::create([
            'name' => 'consultant',
            'login' => 'consultant',
            'phone' => '9227711s891',
            'password' => 'password'
        ])->assignRole('consultant');
        User::create([
            'name' => 'admin',
            'login' => 'admin',
            'phone' => '92`7a711891',
            'password' => 'password'
        ])->assignRole('admin');
        User::create([
            'name' => 'provider',
            'login' => 'provider',
            'phone' => '927a7111891',
            'password' => 'password'
        ])->assignRole('provider');
        User::create([
            'name' => 'store',
            'login' => 'store',
            'phone' => '927a7`1211891',
            'password' => 'password'
        ])->assignRole('store');
        User::create([
            'name' => 'client',
            'login' => 'client',
            'phone' => '927a`121711891',
            'password' => 'password'
        ])->assignRole('client');
    }
}
