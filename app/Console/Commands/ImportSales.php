<?php

namespace App\Console\Commands;
use App\Models\Sale;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импорт Sales';

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
            $response = Http::get("http://109.73.206.144:6969/api/sales", [
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
                Sale::updateOrCreate(
                    ['sale_id' => $item['sale_id'] ?? null],
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
