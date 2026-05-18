<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // DB::statement("
        //     DO $$
        //     BEGIN
        //         IF NOT EXISTS (
        //             SELECT 1 FROM pg_type WHERE typname = 'process_manufact'
        //         ) THEN
        //             CREATE TYPE process_manufact AS ENUM (
        //                 'INTEL',
        //                 'AMD',
        //                 'APPLE'
        //             );
        //         END IF;
        //     END$$;
        // ");
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS process_manufact CASCADE");
    }
};
