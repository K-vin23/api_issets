<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('computer_models', function (Blueprint $table) {
            $table->id('modelId');
            $table->string('brandId', 4);
            $table->foreign('brandId')->references('brandId')->on('computer_brands');          
            $table->unsignedInteger('processorId');
            $table->foreign('processorId')->references('processorId')->on('processors');      
            $table->string('modelFamily',100);   
            $table->string('modelSerie', 100)->default('SIN SERIE'); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('computer_models');
    }
};
