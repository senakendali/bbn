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
        Schema::table('producers', function (Blueprint $table) {
            $table->string('company_address')->after('name');
            $table->string('factory_address')->after('company_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('producers', function (Blueprint $table) {
            //
        });
    }
};
