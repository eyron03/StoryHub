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
        Schema::create('children_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('child_id')->nullable(); // Foreign key column

            $table->foreign('child_id')->references('id')->on('childrens')->onDelete('cascade');
            $table->unsignedBigInteger('class_id')->nullable(); // Foreign key column

            $table->foreign('class_id')->references('id')->on('grade_levels')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('children_classes');
    }
};
