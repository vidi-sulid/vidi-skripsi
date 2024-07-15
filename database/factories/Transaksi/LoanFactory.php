<?php

namespace Database\Factories\Transaksi;

use App\Models\Master\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $member = Member::inRandomOrder()->first();
        $invoice = invoice("SYS", true);
        return [
            'invoice' => $invoice,
            'rekening' => function () use ($member) {
                return getRekeningLoan($member->code, "PJ_01");
            },
            'date_open' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'date_close' => '9999-12-31',
            'loan_amount' => $this->faker->numberBetween(2, 10) * 500000,
            'loan_term' => $this->faker->numberBetween(12, 36),
            'interest_rate' => $this->faker->randomFloat(2, 1, 15),
            'administration_fee' => $this->faker->randomFloat(2, 10000, 500000),
            'provision_fee' => $this->faker->randomFloat(2,  10000, 500000),
            'stamp_duty' => $this->faker->randomFloat(2,  10000, 50000),
            'member_code' => $member->code,
            'product_loan_id' => "PJ_01",
            'username' => $this->faker->userName,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}
