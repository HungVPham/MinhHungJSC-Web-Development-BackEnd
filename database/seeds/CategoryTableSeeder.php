<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryRecords = [
            ['id'=>1, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'Cordless Tools', 'category_discount'=>0, 'category_description'=>'', 'url'=>'cordless-tools', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>2, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'Corded Drills', 'category_discount'=>0, 'category_description'=>'', 'url'=>'corded-drills', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>3, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'Demolition Tools', 'category_discount'=>0, 'category_description'=>'', 'url'=>'demolition-tools', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>4, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'Hammers Drills', 'category_discount'=>0, 'category_description'=>'', 'url'=>'hammer-drills', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>5, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'Grinders', 'category_discount'=>0, 'category_description'=>'', 'url'=>'grinders', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>6, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'Sanders', 'category_discount'=>0, 'category_description'=>'', 'url'=>'sanders', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>7, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'Planers', 'category_discount'=>0, 'category_description'=>'', 'url'=>'planers', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>8, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'Wood Saws', 'category_discount'=>0, 'category_description'=>'', 'url'=>'wood-saws', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>9, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'Others', 'category_discount'=>0, 'category_description'=>'', 'url'=>'', 'other-tools'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>10, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'Bench Top Tools', 'category_discount'=>0, 'category_description'=>'', 'url'=>'bench-top-tools', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>11, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'Pressure Washers', 'category_discount'=>0, 'category_description'=>'', 'url'=>'pressure-washers', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>12, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'Wielding Machines', 'category_discount'=>0, 'category_description'=>'', 'url'=>'wielding-machines', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>13, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'Air Compressors', 'category_discount'=>0, 'category_description'=>'', 'url'=>'air-compressors', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>14, 'parent_id'=>0, 'section_id'=>2, 'category_name'=>'SP Flex', 'category_discount'=>0, 'category_description'=>'', 'url'=>'sp-flex', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>15, 'parent_id'=>0, 'section_id'=>3, 'category_name'=>'Submersible & Sewage Pumps', 'category_discount'=>0, 'category_description'=>'', 'url'=>'submersible-sewage-pumps', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>16, 'parent_id'=>0, 'section_id'=>3, 'category_name'=>'Surface Pumps', 'category_discount'=>0, 'category_description'=>'', 'url'=>'', 'meta_title'=>'surface-pumps', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
        ];

        Category::insert($categoryRecords);
    }
}
