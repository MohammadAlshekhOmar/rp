<?php

namespace Database\Seeders;

use App\Enums\AdStatusEnum;
use App\Models\AdStatus;
use Illuminate\Database\Seeder;

class AdStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdStatus::create([
            'status' => AdStatusEnum::PENDING->value,
            'ar' => [
                'name' => 'قيد الإنتظار',
            ],
            'en' => [
                'name' => 'Pending',
            ],
        ]);

        AdStatus::create([
            'status' => AdStatusEnum::ACCEPTED->value,
            'ar' => [
                'name' => 'مقبول',
            ],
            'en' => [
                'name' => 'Accepted',
            ],
        ]);

        AdStatus::create([
            'status' => AdStatusEnum::REJECTED->value,
            'ar' => [
                'name' => 'مرفوض',
            ],
            'en' => [
                'name' => 'Rejected',
            ],
        ]);
    }
}
