<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiServiceTokenTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('api_service_token_type', function (Blueprint $table) {
            $table->foreignId('api_service_id')->constrained('api_services')->onDelete('cascade');
            $table->foreignId('token_type_id')->constrained('token_types')->onDelete('cascade');
            $table->primary(['api_service_id', 'token_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_service_token_type');
    }
}
