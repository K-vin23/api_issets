<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('change_asset_history', function (Blueprint $table) {
            $table->bigIncrements('changeId');
            $table->unsignedBigInteger('assetId')->nullable();
            $table->foreign('assetId')->references('assetId')->on('assets');
            $table->unsignedBigInteger('maintenanceId');
            $table->foreign('maintenanceId')->references('maintenanceId')->on('maintenances');
            $table->unsignedInteger('changeTypeId');
            $table->foreign('changeTypeId')->references('changeTypeId')->on('change_types');
            $table->string('observations', 100);
            $table->date('changeDate')->default(DB::raw('CURRENT_DATE'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('change_asset_history');
    }
};
