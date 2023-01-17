<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            [
                'id' => 1,
                'name' => 'US Dollar',
                'code' => 'USD',
                'rate' => 1,
                'symbol' => '$',
                'position' => 'left',
                'status' => 1,
                'is_default' => 1
            ],
            [
                'id' => 2,
                'name' => 'Euro',
                'code' => 'EUR',
                'rate' => 0.95,
                'symbol' => '€',
                'position' => 'left',
                'status' => 1,
                'is_default' => 0
            ],
            [
                'id' => 3,
                'name' => 'Bangladeshi Taka',
                'code' => 'BDT',
                'rate' => 92.87,
                'symbol' => '৳',
                'position' => 'left',
                'status' => 1,
                'is_default' => 0
            ],
            [
                'id' => 4,
                'name' => 'Indian Rupee',
                'code' => 'INR',
                'rate' => 78.28,
                'symbol' => '₹',
                'position' => 'left',
                'status' => 1,
                'is_default' => 0
            ],
            [
                'id' => 5,
                'name' => 'Nigerian Naira',
                'code' => 'NGN',
                'rate' => 414.99,
                'symbol' => '₦',
                'position' => 'left',
                'status' => 1,
                'is_default' => 0
            ],
            [
                'id' => 6,
                'name' => 'Malaysian Ringgit',
                'code' => 'MYR',
                'rate' => 4.41,
                'symbol' => 'RM',
                'position' => 'left',
                'status' => 1,
                'is_default' => 0
            ],
            [
                'id' => 7,
                'name' => 'Omani rial',
                'code' => 'OMR',
                'rate' => 0.39,
                'symbol' => 'ر.ع.',
                'position' => 'right',
                'status' => 1,
                'is_default' => 0
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
