<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('computer_model_memory', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('modelId');
            $table->foreign('modelId')->references('modelId')->on('computer_models');          
            $table->unsignedInteger('memoryId');
            $table->foreign('memoryId')->references('memoryId')->on('memories');      
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('computer_model_memory');
    }
};
