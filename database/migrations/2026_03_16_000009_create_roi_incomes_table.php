<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('roi_incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('investment_id')->constrained('investments')->cascadeOnDelete();
            $table->decimal('investment_amount', 15, 2);
            $table->decimal('roi_percentage', 5, 2);
            $table->decimal('roi_amount', 15, 2);
            $table->unsignedInteger('week_number');
            $table->date('for_week_ending');   // The week this payout covers
            $table->timestamp('distributed_at');
            $table->index(['user_id', 'for_week_ending']);
        });
    }
    public function down(): void { Schema::dropIfExists('roi_incomes'); }
};