<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Verificar se a tabela já existe antes de criá-la
        if (!Schema::hasTable('personal_access_tokens')) {
            Schema::create('personal_access_tokens', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tokenable_id');
                $table->string('tokenable_type');
                $table->string('name');
                $table->text('token');
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();

                $table->unique(['tokenable_id', 'tokenable_type', 'name']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('personal_access_tokens');
    }
}