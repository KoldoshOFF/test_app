<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('api_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
            $table->foreignId('api_service_id')->constrained('api_services')->onDelete('cascade');
            $table->foreignId('token_type_id')->constrained('token_types')->onDelete('cascade');
            $table->text('token');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->unique(
                ['account_id', 'api_service_id', 'token_type_id'],
                'account_service_token_type_unique'
            );
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_tokens');
    }
}
