<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            CREATE TYPE audit_action AS ENUM (
                'INSERTAR',
                'ELIMINAR',
                'ACTUALIZAR'
            )
        ");
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS audit_action");
    }
};
