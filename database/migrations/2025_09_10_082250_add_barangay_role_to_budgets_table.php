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
        // Check if the table exists
        if (!Schema::hasTable('budgets')) {
            Schema::create('budgets', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->decimal('amount', 12, 2);
                $table->enum('type', ['income', 'expense']);
                $table->string('category')->nullable();
                $table->date('date')->nullable();
                $table->text('description')->nullable();
                $table->string('receipt')->nullable();
                $table->string('receipt_path')->nullable();
                $table->string('barangay_role')->default('malbago'); // Add barangay role field
                $table->timestamps();
            });
        } else {
            // Table exists, make sure 'barangay_role' column exists
            Schema::table('budgets', function (Blueprint $table) {
                if (!Schema::hasColumn('budgets', 'barangay_role')) {
                    $table->string('barangay_role')->default('malbago')->after('type');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the table if it exists
        if (Schema::hasTable('budgets')) {
            Schema::dropIfExists('budgets');
        }
    }
};
