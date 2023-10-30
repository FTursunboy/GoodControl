<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Good;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RealizationHistory>
 */
class RealizationHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $possibleTypes = ['purchase', 'return', 'sale'];

        $startDate = Carbon::create(2022, 1, 1);
        $endDate = Carbon::create(2023, 12, 31);

        $randomDate = $startDate->copy()->addDays(rand(0, $endDate->diffInDays($startDate)));

        return [
            'IMEI' => Good::where('id', rand(1, Good::count()))->first()?->IMEI,
            'type_id' => rand(1, Type::count()),
            'sent' => false,
            'sender' => [1, 5,4, 6][array_rand([1, 5, 6, 4])],
            'recipient' => [1, 5, 6][array_rand([1, 5, 6])],
            'doc_number' => rand(100000, 102000),
            'type' => fake()->randomElement($possibleTypes),
            'status_id' => rand(1, 5),
            'created_at' => $randomDate
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
