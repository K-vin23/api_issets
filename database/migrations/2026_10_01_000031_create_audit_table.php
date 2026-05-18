<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('audit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('afTable', 40);
            $table->text('afRecord');

            $table->jsonb('dataBefore')->nullable();
            $table->jsonb('dataAfter')->nullable();

            $table->unsignedBigInteger('userId');
            $table->string('userName', 200)->nullable();

            $table->timestamp('apDate')->useCurrent();
        });

        DB::statement("
            ALTER TABLE audit
            ADD COLUMN apAction audit_action NOT NULL
        ");
    }

    public function down(): void
    {
        schema::dropIfExists('audit');
    }
};
