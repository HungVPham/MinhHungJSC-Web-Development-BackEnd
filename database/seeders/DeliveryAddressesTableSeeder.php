<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\DeliveryAddress;

class DeliveryAddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryRecords = [
            ['id'=>1, 'user_id'=>45, 'name'=>'Phạm Việt Hưng', 'address'=>'28.06A (tầng 28, tháp A), Parkson Hùng Vương, Phường 12, Quận 5', 'city'=>'Thành Phố Hồ Chí Minh', 'state'=>'', 'country'=>'Việt Nam', 'mobile'=>'0912807016', 'status'=>1],
            ['id'=>2, 'user_id'=>51, 'name'=>'Phạm Việt Trung', 'address'=>'28.06A (tầng 28, tháp A), Parkson Hùng Vương, Phường 12, Quận 5', 'city'=>'Thành Phố Hồ Chí Minh', 'state'=>'', 'country'=>'Việt Nam', 'mobile'=>'0967158383', 'status'=>1],
        ];

        DeliveryAddress::insert($deliveryRecords);
    }
}
