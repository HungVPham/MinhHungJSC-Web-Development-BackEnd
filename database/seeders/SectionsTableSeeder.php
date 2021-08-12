<?php

use Illuminate\Database\Seeder;
use App\Section;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectionsRecords = [
            ['id'=>1, 'name'=>'MaxProTools', 'section_image'=>'', 'section_discount'=>0, 'section_description'=>'', 'url'=>'maxprotools', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'','status'=>1],
            ['id'=>2, 'name'=>'HydraulicPipes','section_image'=>'', 'section_discount'=>0, 'section_description'=>'', 'url'=>'hydraulicpumps', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
            ['id'=>3, 'name'=>'ShimgePumps', 'section_image'=>'', 'section_discount'=>0, 'section_description'=>'', 'url'=>'shimgepumps', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'','status'=>1],
            ['id'=>4, 'name'=>'KoreanRubberConveyorBelts', 'section_image'=>'', 'section_discount'=>0, 'section_description'=>'', 'url'=>'koreanrubberconveyorbelts', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1],
        ];
        Section::insert($sectionsRecords);
    }
}
