<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('component_category', function (Blueprint $table) {
            $table->string('categoryId', 4)->primary();
            $table->string('category', 50);
        });
    }

    public function down(): void
    {
       Schema::dropIfExists('component_category');
    }
};
