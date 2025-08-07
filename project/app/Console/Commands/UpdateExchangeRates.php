<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Currency;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:exchange-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update exchange rates from an API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $apiKey = '96ddc27d719829d4f59b6356';
            $response = Http::withoutVerifying()->get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/USD");

            if ($response->successful() && $response->json()['result'] === 'success') {
                $rates = $response->json()['conversion_rates'];

                foreach ($rates as $code => $rate) {
                    Currency::where('name', $code)->update(['value' => $rate]);
                }

                $this->info('Exchange rates updated successfully.');
            } else {
                $this->error('Failed to fetch exchange rates.');
                Log::error('Exchange Rate API Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            $this->error('An exception occurred: ' . $e->getMessage());
            Log::error('Exchange Rate API Exception: ' . $e->getMessage());
        }

        return 0;
    }
} 