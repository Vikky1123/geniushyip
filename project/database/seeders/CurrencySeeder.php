<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Currency::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $countries = Country::all();
        $currencies = [];

        foreach ($countries as $country) {
            if (!empty($country->currency_code) && !isset($currencies[$country->currency_code])) {
                $currencies[$country->currency_code] = [
                    'name' => $country->currency_code,
                    'sign' => $country->currency_symbol,
                    'value' => 1, 
                    'is_default' => $country->currency_code == 'USD' ? 1 : 0,
                ];
            }
        }
        
        foreach($currencies as $currencyData){
            Currency::create($currencyData);
        }
    }
} 