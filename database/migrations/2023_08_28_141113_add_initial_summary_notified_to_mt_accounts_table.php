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
        Schema::table('mt_accounts', function (Blueprint $table) {
            $table->boolean('initial_summary_notified')->default(false)->after('profit_all_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mt_accounts', function (Blueprint $table) {
            $table->dropColumn('initial_summary_notified');
        });
    }
};
