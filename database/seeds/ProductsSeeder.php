<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category_id = DB::table('product_categories')->where('name', 'Rigging')->value('id');
        $cost_type_id = DB::table('cost_types')->where('name', 'One-off')->value('id');

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '2ft Scaffold Bar',
            'quantity_available'    =>  1000,
            'quantity_total'        =>  2000,
            'cost'                  =>  7.50,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')

        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '5ft Scaffold Bar',
            'quantity_available'    =>  1000,
            'quantity_total'        =>  2000,
            'cost'                  =>  10,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '10ft Scaffold Bar',
            'quantity_available'    =>  1000,
            'quantity_total'        =>  2000,
            'cost'                  =>  12.50,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '20ft Scaffold Bar',
            'quantity_available'    =>  1000,
            'quantity_total'        =>  2000,
            'cost'                  =>  18,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '8-rung A Frame Ladder',
            'quantity_available'    =>  5,
            'quantity_total'        =>  30,
            'cost'                  =>  100,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '10-rung A Frame Ladder',
            'quantity_available'    =>  15,
            'quantity_total'        =>  30,
            'cost'                  =>  150,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '12.6Kg Stage Weight',
            'quantity_available'    =>  100,
            'quantity_total'        =>  250,
            'cost'                  =>  50,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '5Kg Safety Bond',
            'quantity_available'    =>  100,
            'quantity_total'        =>  350,
            'cost'                  =>  4,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '15Kg Safety Bond',
            'quantity_available'    =>  50,
            'quantity_total'        =>  250,
            'cost'                  =>  15,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '35Kg Safety Bond',
            'quantity_available'    =>  50,
            'quantity_total'        =>  100,
            'cost'                  =>  20,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '48.3mm Pipe Clamp Long Tee',
            'quantity_available'    =>  150,
            'quantity_total'        =>  500,
            'cost'                  =>  100,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '48.3mm Pipe Clamp 90 Degree',
            'quantity_available'    =>  250,
            'quantity_total'        =>  500,
            'cost'                  =>  40,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '48.3mm Pipe Clamp Short Tee',
            'quantity_available'    =>  350,
            'quantity_total'        =>  500,
            'cost'                  =>  35,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  'Scaffold Base Jack',
            'quantity_available'    =>  1000,
            'quantity_total'        =>  2000,
            'cost'                  =>  100,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $category_id = DB::table('product_categories')->where('name', 'Power Distribution')->value('id');

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '16A Power Distribution Box',
            'quantity_available'    =>  100,
            'quantity_total'        =>  200,
            'cost'                  =>  150,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '32A Power Distribution Box',
            'quantity_available'    =>  50,
            'quantity_total'        =>  200,
            'cost'                  =>  200,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '63A Power Distribution Box',
            'quantity_available'    =>  25,
            'quantity_total'        =>  100,
            'cost'                  =>  300,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '63A Power Distribution Box (Three Phase)',
            'quantity_available'    =>  100,
            'quantity_total'        =>  200,
            'cost'                  =>  350,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $category_id = DB::table('product_categories')->where('name', 'Lighting')->value('id');

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  'ETC Source 4 Junior',
            'quantity_available'    =>  100,
            'quantity_total'        =>  200,
            'cost'                  =>  450,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  'Par 64 Long',
            'quantity_available'    =>  100,
            'quantity_total'        =>  200,
            'cost'                  =>  75,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  'Selecon Acclaim Fresnel',
            'quantity_available'    =>  50,
            'quantity_total'        =>  200,
            'cost'                  =>  250,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  'Strand Coda Flood',
            'quantity_available'    =>  150,
            'quantity_total'        =>  200,
            'cost'                  =>  50,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '150w flood',
            'quantity_available'    =>  50,
            'quantity_total'        =>  200,
            'cost'                  =>  100,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $category_id = DB::table('product_categories')->where('name', 'Cables & Adapters')->value('id');

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '2m 13A Cable',
            'quantity_available'    =>  150,
            'quantity_total'        =>  200,
            'cost'                  =>  10,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '5m 13A Cable',
            'quantity_available'    =>  150,
            'quantity_total'        =>  200,
            'cost'                  =>  20,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '2m 15A Cable',
            'quantity_available'    =>  150,
            'quantity_total'        =>  200,
            'cost'                  =>  15,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '5m 15A Cable',
            'quantity_available'    =>  150,
            'quantity_total'        =>  200,
            'cost'                  =>  25,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '2m 16A Cable',
            'quantity_available'    =>  150,
            'quantity_total'        =>  200,
            'cost'                  =>  20,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '5m 16A Cable',
            'quantity_available'    =>  150,
            'quantity_total'        =>  200,
            'cost'                  =>  30,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '20A PowerCon',
            'quantity_available'    =>  150,
            'quantity_total'        =>  200,
            'cost'                  =>  10,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '5m 32A 230v Cable',
            'quantity_available'    =>  150,
            'quantity_total'        =>  200,
            'cost'                  =>  35,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '10m 32A 230v Cable',
            'quantity_available'    =>  150,
            'quantity_total'        =>  200,
            'cost'                  =>  50,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '5m Socapex Cable',
            'quantity_available'    =>  150,
            'quantity_total'        =>  200,
            'cost'                  =>  10,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'category_id'           =>  $category_id,
            'name'                  =>  '10m Socapex Cable',
            'quantity_available'    =>  150,
            'quantity_total'        =>  200,
            'cost'                  =>  20,
            'cost_type_id'          =>  $cost_type_id,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
