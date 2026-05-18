<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_components', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('assetId');
            $table->foreign('assetId')->references('assetId')->on('assets');            
            $table->unsignedBigInteger('componentId');
            $table->foreign('componentId')->references('componentId')->on('components');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_components');
    }
};
