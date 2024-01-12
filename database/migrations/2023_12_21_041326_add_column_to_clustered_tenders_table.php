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
        Schema::table('clustered_tenders', function (Blueprint $table) {
            $table->string('tender_id')->after('id');
            $table->string('cluster_id')->after('tender_id');
            $table->string('delivery_point_id')->after('cluster_id');
            $table->string('bbn_quota')->after('delivery_point_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clustered_tenders', function (Blueprint $table) {
            //
        });
    }
};
