<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('computer_disk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('computerId');
            $table->foreign('computerId')->references('computerId')->on('computers');          
            $table->unsignedInteger('diskId');
            $table->foreign('diskId')->references('diskId')->on('hard_disks');
            $table->timestampTz('lastUpdate')->useCurrent();    

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('computer_disk');
    }
};
