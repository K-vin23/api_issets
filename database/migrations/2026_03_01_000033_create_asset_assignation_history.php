<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('asset_assignation_history', function (Blueprint $table) {
            $table->bigIncrements('assignId');
            $table->string('assignationType', 10);
            $table->unsignedBigInteger('assetId')->nullable();
            $table->foreign('assetId')->references('assetId')->on('assets'); 
            $table->string('serialNumber', 30); 
            $table->unsignedBigInteger('userId')->nullable();
            $table->foreign('userId')->references('userId')->on('users');
            $table->string('userName', 200);
            $table->unsignedBigInteger('assignedBy')->nullable();
            $table->foreign('assignedBy')->references('userId')->on('users');
            $table->string('assignName', 200);
            $table->date('assignmentDate');
            $table->date('unassignmentDate')->nullable();
        });
    }

    public function down(): void
    {
        schema::dropIfExists('asset_assignation_history');
    }
};
