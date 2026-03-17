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
        Schema::table('vouchers', function (Blueprint $table) {
            $table->renameColumn('user_id', 'owner_id');
            $table->unsignedBigInteger('used_by')->nullable()->after('amount');
            $table->foreign('used_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropForeign(['used_by']);
            $table->dropColumn('used_by');
            $table->renameColumn('owner_id', 'user_id');
        });
    }
};
