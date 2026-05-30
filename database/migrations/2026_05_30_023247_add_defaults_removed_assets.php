<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('removed_asset_history', function (Blueprint $table) {
            $table->bigInteger('lastUser')->nullable()->change();
            $table->string('userName', 200)->default('Sin asignar')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->bigInteger('lastUser')->change();
            $table->string('userName', 200)->default('')->change();
        });
    }
};
