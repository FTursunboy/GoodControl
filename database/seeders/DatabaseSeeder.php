<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Status;
use App\Models\Type;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Role::create([
            'name' => 'admin'
        ]);
        Role::create([
            'name' => 'storage'
        ]);
        Role::create([
            'name' => 'consultant'
        ]);
        Role::create([
            'name' => 'client'
        ]);
        Role::create([
            'name' => 'provider'
        ]);
        Role::create([
            'name' => 'store'
        ]);

        Category::create([
            'name' =>  "TV",
        ]);

        Type::create([
            'barcode' => "3424324",
            "name" => "Tv",
            "category_id" => 1,
        ]);
        $this->call(CreateRoleSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(FactorySeeder::class);
        $this->call(AddStoreUsersPivot::class);
        $this->call(AddReturnSeeder::class);
    }
}
