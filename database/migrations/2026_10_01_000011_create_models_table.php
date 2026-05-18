<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('models', function (Blueprint $table) {
            $table->bigIncrements('modelId');
            $table->string('brandId', 4);
            $table->foreign('brandId')->references('brandId')->on('brands');
            $table->string('typeId', 4);
            $table->foreign('typeId')->references('typeId')->on('asset_types');               
            $table->string('modelFamily',100);   
            $table->string('modelSerie', 100)->default('SIN SERIE'); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('models');
    }
};
