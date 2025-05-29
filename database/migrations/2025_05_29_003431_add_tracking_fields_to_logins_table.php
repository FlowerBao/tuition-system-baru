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
        Schema::table('logins', function (Blueprint $table) {
            //
            $table->string('ip_address')->after('action')->nullable();
            $table->string('user_agent')->after('ip_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logins', function (Blueprint $table) {
            //
            $table->dropColumn(['ip_address', 'user_agent']);
        });
    }
};
