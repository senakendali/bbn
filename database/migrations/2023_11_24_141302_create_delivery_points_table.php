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
        Schema::create('delivery_points', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_point');
            $table->string('cluster');
            $table->integer('delivery_point_province_id');
            $table->integer('delivery_point_regency_id');
            $table->integer('bbn_estimate_alocation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_points');
    }
};
