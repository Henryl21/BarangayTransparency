<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('officer_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('officer_user_id')->constrained('officer_users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('receipt')->nullable();
            $table->string('resolution')->nullable();
            $table->enum('status', ['pending','approved','declined'])->default('pending');
            $table->text('decline_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('officer_requests');
    }
};
