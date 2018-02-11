<?php
declare(strict_types = 1);

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SettingsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(PagesSeeder::class);
        $this->call(ServersSeeder::class);
        $this->call(ProductsSeeder::class);
    }
}
