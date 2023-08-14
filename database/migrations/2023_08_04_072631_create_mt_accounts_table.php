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
        Schema::create('mt_accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('login_id')->unique();
            $table->foreignUuid('telegram_user_uuid');
            $table->string('name');
            $table->string('currency');
            $table->decimal('balance', 20, 2)->default(0);
            $table->decimal('equity', 20, 2)->default(0);
            $table->decimal('margin_level', 20, 2)->default(0);
            $table->decimal('highest_drawdown_amount', 20, 2)->default(0);
            $table->decimal('highest_drawdown_percentage', 8, 2)->default(0);
            $table->decimal('floating', 20, 2)->default(0);
            $table->integer('active_pairs')->default(0);
            $table->integer('active_orders')->default(0);
            $table->decimal('profit_today')->default(0);
            $table->decimal('profit_all_time')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mt_accounts');
    }
};
