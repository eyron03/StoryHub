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
        Schema::create('childrens', function (Blueprint $table) {
            $table->id();
            $table->string('childFirstName');
            $table->string('childLastName');
            $table->unsignedInteger('childAge');
            $table->date('childDob');
            $table->string('childAddress');
            $table->enum('childGender', ['Male', 'Female']);

            $table->unsignedBigInteger('parent_id')->nullable(); // Foreign key column

        $table->foreign('parent_id')->references('id')->on('parents')->onDelete('cascade'); 
        // Foreign key constraint
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('childrens');
    }
};
