<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('officers', function (Blueprint $table) {
        $table->string('title')->nullable()->after('email');
        $table->string('category')->nullable()->after('title');
        $table->decimal('amount', 12, 2)->default(0)->after('category');
        $table->text('description')->nullable()->after('amount');
        $table->string('receipt')->nullable()->after('description');
        $table->string('decline_reason')->nullable()->after('status');
    });
}

public function down(): void
{
    Schema::table('officers', function (Blueprint $table) {
        $table->dropColumn(['title', 'category', 'amount', 'description', 'receipt', 'decline_reason']);
    });
}

};
