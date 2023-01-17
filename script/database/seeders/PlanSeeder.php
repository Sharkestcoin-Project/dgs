<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            ['name' => 'Free','duration' => '-1','price' => '-1','status' => '1','is_trial' => '0','is_featured' => '1','description' => NULL,'meta' => '{"max_file_size": "25", "product_limit": "3", "subscription_plan_limit": "0", "sell_subscription": "0", "withdraw_charge": "2"}','created_at' => now(),'updated_at' => now()],
            ['name' => 'Grow','duration' => '30','price' => '9','status' => '1','is_trial' => '0','is_featured' => '1','description' => NULL,'meta' => '{"max_file_size": "500", "product_limit": "9", "subscription_plan_limit": "2", "sell_subscription": "1", "withdraw_charge": "4"}','created_at' => now(),'updated_at' => now()],
            ['name' => 'Expand','duration' => '30','price' => '29','status' => '1','is_trial' => '0','is_featured' => '1','description' => NULL,'meta' => '{"max_file_size": "5120", "product_limit": "50", "subscription_plan_limit": "5", "sell_subscription": "1", "withdraw_charge": "10"}','created_at' => now(),'updated_at' => now()]
        ];

        Plan::insert($plans);
    }
}
