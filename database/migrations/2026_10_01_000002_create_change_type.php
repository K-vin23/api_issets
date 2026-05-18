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
                    SELECT 1 FROM pg_type WHERE typname = 'change_type'
                ) THEN
                    CREATE TYPE change_type AS ENUM (
                        'AGREGADO',
                        'REMOVIDO'
                    );
                END IF;
            END$$;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS change_type CASCADE");
    }
};
