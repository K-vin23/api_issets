<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            CREATE TYPE disk_type AS ENUM (
                'SSD',
                'HDD',
                'M.2'
            )
        ");
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS disk_type");
    }
};
