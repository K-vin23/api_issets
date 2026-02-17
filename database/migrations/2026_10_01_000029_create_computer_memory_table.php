<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('computer_memory', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('computerId');
            $table->foreign('computerId')->references('computerId')->on('computers');          
            $table->unsignedInteger('memoryId');
            $table->foreign('memoryId')->references('memoryId')->on('memories');  
            $table->timestampTz('lastUpdate')->useCurrent();    
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('computer_memory');
    }
};
