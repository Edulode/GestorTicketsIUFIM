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
        Schema::table('subareas', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['area_id']);
            // Then drop the column
            $table->dropColumn('area_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subareas', function (Blueprint $table) {
            // Re-add the area_id column and foreign key constraint
            $table->foreignId('area_id')->constrained('areas');
        });
    }
};
