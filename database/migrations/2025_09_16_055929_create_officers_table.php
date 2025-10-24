<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('officers', function (Blueprint $table) {
            // Add a password column
            $table->string('password')->nullable();  // We can make it nullable for the initial state
        });
    }

    public function down(): void
    {
        Schema::table('officers', function (Blueprint $table) {
            // Drop the password column if rolling back
            $table->dropColumn('password');
        });
    }
};
