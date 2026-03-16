<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained('packages');
            $table->decimal('amount', 15, 2);
            $table->decimal('daily_roi_percentage', 5, 2);
            $table->decimal('total_roi_earned', 15, 2)->default(0);
            $table->timestamp('next_payout_at')->nullable();
            $table->timestamp('matures_at')->nullable();
            $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])->default('pending');
            $table->timestamp('activated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['user_id', 'status']);
        });
    }
    public function down(): void { Schema::dropIfExists('investments'); }
};