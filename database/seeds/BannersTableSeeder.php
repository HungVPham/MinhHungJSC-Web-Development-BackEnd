<?php

use Illuminate\Database\Seeder;
use App\Banner;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bannerRecords = [
            ['id'=>1, 'image'=>'banner1.jpg', 'link'=>'','title'=>'','alt'=>'','is_main'=>'Yes', 'status'=>1],
            ['id'=>2, 'image'=>'banner2.jpg', 'link'=>'','title'=>'','alt'=>'','is_main'=>'No', 'status'=>1],
            ['id'=>3, 'image'=>'banner3.jpg', 'link'=>'','title'=>'','alt'=>'','is_main'=>'No', 'status'=>1],
            ['id'=>4, 'image'=>'banner4.jpg', 'link'=>'','title'=>'',
            'alt'=>'','is_main'=>'No', 'status'=>1]
        ];
        Banner::insert($bannerRecords);
    }
}
