<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_license', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('assetId');
            $table->foreign('assetId')->references('assetId')->on('assets');          
            $table->unsignedInteger('licenseId');
            $table->foreign('licenseId')->references('licenseId')->on('licenses');
            $table->string('licenseKey', 255);
            $table->unique(['assetId', 'licenseId'], 'uq_asset_license');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_license');
    }
};
