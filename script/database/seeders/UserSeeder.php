<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Plan;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Demo User
        $plan = Plan::where('price',  '>', 0)->first();

        $user = User::factory()->create([
            'email' => 'user@user.com',
            'password' => Hash::make('rootadmin'),
            'username' => 'demo-user',
            'plan_id' => $plan->id,
            'plan_meta' => $plan->meta,
            'avatar' => 'https://avatars.dicebear.com/api/adventurer/admin.png',
            'email_verified_at' => now()
        ]);

        $currency = Currency::first();

        Wallet::create([
            'wallet' => 1000,
            'user_id' => $user->id,
            'currency_id' => $currency->id,
        ]);
    }
}
