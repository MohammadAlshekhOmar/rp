<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class PaymentMethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentMethod::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $arabic_faker = Faker::create('ar_JO');
        return [
            'ar' => [
                'name' => $arabic_faker->name()
            ],
            'en' => [
                'name' => $this->faker->name()
            ],
        ];
    }
}
