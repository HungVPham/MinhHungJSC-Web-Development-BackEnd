<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\AboutPage;

class AboutPageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $AboutPagesRecords = [
            ['id'=>1,'title'=>'Giới Thiệu', 'description'=>'content is coming soon','info_banner'=>'','url'=>'gioi-thieu','meta_title'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>2,'title'=>'Lịch Sử Hình Thành', 'description'=>'content is coming soon','info_banner'=>'','url'=>'lich-su-hinh-thanh','meta_title'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>3,'title'=>'Tầm Nhìn - Sứ Mệnh', 'description'=>'content is coming soon','info_banner'=>'','url'=>'tam-nhin-su-menh','meta_title'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>4,'title'=>'Sơ Đồ Tổ Chức', 'description'=>'content is coming soon','info_banner'=>'','url'=>'so-do-to-chuc','meta_title'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
        ];
            
        AboutPage::insert($AboutPagesRecords);
    }
}
