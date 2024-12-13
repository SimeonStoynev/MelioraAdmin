<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CalculateChurnRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-churn-rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates and displays the churn rate based on random subscriber data.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $churnedSubscribers = random_int(100, 150);
        $activeSubscribers = random_int(1000, 1200);
        $newSubscribers = random_int(150, 300);

        $totalSubscribersAtStart = $churnedSubscribers + $activeSubscribers;

        // Calculate churn rate
        $churnRate = ($churnedSubscribers / $totalSubscribersAtStart) * 100;
        $churnRateFormatted = round($churnRate, 2);

        // Output the data as a table
        $this->table(
            ['Metric', 'Value'],
            [
                ['Churned Subscribers', $churnedSubscribers],
                ['Active Subscribers', $activeSubscribers],
                ['New Subscribers', $newSubscribers],
                ['Total Subscribers at Start', $totalSubscribersAtStart],
                ['Churn Rate (%)', $churnRateFormatted . '%'],
            ]
        );

        $this->info('Churn rate calculation completed successfully.');

        return 0;
    }
}
