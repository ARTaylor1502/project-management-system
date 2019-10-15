<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project_id = DB::table('projects')->where(['name' => 'Exhibition Stand'])->value('id');
        $product_id = DB::table('products')->where('name', '2ft Scaffold Bar')->value('id');

        DB::table('project_products')->insert([
            'project_id'     =>  $project_id,
            'product_id'     =>  $product_id,
            'quantity'       =>  2
        ]);

        $product_id = DB::table('products')->where('name', '5ft Scaffold Bar')->value('id');

        DB::table('project_products')->insert([
            'project_id'     =>  $project_id,
            'product_id'     =>  $product_id,
            'quantity'       =>  2
        ]);

        $product_id = DB::table('products')->where('name', '10ft Scaffold Bar')->value('id');

        DB::table('project_products')->insert([
            'project_id'     =>  $project_id,
            'product_id'     =>  $product_id,
            'quantity'       =>  2
        ]);

        $project_id = DB::table('projects')->where(['name' => 'Exhibition Stand 2'])->value('id');
        $product_id = DB::table('products')->where('name', '2ft Scaffold Bar')->value('id');

        DB::table('project_products')->insert([
            'project_id'     =>  $project_id,
            'product_id'     =>  $product_id,
            'quantity'       =>  2
        ]);

        $product_id = DB::table('products')->where('name', '5ft Scaffold Bar')->value('id');

        DB::table('project_products')->insert([
            'project_id'     =>  $project_id,
            'product_id'     =>  $product_id,
            'quantity'       =>  2
        ]);

        $product_id = DB::table('products')->where('name', '10ft Scaffold Bar')->value('id');

        DB::table('project_products')->insert([
            'project_id'     =>  $project_id,
            'product_id'     =>  $product_id,
            'quantity'       =>  2
        ]);

        $project_id = DB::table('projects')->where(['name' => 'Exhibition Stand 3'])->value('id');
        $product_id = DB::table('products')->where('name', '2ft Scaffold Bar')->value('id');

        DB::table('project_products')->insert([
            'project_id'     =>  $project_id,
            'product_id'     =>  $product_id,
            'quantity'       =>  2
        ]);

        $product_id = DB::table('products')->where('name', '5ft Scaffold Bar')->value('id');

        DB::table('project_products')->insert([
            'project_id'     =>  $project_id,
            'product_id'     =>  $product_id,
            'quantity'       =>  2
        ]);

        $product_id = DB::table('products')->where('name', '10ft Scaffold Bar')->value('id');

        DB::table('project_products')->insert([
            'project_id'     =>  $project_id,
            'product_id'     =>  $product_id,
            'quantity'       =>  2
        ]);

        $project_id = DB::table('projects')->where(['name' => 'Bar Structure'])->value('id');
        $product_id = DB::table('products')->where('name', '2ft Scaffold Bar')->value('id');

        DB::table('project_products')->insert([
            'project_id'     =>  $project_id,
            'product_id'     =>  $product_id,
            'quantity'       =>  2
        ]);

        $product_id = DB::table('products')->where('name', '5ft Scaffold Bar')->value('id');

        DB::table('project_products')->insert([
            'project_id'     =>  $project_id,
            'product_id'     =>  $product_id,
            'quantity'       =>  2
        ]);

        $product_id = DB::table('products')->where('name', '10ft Scaffold Bar')->value('id');

        DB::table('project_products')->insert([
            'project_id'     =>  $project_id,
            'product_id'     =>  $product_id,
            'quantity'       =>  2
        ]);
    }
}
