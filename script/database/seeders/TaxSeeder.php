<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taxes = [
            ['name' => 'Vat','rate' => '2','type' => 'percentage','status' => '1','created_at' => now(),'updated_at' => now()],
            ['name' => 'AT','rate' => '3','type' => 'fixed','status' => '1','created_at' => now(),'updated_at' => now()]
        ];

        Tax::insert($taxes);
    }
}
