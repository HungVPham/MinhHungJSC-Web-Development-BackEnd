<?php

use Illuminate\Database\Seeder;
use App\HhoseProductAttributes;

class HhoseProductAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $HhoseProductAttributesRecords = [
            ['id'=>1, 'product_id'=>67, 'section_id'=>2, 'diameter'=>'1/4 Inch', 'hhose_spflex_embossed'=>"No", 'hhose_spflex_smoothtexture'=>"No",  'price'=>23500, 'stock'=>10, 'sku'=>'HHSP1-NN', 'status'=>1],
            ['id'=>2, 'product_id'=>67, 'section_id'=>2, 'diameter'=>'1/4 Inch', 'hhose_spflex_embossed'=>"No", 'hhose_spflex_smoothtexture'=>"Yes",  'price'=>26500, 'stock'=>10, 'sku'=>'HHSP1-NY', 'status'=>1],
        ];
        HhoseProductAttributes::insert($HhoseProductAttributesRecords);
    }
}
