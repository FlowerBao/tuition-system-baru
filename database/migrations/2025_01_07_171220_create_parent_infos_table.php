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
        Schema::create('parent_infos', function (Blueprint $table) {
            $table->id();
            $table->string('parent_name');
            $table->integer('parent_ic');
            $table->string('parent_email');
            $table->string('parent_phone');
            $table->string('parent_address');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_infos');
    }
};
