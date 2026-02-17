<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            CREATE TYPE change_action AS ENUM (
                'AGREGADO',
                'REEMPLAZADO',
                'REMOVIDO',
                'ACTUALIZADO'
            )
        ");
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS change_action");
    }
};
