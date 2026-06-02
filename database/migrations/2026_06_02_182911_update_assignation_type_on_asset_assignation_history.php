<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asset_assignation_history', function (Blueprint $table) {
            $table->string('assignationType', 13)->change();
        });
    }

    public function down(): void
    {
        Schema::table('asset_assignation_history', function (Blueprint $table) {
            $table->string('assignationType', 10)->change();
        });
    }
};
