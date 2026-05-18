<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id('locationId');
            $table->unsignedInteger('companyId')->nullable();
            $table->foreign('companyId')->references('companyId')->on('companies');          
            $table->string('cityId', 6);
            $table->foreign('cityId')->references('cityId')->on('cities');      
            $table->string('locationName',100);    
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
