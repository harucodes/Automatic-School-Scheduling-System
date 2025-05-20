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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
    
            // Foreign keys
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('user_teacher_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('room_id');
    
            // Schedule details
            $table->string('day'); // e.g., Monday, Tuesday
            $table->time('start_time');
            $table->time('end_time');
    
            $table->timestamps();
    
            // Foreign key constraints
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('user_teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
