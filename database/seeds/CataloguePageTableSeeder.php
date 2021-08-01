<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\CataloguePage;


class CataloguePageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $CataloguePagesRecords = [
            ['id'=>1,'title'=>'Catalogue MAXPRO POWER TOOLS', 'description'=>'content is coming soon','file_path'=>'','url'=>'gioi-thieu','meta_title'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>2,'title'=>'Catalogue SHIMGE PUMPS', 'description'=>'content is coming soon','file_path'=>'','url'=>'lich-su-hinh-thanh','meta_title'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','status'=>1],
        ];
            
        CataloguePage::insert($CataloguePagesRecords);
    }
}
