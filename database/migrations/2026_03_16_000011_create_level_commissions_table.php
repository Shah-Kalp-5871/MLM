<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('level_commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receiver_id');       // Upline who gets the commission
            $table->unsignedBigInteger('from_user_id');      // Downline whose ROI triggered it
            $table->unsignedBigInteger('roi_income_id');     // Reference to the ROI payout
            $table->unsignedTinyInteger('level');             // 1–15
            $table->decimal('roi_amount', 15, 2);            // The downline's ROI amount
            $table->decimal('commission_percentage', 5, 2);  // % applied
            $table->decimal('commission_amount', 15, 2);     // Actual commission received
            $table->timestamp('created_at');
            $table->foreign('receiver_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('from_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('roi_income_id')->references('id')->on('roi_incomes')->cascadeOnDelete();
            $table->index(['receiver_id', 'level']);
            $table->index('created_at');
        });
    }
    public function down(): void { Schema::dropIfExists('level_commissions'); }
};