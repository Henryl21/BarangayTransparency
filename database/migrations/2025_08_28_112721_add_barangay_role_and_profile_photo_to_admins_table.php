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
        Schema::table('admins', function (Blueprint $table) {
            // Add only the new fields
            if (!Schema::hasColumn('admins', 'barangay_role')) {
                $table->enum('barangay_role', [
                    'bunakan',
                    'kangwayan',
                    'kaongkod',
                    'kodia',
                    'maalat',
                    'malbago',
                    'mancilang',
                    'tarong',
                    'pili',
                    'poblacion',
                    'san agustin',
                    'tabagak',
                    'talangnan',
                    'tugas'
                ])->unique()->after('password');
                $table->index('barangay_role');
            }

            if (!Schema::hasColumn('admins', 'profile_photo')) {
                $table->string('profile_photo')->nullable()->after('barangay_role');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['barangay_role', 'profile_photo']);
        });
    }
};
