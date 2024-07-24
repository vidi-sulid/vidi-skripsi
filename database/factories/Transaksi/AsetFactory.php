<?php

namespace Database\Factories\Transaksi;

use App\Models\Master\Member;
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
        $invoice = $this->faker->bothify('INV-#####');
        $vaProduct = array("1", "2");
        $product = $vaProduct[array_rand($vaProduct)];
        return [
            'invoice' => $invoice,
            'code' => $this->faker->bothify('######'),
            'name' => $this->faker->words(3, true) . ' Asset',  // Menghasilkan nama barang acak
            'inventory_number' => $this->faker->bothify('INVNUM-#####'),
            'purchase_date' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'product_asset_id' => $product,
            'price' => $this->faker->numberBetween(2, 8) * 200000, // Harga acak antara 100.00 dan 10000.99
            'residual_value' => 1,  // Nilai residu acak antara 0.00 dan 500.99
            'depreciation_period' => rand(1, 20),
            'username' => 'user' . rand(1, 10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
