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
        Schema::create('schedule_student', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('user_student_id');

            $table->timestamps();

            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->foreign('user_student_id')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['schedule_id', 'user_student_id']); // Prevent duplicates
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_student');
    }
};
