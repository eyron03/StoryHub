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
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('pFname');
            $table->string('pLname');
            $table->unsignedInteger('pAge');
            $table->date('pDob');
            $table->string('pAddress');
            $table->enum('pGender', ['Male', 'Female', 'other']);
            $table->string('usertype');
            $table->string('email')->unique();
            $table->string('password');
         
            //$table->foreign('childrens_kFname')->references('kFname')->on('childrens')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
