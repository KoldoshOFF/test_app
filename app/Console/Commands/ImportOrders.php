<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
class ImportOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command imports orders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $page = 1;
        $limit = 500;
        $imported = 0;

        while ($imported < $limit) {
            $response = Http::get("http://109.73.206.144:6969/api/orders", [
                'dateFrom' => '2024-01-01',
                'dateTo' => now()->format('Y-m-d'),
                'page' => $page,
                'limit' => 100,
                'key' => 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie',
            ]);

            $data = $response->json('data');

            if (empty($data)) {
                break;
            }

            foreach ($data as $item) {
                \App\Models\Order::updateOrCreate(
                    [
                        'g_number' => $item['g_number'],
                        'nm_id' => $item['nm_id'],
                    ],
                    $item
                );
                $imported++;
                if ($imported >= $limit) {
                    break 2;
                }
            }

            $page++;
        }
    }
}
