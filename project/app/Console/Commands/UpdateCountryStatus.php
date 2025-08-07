<?php

namespace App\Console\Commands;

use App\Models\Country;
use Illuminate\Console\Command;

class UpdateCountryStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'countries:activate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the status of all countries to active (1)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating status for all countries to active...');
        
        try {
            $updatedCount = Country::query()->update(['status' => 1]);
            $this->info("Successfully updated {$updatedCount} countries.");
            return 0;
        } catch (\Exception $e) {
            $this->error('An error occurred while updating the countries.');
            $this->error($e->getMessage());
            return 1;
        }
    }
}
