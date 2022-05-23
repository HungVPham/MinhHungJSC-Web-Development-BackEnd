<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\OrderStatus;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderStatusRecords = [
            ['id'=>1,'name'=>'New','status'=>1],
            ['id'=>2,'name'=>'Pending','status'=>1],
            ['id'=>3,'name'=>'Completed','status'=>1],
            ['id'=>4,'name'=>'Cancelled','status'=>1],
        ];

        OrderStatus::insert($orderStatusRecords);
    }
}
