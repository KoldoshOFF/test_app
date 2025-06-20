<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApiService;

class AddApiService extends Command
{
    protected $signature = 'add:api-service {name} {base_url}';
    protected $description = 'Добавить новый API сервис';

    public function handle()
    {
        $name = $this->argument('name');
        $baseUrl = $this->argument('base_url');

        $service = ApiService::create([
            'name' => $name,
            'base_url' => $baseUrl,
        ]);
        $this->info("API сервис '{$service->name}' создан с id {$service->id}");
    }
}
