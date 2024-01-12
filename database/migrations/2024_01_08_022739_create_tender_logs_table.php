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
        Schema::create('tender_logs', function (Blueprint $table) {
            $table->id();
            $table->string('tender_id');
            $table->string('tender_log');
            $table->string('description')->nullable();
            $table->string('user_created');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_logs');
    }
};
