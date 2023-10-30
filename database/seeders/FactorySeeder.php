<?php

namespace Database\Seeders;


use App\Models\Good;
use App\Models\RealizationHistory;
use App\Models\StoreGood;
use Illuminate\Database\Seeder;

class FactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     // Category::factory()->count(200)->create();
     //  Type::factory()->count(500)->create();
      //  Good::factory()->count(10000)->create();
//        RealizationHistory::factory()->count(10000)->create();

        StoreGood::factory()->count(5000)->create();
    }
}
