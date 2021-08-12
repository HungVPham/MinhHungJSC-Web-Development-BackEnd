<?php

use Illuminate\Database\Seeder;
use App\ShimgeProductAttributes;

class ShimgeProductAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shimgeProductAttributesRecords = [
            ['id'=>1, 'product_id'=>73, 'section_id'=>1, 'voltage'=>220, 'power'=>370, 'vertical'=>40, 'maxflow'=>2.4, 'indiameter'=>34, 'outdiameter'=>34, 'price'=>880000, 'stock'=>10, 'sku'=>'SGDJDT1-QB60K', 'status'=>1],
            ['id'=>2, 'product_id'=>73, 'section_id'=>1, 'voltage'=>220, 'power'=>750, 'vertical'=>60, 'maxflow'=>3.6, 'indiameter'=>34, 'outdiameter'=>34, 'price'=>1480000, 'stock'=>10, 'sku'=>'SGDJDT1-QB80', 'status'=>1],
        ];
        ShimgeProductAttributes::insert($shimgeProductAttributesRecords);
    }
}
