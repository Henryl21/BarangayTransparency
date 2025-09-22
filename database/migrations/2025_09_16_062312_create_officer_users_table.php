<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('officer_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // officer full name
            $table->string('email')->unique();      // login email
            $table->string('password');             // hashed password
            $table->string('position')->nullable(); // position in barangay (captain, treasurer, secretary, etc.)
            $table->enum('role', ['officer'])->default('officer'); // role type
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('officer_users');
    }
};
