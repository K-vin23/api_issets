<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('memories', function (Blueprint $table) {
            $table->id('memoryId');
            $table->integer('gbCapacity');
        });

        DB::statement("
            ALTER TABLE memories
            ADD COLUMN memoryType memory_type NOT NULL
        ");
    }

    public function down(): void
    {
        schema::dropIfExists('memories');
    }
};
