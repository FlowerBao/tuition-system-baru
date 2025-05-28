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
        Schema::create('fee_payments', function (Blueprint $table) {
             $table->id();
            $table->foreignId('student_id')->constrained('student_lists')->onDelete('cascade');
            $table->foreignId('parent_id')->constrained('parent_infos')->onDelete('cascade');
            $table->decimal('amount', 8, 2);
            $table->string('status')->default('pending'); // paid, failed
            $table->string('stripe_payment_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_payments');
    }
};
