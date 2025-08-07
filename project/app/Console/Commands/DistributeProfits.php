<?php

namespace App\Console\Commands;

use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Console\Command;

class DistributeProfits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profits:distribute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Distribute profits to all active investments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting profit distribution...');
        
        try {
            $controller = new FrontendController();
            $controller->profitSend();
            $this->info('Profit distribution completed successfully.');
            return 0;
        } catch (\Exception $e) {
            $this->error('An error occurred during profit distribution: ' . $e->getMessage());
            return 1;
        }
    }
} 