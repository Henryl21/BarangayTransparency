<?php
// ===================================
// 1. MIGRATION COMMANDS TO RUN
// ===================================

/*
Run these commands in your terminal:

1. Add receipt column to budgets table:
php artisan make:migration add_receipt_to_budgets_table --table=budgets

2. Add category and date columns to budgets table:
php artisan make:migration add_category_date_to_budgets_table --table=budgets

3. Or create a single migration to add all missing columns:
php artisan make:migration add_missing_columns_to_budgets_table --table=budgets
*/

// ===================================
// 2. MIGRATION FILE CONTENT
// ===================================

// File: database/migrations/YYYY_MM_DD_HHMMSS_add_missing_columns_to_budgets_table.php
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
        Schema::table('budgets', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('budgets', 'category')) {
                $table->string('category')->nullable()->after('title');
            }
            if (!Schema::hasColumn('budgets', 'date')) {
                $table->date('date')->nullable()->after('amount');
            }
            if (!Schema::hasColumn('budgets', 'receipt')) {
                $table->string('receipt')->nullable()->after('date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropColumn(['category', 'date', 'receipt']);
        });
    }
};