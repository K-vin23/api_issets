<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('
            ALTER TABLE companies
            ALTER COLUMN status DROP DEFAULT
        ');

        DB::statement("
            ALTER TABLE companies
            ALTER COLUMN status TYPE BOOLEAN
            USING (
                CASE
                    WHEN status = 'A' THEN TRUE
                    WHEN status = 'I' THEN FALSE
                    ELSE FALSE
                END
            )
        ");

        DB::statement('
            ALTER TABLE companies
            ALTER COLUMN status SET DEFAULT TRUE
        ');

        Schema::table('companies', function (Blueprint $table) {
            $table->renameColumn('status', 'isActive');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->renameColumn('isActive', 'status');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->string('status')->default('A')->change();
        });
    }
};
