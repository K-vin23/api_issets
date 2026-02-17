<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id('configId');
            $table->string('config',30);    
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configs');
    }
};
