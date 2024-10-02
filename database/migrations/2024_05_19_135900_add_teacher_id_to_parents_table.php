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
        Schema::table('parents', function (Blueprint $table) {
            //
            // $table->unsignedBigInteger('teacher_id')->nullable()->after('password');

            // // Add the foreign key constraint
            // $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parents', function (Blueprint $table) {
            //
            // $table->dropForeign(['teacher_id']);

            // // Drop the foreign key column
            // $table->dropColumn('teacher_id');
        });
    }
};
