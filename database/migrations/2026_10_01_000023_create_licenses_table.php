<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id('licenseId');
            $table->unsignedInteger('providerId')->nullable();
            $table->foreign('providerId')->references('providerId')->on('license_providers');          
            $table->string('softwareType', 5);
            $table->foreign('softwareType')->references('typeId')->on('software_types');      
            $table->string('software', 50);
            $table->string('sofVersion', 30);    
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
