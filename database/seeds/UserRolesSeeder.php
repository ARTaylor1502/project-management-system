<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            'name'                  =>  'Staff'
        ]);

        DB::table('user_roles')->insert([
            'name'                  =>  'Client'
        ]);

        DB::table('user_roles')->insert([
            'name'                  =>  'Supplier'
        ]);

        DB::table('user_roles')->insert([
            'name'                  =>  'Contractor'
        ]);
    }
}
