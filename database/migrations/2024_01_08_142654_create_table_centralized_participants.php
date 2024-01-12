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
        Schema::create('table_centralized_participants', function (Blueprint $table) {
            $table->id();
            $table->string('tender_id');
            $table->string('vendor_id');
            $table->integer('offered_quota');
            $table->integer('offered_price');
            $table->string('user_created');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_centralized_participants');
    }
};
