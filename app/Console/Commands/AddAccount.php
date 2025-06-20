<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Account;
use App\Models\Company;

class AddAccount extends Command
{
    protected $signature = 'add:account {company_id} {name}';
    protected $description = 'Добавить новый аккаунт компании';

    public function handle()
    {
        $companyId = $this->argument('company_id');
        $name = $this->argument('name');

        if (!Company::find($companyId)) {
            $this->error("Компания с id {$companyId} не найдена.");
            return 1;
        }

        $account = Account::create([
            'company_id' => $companyId,
            'name' => $name,
        ]);
        $this->info("Аккаунт '{$account->name}' создан с id {$account->id} для компании {$companyId}");
    }
}
