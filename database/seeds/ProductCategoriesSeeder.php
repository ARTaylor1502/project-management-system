<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert([
            'name'          =>  'Rigging'
        ]);

        DB::table('product_categories')->insert([
            'name'          =>  'Power Distribution'
        ]);

        DB::table('product_categories')->insert([
            'name'          =>  'Lighting'
        ]);

        DB::table('product_categories')->insert([
            'name'          =>  'Cables & Adapters'
        ]);
    }
}
