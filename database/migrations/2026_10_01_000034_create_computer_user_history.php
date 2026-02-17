<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('computer_user_history', function (Blueprint $table) {
            $table->bigIncrements('historyId');

            $table->unsignedBigInteger('computerId')->nullable();
            $table->foreign('computerId')->references('computerId')->on('computers');

            $table->unsignedBigInteger('userId');
            $table->string('userName', 200);

            $table->date('assignmentDate')->nullable();
            $table->date('unassignmentDate');

            $table->char('status', 1);
        });
    }

    public function down(): void
    {
        schema::dropIfExists('computer_user_history');
    }
};
