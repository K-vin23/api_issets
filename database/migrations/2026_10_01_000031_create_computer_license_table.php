<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('computer_license', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('computerId');
            $table->foreign('computerId')->references('computerId')->on('computers');          
            $table->unsignedInteger('licenseId');
            $table->foreign('licenseId')->references('licenseId')->on('licenses');
            $table->string('licenseKey', 255);
            $table->unique(['computerId', 'licenseId'], 'uq_computer_license');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('computer_license');
    }
};
