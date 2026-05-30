<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('component_type', function (Blueprint $table) {
            $table->bigIncrements('ctypeId');
            $table->string('categoryId', 4);
            $table->foreign('categoryId')->references('categoryId')->on('component_category');
            $table->string('compType', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('component_category');
    }
};
