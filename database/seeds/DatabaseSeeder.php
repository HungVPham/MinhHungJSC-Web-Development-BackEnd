<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(AdminsTableSeeder::class);
        // $this->call(SectionsTableSeeder::class);
        // $this->call(CategoryTableSeeder::class);
        // $this->call(ProductsTableSeeder::class);
        // $this->call(ShimgeProductAttributesTableSeeder::class);
        // $this->call(MaxproProductAttributesTableSeeder::class);
        /// $this->call(HhoseProductAttributesTableSeeder::class);
        $this->call(ProductsImagesTableSeeder::class);
    }
}
