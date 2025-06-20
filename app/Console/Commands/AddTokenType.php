<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TokenType;

class AddTokenType extends Command
{
    protected $signature = 'add:token-type {type} {name}';
    protected $description = 'Добавить новый тип токена';

    public function handle()
    {
        $type = $this->argument('type');
        $name = $this->argument('name');

        $tokenType = TokenType::create([
            'type' => $type,
            'name' => $name,
        ]);
        $this->info("Тип токена '{$tokenType->type}' ({$tokenType->name}) создан с id {$tokenType->id}");
    }
}
