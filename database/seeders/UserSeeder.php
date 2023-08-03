<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'mohammad',
            'email' => 'mohammad.alshekh.omar@gmail.com',
            'phone' => '0993571184',
            'password' => bcrypt('p@$$word'),
        ]);

        User::factory()->count(10)->create();
    }
}
