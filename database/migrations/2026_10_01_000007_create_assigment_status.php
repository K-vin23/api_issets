<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            CREATE TYPE assignment_status AS ENUM (
                'A',
                'I'
            );
        ");
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS assignment_status");
    }
};
