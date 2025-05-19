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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_subject_id')->nullable(); // link to teacher/user, if needed
            $table->string('subject_name');
            $table->text('subject_description')->nullable();
            $table->string('subject_code')->unique();
            $table->timestamps();

            // Optional: Add foreign key if user_subject_id relates to users table
            $table->foreign('user_subject_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
