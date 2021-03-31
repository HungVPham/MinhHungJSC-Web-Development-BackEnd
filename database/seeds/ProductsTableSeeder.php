<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecords = [
            ['id'=>1,'category_id'=>1, 'subcategory_id'=>17, 'section_id'=>1, 'product_name'=>'Cordless Drill MPCD12Li/2E', 'product_code'=>'MPCD12Li/2E','product_price'=>'', 'product_description'=>'','product_discount'=>'','product_weight'=>'', 'product_video'=>'', 'main_image'=>'', 'image_v1'=>'', 'image_v2'=>'', 'image_v3'=>'', 'product_rating'=>'', 'meta_title'=>'', 'meta_keywords'=>'', 'meta_description'=>'', 'is_featured'=>'No', 'status'=>'1'],
            ['id'=>2,'category_id'=>1, 'subcategory_id'=>17, 'section_id'=>1, 'product_name'=>'Cordless Drill MPCD14Li/2E', 'product_code'=>'MPCD14Li/2E','product_price'=>'', 'product_description'=>'','product_discount'=>'','product_weight'=>'', 'product_video'=>'', 'main_image'=>'', 'image_v1'=>'', 'image_v2'=>'', 'image_v3'=>'', 'product_rating'=>'', 'meta_title'=>'', 'meta_keywords'=>'', 'meta_description'=>'', 'is_featured'=>'No', 'status'=>'1'],
            ['id'=>3,'category_id'=>1, 'subcategory_id'=>17, 'section_id'=>1, 'product_name'=>'Cordless Drill MPCD18Li/2E', 'product_code'=>'MPCD18Li/2E','product_price'=>'', 'product_description'=>'','product_discount'=>'','product_weight'=>'', 'product_video'=>'', 'main_image'=>'', 'image_v1'=>'', 'image_v2'=>'', 'image_v3'=>'', 'product_rating'=>'', 'meta_title'=>'', 'meta_keywords'=>'', 'meta_description'=>'', 'is_featured'=>'No', 'status'=>'1'],
            ['id'=>4,'category_id'=>1, 'subcategory_id'=>18, 'section_id'=>1, 'product_name'=>'Cordless Hammer Drill MPCD18HLi/2E', 'product_code'=>'MPCD18HLi/2E','product_price'=>'', 'product_description'=>'','product_discount'=>'','product_weight'=>'', 'product_video'=>'', 'main_image'=>'', 'image_v1'=>'', 'image_v2'=>'', 'image_v3'=>'', 'product_rating'=>'', 'meta_title'=>'', 'meta_keywords'=>'', 'meta_description'=>'', 'is_featured'=>'No', 'status'=>'1'],
        ];

        Product::insert($productRecords);
    }
}
