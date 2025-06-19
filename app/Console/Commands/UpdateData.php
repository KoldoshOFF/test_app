<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApiToken;
use Illuminate\Support\Facades\Http;

class UpdateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновить данные из внешних API для всех аккаунтов';

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
        $this->info('Запуск обновления данных...');

        $tokens = ApiToken::with(['account', 'apiService', 'tokenType'])->get();

        if ($tokens->isEmpty()) {
            $this->warn('Нет токенов для обновления.');
            return;
        }

        foreach ($tokens as $token) {
            $this->info("Обновление для аккаунта {$token->account->name}, сервис {$token->apiService->name}");

            $headers = [];
            if ($token->tokenType->type === 'bearer') {
                $headers['Authorization'] = 'Bearer ' . $token->token;
            }

            $url = $token->apiService->base_url . '/sales';

            try {
                $response = Http::withHeaders($headers)->get($url);

                if ($response->status() == 429) {
                    $this->warn('Too many requests, ждем 60 секунд...');
                    sleep(60);
                    continue;
                }

                if ($response->failed()) {
                    $this->error('Ошибка запроса: ' . $response->body());
                    continue;
                }

                $this->info('Данные успешно получены: ' . substr($response->body(), 0, 200));
            } catch (\Exception $e) {
                $this->error('Ошибка: ' . $e->getMessage());
            }
        }
    }
}
