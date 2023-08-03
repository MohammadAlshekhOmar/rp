<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\Region;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provider = Provider::create([
            'name' => 'ahmad',
            'email' => 'ahmad@gmail.com',
            'phone' => '0993571188',
            'password' => bcrypt('p@$$word'),
        ]);
        $provider->regions()->firstOrCreate([
            'region_id' => Region::inRandomOrder()->first()->id,
        ]);
        $provider->regions()->firstOrCreate([
            'region_id' => Region::inRandomOrder()->first()->id,
        ]);

        Provider::factory()->count(10)->hasRegions(2)->create();
    }
}
