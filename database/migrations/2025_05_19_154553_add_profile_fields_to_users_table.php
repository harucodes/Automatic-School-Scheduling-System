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
        Schema::table('users', function (Blueprint $table) {
            $table->string('id_number')->nullable()->after('id');
            $table->string('firstname')->nullable()->after('id_number');
            $table->string('lastname')->nullable()->after('firstname');
            $table->integer('age')->nullable()->after('lastname');
            $table->string('role')->default('user')->after('age');
            $table->string('avatar')->nullable()->after('role'); // Profile picture
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['id_number', 'firstname', 'lastname', 'age', 'role', 'avatar']);
        });
    }
};
