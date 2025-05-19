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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_section_id')->nullable(); // e.g. teacher or adviser
            $table->string('section_name');
            $table->string('section_level'); // e.g. Grade 10, Grade 11, etc.
            $table->timestamps();

            // Optional: foreign key constraint to users table
            $table->foreign('user_section_id')->references('id')->on('users')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
