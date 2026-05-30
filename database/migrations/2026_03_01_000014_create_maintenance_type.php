<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1 FROM pg_type WHERE typname = 'maintenance_type'
                ) THEN
                    CREATE TYPE maintenance_type AS ENUM (
                        'CORRECTIVO',
                        'PREVENTIVO'
                    );
                END IF;
            END$$;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS maintenance_type CASCADE");
    }
};
