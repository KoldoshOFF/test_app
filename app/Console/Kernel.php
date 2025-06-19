<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\ImportIncomes;
use App\Console\Commands\ImportOrders;
use App\Console\Commands\ImportStocks;
use App\Console\Commands\ImportSales;
class Kernel extends ConsoleKernel
{
    protected $commands = [
        ImportSales::class,
        ImportIncomes::class,
        ImportStocks::class,
        ImportOrders::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule)
    {
        $schedule->command('data:update')->twiceDaily(1, 13);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
