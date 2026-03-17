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
        Schema::table('roi_incomes', function (Blueprint $table) {
            $table->string('week_key')->nullable()->after('investment_id');
            $table->unique(['investment_id', 'week_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roi_incomes', function (Blueprint $table) {
            //
        });
    }
};
