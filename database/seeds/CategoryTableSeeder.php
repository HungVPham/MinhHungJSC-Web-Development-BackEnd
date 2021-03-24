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
            ['id'=>1, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'máy khoan pin', 'category_discount'=>0, 'category_description'=>'', 'url'=>'maykhoanpin', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>2, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'máy khoan điện', 'category_discount'=>0, 'category_description'=>'', 'url'=>'maykhoandien', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>3, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'máy khoan búa', 'category_discount'=>0, 'category_description'=>'', 'url'=>'maykhoanbua', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>4, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'máy đục bê tông', 'category_discount'=>0, 'category_description'=>'', 'url'=>'mayducbetong', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>5, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'máy mài', 'category_discount'=>0, 'category_description'=>'', 'url'=>'maymai', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>6, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'máy nén khí', 'category_discount'=>0, 'category_description'=>'', 'url'=>'maynenkhi', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>7, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'máy trong xưởng mộc', 'category_discount'=>0, 'category_description'=>'', 'url'=>'maytrongxuongmoc', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>8, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'máy cắt đa năng', 'category_discount'=>0, 'category_description'=>'', 'url'=>'maycatdanang', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>9, 'parent_id'=>0, 'section_id'=>1, 'category_name'=>'những máy khác', 'category_discount'=>0, 'category_description'=>'', 'url'=>'nhungmaykhac', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>10, 'parent_id'=>0, 'section_id'=>2, 'category_name'=>'sp flex', 'category_discount'=>0, 'category_description'=>'', 'url'=>'spflex', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>11, 'parent_id'=>0, 'section_id'=>3, 'category_name'=>'máy bơm tăng áp', 'category_discount'=>0, 'category_description'=>'', 'url'=>'maybomtangap', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>12, 'parent_id'=>0, 'section_id'=>3, 'category_name'=>'máy bơm wsd', 'category_discount'=>0, 'category_description'=>'', 'url'=>'maybomwsd', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>13, 'parent_id'=>0, 'section_id'=>3, 'category_name'=>'máy bơm qb', 'category_discount'=>0, 'category_description'=>'', 'url'=>'maybomqb', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>14, 'parent_id'=>0, 'section_id'=>3, 'category_name'=>'máy bơm sgjw', 'category_discount'=>0, 'category_description'=>'', 'url'=>'maybomshjw', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>15, 'parent_id'=>0, 'section_id'=>3, 'category_name'=>'máy bơm shfm', 'category_discount'=>0, 'category_description'=>'', 'url'=>'maybomshfm', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>16, 'parent_id'=>0, 'section_id'=>3, 'category_name'=>'máy bơm cpm', 'category_discount'=>0, 'category_description'=>'', 'url'=>'maybomcpm', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
        ];

        Category::insert($categoryRecords);
    }
}
