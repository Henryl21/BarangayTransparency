<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenditures', function (Blueprint $table) {
            $table->unsignedBigInteger('officer_id')->nullable()->after('id');
            $table->foreign('officer_id')
                ->references('id')
                ->on('officer_users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('expenditures', function (Blueprint $table) {
            $table->dropForeign(['officer_id']);
            $table->dropColumn('officer_id');
        });
    }
};
