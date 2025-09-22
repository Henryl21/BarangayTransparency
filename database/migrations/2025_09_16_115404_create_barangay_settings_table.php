<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangay_settings', function (Blueprint $table) {
            $table->id();
            $table->string('barangay_name');      // Barangay name
            $table->string('barangay_role');      // Auto-saved role (barangay they belong to)
            $table->string('logo')->nullable();   // Logo file path
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangay_settings');
    }
};
