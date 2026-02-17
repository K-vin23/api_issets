<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('change_types', function (Blueprint $table) {
            $table->id('changeTypeId');
        });

        DB::statement("
            ALTER TABLE change_types
            ADD COLUMN component change_component NOT NULL
        ");

        DB::statement("
            ALTER TABLE change_types
            ADD COLUMN action change_action NOT NULL
        ");
    }

    public function down(): void
    {
        schema::dropIfExists('change_types');
    }
};
