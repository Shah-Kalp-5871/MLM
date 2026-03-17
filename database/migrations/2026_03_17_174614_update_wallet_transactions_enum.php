<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->string('type')->change(); // Temporary change to allow updating enum in some DBs
        });

        DB::statement("ALTER TABLE wallet_transactions MODIFY COLUMN type ENUM(
            'roi_income',
            'level_income',
            'deposit',
            'withdrawal',
            'voucher_awarded',
            'voucher_redeemed',
            'voucher_earned',
            'voucher_redeem',
            'voucher_transferred_use',
            'refund',
            'admin_credit',
            'admin_debit'
        ) NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE wallet_transactions MODIFY COLUMN type ENUM(
            'roi_income',
            'level_income',
            'deposit',
            'withdrawal',
            'voucher_awarded',
            'voucher_redeemed',
            'refund',
            'admin_credit',
            'admin_debit'
        ) NOT NULL");
    }
};
