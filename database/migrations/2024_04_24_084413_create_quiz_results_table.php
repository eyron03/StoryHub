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
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('child_id')->nullable(); // Foreign key column

        $table->foreign('child_id')->references('id')->on('childrens')->onDelete('cascade');

            $table->unsignedBigInteger('flipbook_id')->nullable(); // Foreign key column

        $table->foreign('flipbook_id')->references('id')->on('flipbooks')->onDelete('cascade');
            $table->unsignedBigInteger('grade_level_id')->nullable(); // Nullable to handle cases where a child has no grade
    $table->unsignedBigInteger('teacher_id')->nullable(); // Nullable to handle cases where no teacher is assigned
        $table->integer('total_score');
          $table->dateTime('date_taken')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};
