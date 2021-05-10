<?php

use Illuminate\Database\Seeder;
use App\Brand;

class BrandsTableSeeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brandRecords = [
        ['id'=>1,'name'=>'MAXPRO', 'status'=>1],
        ['id'=>2,'name'=>'SP FLEX', 'status'=>1],
        ['id'=>3,'name'=>'HAMMER', 'status'=>1],
        ['id'=>4,'name'=>'SHIMGE', 'status'=>1],
        ];

        Brand::insert($brandRecords);
    }
}
