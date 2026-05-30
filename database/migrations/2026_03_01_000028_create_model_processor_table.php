<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('model_components', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('modelId');
            $table->foreign('modelId')->references('modelId')->on('models');          
            $table->unsignedInteger('componentId');
            $table->foreign('componentId')->references('componentId')->on('components');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_processor');
    }
};
