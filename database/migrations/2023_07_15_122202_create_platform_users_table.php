<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('platform_users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->text('password');
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamp('last_login_at')->nullable();
            $table->bigInteger('game_scores')->nullable()->default(0);
            $table->bigInteger('uploaded_games')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_users');
    }
};
