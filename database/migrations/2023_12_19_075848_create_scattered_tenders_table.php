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
        Schema::create('scattered_tenders', function (Blueprint $table) {
            $table->id();
            $table->string('tender_id');
            $table->string('delivery_point_id');
            $table->integer('bbn_quota');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scattered_tenders');
    }
};
