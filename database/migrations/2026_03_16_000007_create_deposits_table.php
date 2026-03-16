<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained('packages');
            $table->decimal('amount', 15, 2);
            $table->enum('payment_method', ['usdt_trc20', 'bank_transfer', 'upi', 'internal_wallet'])->default('bank_transfer');
            $table->string('payment_proof')->nullable()->comment('File path for uploaded screenshot');
            $table->string('transaction_hash', 200)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('status');
        });
    }
    public function down(): void { Schema::dropIfExists('deposits'); }
};