<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('voucher_redemptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voucher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_reference', 100)->nullable();
            $table->decimal('amount_used', 15, 2);
            $table->text('notes')->nullable();
            $table->timestamp('redeemed_at');
            $table->index('user_id');
        });
    }
    public function down(): void { Schema::dropIfExists('voucher_redemptions'); }
};