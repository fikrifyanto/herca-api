<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $trxNumber = 1;

        return [
            'transaction_number' => 'TRX' . str_pad($trxNumber++, 3, '0', STR_PAD_LEFT),
            'date' => fake()->dateTimeBetween(now()->startOfYear(), now()->endOfYear())->format('Y-m-d'),
            'cargo_fee' => $this->generateRandomPrice(),
            'total_balance' => $this->generateRandomPrice(),
            'grand_total' => $this->generateRandomPrice(),
        ];
    }


    /**
     * Generate a random cargo fee with increments of 100, 1000, or 1000000.
     *
     * @return int
     */
    protected function generateRandomPrice()
    {
        $increments = [1000, 10000, 100000, 1000000];
        $baseFee = $this->faker->numberBetween(1, 10) * 100;

        return $baseFee + $this->faker->randomElement($increments);
    }
}
