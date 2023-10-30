<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::insert([
            ['name' => 'Покупка'],
            ['name' => 'Реализация - Клиент'],
            ['name' => 'Реализация - Магазин'],
            ['name' => 'Возврат - Клиент'],
            ['name' => 'Возврат - Магазин'],
            ['name' => 'Реализация - Магазин - Клиент']
        ]);
    }
}
