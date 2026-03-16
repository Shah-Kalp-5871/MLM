<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('club_qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->decimal('direct_business', 15, 2)->default(0.00);  // Sum of direct referral deposits
            $table->decimal('team_business', 15, 2)->default(0.00);    // Sum of all downline deposits
            $table->unsignedTinyInteger('current_tier')->default(0);   // Highest tier achieved (0 = none)
            $table->unsignedTinyInteger('highest_tier_achieved')->default(0);
            $table->timestamp('last_calculated_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('club_qualifications'); }
};