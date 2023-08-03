<?php

namespace Database\Seeders;

use App\Enums\OrderStatusEnum;
use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::create([
            'status' => OrderStatusEnum::PENDING->value,
            'ar' => [
                'name' => 'قيد الإنتظار',
            ],
            'en' => [
                'name' => 'pending',
            ],
        ]);

        OrderStatus::create([
            'status' => OrderStatusEnum::ACCEPTED->value,
            'ar' => [
                'name' => 'قيد الدراسة',
            ],
            'en' => [
                'name' => 'Under Consideration',
            ],
        ]);

        OrderStatus::create([
            'status' => OrderStatusEnum::REJECTED->value,
            'ar' => [
                'name' => 'مرفوض',
            ],
            'en' => [
                'name' => 'Rejected',
            ],
        ]);

        OrderStatus::create([
            'status' => OrderStatusEnum::FINISHED->value,
            'ar' => [
                'name' => 'مكتمل',
            ],
            'en' => [
                'name' => 'Finished',
            ],
        ]);
    }
}
