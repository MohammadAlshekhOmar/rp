<?php

namespace Database\Factories;

use App\Models\Provider;
use App\Models\Service;
use App\Models\Category;
use App\Models\PaymentMethod;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $arabic_faker = Faker::create('ar_JO');
        return [
            'provider_id' => Provider::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'payment_method_id' => PaymentMethod::inRandomOrder()->first()->id,
            'price' => random_int(10, 1000),
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
