<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('assetId');
            $table->unsignedInteger('companyId')->nullable();
            $table->foreign('companyId')->references('companyId')->on('companies');
            $table->unsignedInteger('areaId');
            $table->foreign('areaId')->references('areaId')->on('areas');
            $table->string('typeId', 4);
            $table->foreign('typeId')->references('typeId')->on('asset_types');
            $table->unsignedBigInteger('modelId');
            $table->foreign('modelId')->references('modelId')->on('models');
            $table->string('serialNumber', 200);
            $table->string('internalId', 100);
            $table->string('invoice', 50)->default('NO REGISTRADO');
            $table->date('purchaseDate')->default(DB::raw('CURRENT_DATE'));
            $table->string('networkName', 50)->nullable();
            $table->unsignedBigInteger('assignedUser')->nullable();
            $table->foreign('assignedUser')->references('userId')->on('users');
            $table->string('details', 100);
            $table->timestamp('lastUpdate')->useCurrent();
            $table->boolean('isActive')->default(true);
            $table->date('nextMaintenance');
            $table->unsignedBigInteger('registeredBy');
            $table->foreign('registeredBy')->references('userId')->on('users');
            $table->unique(['companyId', 'internalId'], 'uq_company_asset_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
