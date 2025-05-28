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
        Schema::table('tutors', function (Blueprint $table) {
            //
            // Add subject_id as a foreign key in the tutors table
            $table->unsignedBigInteger('subject_id')->nullable()->after('id'); // Position it after the 'id' column, or change as needed
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tutors', function (Blueprint $table) {
            //
             $table->dropForeign(['subject_id']);
            $table->dropColumn('subject_id');
        });
    }
};
