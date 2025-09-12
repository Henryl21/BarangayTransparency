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
        Schema::create('expenditures', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('category', [
                'Infrastructure',
                'Education', 
                'Healthcare',
                'Public Safety',
                'Utilities',
                'Other'
            ]);
            $table->decimal('amount', 12, 2);
            $table->date('date');
            $table->string('receipt')->nullable(); // For backward compatibility
            $table->string('receipt_path')->nullable(); // New field name
            $table->string('vendor')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'approved', 'completed', 'cancelled'])->default('pending');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            // Foreign key constraints (optional - uncomment if you have users table)
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');

            // Indexes for better performance
            $table->index('category');
            $table->index('date');
            $table->index('status');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenditures');
    }
};