<?php

namespace Database\Factories\Master;

use App\Models\Master\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Member::class;
    public function definition(): array
    {
        $code = str_pad($this->faker->unique()->numberBetween(1, 100), 7, '0', STR_PAD_LEFT);

        return [
            'name' => $this->faker->name,
            'identitycardnumber' => $this->faker->numerify('###############'),
            'gender' => $this->faker->randomElement(['L', 'P']),
            'address' => $this->faker->address,
            'date' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'code' => $code,
        ];
    }
}
