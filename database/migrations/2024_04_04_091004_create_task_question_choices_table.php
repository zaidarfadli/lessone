<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_question_choices', function (Blueprint $table) {
            $table->id();
            $table->string('answer');
            $table->unsignedBigInteger('task_question_id');
            $table->foreign('task_question_id')->references('id')->on('task_questions')->onDelete('cascade');
            $table->boolean('is_true')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_question_choices');
    }
};
