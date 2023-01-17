<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call([
            CurrencySeeder::class,
            TaxSeeder::class,
            GatewaySeeder::class,
            OptionSeeder::class,
            PlanSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            MediaSeeder::class,
            CategorySeeder::class,
            TermSeeder::class,
            PayoutMethodSeeder::class,
            MenuSeeder::class
        ]);

        \Storage::disk('local')->copy('sample-file.zip', 'public/uploads/sample-file.zip');
    }
}
