<?php

namespace Database\Seeders;

use App\Models\PayoutMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PayoutMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = [
            ['id' => 1, 'currency_id' => 1, 'name' => 'IBBL', 'image' => 'uploads/1/22/09/63173b10682d90609221662466832.png', 'min_limit' => 10, 'max_limit' => 1000, 'delay' => 10, 'fixed_charge' => NULL, 'percent_charge' => 10, 'data' => '[{"label":"Your account here.","type":"text"},{"label":"Your name here.","type":"text"}]', 'instruction' => "Nothing", 'status' => 1],
            ['id' => 2, 'currency_id' => 2, 'name' => 'Dutch Banlga', 'image' => 'uploads/1/22/09/63173b0fcbaab0609221662466831.jpg', 'min_limit' => 50, 'max_limit' => 5000, 'delay' => 10, 'fixed_charge' => NULL, 'percent_charge' => 10, 'data' => '[{"label":"Your account here.","type":"text"},{"label":"Your name here.","type":"text"}]', 'instruction' => "Nothing", 'status' => 1],
        ];

        PayoutMethod::insert($methods);
    }
}
