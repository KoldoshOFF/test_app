<?php

namespace App\Console;

use App\Console\Commands\LoadData;
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
        $logPath = storage_path('logs/cron.log');
        $schedule->command('import:sales')->cron('47 6 * * *')->sendOutputTo($logPath);
        $schedule->command('import:sales')->cron('9 7 * * *')->sendOutputTo($logPath);

        $schedule->command('import:orders')->cron('47 6 * * *')->sendOutputTo($logPath);
        $schedule->command('import:orders')->cron('9 7 * * *')->sendOutputTo($logPath);

        $schedule->command('import:stocks')->cron('47 6 * * *')->sendOutputTo($logPath);
        $schedule->command('import:stocks')->cron('9 7 * * *')->sendOutputTo($logPath);

        $schedule->command('import:incomes')->cron('47 6 * * *')->sendOutputTo($logPath);
        $schedule->command('import:incomes')->cron('9 7 * * *')->sendOutputTo($logPath);
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
