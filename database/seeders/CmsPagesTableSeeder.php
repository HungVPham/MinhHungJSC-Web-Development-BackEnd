<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\CmsPage;

class CmsPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cmsPagesRecords = [
            ['id'=>1,'title'=>'Giới Thiệu', 'description'=>'content is coming soon','url'=>'gioi-thieu','meta_title'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>2,'title'=>'Chính Sách Bảo Mật', 'description'=>'content is coming soon','url'=>'chinh-sach-bao-mat','meta_title'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>3,'title'=>'Chính Sách Đổi - Trả', 'description'=>'content is coming soon','url'=>'chinh-sach-doi-tra','meta_title'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>4,'title'=>'Chính Sách Thanh Toán - Vận Chuyển', 'description'=>'content is coming soon','url'=>'chinh-sach-thanh-toan-va-van-chuyen','meta_title'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>5,'title'=>'Tuyển Dụng', 'description'=>'content is coming soon','url'=>'tuyen-dung','meta_title'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
        ];
            
        CmsPage::insert($cmsPagesRecords);
    }
}

