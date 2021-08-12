<?php

use Illuminate\Database\Seeder;
use App\MaxproProductAttributes;

class MaxproProductAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $maxproProductAttributesRecords = [
            ['id'=>1, 'product_id'=>1, 'section_id'=>1, 'voltage'=>18, 'power'=>NULL, 'price'=>2150000, 'stock'=>10, 'sku'=>'MPKP1-MPCD18Li/2', 'status'=>1],
            ['id'=>2, 'product_id'=>2, 'section_id'=>1, 'voltage'=>18, 'power'=>NULL, 'price'=>1150000, 'stock'=>10, 'sku'=>'MPKP2-MPCD18Li/2E', 'status'=>1],
        ];
        MaxproProductAttributes::insert($maxproProductAttributesRecords);
    }
}
