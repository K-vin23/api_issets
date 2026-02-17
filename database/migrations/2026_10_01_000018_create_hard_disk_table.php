<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hard_disks', function (Blueprint $table) {
            $table->id('diskId');
            $table->integer('gbCapacity');
        });

        DB::statement("
            ALTER TABLE hard_disks
            ADD COLUMN diskType disk_type NOT NULL
        ");
    }

    public function down(): void
    {
        schema::dropIfExists('hard_disks');
    }
};
