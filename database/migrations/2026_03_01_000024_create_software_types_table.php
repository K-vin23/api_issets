<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('software_types', function (Blueprint $table) {
            $table->string('typeId', 5)->primary();
            $table->string('softwareType', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('software_types');
    }
};
