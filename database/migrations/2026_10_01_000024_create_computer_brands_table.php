<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('computer_brands', function (Blueprint $table) {
            $table->string('brandId', 4)->primary();
            $table->string('brand', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('computer_brands');
    }
};
