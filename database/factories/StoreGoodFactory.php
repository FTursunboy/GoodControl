<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Good;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StoreGood>
 */
class StoreGoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $good = Good::find(rand(1, 20000))->first();
        return [
            'IMEI' => $good?->IMEI,
            'amount' => 1,
            'store_id'  => 5,
            'type_id' => $good->type_id
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
