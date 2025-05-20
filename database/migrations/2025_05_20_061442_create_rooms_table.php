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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_room_id')->nullable(); // e.g., assigned staff or manager
            $table->string('room_number')->unique(); // Unique room identifier
            $table->integer('capacity'); // Number of students the room can hold
            $table->timestamps();

            // Optional foreign key to users table
            $table->foreign('user_room_id')->references('id')->on('users')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
