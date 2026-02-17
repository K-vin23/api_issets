<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('removed_asset_history', function (Blueprint $table) {
            $table->bigIncrements('removedId');
            $table->string('assetType', 50);
            $table->string('serialNumber', 200);
            $table->string('internalId', 100);
            $table->unsignedInteger('companyId');
            $table->string('companyName', 100);
            $table->date('removalDate')->default(DB::raw('CURRENT_DATE'));
            $table->unsignedBigInteger('removedBy');
            $table->string('remUserName', 200);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('removed_asset_history');
    }
};
