<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('assetId');
            $table->string('serialNumber', 200);
            $table->unsignedInteger('companyId')->nullable();
            $table->foreign('companyId')->references('companyId')->on('companies');
            $table->string('assetType', 4)->nullable();
            $table->foreign('assetType')->references('typeId')->on('asset_types');
            $table->string('invoice', 50)->default('NO REGISTRADO');
            $table->date('purchaseDate')->default(DB::raw('CURRENT_DATE'));
            $table->unsignedBigInteger('registeredBy');
            $table->foreign('registeredBy')->references('userId')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
