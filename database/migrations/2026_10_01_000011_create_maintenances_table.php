<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->bigIncrements('maintenanceId');
            $table->unsignedBigInteger('assetId')->nullable();
            $table->foreign('assetId')->references('assetId')->on('assets');
            $table->string('typeId', 6);
            $table->foreign('typeId')->references('typeId')->on('maintenance_types');
            $table->date('maintenanceDate')->default(DB::raw('CURRENT_DATE'));
            $table->date('nextMaintenance');
            $table->unsignedBigInteger('tecId');
            $table->foreign('tecId')->references('userId')->on('users');
            $table->string('observations', 100);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
