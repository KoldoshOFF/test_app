<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApiToken;
use App\Models\Account;
use App\Models\ApiService;
use App\Models\TokenType;

class AddApiToken extends Command
{
    protected $signature = 'add:api-token {account_id} {api_service_id} {token_type_id} {token}';
    protected $description = 'Добавить новый API токен';

    public function handle()
    {
        $accountId = $this->argument('account_id');
        $apiServiceId = $this->argument('api_service_id');
        $tokenTypeId = $this->argument('token_type_id');
        $token = $this->argument('token');

        if (!Account::find($accountId)) {
            $this->error("Аккаунт с id {$accountId} не найден.");
            return 1;
        }
        if (!ApiService::find($apiServiceId)) {
            $this->error("API сервис с id {$apiServiceId} не найден.");
            return 1;
        }
        if (!TokenType::find($tokenTypeId)) {
            $this->error("Тип токена с id {$tokenTypeId} не найден.");
            return 1;
        }

        $apiToken = ApiToken::create([
            'account_id' => $accountId,
            'api_service_id' => $apiServiceId,
            'token_type_id' => $tokenTypeId,
            'token' => $token,
        ]);
        $this->info("API токен создан с id {$apiToken->id}");
    }
}
