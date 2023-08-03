<?php

namespace Database\Seeders;

use App\Models\Info;
use Illuminate\Database\Seeder;

class InfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Info::create([
            'email' => 'mohammad.alshekh.omar@gmail.com',
            'phone' => '0993571184',
            'facebook' => 'www.facebook.com',
            'instagram' => 'www.instagram.com',
            'twitter' => 'www.twitter.com',
            'whatsapp' => 'www.whatsapp.com',
            'youtube' => 'www.youtube.com',
        ]);
    }
}
