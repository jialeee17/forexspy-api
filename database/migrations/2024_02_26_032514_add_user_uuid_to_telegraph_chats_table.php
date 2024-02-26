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
        Schema::table('telegraph_chats', function (Blueprint $table) {
            $table->foreignUuid('user_uuid')->nullable()->after('telegraph_bot_id')->references('uuid')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('telegraph_chats', function (Blueprint $table) {
            $table->dropForeign(['user_uuid']);
            $table->dropColumn('user_uuid');
        });
    }
};
