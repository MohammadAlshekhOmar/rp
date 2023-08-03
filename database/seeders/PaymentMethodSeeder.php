<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'ar' => [
                'name' => 'طريقة 1',
            ],
            'en' => [
                'name' => 'method 1',
            ],
        ]);
        PaymentMethod::create([
            'ar' => [
                'name' => 'طريقة 2',
            ],
            'en' => [
                'name' => 'method 2',
            ],
        ]);
        // PaymentMethod::factory()->count(5)->create();
    }
}
