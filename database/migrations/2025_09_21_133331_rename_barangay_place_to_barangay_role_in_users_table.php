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
            // Rename barangay_place → barangay_role
            if (Schema::hasColumn('users', 'barangay_place')) {
                $table->renameColumn('barangay_place', 'barangay_role');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rollback: rename back
            if (Schema::hasColumn('users', 'barangay_role')) {
                $table->renameColumn('barangay_role', 'barangay_place');
            }
        });
    }
};
