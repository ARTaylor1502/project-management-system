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
        $this->call(DepartmentsSeeder::class);
        $this->call(UserRolesSeeder::class);
        $this->call(UserTitlesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(UserAddressesSeeder::class);
        $this->call(ClientTypesSeeder::class);
        $this->call(ClientsSeeder::class);
        $this->call(ClientContactsSeeder::class);
        $this->call(ClientAliasesSeeder::class);
        $this->call(ClientAddressesSeeder::class);
        $this->call(ClientPasswordsSeeder::class);
        $this->call(ClientUsersSeeder::class);
        $this->call(VenuesSeeder::class);
        $this->call(EventsSeeder::class);
        $this->call(ProjectStatusesSeeder::class);
        $this->call(ProjectTypesSeeder::class);
        $this->call(ProjectsSeeder::class);
        $this->call(ProductCategoriesSeeder::class);
        $this->call(CostTypes::class);
        $this->call(ProductsSeeder::class);
        $this->call(ProjectUsersSeeder::class);
        $this->call(ProjectProductsSeeder::class);
        $this->call(ArtworkTypesSeeder::class);
        $this->call(TaskCategoriesSeeder::class);
        $this->call(TaskTemplatesSeeder::class);
        $this->call(TasksSeeder::class);
        $this->call(CarParkTypesSeeder::class);
        $this->call(VehicleTypesSeeder::class);
    }
}
