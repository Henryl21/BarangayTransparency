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
            // ✅ Add a column to record the officer's last login timestamp
            $table->timestamp('last_login_at')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('officer_users', function (Blueprint $table) {
            // ✅ Rollback: remove the column if migration is rolled back
            $table->dropColumn('last_login_at');
        });
    }
};
