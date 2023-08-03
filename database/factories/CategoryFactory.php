<?php

namespace Database\Factories;

use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

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
                'name' => $arabic_faker->name(),
                'text' => $this->faker->sentence(10),
            ],
            'en' => [
                'name' => $this->faker->name(),
                'text' => $this->faker->sentence(10),
            ],
        ];
    }
}
