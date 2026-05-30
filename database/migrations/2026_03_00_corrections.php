<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        schema::dropIfExists('maintenance_types');
        schema::dropIfExists('change_types');
        DB::statement("DROP TYPE IF EXISTS change_action CASCADE");
        DB::statement("DROP TYPE IF EXISTS change_component CASCADE");
        DB::statement("DROP TYPE IF EXISTS technology_type CASCADE");
        DB::statement("DROP TYPE IF EXISTS component_type CASCADE");
    }

    public function down(): void
    {
        schema::dropIfExists('maintenance_types');
        schema::dropIfExists('change_types');
        DB::statement("DROP TYPE IF EXISTS change_action CASCADE");
        DB::statement("DROP TYPE IF EXISTS change_component CASCADE");
        DB::statement("DROP TYPE IF EXISTS technology_type CASCADE");
        DB::statement("DROP TYPE IF EXISTS component_type CASCADE");
    }
};
