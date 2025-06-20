<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\ApiToken;
use App\Models\Sale;

class ImportSales extends Command
{
    protected $signature = 'import:sales';
    protected $description = 'Импорт заказов (sales) для всех аккаунтов и сервисов';

    public function handle()
    {
        $this->info('Старт импорта sales...');

        $tokens = ApiToken::with(['account', 'apiService', 'tokenType'])
            ->whereHas('apiService', function ($q) {
                $q->where('name', 'Custom API');
            })
            ->get();

        if ($tokens->isEmpty()) {
            $this->warn('Нет токенов для импорта sales.');
            return 0;
        }

        foreach ($tokens as $token) {
            $accountId = $token->account_id;
            $serviceUrl = rtrim($token->apiService->base_url, '/');
            $apiKey = $token->token;

            $this->info("Импорт для аккаунта {$token->account->name} (ID: $accountId), сервис {$token->apiService->name}");

            $lastDate = Sale::where('account_id', $accountId)->max('date') ?? '2024-01-01';

            $page = 1;
            $imported = 0;
            $limit = 100;
            $maxPages = 1000;

            while ($page <= $maxPages) {
                $response = Http::get("$serviceUrl/sales", [
                    'dateFrom' => $lastDate,
                    'dateTo' => now()->format('Y-m-d'),
                    'page' => $page,
                    'limit' => $limit,
                    'key' => $apiKey,
                ]);

                if ($response->status() == 429) {
                    $this->warn('Too many requests, ждем 60 секунд...');
                    sleep(60);
                    continue;
                }

                if ($response->failed()) {
                    $this->error('Ошибка запроса: ' . $response->body());
                    break;
                }

                $json = $response->json();
                $data = $json['data'] ?? [];
                $meta = $json['meta'] ?? [];

                if (!is_array($data) || count($data) === 0) {
                    $this->info("Нет новых данных для аккаунта $accountId (страница $page).");
                    break;
                }

                foreach ($data as $item) {
                    $item['account_id'] = $accountId;
                    $externalId = $item['external_id'] ?? md5(json_encode($item));
                    $item['external_id'] = $externalId;

                    Sale::updateOrCreate(
                        [
                            'external_id' => $externalId,
                            'account_id' => $accountId,
                        ],
                        $item
                    );
                    $imported++;
                }

                $this->info("Загружено записей: $imported для аккаунта $accountId (страница $page)");

                if (isset($meta['last_page']) && $page >= $meta['last_page']) {
                    break;
                }

                $page++;
            }
        }

        $this->info('Импорт sales завершён.');
        return 0;
    }
}
