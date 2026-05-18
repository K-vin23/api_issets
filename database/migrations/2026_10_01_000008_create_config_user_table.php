<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('config_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('userId')->nullable();
            $table->foreign('userId')->references('userId')->on('users');
            $table->unsignedInteger('configId')->nullable();
            $table->foreign('configId')->references('configId')->on('configs'); 
            $table->string('configValue', 100);
            $table->unique(['userId', 'configId'], 'uq_config_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('config_user');
    }
};
