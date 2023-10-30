<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddReturnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create([
            'name' => 'Возврат  - Клиент - Магазин'
        ]);
        Status::create([
            'name' => 'Возврат  - Магазин - Склад'
        ]);
    }
}
