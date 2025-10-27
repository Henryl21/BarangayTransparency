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
            $roles = [
                'Officer',
                'Captain',
                'Kagawad',
                'SK Chairperson',
                'Treasurer',
                'Clerk',
                'Record Keeper',
                'Tanod',
                'Health Worker',
                'Nutrition Scholar',
                'Day Care Worker',
                'IT Officer',
                'DRRMO',
                'Utility Worker'
            ];

            if (Schema::hasColumn('officer_users', 'role')) {
                $table->enum('role', $roles)->default('Officer')->change();
            } else {
                $table->enum('role', $roles)->default('Officer');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('officer_users', function (Blueprint $table) {
            // Optional: drop or revert the role column
            // $table->dropColumn('role');
        });
    }
};
