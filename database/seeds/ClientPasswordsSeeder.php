<?php

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Helper\Encryption;

class ClientPasswordsSeeder extends Seeder
{
    public $_encryption;

    public function __construct(Encryption $encryption) {
        $this->_encryption = $encryption;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_GB');

        $clients = DB::table('clients')->get();

        foreach($clients as $client) {
            DB::table('client_passwords')->insert([
                'client_id'     => $client->id,
                'name'          => $faker->name,
                'url'           => $faker->url,
                'details'       => $faker->text(20),
                'password'      => $this->_encryption->encrypt($faker->password),
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('client_passwords')->insert([
                'client_id'     => $client->id,
                'name'          => $faker->name,
                'url'           => $faker->url,
                'details'       => $faker->text(20),
                'password'      => $this->_encryption->encrypt($faker->password),
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('client_passwords')->insert([
                'client_id'     => $client->id,
                'name'          => $faker->name,
                'url'           => $faker->url,
                'details'       => $faker->text(20),
                'password'      => $this->_encryption->encrypt($faker->password),
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
