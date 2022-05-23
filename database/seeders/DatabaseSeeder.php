<?php

namespace Database\Seeders;

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
        // $this->call(ProductsImagesTableSeeder::class);
        // $this->call(BrandsTableSeeeder::class);
        // $this->call(BannersTableSeeder::class);
        //$this->call(CmsPagesTableSeeder::class);
        //$this->call(AboutPageTableSeeder::class);
        //$this->call(CataloguePageTableSeeder::class);
        // $this->call(CouponsTableSeeder::class);
        // $this->call(DeliveryAddressesTableSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
    }
}

