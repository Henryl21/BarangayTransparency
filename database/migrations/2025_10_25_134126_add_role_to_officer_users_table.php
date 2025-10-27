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
        Schema::table('officer_users', function (Blueprint $table) {
            // ✅ Add the role column after 'position'
            if (!Schema::hasColumn('officer_users', 'role')) {
                $table->string('role')->after('position')->default('Officer');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('officer_users', function (Blueprint $table) {
            // ✅ Drop the role column when rolling back
            if (Schema::hasColumn('officer_users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
