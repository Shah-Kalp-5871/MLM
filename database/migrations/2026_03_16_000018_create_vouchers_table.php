<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 32)->unique();
            $table->decimal('value', 15, 2);
            $table->foreignId('club_reward_id')->nullable()->constrained('club_rewards')->nullOnDelete();
            $table->enum('status', ['unused', 'assigned', 'redeemed', 'expired'])->default('unused');
            $table->timestamp('expires_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->comment('Admin ID');
            $table->timestamps();
            $table->index('status');
        });
    }
    public function down(): void { Schema::dropIfExists('vouchers'); }
};