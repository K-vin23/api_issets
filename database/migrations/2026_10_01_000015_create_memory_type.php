<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            CREATE TYPE memory_type AS ENUM (
                'DDR3',
                'DDR4',
                'DDR3L',
                'DDR4L'
            )
        ");
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS memory_type");
    }
};
