<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1 FROM pg_type WHERE typname = 'assignment_type'
                ) THEN
                    CREATE TYPE assignment_type AS ENUM (
                        'ASSIGNED',
                        'TRANSFERRED',
                        'REMOVED'
                    );
                END IF;
            END$$;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS assignment_type CASCADE");
    }
};
