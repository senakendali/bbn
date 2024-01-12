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
        Schema::table('delivery_points', function (Blueprint $table) {
            $table->dropColumn(['delivery_point_regency_id', 'bbn_estimate_alocation']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_points', function (Blueprint $table) {
            //
        });
    }
};
