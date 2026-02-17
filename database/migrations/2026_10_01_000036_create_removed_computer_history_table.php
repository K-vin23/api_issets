<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('removed_computer_history', function (Blueprint $table) {
            $table->bigIncrements('removedId');
            $table->unsignedBigInteger('remAssetId');
            $table->foreign('remAssetId')->references('removedId')->on('removed_asset_history');
            $table->string('internalId', 100);
            $table->string('brand', 50);
            $table->string('model', 200);
            $table->unsignedInteger('companyId');
            $table->string('companyName', 100);
            $table->unsignedBigInteger('lastAssignedUser');
            $table->string('userName', 200);
            $table->date('lastUpdate');
            $table->string('removalReason', 200);
            $table->unsignedBigInteger('removedBy');
            $table->string('remUserName', 200);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('removed_computer_history');
    }
};
