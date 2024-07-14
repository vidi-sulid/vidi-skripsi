<?php

namespace Database\Factories;

use App\Models\Transaksi\Aset;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aset>
 */
class AsetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Aset::class;
    public function definition(): array
    {
        return [
            'invoice' => $this->faker->bothify('INV-#####'),
            'code' => $this->faker->bothify('CODE-#####'),
            'name' => $this->faker->word . ' Asset',
            'inventory_number' => $this->faker->bothify('INVNUM-#####'),
            'purchase_date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'product_asset_id' => Str::random(10),
            'loan_amount' => $this->faker->numberBetween(2, 8) * 200000, // Harga acak antara 100.00 dan 10000.99
            'residual_value' => $this->faker->randomFloat(2, 0, 500),  // Nilai residu acak antara 0.00 dan 500.99
            'depreciation_period' => rand(1, 20) . ' years',
            'username' => 'user' . rand(1, 10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
