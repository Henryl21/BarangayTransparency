<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('barangay_role')->default('malbago')->after('password');
            // Remove this line: $table->string('barangay_name')->nullable()->after('barangay_role');
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('barangay_role'); // Only drop barangay_role now
        });
    }
};