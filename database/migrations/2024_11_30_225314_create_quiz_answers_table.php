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
        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->id();
      // Foreign key for quizzes table
      $table->unsignedBigInteger('quiz_id');
      $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');

      // Foreign key for quiz_results table
      $table->unsignedBigInteger('quiz_result_id');
      $table->foreign('quiz_result_id')->references('id')->on('quiz_results')->onDelete('cascade');

      // Foreign key for child table (to associate the answer with a specific child)
      $table->unsignedBigInteger('child_id');
      $table->foreign('child_id')->references('id')->on('childrens')->onDelete('cascade');

      // Store the selected answer (e.g., option_a, option_b, etc.)
      $table->string('selected_answer')->nullable();

      // To check if the answer is correct
      $table->boolean('is_correct')->defaultFalse();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_answers');
    }
};
