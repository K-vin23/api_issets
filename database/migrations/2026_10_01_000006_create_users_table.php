<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedBigInteger('userId')->primary();
            $table->string('rolId', 4)->nullable();
            $table->unsignedInteger('companyId')->nullable();
            $table->unsignedInteger('areaId')->nullable();
            $table->unsignedInteger('locationId')->nullable();
            $table->string('firstname', 50);
            $table->string('middlename', 50)->nullable();
            $table->string('lastname', 50);
            $table->string('s_lastname', 50)->nullable();
            $table->string('email', 100)->default('NO REGISTRADO');
            $table->string('pw_encrypt', 255)->nullable();
            $table->rememberToken();
            $table->timestampTz('registDate')->useCurrent();
            $table->unsignedBigInteger('registBy')->nullable();   
            $table->boolean('isActive')->default(true);     
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('rolId')->references('rolId')->on('roles');
            $table->foreign('companyId')->references('companyId')->on('companies');
            $table->foreign('areaId')->references('areaId')->on('areas');
            $table->foreign('locationId')->references('locationId')->on('locations');

            // ⚠️ Self reference
            $table->foreign('registBy')
                ->references('userId')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
