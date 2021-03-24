<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
            [
                'id'=>1,
                'name'=>'Phạm Việt Hưng',
                'type'=>'admin',
                'mobile'=>'0912807016',
                'email'=>'hung.v.pham002@gmail.com',
                'password'=>'$2y$10$bA3i/mrFGqGBh2JlHFyAZOQBpZzRNwSI2FPAWQj9a4miUNsURTEly',
                'image'=>'',
                'status'=>1
            ],
            [
                'id'=>2,
                'name'=>'Phạm Dũng',
                'type'=>'admin',
                'mobile'=>'0913807016',
                'email'=>'phamdung67@gmail.com',
                'password'=>'$2y$10$KbH0Z98BU5WDZE9t7Sbn1Otu.JQDyYZ7dnqE9g3/1JlaIG.sDz2l2',
                'image'=>'',
                'status'=>1
            ],
            [
                'id'=>3,
                'name'=>'Vũ Hà My',
                'type'=>'admin',
                'mobile'=>'0938020215',
                'email'=>'vhmy202@gmail.com',
                'password'=>'$2y$10$Bn9sOq.OIq8MYWLR07EdgO7ix4KU/XNRye1H0sJNORRKdB1.aomP2',
                'image'=>'',
                'status'=>1
            ],
        ];

        DB::table('admins')->insert($adminRecords);
        // foreach ($adminRecords as $key => $record) {
        //     \App\Admin::create($record);
        // }
    }
}
