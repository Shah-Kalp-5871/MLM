<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2)->default(0.00);
            $table->decimal('net_amount', 15, 2)->storedAs('amount - fee');
            $table->enum('payment_method', ['usdt_trc20', 'bank_transfer', 'upi'])->default('bank_transfer');
            $table->string('wallet_address', 200)->nullable();   // target address or bank details
            $table->string('transaction_id', 200)->nullable();   // admin fills after payment
            $table->enum('status', ['pending', 'processing', 'approved', 'paid', 'rejected'])->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('approved_by')->references('id')->on('admins')->nullOnDelete();
            $table->index(['user_id', 'status']);
        });
    }
    public function down(): void { Schema::dropIfExists('withdrawals'); }
};