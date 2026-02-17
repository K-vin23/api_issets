<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            CREATE TYPE process_manufact AS ENUM (
                'INTEL',
                'AMD',
                'APPLE'
            )
        ");
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS process_manufact");
    }
};
