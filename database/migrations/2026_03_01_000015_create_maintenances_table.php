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
            $table->unsignedBigInteger('tecId');
            $table->foreign('tecId')->references('userId')->on('users');
            $table->date('maintenanceDate')->default(DB::raw('CURRENT_DATE'));
            $table->string('observations', 100);
        });

        DB::statement("
            ALTER TABLE maintenances
            ADD COLUMN type maintenance_type
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
