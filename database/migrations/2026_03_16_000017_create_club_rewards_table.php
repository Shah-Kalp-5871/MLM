<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('club_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('club_milestone_id')->constrained('club_milestones');
            $table->unsignedTinyInteger('tier');
            $table->decimal('reward_amount', 15, 2);
            $table->enum('status', ['awarded', 'assigned', 'redeemed', 'expired'])->default('awarded');
            $table->timestamp('awarded_at');
            $table->timestamps();
            $table->unique(['user_id', 'tier']); // Only one reward per tier per user
        });
    }
    public function down(): void { Schema::dropIfExists('club_rewards'); }
};