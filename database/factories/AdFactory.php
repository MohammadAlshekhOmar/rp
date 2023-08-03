<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class AdFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ad::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provider_id' => Provider::inRandomOrder()->first()->id,
            'ar' => [
                'text' => $this->faker->sentence(10),
            ],
            'en' => [
                'text' => $this->faker->sentence(10),
            ],
        ];
    }
}
