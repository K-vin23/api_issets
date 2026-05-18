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
            $table->bigInteger('assetId');
            $table->string('assetType', 50);
            $table->string('serialNumber', 30);
            $table->string('internalId', 100);
            $table->string('brand', 50);
            $table->string('model', 200);
            $table->integer('companyId');
            $table->string('companyName', 100);
            $table->bigInteger('lastUser');
            $table->string('userName', 200);
            $table->string('removalReason', 200);
            $table->date('removalDate')->default(DB::raw('CURRENT_DATE'));
            $table->bigInteger('removedBy');
            $table->string('remUserName', 200);
            $table->json('details')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('removed_asset_history');
    }
};
