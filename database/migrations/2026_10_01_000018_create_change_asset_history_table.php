<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('change_asset_history', function (Blueprint $table) {
            $table->bigIncrements('changeId');
            $table->unsignedBigInteger('maintenanceId');
            $table->foreign('maintenanceId')->references('maintenanceId')->on('maintenances');
            $table->string('description', 100);
            $table->date('changeDate')->default(DB::raw('CURRENT_DATE'));
        });

        DB::statement("
            ALTER TABLE change_asset_history
            ADD COLUMN changeType change_type
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('change_asset_history');
    }
};
