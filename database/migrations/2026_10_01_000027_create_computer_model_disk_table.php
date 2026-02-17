<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('computer_model_disk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('modelId');
            $table->foreign('modelId')->references('modelId')->on('computer_models');          
            $table->unsignedInteger('diskId');
            $table->foreign('diskId')->references('diskId')->on('hard_disks');      
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('computer_model_disk');
    }
};
