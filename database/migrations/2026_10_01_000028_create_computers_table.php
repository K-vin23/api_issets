<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('computers', function (Blueprint $table) {
            $table->bigIncrements('computerId');
            $table->unsignedBigInteger('assetId');
            $table->foreign('assetId')->references('assetId')->on('assets');            
            $table->unsignedInteger('companyId')->nullable();
            $table->foreign('companyId')->references('companyId')->on('companies');
            $table->string('internalId', 100);
            $table->unsignedInteger('areaId');
            $table->foreign('areaId')->references('areaId')->on('areas');
            $table->unsignedInteger('modelId');
            $table->foreign('modelId')->references('modelId')->on('computer_models');
            $table->unsignedBigInteger('assignedUser')->nullable();
            $table->foreign('assignedUser')->references('userId')->on('users');
            $table->unsignedBigInteger('assignedBy')->nullable();
            $table->foreign('assignedBy')->references('userId')->on('users');
            $table->timestampTz('lastUpdate')->useCurrent();
            $table->unique(['companyId', 'internalId'], 'uq_internalId');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('computers');
    }
};
