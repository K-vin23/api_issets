<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('processors', function (Blueprint $table) {
            $table->id('processorId');
            $table->string('processorModel');
        });

        DB::statement("
            ALTER TABLE processors
            ADD COLUMN manufacturer process_manufact NOT NULL
        ");
    }

    public function down(): void
    {
        schema::dropIfExists('processors');
    }
};
