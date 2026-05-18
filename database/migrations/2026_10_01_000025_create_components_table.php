<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('components', function (Blueprint $table) {
            $table->bigIncrements('componentId');
            $table->unsignedInteger('ctypeId');
            $table->foreign('ctypeId')->references('ctypeId')->on('component_type');
            $table->string('component');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('components');
    }
};
