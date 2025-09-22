<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('budgets', function (Blueprint $table) {
            // Add officer_id (nullable until officers are set up)
            $table->unsignedBigInteger('officer_id')->nullable()->after('id');

            // Add status column (default = pending)
            $table->enum('status', ['pending', 'approved', 'declined'])->default('pending')->after('type');

            // Optional: add foreign key if you have officers table
            // $table->foreign('officer_id')->references('id')->on('officers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropColumn('officer_id');
            $table->dropColumn('status');
        });
    }
};
