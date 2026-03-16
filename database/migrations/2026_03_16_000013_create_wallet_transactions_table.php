<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', [
                'roi_income',
                'level_income',
                'deposit',
                'withdrawal',
                'voucher_awarded',
                'voucher_redeemed',
                'refund',
                'admin_credit',
                'admin_debit',
            ]);
            $table->enum('wallet', ['cash', 'voucher'])->default('cash');
            $table->decimal('amount', 15, 2);             // always positive
            $table->enum('direction', ['credit', 'debit']);
            $table->decimal('balance_after', 15, 2);      // snapshot after transaction
            $table->unsignedBigInteger('reference_id')->nullable();   // id in related table
            $table->string('reference_type', 100)->nullable();        // model name
            $table->string('description')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'type']);
            $table->index('created_at');
        });
    }
    public function down(): void { Schema::dropIfExists('wallet_transactions'); }
};