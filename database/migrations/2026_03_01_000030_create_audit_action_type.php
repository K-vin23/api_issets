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
                    SELECT 1 FROM pg_type WHERE typname = 'audit_action'
                ) THEN
                    CREATE TYPE audit_action AS ENUM (
                        'INSERTAR',
                        'ELIMINAR',
                        'ACTUALIZAR'
                    );
                END IF;
            END$$;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS audit_action");
    }
};
